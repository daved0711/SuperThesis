<script setup>
import BarChartCases from "~/components/charts/BarChartCases.vue";
import PieChartCases from "~/components/charts/PieChartCases.vue";
import SimpleWidget from "~/components/widgets/SimpleWidget.vue";
import TopBarangayCases from "~/components/charts/TopBarangayCases.vue";
import MapWidget from "~/components/widgets/MapWidget.vue";
import BarangayCases from "~/components/charts/BarangayCases.vue";
import PieChartBarangayCases from "~/components/charts/PieChartBarangayCases.vue";
import PieChartGenderBarangayCases from "~/components/charts/PieChartGenderBarangayCases.vue";
import PieChartAgeBarangayCases from "~/components/charts/PieChartAgeBarangayCases.vue";

const {getCounts} = useTransactionService();
const {data: counts} = getCounts()

const monthYear = ref(null)

onMounted(() => {
  const date = new Date();
  date.setMonth(date.getMonth());
  monthYear.value = date.toISOString().slice(0, 7)
})
</script>


<template>
  <div class="mx-5 mb-5 mt-10">
    <div class="flex content-center justify-center gap-5 mb-5">
      <div v-for="(count, key) in counts">
        <SimpleWidget :title="key" :number="count" color="#50d71e"/>
      </div>
    </div>
    <BarChartCases/>
    <div class="flex gap-5 mb-5">
      <PieChartCases/>
      <TopBarangayCases/>
    </div>
    <div class="rounded-2xl shadow-sm p-6 border border-gray-200">
      <div class="grid grid-cols-2 gap-2 w-full">
        <div>
          <div class="legend">
            <div class="title">Risk Levels for Animal Bite Cases</div>
            <div class="item"><span class="color low"></span>Low Risk (0-5 cases) – Minimal cases, routine precautions
              recommended.
            </div>
            <div class="item"><span class="color moderate"></span>Moderate Risk (6-15 cases) – Increased cases, clinics
              should
              prepare supplies.
            </div>
            <div class="item"><span class="color high"></span>High Risk (16-30 cases) – Significant rise, ensure staff
              readiness and vaccine availability.
            </div>
            <div class="item"><span class="color critical"></span>Critical Risk (31+ cases) – Very high cases, urgent
              preparedness needed.
            </div>
          </div>
        </div>
        <div>
          <div class="font-bold">Choose Month and Year:</div>
          <input type="month" class="input input-bordered w-full" v-model="monthYear">
        </div>
      </div>
      <MapWidget :monthYear="monthYear"/>
    </div>
    <div class="flex gap-5 mb-5">
      <BarangayCases :monthYear="monthYear" />
      <PieChartBarangayCases :monthYear="monthYear" />
    </div>
    <div class="flex gap-5 mb-5">
      <PieChartGenderBarangayCases :monthYear="monthYear" />
      <PieChartAgeBarangayCases :monthYear="monthYear" />
    </div>
  </div>
</template>

<style scoped>
.legend {
  .title {
    font-weight: bolder;
  }

  .item {
    .color {
      display: inline-block;
      width: 20px;
      height: 20px;
      margin-right: 10px;

      &.low {
        background-color: #00d26a;
      }

      &.moderate {
        background-color: #fcd53f;
      }

      &.high {
        background-color: #ff6723;
      }

      &.critical {
        background-color: #f8312f;
      }
    }
  }
}
</style>
