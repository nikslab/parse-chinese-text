#!/usr/bin/php
<?php
/**
 * @name    parsestdin.php
 * @author  Nik Stankovic 2014
 * @see     http://github.com/nikslab
 *
 * Read in Chinese text from STDIN and, parse it with parseChinese and
 * send it back out the other end on STDOUT.
 *
 * Words separated by "|"
 *
 */

require_once("parseChinese.php");

// Preload the entire text from STDIN
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