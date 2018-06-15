<?php

namespace Webshop\Core;


class Util
{
    static function cleanString(string $text): string
    {
        $text = str_replace(' ', '', $text); // Replaces all spaces with hyphens.
        $text = preg_replace('/[^A-Za-z0-9\-]/', '', $text); // Removes special chars.
        return preg_replace('/-+/', '', $text); // Replaces multiple hyphens with single one.
    }

    static function cleanStringAndTruncate( $text, $length)
    {
        $text = (strlen($text) > 150) ? substr($text, 0, 200) . '...' : $text;
        // Remove all headings and text
        $text = preg_replace('#<h([1-6])>(.*?)<\/h[1-6]>#si', '', $text);
        // Strip tags
        return strip_tags($text);
    }

}
