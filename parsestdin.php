#!/usr/bin/php
<?php

require_once("parseChinese.php");

// Load text from STDIN
$text = "";
while($f = fgets(STDIN)){
    $text .= $f;    
}

$parsed = parseChinese($text, "mandarin_words.txt");

// Print out parsed text
$count = count($parsed);
for ($i=0; $i < $count; $i++) {
    print $parsed[$i] . " | ";
}

print "\n";

?>