
<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useGoogleMaps } from '@/composables/useGoogleMaps'
const {getTopBarangay} = useTransactionService();
const {data: barangays, loading, execute} = getTopBarangay({immediate: false});

const mapContainer = ref<HTMLElement | null>(null)
const apiKey = 'AIzaSyA3mWSU5HIN1W_daU3Lqtx-xSCq3GOzaN4' // replace this

const { loadGoogleMaps } = useGoogleMaps(apiKey)
onMounted(async () => {
  await execute();

  try {
    await loadGoogleMaps()

    if (mapContainer.value && window.google) {
      const map = new window.google.maps.Map(mapContainer.value, {
        center: { lat: 13.9476859, lng: 121.3582056 }, // Example: Manila
        zoom: 11,
      })


      for (const barangay of barangays.value) {
        const position = {
          lat: parseFloat(barangay.latitude),
          lng: parseFloat(barangay.longitude),
        }

        console.log(barangay.latitude)
        const cityCircle = new window.google.maps.Circle({
          strokeColor: "#0000FF",
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: "#0000FF",
          fillOpacity: 0.35,
          map,
          center: {
            lat: parseFloat(barangay.latitude),
            lng: parseFloat(barangay.longitude),
          },
          radius: Math.sqrt(50) * 100,
        })

        const content = document.createElement('div')
        content.innerHTML = `
          <strong>${barangay.name}</strong><br />
          Population: ${barangay.population ?? 'N/A'}
        `

        const popup = new Popup(position, content)
        popup.setMap(map)

      }
    }


  } catch (e) {
    console.error('Failed to load Google Maps:', e)
  }
})
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