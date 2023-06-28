<?php


namespace App\Services;


abstract class AbstractService
{
    protected $repository;
    protected $pixAdapter;

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
        $result = $this->pixAdapter->getAdaptPix($data);
        if($result) {
            return $this->repository->store($result);
        }
        throw new \Exception('Error during conversion');
    }

    public function update($id, $data)
    {
        $foundData = $this->repository->find($id);
        if (!$foundData)
            return null;

        $mergedData = array_merge($foundData->toArray(), $data);
        return $this->repository->update($id, $mergedData);
    }

    public function delete($id)
    {
        $foundData = $this->repository->find($id);
        if (!$foundData)
            return null;

        return $this->repository->delete($id);
    }
}

