<?php

namespace App\Http\Repositories;

abstract class BaseRepository {

    /**
     * @var
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param $model
     */
    public function __construct($model) {
        $this->model = $model;
    }

    /**
     * @return  mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param mixed $paginate
     *
     * @return mixed
     */
    public function paginated($paginate) {
        return $this->model->paginate($paginate);
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function create(array $input) {
        return $this->model->create($input);
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function insert(array $input) {
        return $this->model->insert($input);
    }

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->model->where('id', $id)->first();
    }

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function destroy($id) {
        return $this->find($id)->delete();
    }

    /**
     * @param mixed $id
     * @param array $input
     *
     * @return mixed
     */
    public function update($id, array $input) {
        return $this->model->where(['id' => $id])->update($input);
    }

    /**
     * @param array $where
     * @param array $update
     * @return mixed
     */
    public function updateWhere(array $where=[], array $update=[]) {
        $query = $this->model::query();
        foreach($where as $key => $value) {
            if(is_array($value)){
                $query->where($key,$value[0],$value[1]);
            }else{
                $query->where($key,'=',$value);
            }
        }
        return $query->update($update);
    }

    /**
     * @param array $where
     * @param bool $isForce
     * @return mixed
     */
    public function deleteWhere(array $where=[], bool $isForce = false) {
        $query = $this->model::query();
        foreach($where as $key => $value) {
            if(is_array($value)){
                $query->where($key,$value[0],$value[1]);
            }else{
                $query->where($key,'=',$value);
            }
        }

        if ($isForce) {
            return $query->forceDelete();
        }
        return $query->delete();
    }

    /**
     * @param array $where
     * @param array|null $select
     * @param array $orderBy
     * @param array $with
     * @return mixed
     */
    public function selectData(array $where=[], array $select=null, array $orderBy=[], array $with=[]) {
        if($select == null){
            $select = ['*'];
        }
        $query = $this->model::select($select);
        foreach($with as $wt) {
            $query = $query->with($wt);
        }
        foreach($where as $key => $value) {
            if(is_array($value)){
                $query->where($key,$value[0],$value[1]);
            }else{
                $query->where($key,'=',$value);
            }
        }
        foreach($orderBy as $key => $value) {
            if (empty($orderBy)) {
                $query->orderBy("created_at", "DESC");
            } else {
                $query->orderBy($key,$value);
            }
        }

        return $query;
    }

    /**
     * @param array $where
     * @param array|null $select
     * @param array $orderBy
     * @param array $with
     * @return mixed
     */
    public function getData(array $where=[], array $select=null, array $orderBy=[], array $with=[]){
        $query = $this->selectData($where, $select, $orderBy, $with);

        return $query->get();
    }

    /**
     * @param array $where
     *
     * @return mixed
     */
    public function firstWhere(array $where) {
        return $this->model->where($where)->first();
    }

    /**
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public function updateOrCreate(array $where, array $data) {
        return $this->model->updateOrCreate($where, $data);
    }
}
