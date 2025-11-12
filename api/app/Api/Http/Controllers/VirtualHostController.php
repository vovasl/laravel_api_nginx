<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\VirtualHostRequest;
use App\Api\Repositories\Interfaces\VirtualHostRepositoryInterface;

class VirtualHostController extends ApiController
{
    public function __construct(private readonly VirtualHostRepositoryInterface $repository) {}

    public function store(VirtualHostRequest $request)
    {
        $domain = $request->validated()['domain'];

        return $this->repository->createVirtualHost($domain);
    }

    public function destroy(string $domain)
    {
        return $this->repository->deleteVirtualHost($domain);
    }
}
