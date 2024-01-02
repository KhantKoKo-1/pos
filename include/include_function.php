<?php
function convertDateFormatYmd($dateString) {
    $dateTime = new DateTime($dateString);
    $newFormat = $dateTime->format('Y-m-d');
    return $newFormat;
}

function convertDateFormatMdy($dateString) {
    $dateTime = new DateTime($dateString);
    $newFormat = $dateTime->format('m/d/Y');
    return $newFormat;
}
?>
