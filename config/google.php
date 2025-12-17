<?php

return [
  'client_id' => getenv('GOOGLE_CLIENT_ID') ?: '',
  'client_secret' => getenv('GOOGLE_CLIENT_SECRET') ?: '',
  'redirect_uri' => getenv('GOOGLE_REDIRECT_URI') ?: 'http://localhost:8080/auth/google/callback',
  'auth_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
  'token_url' => 'https://oauth2.googleapis.com/token',
  'user_info_url' => 'https://www.googleapis.com/oauth2/v2/userinfo',
  'scopes' => 'openid email profile',
];

