<?php
// config/cors.php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    
    'allowed_methods' => ['*'],
    
    'allowed_origins' => [
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'https://next-restuarant-booking-cobb.vercel.app/',
        'https://next-restuarant-booking-cobb.vercel.app/auth/login',
        'https://next-restuarant-booking-cobb.vercel.app/auth/login/',
        'https://next-restuarant-booking-cobb.vercel.app/auth/register',
        'https://next-restuarant-booking-cobb.vercel.app/auth/register/',
        'https://*.vercel.app',
        '',
    ],
    
    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'],
    
    'exposed_headers' => [],
    
    'max_age' => 0,
    
    'supports_credentials' => true,
];