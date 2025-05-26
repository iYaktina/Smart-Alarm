document.addEventListener('DOMContentLoaded', () => {
  const alarmTypeSelect = document.getElementById('alarm_type');
  const smartOptionsDiv = document.getElementById('smart-options');

  const useTrafficCheckbox = document.getElementById('use_traffic');
  const useWeatherCheckbox = document.getElementById('use_weather');

  const trafficModal = document.getElementById('traffic-modal');
  const weatherModal = document.getElementById('weather-modal');
  const mapModal = document.getElementById('map-modal');

  const closeTraffic = document.getElementById('close-traffic');
  const closeWeather = document.getElementById('close-weather');
  const closeMap = document.getElementById('close-map');

  const useDeviceLocationRadio = document.getElementById('use-device-location');
  const chooseOnMapRadio = document.getElementById('choose-on-map');
  const chooseEndLocationButton = document.getElementById('choose-end-location');

  const trafficStartInput = document.getElementById('traffic_start_modal');
  const trafficEndInput = document.getElementById('traffic_end_modal');
  const trafficStartSub = document.getElementById('traffic_start');
  const trafficEndSub = document.getElementById('traffic_end');

  const tempMinInput = document.getElementById('temp_min_modal');
  const tempMaxInput = document.getElementById('temp_max_modal');
  const tempMinSub = document.getElementById('temp_min');
  const tempMaxSub = document.getElementById('temp_max');

  const confirmTrafficButton = document.getElementById('confirm-traffic');
  const confirmWeatherButton = document.getElementById('confirm-weather');
  const confirmLocationButton = document.getElementById('confirm-location');

  let map, marker, selectedLatLng = null;
  let locationType = ''; 

  alarmTypeSelect.addEventListener('change', () => {
    const isSmart = alarmTypeSelect.value === 'smart';
    smartOptionsDiv.style.display = isSmart ? 'block' : 'none';
    useTrafficCheckbox.checked = false;
    useWeatherCheckbox.checked = false;
    trafficModal.classList.remove('active');
    weatherModal.classList.remove('active');
  });

  useTrafficCheckbox.addEventListener('change', () => {
    if (useTrafficCheckbox.checked) {
      trafficModal.classList.add('active');
    } else {
      trafficModal.classList.remove('active');
      trafficStartInput.value = '';
      trafficEndInput.value = '';
    }
  });

  useWeatherCheckbox.addEventListener('change', () => {
    if (useWeatherCheckbox.checked) {
      weatherModal.classList.add('active');
    } else {
      weatherModal.classList.remove('active');
      tempMinInput.value = '';
      tempMaxInput.value = '';
    }
  });

  closeTraffic.onclick = () => {
    trafficModal.classList.remove('active');
    useTrafficCheckbox.checked = false;
  };

  closeWeather.onclick = () => {
    weatherModal.classList.remove('active');
    useWeatherCheckbox.checked = false;
  };

  closeMap.onclick = () => {
    mapModal.classList.remove('active');
  };

  confirmWeatherButton.addEventListener('click', () => {
    tempMaxSub.value=tempMaxInput.value;
    tempMinSub.value=tempMinInput.value;
    weatherModal.classList.remove('active');
  });

  confirmTrafficButton.addEventListener('click', () => {
    if (!trafficStartInput.value || !trafficEndInput.value) {
      alert('Please select both start and end locations.');
      return;
    }
      trafficStartSub.value=trafficStartInput.value;
      trafficEndSub.value=trafficEndInput.value;
    trafficModal.classList.remove('active');
  });

  useDeviceLocationRadio.addEventListener('change', () => {
    if (useDeviceLocationRadio.checked && navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        pos => {
          trafficStartInput.value = `${pos.coords.latitude},${pos.coords.longitude}`;
        },
        err => {
          alert('Failed to get your location: ' + err.message);
        }
      );
    }
  });

  chooseOnMapRadio.addEventListener('change', () => {
    if (chooseOnMapRadio.checked) {
      locationType = 'start';
      openMapModal();
    }
  });

  chooseEndLocationButton.addEventListener('click', () => {
    locationType = 'end';
    openMapModal();
  });

  confirmLocationButton.addEventListener('click', () => {
    if (!selectedLatLng) {
      alert('Please select a location on the map.');
      return;
    }
    const loc = `${selectedLatLng.lat()},${selectedLatLng.lng()}`;
    if (locationType === 'start') {
      trafficStartInput.value = loc;
    } else if (locationType === 'end') {
      trafficEndInput.value = loc;
    }
    mapModal.classList.remove('active');
  });

  smartOptionsDiv.style.display = alarmTypeSelect.value === 'smart' ? 'block' : 'none';

  function openMapModal() {
    mapModal.classList.add('active');
    if (!map) initMap();
  }

  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: { lat: 30.0444, lng: 31.2357 }, 
      zoom: 12
    });

    marker = new google.maps.Marker({
      position: map.getCenter(),
      map: map,
      draggable: true
    });

    google.maps.event.addListener(marker, 'position_changed', () => {
      selectedLatLng = marker.getPosition();
    });

    google.maps.event.addListener(map, 'click', event => {
      marker.setPosition(event.latLng);
      selectedLatLng = event.latLng;
    });
  }
});
