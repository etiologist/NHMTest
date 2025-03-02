<html>
   <head>
    <title>Microsoft Power BI - API test</title>
    </head>
   <body>
   
<h1>Microsoft Power BI - API test</h1>
<table>
<?php
// Turn off error reporting
error_reporting(0);
$ch = curl_init();
$url = 'https://api-eu.hosted.exlibrisgroup.com/almaws/v1/analytics/reports';
$queryParams = '?' . urlencode('path') . '=' . urlencode('/shared/Natural History Museum UK (NHM)/Reports/Harwell/Top Stats') . '&' . urlencode('limit') . '=' . urlencode('500') . '&' . urlencode('apikey') . '=' . urlencode('l7xx277d3e08fbd54018b3b00028360e48af');
curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);
/* creates xml array */
$alma_analytics_result_array = simplexml_load_string($response);
$rowset = $alma_analytics_result_array ->QueryResult->ResultXml->rowset;
function remote_file_exists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if( $httpCode == 200 ){return true;}
}




echo '<table>';  
  
 foreach ($rowset->Row as $row_number){
 echo '<tr><td>' . $row_number[0]->Column1 . ' </td><td>' . $row_number[0]->Column2 .'</td><td>' . $row_number[0]->Column3 .'</td></tr>';
 
 }
 echo '</table>';
    
?>
  
  </body>
</html>
