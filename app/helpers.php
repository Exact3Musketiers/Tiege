<?
use Illuminate\Support\Facades\Http;

if (! function_exists('getWeather'))
{
    function getWeather()
    {
        // Call openweathermap api
        $weatherResponse = Http::get('api.openweathermap.org/data/2.5/weather', [
            'q' => 'sneek,nl',
            'lang' => 'nl',
            'units' => 'metric',
            'APPID' => '2a00ff331d7e11c1e9e53406e66efb78',
        ]);
        // Decode json
        $weather = json_decode($weatherResponse->body());
        // Check if data exists
        if (isset($weather->weather[0])) {
            // Get temoperature
            $temperatureFeels = $weather->main->temp;
            $main = $weather->weather[0]->main;
            // To Jas Or Not To Jas
            $toJas = true;
            if ($temperatureFeels >= 15) {
                if ($main !== 'Rain') {
                    $toJas = false;
                }
            }
            // Get wind
            $windDeg = $weather->wind->deg;
            $windSpeed = $weather->wind->speed;
            $windText = '';
            $windBft = '';
            // Wind speed
            switch ($windSpeed) {
                case $windSpeed >= 0.0 && $windSpeed <= 0.2:
                    $windText = 'windstil';
                    $windBft = 0;
                    break;
                case $windSpeed >= 0.3 && $windSpeed <= 1.5:
                    $windText = 'zwakke wind';
                    $windBft = 1;
                    break;
                case $windSpeed >= 1.6 && $windSpeed <= 3.3:
                    $windText = 'zwakke wind';
                    $windBft = 2;
                    break;
                case $windSpeed >= 3.4 && $windSpeed <= 5.4:
                    $windText = 'matige wind';
                    $windBft = 3;
                    break;
                case $windSpeed >= 5.5 && $windSpeed <= 7.9:
                    $windText = 'matige wind';
                    $windBft = 4;
                    break;
                case $windSpeed >= 8.0 && $windSpeed <= 10.7:
                    $windText = 'vrij krachtige wind';
                    $windBft = 5;
                    break;
                case $windSpeed >= 10.8 && $windSpeed <= 13.8:
                    $windText = 'krachtige wind';
                    $windBft = 6;
                    break;
                case $windSpeed >= 13.9 && $windSpeed <= 17.1:
                    $windText = 'harde wind';
                    $windBft = 7;
                    break;
                case $windSpeed >= 17.2 && $windSpeed <= 20.7:
                    $windText = 'stormachtige wind';
                    $windBft = 8;
                    break;
                case $windSpeed >= 20.8 && $windSpeed <= 24.4:
                    $windText = 'storm';
                    $windBft = 9;
                    break;
                case $windSpeed >= 24.5 && $windSpeed <= 28.4:
                    $windText = 'zware storm';
                    $windBft = 10;
                    break;
                case $windSpeed >= 28.5 && $windSpeed <= 32.6:
                    $windText = 'zeer zware storm';
                    $windBft = 11;
                    break;
                case $windSpeed >= 32.7:
                    $windText = 'orkaan';
                    $windBft = 12;
                    break;
            }
            // Wind direction
            switch ($windDeg) {
                case $windDeg >= 349 && $windDeg <= 360 || $windDeg >= 1 && $windDeg <= 11:
                    $windDirection = 'Noorden';
                    break;
                case $windDeg >= 12 && $windDeg <= 33:
                    $windDirection = 'Noord Noord Oosten';
                    break;
                case $windDeg >= 34 && $windDeg <= 55:
                    $windDirection = 'Noord Oosten';
                    break;
                case $windDeg >= 56 && $windDeg <= 77:
                    $windDirection = 'Oost Noord Oosten';
                    break;
                case $windDeg >= 78 && $windDeg <= 100:
                    $windDirection = 'Oosten';
                    break;
                case $windDeg >= 101 && $windDeg <= 123:
                    $windDirection = 'Oost Zuid Oosten';
                    break;
                case $windDeg >= 124 && $windDeg <= 145:
                    $windDirection = 'Zuid Oosten';
                    break;
                case $windDeg >= 146 && $windDeg <= 168:
                    $windDirection = 'Zuid Zuid Oosten';
                    break;
                case $windDeg >= 169 && $windDeg <= 190:
                    $windDirection = 'Zuiden';
                    break;
                case $windDeg >= 191 && $windDeg <= 211:
                    $windDirection = 'Zuid Zuid Westen';
                    break;
                case $windDeg >= 212 && $windDeg <= 236:
                    $windDirection = 'Zuid Westen';
                    break;
                case $windDeg >= 237 && $windDeg <= 258:
                    $windDirection = 'West Zuid Westen';
                    break;
                case $windDeg >= 259 && $windDeg <= 280:
                    $windDirection = 'Westen';
                    break;
                case $windDeg >= 281 && $windDeg <= 303:
                    $windDirection = 'West Noord Westen';
                    break;
                case $windDeg >= 304 && $windDeg <= 325:
                    $windDirection = 'Noord Westen';
                    break;
                case $windDeg >= 326 && $windDeg <= 348:
                    $windDirection = 'Noord Noord Westen';
                    break;
            }
            // All data in array
            $allWeather = [
                'temperature' => $weather->main->temp,
                'temperatureMax' => $weather->main->temp_max,
                'temperatureMin' => $weather->main->temp_min,
                'temperatureFeels' => $weather->main->feels_like,
                'windText' => $windText,
                'windBft' => $windBft,
                'windDirection' => $windDirection,
                'type' => $weather->weather[0]->description,
                'toJas' => $toJas,
            ];
        }
        // If check fails send error message
        else {
            $allWeather = ['error' => 'De api is boos'];
        }
        // Return weather
        return $allWeather;
    }
}
?>
