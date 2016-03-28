<?php
/**
 * @name    parseChinese.php
 * @author  Nik Stankovic 2014
 * @see     http://github.com/nikslab
 */

function parseChinese($text, $dictionary) {
/**
 * Parses Chinese text relying on a dictionary.
 * Dictionary is a text file, one word per line with no other content.
 * 
 * @param   $text           Text to parse
 * @param   $dictionary     Path and filename where to find the dictionary
 *
 */

    $text_converted = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);

    $text_length = mb_strlen($text_converted, 'UTF-8');
    
    // Load dictionary into associative array $dict for easy search
    $words = file($dictionary);
    foreach ($words as $word) {
        $word = rtrim($word);
        $word_converted = iconv(mb_detect_encoding($word, mb_detect_order(), true), "UTF-8", $word);
        $dict[$word_converted] = true;
    }
    
    // Prep
    $give_up = 5;
    $start_word = 0;
    $pointer = 0;
    $parsed = array();
    
    // Parsing main loop
    while ($pointer <= $text_length) {
        
        $try = $give_up;
        $not_found = true;
        
        while ( ($not_found) && ($try > 0) ) {
            $test = mb_substr($text_converted, $pointer, $try, 'UTF-8');
            if (isset($dict[$test])) { // found it! 
                $not_found = false;
                $parsed[] = $test; // We'll just take it without much ado
            }
            $try--;
        }
        
        if ($not_found) {
            $parsed[] = mb_substr($text, $pointer, 1, 'UTF-8');
            $pointer++;
        } else {
            $pointer += $try + 1;
        }
        
    }
    
    return $parsed;

}

?>