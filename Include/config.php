<?php

define('BASE_URL', 'http://localhost/SmartAlarmSystem/public/');

// Weather API Configuration
define('WEATHER_API_KEY', 'f6087a9d0837cc795aa8bf0bc6f265f4');
define('WEATHER_API_URL', 'https://api.openweathermap.org/data/2.5/weather');

// Traffic API Configuration
define('TRAFFIC_API_KEY', 'AIzaSyBvafIp6MjnAp8mbJuw5vPUkrtrTw4ckWA');
define('TRAFFIC_API_URL', 'https://maps.googleapis.com/maps/api/distancematrix/json');


// Timezone
date_default_timezone_set('Africa/Cairo');


define('DEBUG_MODE', true);
define('ENABLE_DECORATORS', true);
