<script setup lang="ts">
import {ref, onMounted} from 'vue'
import {useGoogleMaps} from '@/composables/useGoogleMaps'

const {getTop10BrangayBaseMonthYear} = useTransactionService();
const {data: barangays, loading, execute} = getTop10BrangayBaseMonthYear({immediate: false});

const mapContainer = ref<HTMLElement | null>(null)
const apiKey = 'AIzaSyBpPQinxJkTJGuTgfeEJFj5SxtoaL0kirg' // replace this

const props = defineProps<{
  monthYear: String
}>()

const {loadGoogleMaps} = useGoogleMaps(apiKey)

watch(
    () => props.monthYear,
    async () => {
      await exec();
      loadMaps();
    }
)

const exec = async () => {
  await execute({
    showLoading: true,
    params: {
      monthYear: props.monthYear
    }
  });
};

onMounted(async () => {
  await loadGoogleMaps()
  await exec();
  loadMaps();
})

const loadMaps = () => {
  try {
    if (mapContainer.value && window.google) {
      const map = new window.google.maps.Map(mapContainer.value, {
        center: {lat: 13.9476859, lng: 121.3582056}, // Example: Manila
        zoom: 11,
      })
      for (const barangay of barangays.value) {
        if (parseInt(barangay.transaction_count) === 0)
          continue;
        let color = "#00d26a"
        if (parseInt(barangay.transaction_count) <= 5) {
          color = "#00d26a"
        } else if (parseInt(barangay.transaction_count) <= 15) {
          color = "#fcd53f"
        } else if (parseInt(barangay.transaction_count) <= 30) {
          color = "#ff6723"
        } else  {
          color = "#f8312f"
        }

        const cityCircle = new window.google.maps.Circle({
          strokeColor: color,
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: color,
          fillOpacity: 0.35,
          map,
          center: {
            lat: parseFloat(barangay.latitude),
            lng: parseFloat(barangay.longitude),
          },
          radius: Math.sqrt(50) * 100,
        })

      }
    }
  } catch (e) {
    console.error('Failed to load Google Maps:', e)
  }
}
</script>

<template>
  <div ref="mapContainer" class="map-container"></div>
</template>


<style scoped>
.map-container {
  width: 100%;
  height: 400px;
}
</style>