<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/29
 * Time: 下午2:21
 */

namespace Icoming\Presenters;


abstract class Template {

    protected $name;

    protected $namespace;
    protected $view;
    protected $view_path;
    protected $column = [
    ];

    /**
     * Template constructor.
     */
    public function __construct() {
        $this->view_path = "{$this->namespace}.{$this->view}";
        if(!view()->exists('template.' . trim($this->view_path, '.'))) {
            throw new \Exception("视图不存在");
        }
        if(count(array_intersect([
                'content', 'title', 'from', 'to_id', 'viww',
            ], $this->column)) > 0
        ) {
            throw new \Exception("视图字段存在非法名字");
        }
    }

    /**
     * @return mixed
     */
    public function getNamespace() {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getViewPath() {
        return $this->view_path;
    }

    /**
     * @param string $view_path
     */
    public function setViewPath($view_path) {
        $this->view_path = $view_path;
    }

    /**
     * @return array
     */
    public function getColumn() {
        return $this->column;
    }

    /**
     * @param array $column
     */
    public function setColumn($column) {
        $this->column = $column;
    }

    /**
     * @return mixed
     */
    public function getView() {
        return $this->view;
    }

    /**
     * @param mixed $view
     */
    public function setView($view) {
        $this->view = $view;
    }



}