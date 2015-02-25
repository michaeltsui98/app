<?php

/**
 * 视频处理管理
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */


require S_ROOT . 'FFmpegPHP2/FFmpegAutoloader.php';

class Models_Video extends Cola_Model
{
    
    protected  $_pk = 'id';
    protected  $_table = 'video';
    
    
    static $_fs = array();
    public function mogfs ($config = '_imgFs')
    {
        $cfg = Cola::getConfig($config);
        return static::$_fs[$config] = new Cola_Com_Mogilefs($cfg['domain'],
                $cfg['class'], $cfg['trackers']);
    }
    
    /**
     * 判断这个视频对象是否有存在
     * @param string $vid
     * @param string $obj_id
     * @param string $obj_type
     * @return Ambigous <number, boolean>
     */
    public  function checkExists($vid,$obj_id,$obj_type){
         return $this->count("vid='$vid' and obj_id = '$obj_id' and obj_type='$obj_type'");    
    }
    /**
     * 获取视频对象的信息
     * @param string $vid
     * @param string $obj_id
     * @param string $obj_type
     * @return Ambigous <number, boolean>
     */
    public  function getInfo($vid,$obj_id,$obj_type){
         $sql = "select * from $this->_table where vid='$vid' and obj_id = '$obj_id' and obj_type='$obj_type' ";
         return  $this->db->row($sql);
    }

    /**
     * 取视频信息
     * @param int $obj_id 文件ID file_id
     * @param string $obj_type 文件类型 file
     */
    public  function  getInfoByObj($obj_id,$obj_type){
        $sql = "select * from $this->_table where  obj_id = '$obj_id' and obj_type='$obj_type' limit 1 ";
        return  $this->db->row($sql);
    }
    
    /**
     * 取视频图片
     */
    function getVideoImage($file_path,$sec=5){
        //保存原始图片
        $outFilePath = $file_path.'.png';
        $mov = new FFmpegMovie($file_path);
        $frame = $mov->getFrameAtTime($sec);
        $frame->resize(242, 140);
        $im = $frame->toGDImage();
        imagepng($im,$outFilePath);
        imagedestroy($im);
        return  $outFilePath ;
    }
    /**
     * 将视频文件存到FS
     * @param string $image_path
     */
    function saveImageTofs($image_path){
    	$key = Models_Upload::init()->getFsKey($image_path,'png');
    	$cfg = Cola::$_config->get('_imgFs');
    	$fs  = new Cola_Com_Mogilefs($cfg['domain'],$cfg['class'], $cfg['trackers']);
    	$res = $fs->setFile($key, $image_path);
    	unlink($image_path);
    	return $key;
    }
    
    /**
     * 取视频播放时长,秒为单位
     */
    function getVideoTime($file_path){
        $mov = new FFmpegMovie($file_path);
        return (int)$mov->getDuration();
    }
    
    /**
     * 设置头部信息，支持流播放
     *
     * @param string $saveFile
     * @param string $newFile
     */
    public function setMeta ($saveFile, $newFile)
    {
         $cmd = "/usr/bin/qt-faststart $saveFile $newFile";
        return shell_exec($cmd);
    }
    /**
     * 视频转码
     */
    function convertToMp4($sourceFile, $saveFile){
        $cmd = "/usr/bin/ffmpeg -i $sourceFile";
        $cmd .= " -threads 2 -ab 20k -ac 2 -bt 384k   ";
        $cmd .= " -vcodec libx264 -preset ultrafast
                  -tune stillimage -pix_fmt yuv420p 
                  -level 4.1 -crf 21 -f mp4 $saveFile -y ";
        $out = exec($cmd);
        unset($cmd);
    }
    /**
     * 取文件md5码
     * @param string $file_path
     */
    function getFileMd5($file_path){
       $cmd = " /usr/bin/md5sum {$file_path}|cut -d ' ' -f1";
       $out = exec($cmd);
       unset($cmd);
       return $out;
    }
    /**
     * 取视频资源信息
     * @param int $doc_id 资源ID
     * @return array  资源+视频信息
     */
    public function getVideoResouceInfo($doc_id,$cate_id = null){
        
        if($cate_id == 5 or $cate_id ==6){
            $sql = "SELECT * FROM
            resource a
            left join resource_file b
            on a.file_id = b.file_id
            left join `video` c
            on (a.file_id = c.obj_id and c.obj_type = 'file')
            where a.doc_id = '$doc_id' ";
        }else{
            $sql = "SELECT * FROM
            resource a
            left join resource_file b
            on a.file_id = b.file_id
            where a.doc_id = '$doc_id' ";
        }
        return $this->db->row($sql);
    }
}

 