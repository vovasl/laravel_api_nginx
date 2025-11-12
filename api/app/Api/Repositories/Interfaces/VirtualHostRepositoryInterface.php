<?php

namespace App\Api\Repositories\Interfaces;

use Illuminate\Http\JsonResponse;

interface VirtualHostRepositoryInterface
{
    public function createVirtualHost(string $domain): JsonResponse;

    public function deleteVirtualHost(string $domain): JsonResponse;
}
