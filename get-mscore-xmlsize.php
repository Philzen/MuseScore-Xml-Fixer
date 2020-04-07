<?php

$filesToCount = [];
exec("grep -rwl '^<?xml' /home/phil/prog/oss/MuseScore/mtest/", $filesToCount);
$totalSize = 0;
foreach ($filesToCount as $fileName) {    
    $totalSize += filesize($fileName);
}

echo "Files checked: " . count($filesToCount) . "\n";
echo "Total filesize: $totalSize" . "\n";