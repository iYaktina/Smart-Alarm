 const alarmTypeSelect = document.getElementById('alarm_type');
  const smartOptionsDiv = document.getElementById('smart-options');

  const useTrafficCheckbox = document.getElementById('use_traffic');
  const useWeatherCheckbox = document.getElementById('use_weather');

  const trafficModal = document.getElementById('traffic-modal');
  const weatherModal = document.getElementById('weather-modal');

  const closeTraffic = document.getElementById('close-traffic');
  const closeWeather = document.getElementById('close-weather');

  alarmTypeSelect.addEventListener('change', () => {
    smartOptionsDiv.style.display = alarmTypeSelect.value === 'smart' ? 'block' : 'none';
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
      document.getElementById('traffic_start').value = '';
      document.getElementById('traffic_end').value = '';
    }
  });

  useWeatherCheckbox.addEventListener('change', () => {
    if (useWeatherCheckbox.checked) {
      weatherModal.classList.add('active');
    } else {
      weatherModal.classList.remove('active');
      document.getElementById('temp_min').value = '';
      document.getElementById('temp_max').value = '';
    }
  });

  closeTraffic.onclick = () => trafficModal.classList.remove('active');
  closeWeather.onclick = () => weatherModal.classList.remove('active');

  document.getElementById('use-device-location').onclick = () => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(position => {
        const { latitude, longitude } = position.coords;
        document.getElementById('traffic_start').value = latitude + ',' + longitude;
      }, error => {
        alert('Failed to get your location: ' + error.message);
      });
    } else {
      alert('Geolocation is not supported by your browser');
    }
  };

  window.addEventListener('DOMContentLoaded', () => {
    smartOptionsDiv.style.display = alarmTypeSelect.value === 'smart' ? 'block' : 'none';
  });