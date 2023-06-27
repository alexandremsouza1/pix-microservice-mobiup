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
        $pix = $this->pixAdapter->getAdaptPix($data);
        if($pix) {
            return $pix->save();
        }
        throw new \Exception('Error during conversion');
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

