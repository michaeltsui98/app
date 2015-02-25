<?php
function v( $str )
{
    return isset( $_REQUEST[$str] ) ? $_REQUEST[$str] : false;
}
function is_login(){
    return isset($_SESSION['user']['user_id']);
}
function json_to_array($obj){
    $arr=array();
    foreach((array)$obj as $k=>$w){
        if(is_object($w)) $arr[$k]=json_to_array($w);  //判断类型是不是object
        else $arr[$k]=$w;
    }
    return $arr;
}
/**
 * 当前的url，分页的url 
 * @return string
 */
function get_url(){
    $uri_arr = parse_url($_SERVER['REQUEST_URI']);
    parse_str($uri_arr['query'],$query_arr);
    unset($query_arr['page']);
    return $url = $uri_arr['path'].'?'.http_build_query($query_arr).'&page=%page%';
}
function get_star ($num)
{
    if ($num > 10) {
        $num = 10;
    }
    if ($num) {
        $i = $num / 2;
        $f = (float) number_format($i, 2);
    } else {
        $f = 0;
    }
    if (is_float($f)) {
        if(strpos((string)$f, '.')!==false){
            $int = (int) substr((string) $f, 0, strpos((string) $f, '.'));
        }else{
            $int = $f;
        }
    } else {
        $int = $f;
    }
    $de = $f - $int;
    $html = "";
    // 是否有半颗星
    $isde = false;
    if ($de < 1 and $de >= 0.1) {
        $isde = true;
    }

    for ($i = 0; $i < 5; $i ++) {
        if ($i < $int) {
            $html .= "<i class='icon_rateStarOn'></i>";
        } else {
            if ($isde) {
                $html .= "<i class='icon_rateStarHalf'></i>";
                $isde = false;
            } else {
                $html .= "<i class='icon_rateStarOff'></i>";
            }
        }
    }
    return $html;
}