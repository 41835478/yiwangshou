<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:13
 */

namespace Icoming;


abstract class Repository {

    /**
     * @var Model 注入的model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }


    /**
     * @param       $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find($id, $columns = ['*']) {
        return $this->model->find($id, $columns);
    }

    /**
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findBy($attribute, $value, $columns = ['*']) {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * @param int   $perPage
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = ['*']) {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array  $data
     * @param        $id
     * @param string $attribute
     *
     * @return bool|int
     */
    public function update(array $data, $id, $attribute = "id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function withTrashed() {
        return $this->model->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function onlyTrashed() {
        return $this->model->onlyTrashed();
    }

    /**
     * @return Model
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel($model) {
        $this->model = $model;
    }


}