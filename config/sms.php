<?php
return [
  // SMS Gateway API Data
  'url'      => env('SMS_GATEWAY_URL'),
  'username' => env('SMS_GATEWAY_USERNAME'),
  'password' => env('SMS_GATEWAY_PASSWORD'),

  // GreenWeb Gateaway API Data
  'gw_url'    => env('GREEN_WEB_URL'),
  'gw_token'  => env('GREEN_WEB_API_TOKEN'),

  // GP SMS Gateway API Data
  'gp_url'      => env('GP_SMS_GATEWAY_URL'),
  'gp_username' => env('GP_SMS_GATEWAY_USERNAME'),
  'gp_password' => env('GP_SMS_GATEWAY_PASSWORD'),

    // New SMS Panel Gateway API Data
  'url2'      => env('SMS_GATEWAY_URL2'),
  'senderid' => env('SMS_GATEWAY_SENDERID'),
  'api_key' => env('SMS_GATEWAY_API_KEY'),
];