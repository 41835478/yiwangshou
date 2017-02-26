<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Classification;
use Icoming\Models\Type;
use Icoming\Repository;
use Illuminate\Database\Eloquent\Collection;

class ClassificationRepository  extends Repository {

    /**
     * @var Type
     */
    protected $type;

    /**
     * ClassificationRepository constructor.
     *
     * @param Classification $classification
     * @param Type           $type
     */
    public function __construct(Classification $classification, Type  $type) {
        parent::__construct($classification);
        $this->type = $type;
    }

    /**
     * @param $classification_types
     *
     * @return array
     */
    public function getCxselectJson($classification_types) {
        $self = $this;
        return $self->buildTree($classification_types, function($name) use ($self) {
            return $self->buildTree($self->model->whereType($name)->get(), function($id) use ($self) {
                return $self->buildTree($self->type->whereClassificationId($id)->get(), function($id) {
                    return [];
                });
            });
        });
    }

    public function getJson() {
        return $this->model->with(['types' => function($q) {
            $q->orderBy('sort', 'asc');
        }])->orderBy('sort', 'asc')->get();
    }

    /**
     * @param $collection
     *
     * @return array
     */
    protected function transCollection($collection) {
        $result = [];
        (new Collection($collection))->each(function($model) use (&$result) {
            $result[] = [
                'n' => is_string($model) ? $model : $model->name,
                'k' => is_string($model) ? $model : $model->id,
                'v' => is_string($model) ? $model : $model->id,
            ];
        });
        return $result;
    }

    /**
     * @param array    $old
     * @param callable $callback
     *
     * @return array
     */
    protected function buildTree($old, callable $callback) {
        $result = [];
        (new Collection($this->transCollection($old)))->each(function($cell) use (&$result, &$callback) {
            $row_set = $callback($cell['k']);
            if(count($row_set) > 0) {
                $result[] = [
                    'n' => $cell['n'],
                    's' => $row_set,
                    'v' => $cell['v'],
                ];
            } else {
                $result[] = [
                    'n' => $cell['n'],
                    'v' => $cell['v'],
                ];
            }
        });
        return $result;
    }
}