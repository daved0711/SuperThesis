<script setup lang="ts">

const {getTop10BrangayBaseMonthYear} = useTransactionService();
const {data: transactions, loading, execute} = getTop10BrangayBaseMonthYear({immediate: false});


const exec = () => {
  execute({
    showLoading: true,
    params: {
      monthYear: props.monthYear,
    },
  });
};

const props = defineProps<{
  monthYear: String
}>()

watch(
    () => props.monthYear,
    async () => {
      exec();
    }
);


</script>
<template>
  <div class="w-[50%] mt-5 rounded-2xl shadow-sm p-6 border border-gray-200">
    <h2 class="font-bold">No of Cases per Barangay</h2>
    <div class="h-[500px] overflow-y-auto">
      <table class="table table-zebra over">
        <thead>
        <tr>
          <th>#</th>
          <th>Barangay</th>
          <th>Cases</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(value, index) in transactions">
          <td>{{ index + 1 }}</td>
          <td>{{ value.name }}</td>
          <td>{{ value.transaction_count }}</td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>

</style>