<?php
// General App Configuration

define('BASE_URL', 'http://localhost/SmartAlarmSystem/public/');

// Database Settings (optional if not embedded in db.inc.php)
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'smartalarm');
// define('DB_USER', 'root');
// define('DB_PASS', '');

// Weather API Configuration
define('WEATHER_API_KEY', 'your_openweathermap_api_key');
define('WEATHER_API_URL', 'https://api.openweathermap.org/data/2.5/weather');

// Traffic API Configuration
define('TRAFFIC_API_KEY', 'your_google_or_tomtom_api_key');
define('TRAFFIC_API_URL', 'https://api.tomtom.com/traffic/services/4/flowSegmentData/relative0/10/json');

// Timezone
date_default_timezone_set('Africa/Cairo');

// Feature Flags
define('DEBUG_MODE', true);
define('ENABLE_DECORATORS', true);
