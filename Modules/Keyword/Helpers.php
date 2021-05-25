<?php

if (!function_exists('most_frequent_words')) {
    function most_frequent_words($string, $blacklist = [], $limit = 5) {
        $string = strtolower($string); // Make string lowercase
    
        $words = str_word_count($string, 1); // Returns an array containing all the words found inside the string
        $words = array_diff($words, $blacklist); // Remove black-list words from the array
        $words = array_count_values($words); // Count the number of occurrence
    
        arsort($words); // Sort based on count
    
        return array_slice($words, 0, $limit); // Limit the number of words and returns the word array
    }
}