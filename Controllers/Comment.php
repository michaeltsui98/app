<?php
 class Controllers_Comment extends Cola_Controller
{
   protected $_comment = NULL;

   public function __construct()
   {
  	$this->_comment = new Models_Comment_Comment();
   }

  public function indexAction()
  {
 	  $this->tpl();
  } 
  /**
   * 评论列表
   * 
   */
  public function commentListAction()
  {
    //配置
    $page_config = $this->pageConfigAction();
  	$comment_type = $this->getVar("comment_type");
  	$comment_type_id = $this->getVar("comment_type_id");
    $number = $this->getVar("comment_number");
      $comment_textBox = $this->getVar('comment_textBox', 1); //是否显示评论框 0:不显示,1:显示
    $comment_number = empty($number)? $page_config['limit']:$number;//每页多少条
  	$comment_list = $this->_comment->commentList($comment_type, $comment_type_id,$page_config['start'], $comment_number);
    if($comment_list['msg'] == 'OK'){
      $pager = new Cola_Com_Pager($page_config['p'], $page_config['limit'], $comment_list['total'], '/Comment/commentList/p/%page%/');
      $this->view->page = $pager->html();
      if(!empty($comment_list['data']) && isset($_SESSION['user'])){
        foreach($comment_list['data'] as $k =>$v){
               $comment_list['data'][$k]['del_status'] = ($_SESSION['user']['user_id'] == $v['user_id'])?1:0;
        }
      }
      $this->view->comment_list = $comment_list['data'];
    }else{
      $this->view->comment_list = array();
    }
  	$this->view->user_id = $_SESSION['user']['user_id'];
      $this->view->comment_text_box = intval($comment_textBox);
    echo $this->tpl('views/Comment/commentList.htm', NULL, TRUE);
  }


  /**
   * 添加评论
   */
 public function addCommentAction()
 {
      $comment_type = $this->getVar("comment_type");
      $comment_type_id = $this->getVar("comment_type_id");
      $comment_content = $this->getVar('comment_content');
      //检测是否登录
      if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
          echo json_encode(array('type' =>'login'));exit;
       }
       //检测是否为空
     if(empty($comment_type) || empty($comment_type_id) || empty($comment_content)){
        echo json_encode(array('type' =>'error','message' =>'内容不能为空'));exit;
     }
     $status = $this->_comment->addComment($comment_type, $comment_type_id, $comment_content, $_SESSION['user']['user_id'],$_SESSION['user']['user_realname']);
     if($status){
        $html = ' 
                <li>
		                        <div class="avarter">
		                        <img src='.$_SESSION['user']['icon'].' alt="" width="32px">
		                        </div>
		                        <div class="name"><a target="_blank" href=.'.MAIN_NAME.'/'.$_SESSION['user']['user_id'].'/Space/index">'.$_SESSION['user']['user_realname'].'</a><span class="time f-pl10">'.date('Y-m-d H:i',$status['response_timestamp']).'</span>
		                           
								  <a href="javascript:;" val='.$status['data']['comment_id'].' name="del_comment" class="close f-fr">删除</a>
								   
		                        </div>
		                        <div class="con">'.$comment_content.'</div> 
		                    </li>            
                            
                            ';
       echo json_encode(array('type' =>'success','data' =>$html));exit;
     }else{
       echo json_encode(array('type' =>'error','message' =>'添加失败'));
     }
 }

 /**
  * 删除评论
  * 
  */
 public function deleteCommentAction()
 {

   $comment_id = $this->getVar("comment_id");
    if(!isset($_SESSION['user'])){
     echo json_encode(array('type' =>'login'));exit;
    }

   if(empty($comment_id)){
     echo json_encode(array('type' =>'error'));exit;
   }

   $data = $this->_comment->deleteComment($comment_id);
   if($data['data']['status']){
      echo json_encode(array('type' =>'success'));exit;
      $this->echoJson('success', '删除成功');
   }else{
      $this->echoJson('error',$data);
   }

 }
  /**
   * 分页配置
   * @return array
   */
  public function pageConfigAction()
  {
  	$p = $this->getVar('p',1);
  	$limit = 10;
  	$start = ($p - 1) * $limit;
  	return array(
 			'p' =>$p,
 			'start' =>$start,
 			'limit' =>$limit
  		);
  }

 
  
 
}


?>