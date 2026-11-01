<?php

// Isi kuncinya di file .env (jangan ditulis langsung di sini):
//   MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
//   MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
//   MIDTRANS_IS_PRODUCTION=false
return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => (bool) env('MIDTRANS_IS_PRODUCTION', false),
];
