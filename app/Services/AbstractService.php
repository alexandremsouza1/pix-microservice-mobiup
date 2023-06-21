<?php


namespace App\Services;


abstract class AbstractService
{
    protected $repository;

    public function getAll()
    {
        return $this->repository->all();
    }


    public function getById($id)
    {
        return $this->repository->find($id);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function update($id, $data)
    {
        $foundData = $this->repository->find($id);
        if (!$foundData)
            return null;

        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        $foundData = $this->repository->find($id);
        if (!$foundData)
            return null;

        return $this->repository->delete($id);
    }
}

