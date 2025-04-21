import { ref } from 'vue'

const isLoaded = ref(false)

export function useGoogleMaps(apiKey: string) {
    function loadGoogleMaps(): Promise<void> {
        return new Promise((resolve, reject) => {
            if (isLoaded.value) return resolve()

            if (document.getElementById('google-maps-script')) {
                isLoaded.value = true
                return resolve()
            }

            const script = document.createElement('script')
            script.id = 'google-maps-script'
            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}`
            script.async = true
            script.defer = true

            script.onload = () => {
                isLoaded.value = true
                resolve()
            }

            script.onerror = (err) => reject(err)

            document.head.appendChild(script)
        })
    }

    return {
        loadGoogleMaps,
        isLoaded,
    }
}
