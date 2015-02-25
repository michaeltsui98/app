<?php
/**
 * 取用户信息接口
 * @author michaeltsui98@qq.com
 */
class Models_Interface_User extends Models_Interface_Base {
     
     /**
      * 取登录用户信息
      * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
      * @example http://dev-wenku.dodoedu.com/interface/index/access_token/7f61f51e7d64b52b2097770360c8bbe4/c/Models_Interface_User/m/getUserInfo
      */
      public function getUserInfo(){
          $url = DD_API_URL."auth/checksubappaccesstoken";
          $access_token = Cola_Request::param('access_token');
          if($access_token){
              $json = Cola_Com_Http::post($url, array('access_token'=>$access_token));
              $arr = json_decode($json,1);
              return $arr['user_info'];
          }else{
              return array();
          }
      }
 
      
}