<?php
return [
  // SMS Gateway API Url
  'url'      => env('SMS_GATEWAY_URL'),
  'username' => env('SMS_GATEWAY_USERNAME'),
  'password' => env('SMS_GATEWAY_PASSWORD'),

  // GP SMS Gateway API Url
  'gp_url'      => env('GP_SMS_GATEWAY_URL'),
  'gp_username' => env('GP_SMS_GATEWAY_USERNAME'),
  'gp_password' => env('GP_SMS_GATEWAY_PASSWORD'),
];