<?php

/**
 * 文件信息
 * @author michael
 * @version 2.0 2014/07/04 14:17:34 
 */
class Models_ResourceFile extends Cola_Model
{

    protected $_pk = 'file_id';

    protected $_table = 'resource_file';
    
    /**
     * 统计是否有相同的资源文件
     * @param string $file_md5
     * @return array 
     */
    function getFileInfoByMd5($file_md5){
        $sql = "select * from {$this->_table} where file_md5 = '$file_md5'";
        return (array)$this->db->row($sql);
    }


    /**
     * 返回资源文件信息
     * @param $doc_id
     * @return array
     */
    public  function  getFileInfo($doc_id){
        $sql = "select b.* from resource a left join {$this->_table} b on a.file_id  = b.file_id where a.doc_id = '$doc_id'";
        return (array)$this->db->row($sql);
    }

    /**
     * 删除文件系统对应的文件
     * @param $key
     * @return bool
     * @throws \Exception
     */
    public  function delFsFile($key){
        $config = Cola::getConfig('_resourceFs');
        $fs = new Cola_Com_Mogilefs($config['domain'], $config['class'], $config['trackers']);
        if($key and $fs->exists($key)){
            return $fs->delete($key);
        }else{
            throw new Exception('mogilefs key is not exists'.$key);
        }
        return false;
    }
 
    /**
     * 计算时间差
     * @param int $timestamp
     * @return Ambigous <string, unknown>
     */
    public function dateSpan($timestamp) {
        $_lang = array();
        $_lang ['day_before'] = '天前';
        $_lang ['hour_before'] = '小时前';
        $_lang ['minute_before'] = '分钟前';
        $_lang ['seconds_before'] = '秒前';
        $_lang ['now'] = '刚刚';
        $time = (int)$_SERVER['REQUEST_TIME'] - $timestamp;
        if ($time > 24 * 3600) {
            $result = intval ( $time / (24 * 3600) ) . $_lang ['day_before'];
        } elseif ($time > 3600) {
            $result = intval ( $time / 3600 ) . $_lang ['hour_before'];
        } elseif ($time > 60) {
            $result = intval ( $time / 60 ) . $_lang ['minute_before'];
        } elseif ($time > 0) {
            $result = $time . $_lang ['seconds_before'];
        } else {
            $result = $_lang ['now'];
        }
        return $result;
    }
    
    public  function getStar ($num)
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
                $html .= '<i class="icon_tc3"></i>';
            } else {
                if ($isde) {
                    $html .= '<i class="icon_tc4"></i>';
                    $isde = false;
                } else {
                    $html .= '<i class="icon_tc2"></i>';
                }
            }
        }
        return $html;
    }
}

 