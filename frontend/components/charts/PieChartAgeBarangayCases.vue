<script setup lang="ts">
import { ref, watch, onMounted } from "vue";
import { Chart, registerables } from "chart.js"; 
import { PieChart } from "vue-chart-3"; 


Chart.register(...registerables);

// Kunin ang function na nagbabalik ng bilang ng kagat ng hayop
const { getAgeCountBranch } = useTransactionService();
const {data: transactions, loading, execute} = getAgeCountBranch({immediate: false});

// pang fetchh

const barangay = ref(null)

const exec = async () => {
  await execute({
    showLoading: true,
    params: {
      monthYear: props.monthYear
    }
  });
  if(transactions.value.length > 0)
    barangay.value = transactions.value[0]
};


const props = defineProps<{
  monthYear: String
}>()

const getRandomHexColor = () => {
  return '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
};

// details sa pie chart
const chartData = ref({
  labels: ["N/A"],
  datasets: [
    {
      label: "Animal Bites Count", 
      backgroundColor: [], 
      data: [], 
    },
  ],
});

// Mga setting ng chart
const chartOptions = ref({
  responsive: true, 
  plugins: {
    legend: { position: "bottom" }, 
    tooltip: { enabled: true }, 
  },
});


watch(barangay, (newTransactions) => {
  chartData.value.labels = Object.keys(newTransactions.genders); // para pag pag ni update and data
  chartData.value.datasets[0].data = Object.values(newTransactions.genders); //  Ina-update na ang data ng chart
  chartData.value.datasets[0].backgroundColor = Object.values(newTransactions.genders).map(() => getRandomHexColor());
});


watch(
    () => props.monthYear,
    () => {
      exec();
    }
);


onMounted(() => {
  exec(); //  pang tawag ng api
});
</script>

<template>

  <div class="w-[50%] mt-5 rounded-2xl shadow-sm p-6 border border-gray-200">
    <h2 class="font-bold">No of Age Groups Cases per Barangay</h2>
    <div class="form-control">
      <label class="label">
        <span class="label-text">Barangay</span>
      </label>
      <select
          v-model="barangay"
          class="select select-bordered w-full"
      >
        <option value="">All Barangays</option>
        <option
            v-for="barangay in transactions"
            :value="barangay"
            :key="barangay.id"
        >
          {{ barangay.name }}
        </option>
      </select>
    </div>
    <PieChart :chart-data="chartData" :chart-options="chartOptions" />
  </div>
</template>

<style scoped>
</style>
