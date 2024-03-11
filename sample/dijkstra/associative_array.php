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
    [1=>1, 6=>3, 7=>5], // Hiroshima
    [0=>1, 2=>2, 3=>2], // Kaitaichi
    [1=>2, 4=>5], // Kure
    [1=>2, 4=>2], // Saijo
    [2=>5, 3=>2, 5=>1], // Mihara
    [4=>1 ,7=>5], // Fukuyama
    [0=>3], // Iwakuni
    [0=>5, 5=>5, 8=>1], // Miyoshi
    [7=>1] // Shobara
];

$INF = PHP_INT_MAX;

$stationCount = count($adjacentList);
$startStation = 0;
$dist = array_fill(0, $stationCount, $INF);
$prev = array_fill(0, $stationCount, -1);

$dijkstra = new Dijkstra();
$dijkstra->dijkstra_dist($adjacentList, $stationCount, $startStation, $dist, $prev);

echo $stationName[$startStation].PHP_EOL;
for ($i = 0; $i < $stationCount; $i++) {
    if ($i == $startStation) continue;
    echo " => ".$stationName[$i]."(Dist:".$dist[$i].")".PHP_EOL;
}

echo PHP_EOL;

$path = $dijkstra->getPath($prev, 5);
for ($i = 0; $i < count($path); $i++) {
    echo $stationName[$path[$i]];

    if ($i != count($path)-1) echo " => ";
}
