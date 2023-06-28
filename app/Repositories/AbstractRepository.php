<?php

namespace App\Repositories;

use Jenssegers\Mongodb\Eloquent\Model;

abstract class AbstractRepository implements IEntityRepository
{
    /**
     * @var Model
     */
    protected $model;


    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        if($this->model->validate($data)) {
            $pixInstance = new $this->model($data);
            return  $pixInstance->save();
        }
        throw new \Exception('Data is not valid');
    }

    public function update($id, $data)
    {
        if($this->model->validate($data)) {
            return $this->model->where('_id', $id)->update($data);
        }
        throw new \Exception('Data is not valid');
    }

    public function delete($id)
    {
        return $this->model->where('_id', $id)->delete();
    }
}