<?php

$fileName = "./ContestNotification.csv";
$file = fopen($fileName,'r') or die("File does not exists!");

$jsonArray = array();

while(($line = fgetcsv($file)) !== false){
	$jsonData = array(
		'ParticipantName'=>$line[0],
		'EmailAddress'=>$line[1],
		'NotificationType'=>$line[2]
	);
	$jsonArray[] = $jsonData;
}
fclose($file);


$jsonData = json_encode($jsonArray, JSON_PRETTY_PRINT);

echo "<pre>";
print_r($jsonData);
echo "</pre>";

usort($jsonArray, function ($a, $b) {
    return strcmp($a['ParticipantName'], $b['ParticipantName']);
});

$jsonString = json_encode($jsonArray, JSON_PRETTY_PRINT);

echo '<script>console.log(' . $jsonString . ');</script>';
?>