<?php
/**
 * 取知识节点接口
 * @author michaeltsui98@qq.com
 */
class Models_Interface_Unit extends Models_Interface_Base {
     
     /**
      * 取知识节点表列
      * @param string $xd
      * @param string $xk
      * @param string $bb
      * @param string $nj
      * @return Ambigous <boolean, multitype:Ambigous, multitype:, multitype:unknown Ambigous <multitype:, boolean> >
      * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Unit/m/getList?xd=xd001&xk=GS0024&bb=v11&nj=GO003
      */
      public function getList($xd,$xk,$bb,$nj){
          $b = new Models_Unit();
          $arr1 = $b->getUnit($xd, $xk, $bb, $nj);
          return $arr1;
      }
      /**
       * 通过nj ID 取知识节点
       * @param int $id
       * @return mixed
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Unit/m/getListByNjId?id=105
       */
      public function getListByNjId($id){
           $code_arr = Models_Node::init()->cached('getParentCodeById',array($id),3600);
           $unit = Models_Unit::init()->cached('getUnit',array($code_arr['xd'], $code_arr['xk'], $code_arr['bb'], $code_arr['nj']),3600);
           return $unit['rows'];
      }
       
      
}