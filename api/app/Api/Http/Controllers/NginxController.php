<?php

namespace App\Api\Http\Controllers;

use App\Api\Repositories\Interfaces\NginxRepositoryInterface;
use Log;

class NginxController extends ApiController
{

    public function __construct(private readonly NginxRepositoryInterface $repository) {}

    public function start()
    {
        return $this->repository->performAction('start');
    }

    public function stop()
    {
        return $this->repository->performAction('stop');
    }

    public function restart()
    {
        return $this->repository->performAction('restart');
    }

    public function reload()
    {
        return $this->repository->performAction('reload');
    }
}
