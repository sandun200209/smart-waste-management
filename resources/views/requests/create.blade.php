<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Pickup Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('request.store') }}" method="POST">
                    @csrf
                    
                    <div id="map" style="height: 400px; width: 100%;" class="mb-4 rounded border"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="latitude" :value="__('Latitude')" />
                            <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full bg-gray-100" required readonly />
                        </div>
                        <div>
                            <x-input-label for="longitude" :value="__('Longitude')" />
                            <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full bg-gray-100" required readonly />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Pickup Address / Landmark')" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Submit Waste Pickup Request') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    <script>
        function initMap() {
            const defaultPos = { lat: 6.9271, lng: 79.8612 }; // Colombo
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13, 
                center: defaultPos,
            });

            let marker = new google.maps.Marker({ 
                map: map,
                draggable: true,
                position: defaultPos 
            });

            // Map click marker lat/lng inputs 
            map.addListener("click", (e) => {
                const pos = e.latLng;
                marker.setPosition(pos);
                document.getElementById("latitude").value = pos.lat();
                document.getElementById("longitude").value = pos.lng();
            });
            
            // Marker drag position 
            marker.addListener("dragend", (e) => {
                const pos = e.latLng;
                document.getElementById("latitude").value = pos.lat();
                document.getElementById("longitude").value = pos.lng();
            });
        }
        window.onload = initMap;
    </script>
</x-app-layout>