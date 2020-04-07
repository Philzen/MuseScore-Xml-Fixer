<?php

function fixXmlIndention(array $xml) : array {
    
    foreach ($xml as &$line) {
        
        if (strstr($line, "  </") === false || substr($line, 0, 2) !== "  ") {
            continue;
        }
    
        $line = substr($line, 2);
    }
    
    return $xml;
}

$filesToFix = [];
exec("grep -rwl '^<?xml' /home/phil/prog/oss/MuseScore/mtest/", $filesToFix);
foreach ($filesToFix as $fileName) {
    echo "Processing file '$fileName'...\n";

    file_put_contents($fileName, 
        fixXmlIndention(file($fileName))
    );
}