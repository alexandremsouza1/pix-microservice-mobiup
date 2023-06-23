<?php


namespace App\Services;

use App\Adapters\Interfaces\PixAdapterInterface;
use App\Repositories\PixRepository;


class PixService extends AbstractService
{
    protected $repository;

    protected $pixAdapter;

    public function __construct(PixRepository $repository,PixAdapterInterface $pixAdapter)
    {
        $this->repository = $repository;
        $this->pixAdapter = $pixAdapter;
    }
}

