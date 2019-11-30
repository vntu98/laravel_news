<?php
namespace App\Helpers;
use Config;
class Template{
    public static function showItemHistory($by, $time){
        $xhtml = sprintf('<p><i class="fa fa-user"></i> %s</p>
                <p><i class="fa fa-clock-o"></i> %s</p>', $by, date(Config::get('zvn.format.short_time', 'H:i:s d-m-Y'), strtotime($time)));
        return $xhtml;
    }
    public static function showItemStatus($controllerName, $statusValue, $id){
        $tmplStatus = Config::get('zvn.template.status');
        $statusValue = array_key_exists($statusValue,  $tmplStatus) ? $statusValue : 'default'; 
        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link = route($controllerName . '/status', ['status' => $statusValue, 'id' => $id]);
        $xhtml = sprintf('<a type="button" data-controller="%s" data-id="%s" class="btn btn-round %s status" id="status-%s">%s</a>', $controllerName, $id, $currentTemplateStatus['class'], $id, $currentTemplateStatus['name']);
        return $xhtml;
    }
    public static function showItemIsHome($controllerName, $isHomeValue, $id){
        $isHomeValue = ($isHomeValue == 1) ? 'yes' : 'no';
        $tmplIsHome = Config::get('zvn.template.is_home');
        $isHomeValue = array_key_exists($isHomeValue,  $tmplIsHome) ? $isHomeValue : 'yes'; 
        $currentTemplateIsHome = $tmplIsHome[$isHomeValue];
        $link = route($controllerName . '/isHome', ['is_home' => $isHomeValue, 'id' => $id]);
        $xhtml = sprintf('<a id="ishome-%s" type="button" class="ishome btn btn-round %s" data-id="%s" data-value="%s" data-controller="%s">%s</a>', $id ,$currentTemplateIsHome['class'], $id , $isHomeValue , $controllerName , $currentTemplateIsHome['name']);
        return $xhtml;
    }
    public static function showItemSelect($controllerName, $displayValue, $id, $fieldName){
        $tmplDisplay = Config::get('zvn.template.' . $fieldName);
        $xhtml = sprintf('<select name="select_change_attr" data-id="%s" data-controller="%s" data-field="%s" class="form-control">', $id, $controllerName, $fieldName);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelected = '';
            if($key == $displayValue) $xhtmlSelected = 'selected="selected"';
            $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
        }
        $xhtml .= '</select>';
        return $xhtml;
    }
    public static function showItemThumb($controllerName, $thumbName, $thumbAlt){
        $xhtml = sprintf('<img src="%s" alt="%s" class="zvn-thumb">', asset("images/$controllerName/$thumbName"), $thumbAlt);
        return $xhtml;
    }
    public static function showButtonAction($controllerName, $id, $index){
        $tmplButton = Config::get('zvn.template.button');
        $buttonInArea = Config::get('zvn.config.button');
        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons = $buttonInArea[$controllerName];
        $xhtml = '<div class="zvn-box-btn-filter">';
        foreach($listButtons as $btn){
            $currentButton = $tmplButton[$btn];
            $link = route($controllerName . $currentButton['route-name'], $id);
            if($currentButton['icon'] == 'fa-trash') 
                $xhtml .= sprintf('<a type="button" class="index2 btn btn-icon %s" data-index="%s" data-id="%s" data-link="%s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                    <i class="fa %s"></i></a>', $currentButton['class'], $index, $id, $link, $currentButton['title'], $currentButton['icon']);
            else
                $xhtml .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                    <i class="fa %s"></i></a>', $link, $currentButton['class'], $currentButton['title'], $currentButton['icon']);
        }
        $xhtml .= '</div>';
        return $xhtml;
    }
    public static function showButtonFilter($currentFilterStatus, $controllerName, $itemsStatusCount, $paramsSearch){
        $xhtml = null;
        $tmplStatus = Config::get('zvn.template.status');
        if(count($itemsStatusCount) >= 0){
            array_unshift($itemsStatusCount, [
                'count' => array_sum(array_column($itemsStatusCount, 'count')),
                'status' => 'all'
            ]);
            foreach($itemsStatusCount as $item){ // $item = ['count', 'status']
                $statusValue = $item['status'];
                $statusValue = array_key_exists($statusValue,  $tmplStatus) ? $statusValue : 'default'; 
                $currentTemplateStatus = $tmplStatus[$statusValue];
                $class = $statusValue == $currentFilterStatus ? 'btn-success' : 'btn-primary';
                $link = route($controllerName) . '?filter_status=' . $statusValue;
                if($paramsSearch['value'] != "") $link .= "&search_field=" . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                $xhtml .=  sprintf('<a href="%s" type="button" class="btn %s"> 
                                        %s <span class="badge bg-white">%s</span>
                                    </a>', $link, $class, $currentTemplateStatus['name'], $item['count']);
            }
        }
        return $xhtml;
    }
    public static function showButtonFilterIsHome($currentFilterIsHome, $controllerName, $itemsIsHomeCount, $paramsSearch){
        $xhtml = null;
        $tmplIsHome = Config::get('zvn.template.is_home');
        foreach($itemsIsHomeCount as $item){
            $isHomeValue = ($item['is_home'] == 1) ? 'yes' : 'no';
            $currentTemplateIsHome = $tmplIsHome[$isHomeValue];
            $class = $isHomeValue == $currentFilterIsHome ? 'btn-success' : 'btn-primary';
            $link = route($controllerName) . '?filter_isHome=' . $isHomeValue;
            if($paramsSearch['value'] != "") $link .= "&search_field=" . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
            $xhtml .=  sprintf('<a href="%s" type="button" class="btn %s"> 
                                        %s <span class="badge bg-white">%s</span>
                                    </a>', $link, $class, $currentTemplateIsHome['name'], $item['count']);
        }
        return $xhtml;
    }
    public static function showButtonFilterDisplay($currentFilterDisplay, $controllerName, $itemsDisplayCount, $paramsSearch){
        $xhtml = null;
        $tmplDisplay = Config::get('zvn.template.display');
        foreach($itemsDisplayCount as $item){
            $displayValue = $item['display'];
            $currentTemplateDisplay = $tmplDisplay[$displayValue];
            $class = $displayValue == $currentFilterDisplay ? 'btn-success' : 'btn-primary';
            $link = route($controllerName) . '?filter_display=' . $displayValue;
            if($paramsSearch['value'] != "") $link .= "&search_field=" . $paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
            $xhtml .=  sprintf('<a href="%s" type="button" class="btn %s"> 
                                        %s <span class="badge bg-white">%s</span>
                                    </a>', $link, $class, $currentTemplateDisplay['name'], $item['count']);
        }
        return $xhtml;
    }
    public static function showAreaSearch($controllerName, $paramsSearch){
        $xhtml = null;
        $tmplField = Config::get('zvn.template.search');
        $fieldInController = Config::get('zvn.config.search');
        $controllerName = (array_key_exists($controllerName, $fieldInController)) ? $controllerName : 'default';
        $xhtmlField = '';
        foreach($fieldInController[$controllerName] as $field){
            $xhtmlField .= '<li><a href="#" class="select-field" data-field="'. $field .'">'. $tmplField[$field]['name'] .'</a></li>';
        }
        $searchField = in_array($paramsSearch['field'], $fieldInController[$controllerName]) ? $paramsSearch['field'] : "all";
        $xhtml =   sprintf('<div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-active-field" data-toggle="dropdown" aria-expanded="false">
                                    %s <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu"> %s </ul>
                                </div>
                                <input type="text" class="form-control" name="search_value" value="%s">
                                <input type="hidden" name="search_field" value="%s">
                                <span class="input-group-btn">
                                    <button id="btn-clear" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                                    <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                                </span>
                            </div>', $tmplField[$searchField]['name'], $xhtmlField, $paramsSearch['value'], $searchField);
        return $xhtml;
    }
    public static function showDateTimeFrontend($dateTime){
        return date_format(date_create($dateTime), Config::get('zvn.format.short_time'));
    }
    public static function showContent($content, $length, $prefix = '...'){
        $prefix = ($length == 0) ? '' : $prefix;
        $content = str_replace(['<p>', '</p>'], '', $content);
        return str_replace('/\s+?(\S+)?$/', '', substr($content, 0, $length)). $prefix;
    }
}