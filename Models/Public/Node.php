<?php

/**
 * 文档基础节点
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Public_Node extends Cola_Model
{
    
    /**
     * 所有的节点信息
     * @return array
     */
    public static function getAllNode(){
    	return array_merge(Cola::$_config['_xd'],Cola::$_config['_xk'],Cola::$_config['_bb'],Cola::$_config['_nj']);
    }
        
    
     
}

 