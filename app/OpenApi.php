<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Pet Management API',
    description: 'API for managing pets and bookings'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Local Server'
)]
class OpenApi
{
}