<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Plot;
use Icoming\Repository;

class PlotRepository extends Repository {
    /**
     * PlotRepository constructor.
     *
     * @param Plot $plot
     */
    public function __construct(Plot $plot) {
        parent::__construct($plot);
    }

    public function getCxselectJson($plot_id = null) {
        if($plot_id) {
            $provinces = $this->model->whereId($plot_id)->distinct()->get([ 'province' ]);
        } else {
            $provinces = $this->model->distinct()->get([ 'province' ]);
        }
        $result = [];
        foreach($provinces as $province) {
            if(($cities = $this->getCities($province->province)) && count($cities) > 0) {
                $result[] = [
                    'n' => $province->province,
                    's' => $cities,
                    'v' => $province->province,
                ];
            }
        }
        return $result;
    }

    protected function getCities($province) {
        $cities = $this->model->whereProvince($province)->distinct()->get(['city']);
        $result = [];
        foreach($cities as $city) {
            if(($areas = $this->getAreas($city->city)) && count($areas) > 0) {
                $result[] = [
                    'n' => $city->city,
                    's' => $areas,
                    'v' => $city->city,
                ];
            }
        }
        return $result;
    }

    protected function getAreas($city) {
        $areas = $this->model->whereCity($city)->distinct()->get(['area']);
        $result = [];
        foreach($areas as $area) {
            if(($plots = $this->getPlots($area->area)) && count($plots) > 0) {
                $result[] = [
                    'n' => $area->area,
                    's' => $plots,
                    'v' => $area->area,
                ];
            }
        }
        return $result;
    }

    protected function getPlots($area) {
        $plots = $this->model->whereArea($area)->distinct()->get(['name', 'id']);
        $result = [];
        foreach($plots as $plot) {
            $result[] = [
                'n' => $plot->name,
                'v' => $plot->id,
            ];
        }
        return $result;
    }
}