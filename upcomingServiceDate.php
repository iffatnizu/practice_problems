<?php
$service = '01/01/2020';
$start = '04/01';
$end = '06/30';

function isDateFallInside(string $start, string $end, string $service){
    $serviceYear =  date('Y', strtotime($service));
    if($start >= $end){
        $startWithY = date($serviceYear .'-m-d', strtotime($start));
        $endWithY = date($serviceYear + 1 .'-m-d', strtotime($end));
    } else {
        $startWithY = date($serviceYear .'-m-d', strtotime($start));
        $endWithY = date($serviceYear .'-m-d', strtotime($end));
    }
    $serviceYmd = date('Y-m-d', strtotime($service));
    return ($serviceYmd >= $startWithY) && ($serviceYmd <= $endWithY);
}

if(isDateFallInside($start, $end, $service)){
    echo 'True';
} else {
    echo 'False';
}
?>
