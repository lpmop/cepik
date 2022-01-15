<?php
$wojewodztwa = ["02", "04", "06", "08", "10", "12", "14", "16", "18", "20", "22", "24", "26", "28", "30", "32", "XX"];
$wynik_jeepy = [];
foreach ($wojewodztwa as $woj) {
    $strona = 1;
    do {
        $ch = curl_init();
        $url = "https://api.cepik.gov.pl/pojazdy?wojewodztwo={$woj}&data-od=20210101&data-do=20220101&typ-daty=1&tylko-zarejestrowane=true&pokaz-wszystkie-pola=true&limit=500&page={$strona}&filter[marka]=JEEP&filter[model]=WRANGLER
        echo $url . PHP_EOL;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        // zapisywane lokalnie aby nie odpytywać ponownie
        // file_put_contents("wrangler$woj-$strona.json", $output);
        curl_close($ch);
        $response = json_decode($output, true);
        if (!empty($response['data'])) {
            foreach ($response['data'] as $car) {
                $wynik_jeepy[$car['attributes']['pochodzenie-pojazdu']]++;
                //$wynik_jeepy[$woj][$car['attributes']['pochodzenie-pojazdu']]++;
            }
            if (count($response['data']) < 450) {
                break;
            }
        } else {
            break;
        }
        $strona++;
    } while (1);
    print_r($wynik_jeepy);
}
