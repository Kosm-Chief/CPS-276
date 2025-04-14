<?php
function getWeather() {
    if (empty($_POST['zip_code'])) {
        return ["No zip code provided. Please enter a zip code."];
    }

    $zip = urlencode($_POST['zip_code']);
    $url = "https://russet-v8.wccnet.edu/~sshaper/assignments/assignment10_rest/get_weather_json.php?zip_code={$zip}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($json, true);

    if (isset($data['error'])) {
        return [$data['error']];
    }

    // Extract searched city
    $city = $data['searched_city'];
    $output = "<h3>{$city['name']}</h3>";
    $output .= "<p><strong>Temperature:</strong> {$city['temperature']}</p>";
    $output .= "<p><strong>Humidity:</strong> {$city['humidity']}</p>";
    $output .= "<p><strong>3-day forecast</strong></p><ul>";
    foreach ($city['forecast'] as $day) {
        $output .= "<li>{$day['day']}: {$day['condition']}</li>";
    }
    $output .= "</ul>";

    // Cities with higher temps
    $output .= "<h5>Up to three cities where temperatures are higher than {$city['name']}</h5>";
    if (!empty($data['higher_temperatures'])) {
        $output .= "<table class='table table-striped'><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";
        foreach ($data['higher_temperatures'] as $entry) {
            $output .= "<tr><td>{$entry['name']}</td><td>{$entry['temperature']}</td></tr>";
        }
        $output .= "</tbody></table>";
    } else {
        $output .= "<p>There are no cities with temperatures higher than {$city['name']}.</p>";
    }

    // Cities with lower temps
    $output .= "<h5>Up to three cities where temperatures are lower than {$city['name']}</h5>";
    if (!empty($data['lower_temperatures'])) {
        $output .= "<table class='table table-striped'><thead><tr><th>City Name</th><th>Temperature</th></tr></thead><tbody>";
        foreach ($data['lower_temperatures'] as $entry) {
            $output .= "<tr><td>{$entry['name']}</td><td>{$entry['temperature']}</td></tr>";
        }
        $output .= "</tbody></table>";
    } else {
        $output .= "<p>There are no cities with temperatures lower than {$city['name']}.</p>";
    }

    return ["", $output];
}
