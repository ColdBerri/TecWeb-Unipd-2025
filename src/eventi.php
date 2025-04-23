<?php
require_once "dbconnections.php";
use DB\DBAccess;

$month = date('n');
$year = date('Y');

$db = new DBAccess();
$eventDays = [];

if ($db->openDBConnection()) {
    $eventDays = $db->getEventiDelMese($month, $year);
    $db->closeConnection();
}

// Calcoli calendario
$firstDay = mktime(0, 0, 0, $month, 1, $year);
$startDayOfWeek = (date('w', $firstDay) + 6) % 7; // inizio da lunedì
$daysInMonth = date('t', $firstDay);

$day = 1;
$totalCells = $startDayOfWeek + $daysInMonth;
$totalWeeks = ceil($totalCells / 7);

for ($week = 0; $week < $totalWeeks; $week++) {
    echo "<tr>";
    for ($i = 0; $i < 7; $i++) {
        $cellIndex = $week * 7 + $i;

        if ($cellIndex < $startDayOfWeek || $day > $daysInMonth) {
            echo "<td></td>";
        } else {
            $class = in_array($day, $eventDays) ? 'class="event-day"' : '';
            echo "<td $class>$day</td>";
            $day++;
        }
    }
    echo "</tr>";
}
?>
