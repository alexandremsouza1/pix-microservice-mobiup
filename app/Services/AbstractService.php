<?php


namespace App\Services;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\JsonResponse;

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
        $result = $this->repository->find($id);
        if($result) {
            return $result;
        }
        throw new HttpException(JsonResponse::HTTP_NOT_FOUND, 'Not found');
    }

    public function store($data)
    {
        $result = $this->pixAdapter->getAdaptPix($data);
        if($result) {
            $id = $this->repository->store($result);
            return $this->repository->find($id);
        }
        throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, 'Error during conversion');
    }

    public function update($id, $data)
    {
        $foundData = $this->repository->find($id);
        if (!$foundData)
            throw new HttpException(JsonResponse::HTTP_NOT_FOUND, 'Not found');

        $mergedData = array_merge($foundData->toArray(), $data);
        return $this->repository->update($id, $mergedData);
    }

    public function delete($id)
    {
        $foundData = $this->repository->find($id);
        if (!$foundData)
            throw new HttpException(JsonResponse::HTTP_NOT_FOUND, 'Not found');

        return $this->repository->delete($id);
    }
}

