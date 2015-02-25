<?php

/**
 * 文件上传model
 * @author michael
 * @version 1.0 2013/8/12 14:17:34 
 */
class Models_Upload extends Cola_Model
{

    
   
    /**
     * 生成文件key
     * 
     * @param string $fileName            
     * @param string $ext            
     * @return string
     */
    public function getFsKey ($fileName, $ext = NULL)
    {
        return substr(
                hash_hmac('md5', 'resource' . $fileName  . uniqid(), 
                        'ndisk'), - 16) .( $ext?".$ext":'');
    }
    
    function get_disk_fs(){
       
       $cfg = Cola::getConfig('_diskFs');
        
        return new Cola_Com_Mogilefs($cfg['domain'], 
                $cfg['class'], $cfg['trackers']);
    }
    /**
     * 文档转pdf
     */
    function doc2pdf ($doc_file, $pdf_file)
    {
        //$cmd = "/data/app/java/bin/java -Doffice.home=/opt/openoffice4 -jar /usr/local/jodconverter-core/lib/jodconverter-core-3.0-beta-4.jar  $doc_file  $pdf_file ";
        $cmd = "/usr/bin/libreoffice4.1 --headless --invisible --norestore --convert-to pdf:writer_pdf_Export  --outdir /tmp/  $doc_file ";
        
        $res = shell_exec($cmd); 
         
        return $res;
    }

    /**
     * 获取pdf的内容
     * 
     * @return string
     */
    function pdf2txt ($pdf_file)
    {
        $cmd = "/usr/bin/pdftotext -enc GBK $pdf_file -";
        $txt = shell_exec($cmd);
        return iconv('GBK', 'UTF-8', $txt);
    }

