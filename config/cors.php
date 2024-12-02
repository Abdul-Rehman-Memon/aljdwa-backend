<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

        'paths' => ['api/*'], // Paths that will accept CORS requests.
    
        'allowed_methods' => ['GET', 'POST', 'PUT', 'OPTIONS'], // HTTP methods allowed.
    
        'allowed_origins' => ['https://dvb.dev.aljdwa.com'], // Add other trusted origins.
    
        'allowed_origins_patterns' => ['*.dev.aljdwa.com'], // Use wildcards for subdomains if needed.
    
        'allowed_headers' => [
            'Content-Type', 
            'X-Requested-With', 
            'Authorization', 
            'Accept-Language', 
            'Origin',
            'Cache-Control'
        ], // Specify commonly used headers for security.
    
        'exposed_headers' => [
            'Authorization',
            'X-RateLimit-Limit', 
            'X-RateLimit-Remaining', 
            'X-RateLimit-Reset'
        ], // Headers that can be exposed to the browser.
    
        'max_age' => 3600, // Cache preflight response for 1 hour.
    
        'supports_credentials' => true, // Allow cookies or HTTP authentication with cross-origin requests.
    ];
