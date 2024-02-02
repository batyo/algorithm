<?php

require_once("../interval_scheduling.php");

$schedules = [
    ["start_time" => 900, "end_time" => 1200],
    ["start_time" => 600, "end_time" => 1000],
    ["start_time" => 1100, "end_time" => 1230],
    ["start_time" => 1300, "end_time" => 1500],
    ["start_time" => 800, "end_time" => 1000]
];

$scheduling = new IntervalScheduling();
$decidedScheduleCount = $scheduling->selectSchedul($schedules);

echo "Schedule Count => ".$decidedScheduleCount;
