<?php

namespace Webshop\Core;

/**
 * Utility Class
 *
 * Class Util
 * @package Webshop\Core
 */
class Util
{
    /**
     * Clean a string from spaces and unwanted chars
     * @param string $text
     * @return string
     */
    static function cleanString(string $text): string
    {
        $text = str_replace(' ', '', $text); // Replaces all spaces with hyphens.
        $text = preg_replace('/[^A-Za-z0-9\-]/', '', $text); // Removes special chars.
        return preg_replace('/-+/', '', $text); // Replaces multiple hyphens with single one.
    }

    /**
     * Strip H tags from text and truncate the text to $length chars
     * @param $text text to clean
     * @param $length Maximal length to keep
     * @return string
     */
    static function cleanStringAndTruncate($text, $length)
    {
        $text = (strlen($text) > $length) ? substr($text, 0, $length) . '...' : $text;
        // Remove all headings and text
        $text = preg_replace('#<h([1-6])>(.*?)<\/h[1-6]>#si', '', $text);
        // Strip tags
        return strip_tags($text);
    }

    static function validateHtml($html)
    {
        $dom = new \DOMDocument;
        $dom->loadHTML($html); // see docs for load, loadXml, loadHtml and loadHtmlFile
        if ($dom->validate()) {
            echo "This document is valid!\n";
        }
        return $dom->validate();
    }

    /**
     * Throw an error en move the user to a page
     *
     * @param $page Page to redirect to
     * @param $errorKey Error number
     * @param $errorValue Error text
     * @param bool $unsetUser Remove user from session
     */
    static function redirectWithError($page, $errorKey, $errorValue, $unsetUser = false)
    {
        $_SESSION[$errorKey] = $errorValue;
        if ($unsetUser) {
            unset($_SESSION[user]);
        }
        header('Location: ' . $page);
    }

    /**
     * Delete a specific element
     * @param $element
     * @param $array
     */
    static function deleteElement($element, &$array)
    {
        $index = array_search($element, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
    }

    /**
     * Get the amount of items in de shopping cart
     * @return int Amount of cart items
     */
    static function getNrCartItems()
    {
        if (isset($_SESSION['cart']))
            $nrCartItems = count($_SESSION['cart']);
        else {
            $nrCartItems = 0;
        }
        return $nrCartItems;
    }

    /**
     * Check if the variable is in the session
     * @param $variabele Name of the variable to check
     * @return bool
     */
    static function checkExcistInSession($variabele)
    {
        if (array_key_exists ($variabele, $_SESSION)) {
            if (isset($variabele) && !empty($variabele)) {
                return true;
            }
        }
        return false;
    }
}
