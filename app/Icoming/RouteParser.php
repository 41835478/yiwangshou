<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/25
 * Time: 下午9:48
 */

namespace Icoming;


use Route;

class RouteParser {

    public function load($routes) {
        foreach($routes as $route) {
            foreach($route as $url => $conf) {
                if(strpos($conf, '@') !== false) {
                    if(strpos($conf, 'get') !== false) {
                        Route::get($url, $conf);
                    } else if (strpos($conf, 'post') !== false) {
                        Route::post($url, $conf);
                    } else if (strpos($conf, 'any') !== false) {
                        Route::any($url, $conf);
                    } else {
                        throw new \Exception("不正确的权限配置");
                    }
                } else {
                    Route::controller($url, $conf);
                }
            }
        }
    }

    /**
     * @param $perms
     *
     * @return array
     * @throws \Exception
     */
    public function parse($perms) {
        $res = [];
        foreach($perms as $key => $value) {
            $ctr = null;
            $conf = null;
            if(class_exists($key)) {
                $ctr = $key;
                $conf = $value;
            } else if (class_exists($value)){
                $ctr = $value;
                $conf = $key;
            } else {
                throw new \Exception("不正确的权限配置");
            }
            $res[] = $this->resolve($ctr, $conf);
        }
        return $res;
    }

    /**
     * @param $controller
     * @param $conf
     *
     * @return array res
     * @throws \Exception
     */
    protected function resolve($controller, $conf) {
        $res = [];
        if(is_string($conf)) {
            $res[$conf] = $this->getControllerName($controller);
        } else if (is_int($conf)) {
            $res[$this->getControllerPrefix($controller)] = $this->getControllerName($controller);
        }else if (is_array($conf)) {
            foreach($conf as $key => $value) {
                if(is_string($key)) {
                    $res[$key] = $this->getControllerName($controller) . '@' . $value;
                } else {
                    $res[$this->getUrl($controller, $value)] = $this->getControllerName($controller) . '@' . $value;
                }
            }
        } else {
            throw new \Exception("不正确的权限配置");
        }
        return $res;
    }

    /**
     * 根据控制器和方法返回路由地址
     *
     * @param $controllerName
     * @param $methodName
     *
     * @return string
     */
    protected function getUrl($controllerName, $methodName) {
        $controllerName = $this->getControllerName($controllerName);
        return $this->getControllerPrefix($controllerName) . '/' . $this->getMethodName($methodName);
    }

    /**
     * 获取截取相对于App\Http\Controllers\Admin命名空间的类名
     *
     * @param $controllerName
     *
     * @return string
     */
    private function getControllerName($controllerName) {
        return str_replace('App\Http\Controllers\Admin\\', '', $controllerName);
    }

    /**
     * 获取控制器的前缀, 去掉Controller
     *
     * @param $controllerName
     *
     * @return string
     */
    private function getControllerPrefix($controllerName) {
        $controllerName = $this->getControllerName($controllerName);
        return str_replace('\\', '/', strtolower(str_replace('Controller', '', $controllerName)));
    }

    /**
     * 获取方法名, 去掉post, get, any
     * @param $methodName
     *
     * @return string
     */
    private function getMethodName($methodName) {
        return strtolower(str_replace('any', '', str_replace('post', '', str_replace('get', '', $methodName))));
    }
}