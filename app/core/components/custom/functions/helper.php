<?php

/**
 * Get URL
 *
 * @param boolean $location
 * @return void
 */

function getWebsiteUrl($location = false) {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
    else $link = "http";
    
    // Here append the common URL characters.
    $link .= "://";
    
    // Append the host(domain name, ip) to the URL.
    $link .= $_SERVER['HTTP_HOST'];
    
    // Append the requested resource location to the URL
    if($location) {
        $link .= $_SERVER['REQUEST_URI'];
    }
    
    // Print the link
    return $link;
}