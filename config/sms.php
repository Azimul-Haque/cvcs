<?php
return [
  // SMS Gateway API Url
  'url'      => env('SMS_GATEWAY_URL', 'http://66.45.237.70/api.php'),
  'username' => env('SMS_GATEWAY_USERNAME', '01751398392'),
  'password' => env('SMS_GATEWAY_PASSWORD', 'Bulk.Sms.Bd.123'),

  // GP SMS Gateway API Url
  'gp_url'      => env('GP_SMS_GATEWAY_URL', 'https://gpcmp.grameenphone.com/gpcmpapi/messageplatform/controller.home'),
  'gp_username' => env('GP_SMS_GATEWAY_USERNAME', 'CAVCSAdmin_3978'),
  'gp_password' => env('GP_SMS_GATEWAY_PASSWORD', 'API_CVCSbd_123'),
];