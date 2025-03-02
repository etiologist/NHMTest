<!DOCTYPE html>
<html>
<head>
    <title>PHP Embedded in HTML</title>
</head>
<body>
    <h1>API Data</h1>
    <?php
    // Turn off error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $ch = curl_init();
    $url = 'https://api-eu.hosted.exlibrisgroup.com/almaws/v1/analytics/reports';
    $queryParams = '?' . urlencode('path') . '=' . urlencode('/shared/Natural History Museum UK (NHM)/Reports/Harwell/Top Stats') . '&' . urlencode('limit') . '=' . urlencode('500') . '&' . urlencode('apikey') . '=' . urlencode('l7xx277d3e08fbd54018b3b00028360e48af');
    curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $response = curl_exec($ch);
    if ($response === false) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);

    // Print the response
    echo '<pre>';
    print_r($response);
    echo '</pre>';

    libxml_use_internal_errors(true);
    $alma_analytics_result_array = simplexml_load_string($response);
    if ($alma_analytics_result_array === false) {
        echo "Failed loading XML\n";
        foreach(libxml_get_errors() as $error) {
            echo "\t", $error->message;
        }
        libxml_clear_errors();
        die();
    }

    echo '<pre>';
    print_r($alma_analytics_result_array);
    echo '</pre>';

    $rowset = $alma_analytics_result_array->QueryResult->ResultXml->rowset;

    echo '<table>';
    foreach ($rowset->Row as $row_number) {
        echo '<tr><td>' . $row_number->Column1 . ' </td><td>' . $row_number->Column2 . '</td><td>' . $row_number->Column3 . '</td></tr>';
    }
    echo '</table>';
    ?>
</body>
</html>
