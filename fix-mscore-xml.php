<?php

function fixXmlIndention(array $xml, string $fileName) : array {
    
    $isDirty = false;
    $lineCount = sizeof($xml);
    for ($i = 1; $i < $lineCount - 1; $i++) {

        $isIndentedClosingTag = strpos($xml[$i], "  </") !== false && substr($xml[$i], -2) !== "/>";

        $previousIsClosingTag = strpos($xml[$i-1], "</") !== false;
        $previousIsOpeningTag = !$previousIsClosingTag && strpos($xml[$i-1], "  <") !== false;
        $previousIsTextContent = !$previousIsClosingTag && !$previousIsOpeningTag;
        $hasSameIndentationAsPrevious = strlen($xml[$i-1]) - strlen(trim($xml[$i-1])) === strlen($xml[$i]) - strlen(trim($xml[$i]));
        $hasMoreIndentationAsPrevious = strlen($xml[$i-1]) - strlen(trim($xml[$i-1])) < strlen($xml[$i]) - strlen(trim($xml[$i]));
        
        $hasWrongIndentation = $isIndentedClosingTag 
                && (($previousIsClosingTag && $hasSameIndentationAsPrevious) 
                    || ($previousIsOpeningTag && $hasMoreIndentationAsPrevious)
                    || ($previousIsTextContent && $hasSameIndentationAsPrevious));
        
        if (false === $hasWrongIndentation) {
            continue;
        }
        
        $xml[$i] = substr($xml[$i], 2);
        $isDirty = true;
    }

    // Check if last line needs to be processed
    if (strpos($xml[$lineCount-1], "  </") !== false) {
        $xml[$lineCount-1] = substr($xml[$i], 2);
        $isDirty = true;
    }

    if ($isDirty) {
        echo "Processed file '$fileName'...\n";
    }
    
    return $xml;
}

$filesToSkip = [
    "mtest/libmscore/parts/part-image-parts.mscx",          // invalid (unopened </BarLine>)
    "mtest/libmscore/parts/part-all-insertmeasures.mscx",   // invalid (unopened </BarLine>)
    "mtest/musicxml/io/testMultipleNotations.xml",          // malformed anyway
];
$filesToFix = [];
exec("grep -rwl '^<?xml' /home/phil/prog/oss/MuseScore/mtest/", $filesToFix);
foreach ($filesToFix as $fileName) {

    foreach ($filesToSkip as $skipFile) {
        if (strpos($fileName, $skipFile) !== false) {
            continue 2;
        }
    }
    
    file_put_contents($fileName, 
        fixXmlIndention(file($fileName), $fileName)
    );
}