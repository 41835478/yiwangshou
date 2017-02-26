<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/5
 * Time: 上午10:25
 */

namespace Icoming\Presenters\Home;


use Icoming\Repositories\PlotRepository;

class PlotFullNamePresenter {

    protected  $repository;

    public function __construct(PlotRepository $repository) {
        $this->repository = $repository;
    }

    public function getFullName($plot_id, $suffix = '') {
        $plot = $this->repository->find($plot_id);
        return $plot->province.$plot->city.$plot->area.$plot->name.$suffix;
    }
}