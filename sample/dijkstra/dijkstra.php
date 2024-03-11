<?php

require_once("../../dijkstra.php");

$stationName = [
    "Hiroshima", // 0
    "Kaitaichi", // 1
    "Kure", // 2
    "Saijo", // 3
    "Mihara", // 4
    "Fukuyama", // 5
    "Iwakuni", // 6
    "Miyoshi", // 7
    "Shobara" // 8
];

$adjacentList = [
    [1,6,7], // Hiroshima
    [0,2,3], // Kaitaichi
    [1,4], // Kure
    [1,4], // Saijo
    [2,3,5], // Mihara
    [4,7], // Fukuyama
    [0], // Iwakuni
    [0,5,8], // Miyoshi
    [7] // Shobara
];

$INF = PHP_INT_MAX;

$stationCount = count($adjacentList);
$startStation = 0;
$dist = array_fill(0, $stationCount, $INF);

$dijkstra = new Dijkstra();
$dijkstra->dijkstra($adjacentList, $stationCount, $startStation, $dist);

echo $stationName[$startStation].PHP_EOL;
for ($i = 0; $i < $stationCount; $i++) {
    if ($i == $startStation) continue;
    echo " => ".$stationName[$i]."(Dist:".$dist[$i].")".PHP_EOL;
}
