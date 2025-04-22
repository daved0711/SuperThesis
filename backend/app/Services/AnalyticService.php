<?php

namespace App\Services;

use App\Models\Animal;
use App\Models\Barangay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticService
{

    private function getBarangayBittenCount(): array
    {
        $data = DB::select("
                SELECT MONTH(created_at) AS month, YEAR(created_at) as year, barangay_id, count(id) as bites
                from transactions t
                group by barangay_id, month, year;");

        return (array)$data;
    }

    public function getTop10BrangayBase6Month(): array
    {
        $data = DB::select("SELECT b.id, b.name, COUNT(t.id) AS transaction_count, b.latitude, b.longitude
                FROM barangays b
                LEFT JOIN transactions t ON t.barangay_id = b.id
                WHERE t.created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY b.id, b.name
                ORDER BY transaction_count DESC
                LIMIT 10;");

        return (array) $data;
    }

    public function getTop10BrangayBaseMonthYear($start, $end): array
    {
        $data = DB::select("SELECT
                                        b.id,
                                        b.name,
                                        COUNT(t.id) AS transaction_count,
                                        b.latitude,
                                        b.longitude
                                    FROM barangays b
                                    LEFT JOIN transactions t
                                        ON t.barangay_id = b.id
                                        AND t.created_at >= '$start'
                                        AND t.created_at < '$end'
                                    GROUP BY b.id, b.name
                                    ORDER BY transaction_count DESC");

        return (array) $data;
    }

    private function getTotalTransactionCount(): int
    {
        return DB::table('transactions')->count();
    }

    private function getTotalTransactionTodayCount(): int
    {
        return DB::table('transactions')
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    private function getAnimalsCount(): array
    {
        $val = [];
        $animals = Animal::all();
        foreach ($animals as $animal) {
            $val[$animal->name] = $animal->transaction_count;
        }
        return $val;
    }

    public function getCounts(): array
    {
        return [
            "Total Cases" => $this->getTotalTransactionCount(),
            "Today Cases" => $this->getTotalTransactionTodayCount()
        ];
    }

    public function getOnlyAnimalsCount(): array
    {
        return $this->getAnimalsCount();
    }

    public function get6MonthsCases(): array
    {
        return DB::table('transactions')
            ->selectRaw("
            MONTH(created_at) AS month,
            YEAR(created_at) AS year,
            COUNT(id) AS count,
            DATE_FORMAT(MIN(created_at), '%b %Y') AS label
        ")
            ->whereRaw("created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)")
            ->groupByRaw("YEAR(created_at), MONTH(created_at)")
            ->orderByRaw("YEAR(created_at) ASC, MONTH(created_at) ASC")
            ->get()
            ->toArray();
    }


    public function predictedCasesPerBarangay($year, $month): array
    {
        $predictedCases = [];
        $barangays = Barangay::all();
        $data = $this->getBarangayBittenCount();
        foreach ($barangays as $barangay) {
            $predictedCases[] = [
                ...$barangay->toArray(),
                ...[
                    "predictedCase" => $this->predictCasesForMonth($data, $barangay->id, $year, $month)
                ]
            ];
        }

        usort($predictedCases, function ($a, $b) {
            return $b['predictedCase'] <=> $a['predictedCase']; // Descending order
        });

        return array_map(function ($data) {
            $data['risk_level'] = $this->getRiskLevel($data['predictedCase']);
            return $data;
        }, $predictedCases);
    }

    private function getRiskLevel($cases): string
    {
        if ($cases <= 5) {
            return 'Low';
        } elseif ($cases <= 15) {
            return 'Moderate';
        } elseif ($cases <= 30) {
            return 'High';
        } else {
            return 'Critical';
        }
    }

    private function predictCasesForMonth($data, $barangay_id, $targetYear, $targetMonth)
    {
        $barangayData = array_filter($data, function ($d) use ($barangay_id) {
            return $d->barangay_id == $barangay_id;
        });

        if (empty($barangayData)) {
            return 0;
        }

        // Convert (year, month) into a single numeric value (e.g., 2023-01 → 202301)
        $months = [];
        $bites = [];
        foreach ($barangayData as $d) {
            $months[] = $d->year * 12 + $d->month;
            $bites[] = $d->bites;
        }

        $n = count($months);
        if ($n < 2) {
            return 0;
        }

        // Compute sum
        $sumX = array_sum($months);
        $sumY = array_sum($bites);
        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += $months[$i] * $bites[$i];
            $sumX2 += $months[$i] * $months[$i];
        }

        // Compute slope (m) and intercept (b) using the linear regression formula
        $denominator = ($n * $sumX2 - $sumX * $sumX);
        if ($denominator == 0) {
            return ["error" => "Prediction failed due to insufficient variance in data."];
        }

        $m = ($n * $sumXY - $sumX * $sumY) / $denominator;
        $b = ($sumY - $m * $sumX) / $n;

        // Convert target (year, month) to numeric value
        $targetMonthValue = $targetYear * 12 + $targetMonth;
        $predictedCases = round($m * $targetMonthValue + $b);

        // Ensure predicted cases are not negative
        $predictedCases = max(0, $predictedCases);

        return $predictedCases;
    }
}
