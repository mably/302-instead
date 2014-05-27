<?php

    /*
     Plugin Name: 302 Instead + 301 for YOURLS URLs
     Plugin URI: https://github.com/EpicPilgrim/302-instead
     Description: Send a 302 (temporary) redirects that do not redirect to other short URLs and a 301 for YOURLS URLs
     Version: 1.2
     Author: BrettR / Tim Crockford
     Author URI: https://github.com/timcrockford/302-instead
     */

    yourls_add_action('pre_redirect', 'temp_instead_function');

    // This function will check the URL and the HTTP status code of the passed
    // in arguments. If the URL happens to be an existing short URL on the same
    // YOURLS installation, it does nothing. Otherwise it will send a 302
    // redirect. Useful when you want to change the short URLs that end users
    // might be using but you can't change.
    
    function temp_instead_function($args) {
        $url   = $args[0];
        $code  = $args[1];
        $match = strpos($url, yourls_site_url());
        
        // We check here if the url contains the YOURLS installation address,
        // and if it doesn't we'll return a 302 redirect if it isn't getting
        // one already.
        if ( $code != 302 && $match === false ) {
            yourls_redirect($url, 302);
        }

        // We check here if the url contains the YOURLS installation address,
        // and if it does we'll return a 301 redirect if it isn't getting
        // one already.
        if ( $code != 301 && $match !== false ) {
            yourls_redirect($url, 301);
        }
    }
?>