<?php

    /**
     * 文档搜索
     * @author michael
     *
     */
    class Controllers_Search extends Controllers_Base
    {

        public function indexAction()
        {
            $this->view->page_title = '资源搜索页';
            $tmp = explode('/', $this->getVar("param"));
            $params = array();
            while (false !== ($next = next($tmp))) {
                $params[$next] = urldecode(next($tmp));
            }
            //搜索对象
            $search = Models_Search::inits()->getSearchServer();
            //查询条件
            $query = "";

            $key = $params['key'];
            if ($key) {
                $query .= "($key)";
            } else {
                $this->redirect('/index');
            }

            $type = $params['type'] ? $params['type'] : 0;
            $this->view->type = $type;

            //文件类型
            $file_type = $this->getVar('file_type', 0);
            $this->view->file_type = $file_type;
            if ($type and $key) {
                $query .= " AND resource_type:{$type} ";
            } elseif ($type) {
                $query .= " resource_type:{$type} ";
            }
            //文档页数
            $file_page = $this->getVar('file_page', 0);
            //播放时长
            $play_time = $this->getVar('play_time', 0);
            //发布时间
            $on_time = $this->getVar('on_time', 0);
            $order = isset($params['order']) ? $params['order'] : 1;
            if ($order == 1) {
                $sort_field = "id";
                $asc = false;
            } elseif ($order == 2) {
                $sort_field = "remark";
                $asc = false;
            } elseif ($order == 3) {
                $sort_field = "file_size";
                $asc = false;
            } elseif ($order == 4) {   //筛选条件
                $sort_field = "id";
                $asc = false;

                if ($file_type == 1) {  //文档文件
                    if ($query) {
                        $query .= "  AND  ( file_type:doc OR file_type:docx OR file_type:ppt OR file_type:pptx OR file_type:xls OR file_type:xlsx OR file_type:rtf )";
                    } else {
                        $query .= "  ( file_type:doc OR file_type:docx OR file_type:ppt OR file_type:pptx OR file_type:xls OR file_type:xlsx OR file_type:rtf )";
                    }
                } elseif ($file_type == 2) {  //视频文件
                    if ($query) {
                        $query .= "  AND (file_type:mp4 OR file_type:flv)";
                    } else {
                        $query .= "  (file_type:mp4 OR file_type:flv) ";
                    }
                } elseif ($file_type == 3) {  //素材文件
                    if ($query) {
                        $query .= "  AND (file_type:jpg OR file_type:jpeg  OR file_type:rar  OR file_type:zip  OR file_type:png  OR file_type:gif)";
                    } else {
                        $query .= "  (file_type:jpg OR file_type:jpeg  OR file_type:rar  OR file_type:zip  OR file_type:png  OR file_type:gif)";
                    }
                }


                //die;

                if ($file_page == 1) {  //1-5页
                    $search->addRange('pages', null, 5);
                } elseif ($file_page == 2) { //6-10页
                    $search->addRange('pages', 5, 10);
                } elseif ($file_page == 3) { //大于10页
                    $search->addRange('pages', 11, null);
                }

                if ($play_time == 1) {  //1分钟以内
                    $search->addRange('pages', null, 60);
                } elseif ($play_time == 2) {  //5分钟以内
                    $search->addRange('pages', null, 60 * 5);
                } elseif ($play_time == 3) {  //30分钟以内
                    $search->addRange('pages', null, 60 * 30);
                } elseif ($play_time == 4) {  //60分钟以内
                    $search->addRange('pages', null, 60 * 60);
                } elseif ($play_time == 5) {  //60分钟以上
                    $search->addRange('pages', 60 * 60, null);
                }

                if ($on_time == 1) { //一周以内
                    $search->addRange('on_time', null, strtotime("last week"));
                } elseif ($on_time == 2) { //一月以内
                    $search->addRange('on_time', null, strtotime("last month"));
                } elseif ($on_time == 3) { //三月以内
                    $search->addRange('on_time', null, strtotime("-3 month"));
                } elseif ($on_time == 4) { //一年以内
                    $search->addRange('on_time', null, strtotime("-1 year"));
                }
            }
            $search->setFuzzy(true)->setQuery($query);
            //var_dump($query);

            $search->addRange('resource_type', 1, 6);

            if($key){
                $search->addWeight('title', '', $key, 1);
            }

            $count = $search->count();
            $search->setSort($sort_field, $asc, false);
            $page = $this->getVar('page', 1);
            $pagesize = 20;
            $search->setLimit($pagesize, max(0, ($page - 1) * $pagesize));
            $data = $search->search();

            $this->view->search = $search;
            $this->view->data = $data;
            $this->view->resources = $data;
            //搜索热门词
            $words = $search->getHotQuery(10);
            $this->view->words = $words;

            $this->view->resource_list = $this->resourceList();

            $pager = new Cola_Com_Pager($page, $pagesize, $count, Cola_Model::init()->getPageUrl());
            $this->view->page_html = $pager->html();


            $this->view->file_page = $file_page;
            $this->view->play_time = $play_time;
            $this->view->on_time = $on_time;

            $this->view->key = $key;
            $this->view->order = $order;
            $this->view->css = array('searchList/css/index.css');
            $this->layout = $this->getCurrentLayout('index.htm');
            $this->setLayout($this->layout);
            $this->tpl();
        }

        /**
         * 资源列表,对应不同的模板
         */
        public function resourceList()
        {

            $type = $this->view->type;
            $file_type = $this->view->file_type;

            if ($file_type) {
                if ($file_type == 1) {
                    $tpl_name = "views/List/listDoc.htm";
                } elseif ($file_type == 2) {
                    $tpl_name = "views/List/listVideo.htm";
                } elseif ($file_type == 3) {
                    $tpl_name = "views/List/listFile.htm";
                }
            } else {
                //资源数据对应不同的模板输出
                if ($type == 1 or $type == 2 or $type == 3) {  //文档
                    $tpl_name = "views/List/listDoc.htm";
                } elseif ($type == 4 or $type == 0) {  //素村
                    $tpl_name = "views/List/listFile.htm";
                } elseif ($type == 5 or $type == 6) { //视频
                    $tpl_name = "views/List/listVideo.htm";
                }
            }

            return $this->tpl($tpl_name, '', true);

        }

        /**
         * 搜索列表
         */
        function testAction()
        {
            $q = $this->getVar('q', '*');

            $query = ' * ' . $q;

            $file_type = $this->getVar('file_type', 'all');
            $sort = $this->getVar('sort', 1);
            $up = new Models_Upload();
            $search = $up->getSearchService(Cola::$_config['_search']);

            //文件类型条件
            if ($file_type == 'doc') {
                $query .= "  file_type:doc OR file_type:docx OR file_type:rtf";
            }
            if ($file_type == 'ppt') {
                $query .= "  file_type:ppt OR file_type:pptx OR file_type:pps OR file_type:pot";
            }
            if ($file_type == 'xls') {
                $query .= "  file_type:xls OR file_type:xlsx";
            }
            if ($file_type == 'pdf') {
                $query .= "  file_type:pdf";
            }
            //echo $query;
            $sort_cod = "";
            $relevance_first = false;

            //排序条件
            switch ($sort) {
                case 1:
                    $sort_cod = 'doc_content';
                    $asc = false;
                    $relevance_first = true;
                    break;
                case 2:
                    $sort_cod = 'on_time';
                    $asc = false;
                    break;
                case 3:
                    $sort_cod = 'views';
                    $asc = false;
                    break;
                case 4:
                    $sort_cod = 'remark';
                    $asc = false;
                    break;
                case 5:
                    $sort_cod = 'doc_pages';
                    $asc = false;
                    break;
            }

            $page = $this->getVar('page', 1);
            $pagesize = 15;

            //var_dump($query);
            $count = $search->setFuzzy()->setQuery($query)->count();


            $docs = $search->setFuzzy()->setQuery($query)
                ->setSort($sort_cod, $asc, $relevance_first)
                ->setLimit($pagesize, max(0, ($page - 1) * $pagesize))
                ->search();

            //echo $search->getQuery();
            //生成url
            /* $uri_arr = parse_url($_SERVER['REQUEST_URI']);
            parse_str($uri_arr['query'],$query_arr);
            unset($query_arr['page']);
            $url = $uri_arr['path'].'?'.http_build_query($query_arr).'&page=%page%'; */

            $url = get_url();
            //生成分页
            $page_obj = new Cola_Com_Pager($page, $pagesize, $count, $url);
            $page_html = $page_obj->html();
            //生成星星
            $doc = new Models_Doc();


            $this->view->doc = $doc;

            $this->view->search = $search;

            $this->view->vars = get_defined_vars();
            $this->display('search/index', 'master/default');
        }


    }

