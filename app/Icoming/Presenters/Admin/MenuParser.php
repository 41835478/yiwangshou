<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/25
 * Time: 下午9:23
 */

namespace Icoming\Presenters\Admin;


class MenuParser {
    public function parse($menu) {
        $label = $menu['label'];
        $icon = $menu['icon'];
        $action = $menu['action'];
        $html = '';
        if(is_string($action)):
            $html = "
        <li>
            <a href='" . url($action) . "'>
                <i class='{$icon}'></i>
                <span>{$label}</span>
            </a>
        </li>";
        elseif(is_array($action)):
            $html = <<<HTML
        <li class="treeview">
            <a>
                <i class="{$icon}"></i>
                <span>{$label}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
HTML;
            foreach($action as $sub_menu):
                $html .= $this->parse($sub_menu);
            endforeach;
            $html .= <<<HTML
            </ul>
        </li>
HTML;
        endif;
        return $html;
    }
}