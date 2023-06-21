<?php


namespace App\Services;

use App\Repositories\PixRepository;


class PixService extends AbstractService
{
    protected $repository;

    public function __construct(PixRepository $repository)
    {
        $this->repository = $repository;
    }
}

