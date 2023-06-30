<?php

namespace App\Repositories;

use Carbon\Carbon;
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
        $result = $this->model->find($id);
        if($result) {
            return $result;
        }
        return false;
    }

    public function store($data)
    {
        if($this->model->validate($data)) {
            $pixInstance = new $this->model($data);
            if($pixInstance->save()) {
                return $pixInstance->_id;
            }
        }
        return false;
    }

    public function update($id, $data)
    {
        $now = Carbon::now();
        $data['updated_at'] = $now->format('Y-m-d\TH:i:s.u\Z');
        if($this->model->validate($data)) {
            if(!$this->model->where('_id', $id)->update($data)) {
                return false;
            }
        }
        return true;
    }

    public function delete($id)
    {
        return $this->model->where('_id', $id)->delete();
    }
}