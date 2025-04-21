<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangays = [
            ["code" => "045608002", "name" => "Buenavista East", "latitude" => "13.9110865", "longitude" => "121.3426829"],
            ["code" => "045608003", "name" => "Buenavista West", "latitude" => "13.9143182", "longitude" => "121.3834058"],
            ["code" => "045608004", "name" => "Bukal Norte", "latitude" => "13.9657142", "longitude" => "121.3854319"],
            ["code" => "045608005", "name" => "Bukal Sur", "latitude" => "13.9371551", "longitude" => "121.3785707"],
            ["code" => "045608006", "name" => "Kinatihan I", "latitude" => "13.8905305", "longitude" => "121.3847657"],
            ["code" => "045608007", "name" => "Kinatihan II", "latitude" => "13.8729556", "longitude" => "121.3868663"],
            ["code" => "045608008", "name" => "Malabanban Norte", "latitude" => "13.940806", "longitude" => "121.4273853"],
            ["code" => "045608009", "name" => "Malabanban Sur", "latitude" => "13.9174691", "longitude" => "121.4268623"],
            ["code" => "045608010", "name" => "Mangilag Norte", "latitude" => "13.9612111", "longitude" => "121.4449403"],
            ["code" => "045608011", "name" => "Mangilag Sur", "latitude" => "13.9352311", "longitude" => "121.4477618"],
            ["code" => "045608012", "name" => "Masalukot I", "latitude" => "13.9480057", "longitude" => "121.4194087"],
            ["code" => "045608013", "name" => "Masalukot II", "latitude" => "13.9473376", "longitude" => "121.4137932"],
            ["code" => "045608014", "name" => "Masalukot III", "latitude" => "13.9796366", "longitude" => "121.4231164"],
            ["code" => "045608015", "name" => "Masalukot IV", "latitude" => "14.0276968", "longitude" => "121.4192574"],
            ["code" => "045608026", "name" => "Masalukot V", "latitude" => "14.0162308", "longitude" => "121.4411639"],
            ["code" => "045608016", "name" => "Masin Norte", "latitude" => "13.9385029", "longitude" => "121.4071646"],
            ["code" => "045608017", "name" => "Masin Sur", "latitude" => "13.9238416", "longitude" => "121.4009418"],
            ["code" => "045608018", "name" => "Mayabobo", "latitude" => "13.9764532", "longitude" => "121.4507733"],
            ["code" => "045608019", "name" => "Pahinga Norte", "latitude" => "13.9211164", "longitude" => "121.4138927"],
            ["code" => "045608020", "name" => "Pahinga Sur", "latitude" => "13.9076186", "longitude" => "121.3971992"],
            ["code" => "045608001", "name" => "Poblacion", "latitude" => "13.9307447", "longitude" => "121.4244861"],
            ["code" => "045608022", "name" => "San Andres", "latitude" => "13.3276573", "longitude" => "122.573086"],
            ["code" => "045608023", "name" => "San Isidro", "latitude" => "13.6556779", "longitude" => "122.2710226"],
            ["code" => "045608024", "name" => "Santa Catalina Norte", "latitude" => "13.8901371", "longitude" => "121.4133392"],
            ["code" => "045608025", "name" => "Santa Catalina Sur", "latitude" => "13.8769718", "longitude" => "121.4115795"]
        ];

        foreach ($barangays as $barangay) {
            Barangay::create($barangay);
        }
    }
}
