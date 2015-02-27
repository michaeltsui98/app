<?php


    class Controllers_Test extends Cola_Controller
    {


        public function indexAction()
        {
           // $data[pid]='1';
            $data[name]='232332';
            $data[alias]='232332';
            $data[is_ok]='1';

            $res = Orm_CmsColumn::create($data);
            var_dump($res);die;

        }

        /**
         * 更新全部的索引数据
         * 将mysql 的数据全部同步到全文索引上去
         */
        function updateIndexAction()
        {

            //每次取十条数据，更新对对应的索引数据
            //$resource_count = Models_Resource::init()->count("doc_status>0");
            set_time_limit(0);
            // var_dump($resource_count);die;
            $limit = 5000;

            $a = $this->getVar('s', 0);
            $count = $a + $limit;

            $sql = "SELECT a.*,b.doc_ext_name,b.doc_pages,b.doc_page_key,b.doc_pdf_key,b.doc_swf_key,b.file_key,b.file_size
,c.pid_path,d.fid_path unit_pid_path
FROM `resource` a
left join resource_file b on a.file_id = b.file_id
left join
(
  SELECT * from node_cate
  UNION
  SELECT * from node_kind
) c on a.node_id = c.id
left join unit_node d on a.nid = d.id
order by a.doc_id";
            /*$sql  = "SELECT a.doc_id
    FROM `resource` a left join resource_file b
    on a.file_id = b.file_id
    where a.doc_status>0  order by a.doc_id   ";*/

            /*  for($a;$a<$count;$a=$a+150){
                  //var_dump($a);
                  $data = $this->getListBySql($sql,$a,$a+150);
                  $resource = $data['rows'];
                  $this->toIndex($resource);
                // echo  Cola_Model::init()->cache()->get('test_index');
              }*/
            while ($a < $count) {

               $data = $this->getListBySql($sql, $a, 150);
                $resource = $data['rows'];
                $this->toIndex($resource);
                $a = $a + 150;
            }


           // Models_Search::inits()->close();


        }

        /**
         * 更新资源索引           b.doc_ext_name,b.doc_pages,b.doc_page_key,b.doc_pdf_key,b.doc_swf_key,b.file_key,b.file_size
         * @param $resource
         */
        public function toIndex($resource)
        {
            foreach ($resource as $k => $v) {
                $data['title'] = $v['doc_title'];
                $data['summery'] = $v['doc_summery'];
                $data['resource_type'] = $v['cate_id'];
                $node_arr = Models_Node::init()->getNodeName(array($v['xd'], $v['xk'], $v['bb'], $v['nj']));
                if (isset($v['nid']) and $v['nid']) {
                    $zs = Models_Unit::init()->getUnitNameById($v['nid']);
                    array_push($node_arr, $zs);
                }
                $data['node_name'] = implode('+', array_filter($node_arr));

                $kn_arr['xd'] = $v['xd'];
                $kn_arr['xk'] = $v['xk'];
                $kn_arr['bb'] = $v['bb'];
                $kn_arr['nj'] = $v['nj'];
                $kn_arr['nid'] = $v['nid'];
                if (isset($v['node_id']) and $v['node_id']) {
                    $kn_arr['node_id'] = $v['node_id'];
                }
                $data['node_id'] = implode(',', array_filter(array_values($kn_arr)));

                $data['user_name'] = $v['user_name'];
                $data['user_id'] = $v['uid'];
                $data['views'] = $v['doc_views'];
                $data['remark'] = $v['doc_remarks'];
                $data['file_type'] = $v['doc_ext_name'];
                $data['file_size'] = $v['file_size'];
                $data['file_key'] = $v['file_key'];
                $data['pages'] = $v['doc_pages'];
                $data['page_key'] = $v['doc_page_key'];
                $data['on_time'] = $v['on_time'];


                $data['pid_path'] = $v['pid_path'];

                $data['unit_pid_path'] = $v['unit_pid_path'];

                $data['is_hidden'] = $v['is_hidden'];
                $data['obj_id'] = $v['obj_id'];
                $data['obj_type'] = $v['obj_type'];
                $data['cus_id'] = $v['cus_id'];
                $data['attr'] = $v['attr'];
                $data['is_ok'] = $v['is_ok'];
                $data['doc_status'] = $v['doc_status'];
                //var_dump($data);die;
                //Cola_Model::init()->cache()->set('test_index',$v['doc_id'],3600);
                echo $v['doc_id'];
                Models_Search::inits()->update_index($v['doc_id'], $data);
            }
        }


        public function getListBySql($sql, $page, $limit, $type = null, $id = '', $pid = '', $name = '', $status = null, $select = null)
        {
            // (int) $page or $page = 1;
            (int)$limit or $limit = 20;
            //$url or $url = $this->getPageUrl();
            $start = $page;
            $limits = ' limit ' . $start . ',' . $limit;

            $data = Cola_Model::init()->sql($sql . $limits);
            //var_dump($sql.$limits);
           // $sql = "select count(*) from (" . $sql . ") as sy";
            //$count = Cola_Model::init()->db->col($sql);

            if ($type != null and $data) {

                $optionlist = array();
                Cola_Com_Tree::get_trees($data, $optionlist, $type, $select, $id, $pid,
                    $name, $status, 0);
                $data = $optionlist;
            }

            if (!$data)
                return array();
            return array(
                'rows' => $data,
                'total' => $count
            );
        }

        public function delDir($path)
        {
            if (!is_dir($path)) {
                return false;
            }
            $hander = opendir($path);
            while (false !== ($item = readdir($hander))) {
                if ($item != '.' and $item != '..') {
                    if (file_exists($path . '/' . $item) and is_dir($path . '/' . $item)) {
                        $this->delDir($path . '/' . $item);
                    } else {
                        unlink($path . '/' . $item);
                    }
                }
            }
            closedir($hander);
        }

        function addFileToZip($path, $zip)
        {
            $handler = opendir($path); //打开当前文件夹由$path指定。
            while (($filename = readdir($handler)) !== false) {
                if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                    if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
                        $this->addFileToZip($path . "/" . $filename, $zip);
                    } else { //将文件加入zip对象
                        $zip->addFile($path . "/" . $filename, $filename);
                    }
                }
            }
            closedir($handler);
        }


        function NumToStr($num)
        {
            if (stripos($num, 'e') === false) return $num;
            $num = trim(preg_replace('/[=\'"]/', '', $num, 1), '"');//出现科学计数法，还原成字符串
            $result = "";
            while ($num > 0) {
                $v = $num - floor($num / 10) * 10;
                $num = floor($num / 10);
                $result = $v . $result;
            }
            return $result;
        }

        function jsonAction()
        {
            $url = 'http://172.16.0.3/lua';
            $json = Cola_Com_Http::get($url);
            echo $json;
            die;
            $data = json_decode($json);
            var_dump($data);
        }

        function addAction()
        {

            $res = Models_CusCate::init()->addCate('test1', 0, '1', 'site');
            var_dump($res);
        }

        function resAction()
        {
            //$ar = array('a','b','c');
            //$this->abort($ar);die;
            $id = $this->getVar('id', 945);
            $res = Models_Search::inits()->indexQuery(" id:{$id} ");
            var_dump($res['data'][0]);

        }

        function getPdfNum($path)
        {
            $cmd = "pdfinfo -box $path";
            $out = shell_exec($cmd);
            unset($cmd);
            preg_match('/.*Pages:\s+(\d+)\s+/i', $out, $mats);
            return (int)$mats[1];
        }

        function setMateAction()
        {
            $saveFile = S_ROOT . 'hdtldx.mp4';
            $newFile = S_ROOT . 'hdtldx2.mp4';
            $res = Models_Video::init()->setMeta($saveFile, $newFile);
            print_r($res);
        }

        function get_pdf_num($pdf_file)
        {
            $img = new Imagick($pdf_file);
            return (int)$img->getnumberimages();
        }

        function getPdfPages($path)
        {
            if (!file_exists($path)) return array(false, "文件\"{$path}\"不存在！");
            if (!is_readable($path)) return array(false, "文件\"{$path}\"不可读！");
            $max = 0;
            // 打开文件
            $fp = @fopen($path, "r");
            if (!$fp) {
                return array(false, "打开文件\"{$path}\"失败");
            } else {
                while (!feof($fp)) {
                    $line = fgets($fp, 255);
                    if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                        preg_match('/[0-9]+/', $matches[0], $matches2);
                        if ($max < $matches2[0]) $max = $matches2[0];
                    }
                }
                fclose($fp);
                // 返回页数
                return array(true, $max);
            }
        }
    }

?>