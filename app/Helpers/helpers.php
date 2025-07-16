<?php

if (!function_exists('truncateParagraph')) {
    function truncateParagraph($paragraph, $maxLength = 32) {
        if (strlen($paragraph) > $maxLength) {
            return substr($paragraph, 0, $maxLength) . '...';
        }
        return $paragraph;
    }
}

?>