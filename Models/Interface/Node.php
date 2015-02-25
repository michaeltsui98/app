<?php
/**
 * 资源节点接口
 * @author michaeltsui98@qq.com
 */
class Models_Interface_Node extends Models_Interface_Base {
     
      /**
       * 根据对象对资源列表
       * @param string $pid 父ID
       * @return Ambigous <number, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c
       * /Models_Interface_Node/m/getSubNode?pid=0
       */
      public function getSubNode($pid=0){
          $b = new Models_Node();
          $id = (int) $pid;
          $arr1 = $b->cached('getSubNode',array($id),6000);
          return $arr1;
      }
      /**
       * 根据节点ID，取节点code
       * @param int $ids
       * @return multitype:Ambigous <>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Node/m/getCodeById?ids=1,133,149,159
       */
      public function getCodeById($ids){
          if(!$ids){
              return false;
          }
          $node = Models_Node::init();
          $data = $node->sql("select id,code from node_kind where id in ($ids)");
          $tmp = array();
          foreach ($data as $v){
              $tmp[$v['id']] = $v['code'];
          }
          return $tmp;
      }
      
      /**
       * 根据学段学科取版本
       * @param string $xd
       * @param string $xk
       * @return Ambigous <number, multitype:, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Node/m/getBbByXdAndXkAction?xd=xd001&xk=GS0024
       */
      public function getBbByXdAndXkAction($xd,$xk){
          $init_xd = $xd;
          $node = new Models_Node();
          $init_xd_id = $node->getXdIdByCode($init_xd);
          $init_xk_arr = $node->getSubNode($init_xd_id);
          $init_xk = $xk;
          $init_xk_id = 0;
          foreach ($init_xk_arr as $v){
              if($v['code'] == $init_xk){
                  $init_xk_id= $v['id'];
              }
          }
          return $node->getSubNode($init_xk_id);
      }
      /**
       * 通过Code 取 节点ID
       * @param string $xd
       * @param string $xk
       * @param string $bb
       * @param string $nj
       * @return  array
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Node/m/getNodeInfoByXdXkBbNj?xd=xd001&xk=GS0024&bb=v11&nj=GO003
       */
      public function getNodeInfoByXdXkBbNj($xd,$xk,$bb,$nj){
          $sql = "SELECT d.* FROM `node_kind` a
          left join node_kind b
          on a.id = b.pid
          left join node_kind c
          on b.id = c.pid
          left join node_kind d
          on c.id = d.pid
          where
          a.`code` = '$xd'
          and b.`code` = '$xk'
          and c.`code` = '$bb'
          and d.`code` = '$nj'";
        
          return $this->db->row($sql);
      }
      /**
       * 取节点信息
       * @param int $id
       * @return Ambigous <multitype:, boolean>
       * @example http://dev-wenku.dodoedu.com/interface/index/app_key/2a42f76304529c8174f11ca6ad3573a6/c/Models_Interface_Node/m/getNodeInfo?id=97
       */
      public function getNodeInfo($id){
          $b = new Models_Node();
          return $b->load($id);
      }
       
      
}