    /**
     * pdf文件转swf
     */
    function pdf2swf ($pdf_file, $swf_file)
    {
        $file_size = filesize($pdf_file);
        if($file_size/(1024*1024)>10){
            $cmd = "/usr/local/bin/pdf2swf $pdf_file -o $swf_file -f -T 9 -G -t -s   poly2bitmap";
        }else{
           $cmd = "/usr/local/bin/pdf2swf $pdf_file -o $swf_file -f -T 9 -t -s  stroeallcharacters";
        }
        return shell_exec($cmd);
    }
    /**
     * 
     * @param unknown_type $path
     * @return boolean|unknown
     */
    function getdocpage ($pdf_file)
    {
    
        // 打开文件
        if (! $fp = fopen($pdf_file, "r")) {
            die("打开文件{$pdf_file}失败");
            return false;
        } else {
            $max = 0;
            while (! feof($fp)) {
                $line = fgets($fp, 255);
                if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                    preg_match('/[0-9]+/', $matches[0], $matches2);
                    if ($max < $matches2[0])
                        $max = $matches2[0];
                }
            }
            fclose($fp);
            // 返回页数
            return $max;
        }
    }
    /**
     * 获取文件内容的md5码
     * 
     * @param string $str            
     * @return string
     */
    function get_doc_md5 ($str)
    {
        return md5($str);
    }

    /**
     * 将要要转换的文档添加的到队列
     */
    function doc2quee ($arr = array())
    {
        if ($arr) {
            $queue = Cola_Com_Queue_Doc::init();
            return $queue->put($arr);
        } else {
            return false;
        }
    }
    /**
     * 将文档原文件写到当前用户的网盘
     * 的文件系统中
     */
    function doc2diskfs($key,$file_path){
         $config = $this->config['_diskFs'];
         $fssys = new Cola_Com_Mogilefs($config['domain'], $config['class'], $config['trackers']);
         return $fssys->setFile($key, $file_path);
    }

    /**
     * 保存资源文件域中
     * @param        $key
     * @param string $file_path
     * @return bool
     * @throws \Exception
     */
    function uploadToResourceFs($key,$file_path){
         $config = Cola::getConfig('_resourceFs');
         $fssys = new Cola_Com_Mogilefs($config['domain'], $config['class'], $config['trackers']);
         return $fssys->setFile($key, $file_path);
    }
    /**
     * 生成唯一ID
     * @return string
     */
    function getFileKey(){
    	return  uniqid();
    }
    /**
     * 判断资源文件的糊弄是否合法
     * @param int $cate
     * @param string $ext
     * @return bool
     */
    function checkFileType($cate,$ext){
        $ext = strtolower($ext);
    	$file_type = Cola::$_config->get('_resourceFileType');
    	if($cate){
        	if(strpos($file_type[$cate],$ext)===false){
        		return false;
        	}else{
        		return true;
        	}
    	}elseif ($cate==null){  
    	    //验证所有可传的文件格式
    	    $tmp = "";
    	    $tmp = $file_type[1].';'.$file_type[4].';'.$file_type[5];
    	    print_r($tmp);
    	    var_dump($ext);
    	    die;
    	    if(strpos($tmp,$ext)===false){
    	        return false;
    	    }else{
    	        return true;
    	    }
    	}
    
    }

    
    
    /**
     * 初始化search
     * @return Cola_Com_Search
     */
    public  static function initSearch($config=null){
        if($config === null){
            $config = Cola::$_config->get('_resource_search');
        }
        return  new  Cola_Com_Search($config);
    }
    /**
     * 获取搜索服务
     * @return mixed
     */
    public static function getSearchService($config=null){
        return static::initSearch($config)->getSearch()->search;
    }
    
    /**
     * 获取搜索索引服务
     * @return Cola_Com_Search
     */
    public static function getIndexService(){
        return static::initSearch()->getSearch()->index;
    }
    /**
     *  获取文件节点名称，单元名称
     */
    function get_node_txt($doc_id){
        $sql = "SELECT b.base_title xk,
                c.base_title xd,
                d.base_title nj,
                e.base_title bb,
                f.sp_name zt,
                g.node_title dy
                FROM `doc` a
                left join node_base b
                on a.xk  = b.id 
                left join node_base c
                on a.xd  = c.id 
                left join node_base d
                on a.nj  = d.id 
                left join node_base e
                on a.bb  = d.id 
                left join  node_special f
                on a.zt  = f.id 
                left join knowledge_node g
                on a.nid  = g.id 
                where a.doc_id  = '$doc_id'";
       return  $this->db()->row($sql);
    }
    public function bytesToSize ($bytes)
    {
        if ($bytes > 0) {
            $units = array(
                    0 => 'B',
                    1 => 'KB',
                    2 => 'MB',
                    3 => 'GB'
            );
            $log = log($bytes, 1024);
            $power = (int) $log;
            $size = pow(1024, $log - $power);
            return round($size, 2) . ' ' . $units[$power];
        } else {
            return 0;
        }
    }
    /**
     * 上传文档时，根据文档标题返回分类
     * @param string $doc_title
     * @return boolean
     */
    function get_cate_by_title($doc_title){
        if(!$doc_title){
            return false;
        }
        $search = $this->getSearchService();
        $docs = $search->setFuzzy()->setQuery($doc_title)->setLimit(1)->search();
        if(!$docs){
            return false;
        }
        $data = json_to_array($docs);
        return current($data[0]);
    }
    
    
    
    /**
     * 保存标签
     */
    function put_tag($id,$tags=null){
        $dd = new Models_Client();
        $data['target_id'] = $id;
        $data['target'] = 'doc';
       
        $tag = '';
        if($tags!=null){
            $tag = $tags;
        }elseif($_REQUEST['tags']){
            $tag =  $_REQUEST['tags'];
        }
        if(empty($tag))return false;
        
        $data['tags_array'] = json_encode(array_values($tag));
        
        $data['creater_id'] = $_SESSION['user']['user_id'];
        
        return $dd->add_tag($data);
         
    }

    /**
     * 资源上传数据处理
     * @param array $files 文件数组
     * @param       $post
     * @return
     * @throws \Exception
     * @internal param array $data 字段数组
     */
    public function uploadData($files,$post){
        
        $resource = Models_Resource::init();
        $video = Models_Video::init();
        
        foreach ($files as $file){
            $file_data = array();
            if(!file_exists($file['file_path'])){
                $tips = array('status'=>0,'msg'=>"源文件{$file['file_name']}不存在,请重新上传");
                return $tips;
            }
            
            $data['uid'] = isset($post['user_id'])?$post['user_id']:$_SESSION['user']['user_id'];
            $data['user_name'] = isset($post['user_realname'])?$post['user_realname']:$_SESSION['user']['user_realname'];
            
            $data['doc_title'] = $post['doc_title']?$post['doc_title']:$file['file_name'];
            $data['doc_summery'] = $post['doc_summery'];
            $data['xd'] = $post['xd'];
            $data['xk'] = $post['xk'];
            $data['nj'] = $post['nj'];
            $data['bb'] = $post['bb'];
            $data['nid'] = $post['zs'];
            $data['cate_id'] = $post['cate_id'];
            $data['node_id'] = (int)$post['node_id'];
            $data['is_hidden'] = (int)$post['is_hidden'];
            
            $data['doc_file_name'] = $file['file_name'];
            $data['doc_ext_name'] = $file['file_ext'];
            $data['file_size'] = (int)$post['file_size'];
            
            $data['on_time'] = (int)$_SERVER['REQUEST_TIME'];
            $data['doc_credit'] = (int)$post['doc_credit'];
            //文档来源:own,repost
            $data['doc_source'] = $post['doc_source'];

            //用户所在班级ID,学校ID,这里需要重新定义
            $class_school = Models_Circle::init()->getCurClassSchoolByUserId($data['uid']);
            //var_dump($class_school);die;
            $data['class_id'] = $class_school['class_id'];
            $data['school_id'] = $class_school['school_id'];
            
            
            $data['role_id'] = isset($post['role_code'])?$post['role_code']: $_SESSION['user']['role_code'];
             
            $data['obj_type'] = $post['obj_type'];
            $data['obj_id'] = $post['obj_id'];
            $data['cus_id'] = isset($post['cus_id'])?$post['cus_id']:'';
            $data['attr'] = isset($post['attr'])?$post['attr']:1;
            $data['is_ok'] = isset($post['is_ok'])?$post['is_ok']:0;


            //判断文件是否已经存在,如果有存在一样的，就只更新信息，如果不在就走正常流程
            //1.取文件的md5码
            $file_md5 = $video->getFileMd5($file['file_path']);
            //获取相同的资源
            $file_info = Models_ResourceFile::init()->getFileInfoByMd5($file_md5);
            $data['doc_status']  = 0;
            if(!isset($file_info['file_id'])){
                
                if(file_exists($file['file_path'])){
                    //如果没有相同的文件就保存文件mogfiles
                    $data['file_key']  = $this->getFileKey().'.'.$file['file_ext'];
                    $this->uploadToResourceFs($data['file_key'], $file['file_path']);
                    //如果是素材与视频
                    if($data['cate_id']==4){
                        $data['doc_status']  = 1;
                    }
                    $data['file_md5'] = $file_md5;
                    
                    $file_data['file_key'] = $data['file_key'];
                    $file_data['doc_ext_name'] = $data['doc_ext_name'];
                    $file_data['file_md5'] = $file_md5;
                    $file_data['file_size'] = $data['file_size'];
                    
                }
                if($post['cate_id']==5 or $post['cate_id']==6){
                    $data['doc_status'] = 1;
                }
                 //先生成文件信息,产生file_id
                 $data['file_id'] = Models_ResourceFile::init()->insert($file_data);
                 
            }else{
                $data['doc_summery'] = Models_Resource::init()->cached('getResourceSummery',array($file_info['file_id']),3600);
                //有重复的文件存在
            	$data['doc_status'] = 3;
            	$data['file_id'] = $file_info['file_id'];
            	
            }



            $resource_data = $data;
            unset($resource_data['doc_ext_name']);
            unset($resource_data['file_size']);
            unset($resource_data['file_key']);
            unset($resource_data['file_md5']);


            //var_dump($resource_data);die;
            //将信息写到资源表
            $doc_id = $this->insert($resource_data,'resource');
            $data['doc_id']  = $doc_id ;
            unset($resource_data);
            
            if(isset($file_info['file_id'])){
                $data['file_key'] = $file_info['file_key'];
                $data['doc_pages'] = $file_info['doc_pages'];
                $data['doc_page_key'] = $file_info['doc_page_key'];
            }
            
            //$data['user_realname'] = $_SESSION['user']['user_realname'];
            
            
            $data['file_path']  = $file['file_path'];
             
            //获取文档的节点名称
            
            $node_arr = Models_Node::init()->getNodeName(array($data['xd'],$data['xk'],$data['bb'],$data['nj']));
            //var_dump($node_arr);die;
            if(isset($data['nid']) and $data['nid']){
                $zs = Models_Unit::init()->getUnitNameById($data['nid']);
                array_push($node_arr, $zs);
            }

            if($node_arr){
                $data['node_name'] = implode('+', array_filter($node_arr));
            }
            
            //节点id，前四个是基础节点的四级深度的节点ID,后面是,zt,nid,cate_id
            $kn_arr['xd'] = $post['xd'];
            $kn_arr['xk'] = $post['xk'];
            $kn_arr['bb'] = $post['bb'];
            $kn_arr['nj'] = $post['nj'];
            $kn_arr['nid'] = $post['zs'];
            if(isset( $post['node_id']) and  $post['node_id']){
                $kn_arr['node_id'] = $post['node_id'];
            }

            $data['node_ids']  =  implode(',', array_filter(array_values($kn_arr)));
            
            unset($kn_arr);


            //保存标签
            $this->put_tag($data['doc_id'],$post['tags']);


            $data['pid_path'] = isset($post['pid_path'])?$post['pid_path']:'';
            $data['unit_pid_path'] = isset($post['unit_pid_path'])?$post['unit_pid_path']:'';
            $data['is_ts']  = isset($post['is_ts'])?$post['is_ts']:1;

            $data['doc_status'] = 0;
            //var_dump($data);die;
            $data['session']  = $_SESSION;
            
           // print_r($data);exit;
         
        if($data['cate_id']==1 or $data['cate_id']==2 or $data['cate_id']==3 or $data['cate_id']==7 or $data['cate_id']==9){
            //队列中转换成功后，加入到全文检索
            if(!isset($file_info['file_id'])){
                //如果是本地的pdf,txt就用这个队列
                $ext_name_arr = array('pdf','txt','xls','xlsx');
                //$ext_name_arr = array('pdf','txt');
                if(in_array(strtolower($data['doc_ext_name']),$ext_name_arr,1)){
                    
                    Cola_Com_Queue_Doc::init()->put($data);
                    
                    //如果是office文档系列，就放到专用的 office  to pdf 队列
                }else{
                    $httpsqs = new   Cola_Com_Queue_Httpsqs(Cola::getConfig('_docQueue'));
                    $data['pdf_key'] = $this->getFsKey($file['file_path'],'pdf');
                    $res = $httpsqs->put(json_encode($data));
                    unlink($file['file_path']);
                    //var_dump($res,$data);die;
                }
                 
            }else{
                $this->addIndex($data);
                unlink($file['file_path']);
            }
            //var_dump($res);
        }elseif($data['cate_id']==5 or $data['cate_id']==6){
            //视频，暂不转码
            //Cola_Com_Queue_Video::init()->put($data);
        
            if(!isset($file_info['file_id'])){
                //生成图片
                $pages =  $video->getVideoTime($file['file_path']);
                $data['doc_pages'] = $pages;
                $image_path = $video->getVideoImage($file['file_path']);
                $page_key = $video->saveImageTofs($image_path);
                $data['doc_page_key'] = $page_key;
        
                //视频的封面与时长
                Models_ResourceFile::init()->update($data['file_id'],array('doc_page_key'=>$page_key,'doc_pages'=>$pages));
                //将视频写到视频云中
                if($post['vid']){
                    $video_info = Models_Sdk_Polyv::init()->getById($post['vid']);
                    $video_info['obj_type'] = 'file';
                    $video_info['obj_id'] = $data['file_id'];
                    //var_dump($video_info);
                    $result =  Models_Video::init()->insert($video_info);
                    //var_dump($result);
                }
            }
            //写搜索
            $this->addIndex($data);
            unlink($file['file_path']);
        }elseif($data['cate_id']==4){
            $this->addIndex($data);
            unlink($file['file_path']);
        }
        
         
        
        unset($data['session']);
        //die;
        return $data;
    }
    }
    /**
     * 添加资源索引
     * @param array $data 索引数据
     */
    public function addIndex($data){

        $index_arr = array();
        $index_arr['id'] = $data['doc_id'];
        $index_arr['title'] = $data['doc_title'];
        $index_arr['summery'] = $data['doc_summery'];
        $index_arr['resource_type'] = $data['cate_id'];
        // 节点名称集,"小学+数数+三年级+人教版"
        $index_arr['node_name'] = $data['node_name'];
        // 节点ID的串,xd,xk,bb,nj,nid
        $index_arr['node_id'] = $data['node_ids'];
        $index_arr['user_name'] = $data['user_realname'];
        $index_arr['user_id'] = $data['uid'];
        $index_arr['role_id'] = $data['role_id'];
        $index_arr['credit'] =  $data['doc_credit'] ;
        $index_arr['remark'] =  0;
        $index_arr['views'] =  0;
         
        $index_arr['file_type'] = $data['doc_ext_name'];
        $index_arr['file_key'] = $data['file_key'];
        $index_arr['file_size'] = $data['file_size'];
        //页数与时长
        if(isset($data['doc_pages'])){
            $index_arr['pages'] = $data['doc_pages'];
        }
        //封面与截图
        if(isset($data['doc_page_key'])){
            $index_arr['page_key'] = $data['doc_page_key'];
        }
        
        $index_arr['on_time'] = $data['on_time'];
        $index_arr['pid_path'] = $data['pid_path'];
        $index_arr['obj_id'] = $data['obj_id'];
        $index_arr['obj_type'] = $data['obj_type'];
        $index_arr['cus_id'] = $data['cus_id'];
        
        //var_dump($index_arr);die;
       // Models_Search::inits()->beginRebuild();
       $res =   Models_Search::inits()->add_index($index_arr);
       Models_Search::inits()->flushIndex();
       Models_Search::inits()->close();
       return $res;
        //Models_Search::inits()->endRebuild();
        
    }
     
    
}
 