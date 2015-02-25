<?php

/**
 * 资源统计
 * 
 * @author michaeltsui98@qq.com 2014-04-17
 *
 */
class Modules_Admin_Controllers_Statis extends  Modules_Admin_Controllers_Base {
	
	public  function indexAction(){
	    $this->view->title = '资源统计';
 	    if(!$this->request()->isAjax()){
	        $layout = $this->getCurrentLayout('common.htm');
	        $this->setLayout($layout);
	    }
	    $this->view->getChart1  = url($this->c, 'chart1Action');
	    $this->view->getChart2  = url($this->c, 'chart2Action');
	    $this->tpl();
	}

	public function chart2Action(){
		/* echo '{"title":{"text":"Results", "style":"font-size: 14px; font-family: Verdana; text-align: center;"},
		 "bg_colour":"#ffffff", "elements":[{"type":"pie", 
		 "tip":"#label# $#val#<br>#percent#", 
		 "values":[{"value":0.5460168783320114, "label":"1"},{"value":1.1518703534966335, "label":"2"},
	    {"value":1.3166724945418538, "label":"3"},{"value":0.8272772165481002, "label":"4"},
	    {"value":1.5593474025372416, "label":"5"},{"value":1.0560901317046956, "label":"6"},
	    {"value":0.8281081385444851, "label":"7"},{"value":1.2528729066718371, "label":"8"},
	    {"value":0.7146496058208868, "label":"9"},{"value":1.555644403747283, "label":"10"},
	    {"value":0.5070427171885967, "label":"11"},{"value":1.2477280215127395, "label":"12"}], 
	    "animate":true, "gradient-fill":false, 
	    "colours":["#ff0000","#00ff00","#0000ff","#ff9900","#ff00ff","#FFFF00","#6699FF","#339933"]}]}'; */
	   /*  $pie = new pie();
	    $pie->set_alpha(0.6);
	    $pie->set_start_angle( 35 );
	    $pie->add_animation( new pie_fade() );
	    $pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
	    $pie->set_colours( array('#1C9E05','#FF368D') );
	    $pie->set_values( array(2,3,4,new pie_value(6.5, "hello (6.5)")) ); */
	    
	    $where = "";
        
        $start_date = $this->getVar('start_date');
        $end_date = $this->getVar('end_date');
        if($start_date and $end_date){
        	$where = " and  (FROM_UNIXTIME(a.on_time,'%Y-%m-%d') BETWEEN '$start_date' and '$end_date') ";
        }
        //var_dump($where) ;die;
		include S_ROOT.'Models/Ofc/Base/open-flash-chart.php';
		$title = new title('资源文件类型统计');
		$title->set_style("font-size: 14px; font-family: Verdana; text-align: center; color: #FFB900");
		$pie = new pie();
		$pie->tooltip("#label# #val#<br>#percent#");
		$pie->set_animate(true);
		$pie->set_colours(array('#d01f3c','#356aa0','#C79810',"#ff9900","#ff00ff","#303030","#6699FF","#339933"));
		$pie->gradient_fill(true);
		
		$values = array();
		$data = Cola_Model::init()->sql("select b.doc_ext_name, count(*) c from resource a
                                        left join resource_file b 
                                        on a.file_id  = b.file_id
                                        where a.file_id >0 
                                        $where
                                        GROUP BY b.doc_ext_name");				
		
		foreach ($data as $v){
			$values[] = new pie_value((int)$v['c'], '文件类型：'.$v['doc_ext_name']);
		}
		$pie->set_values($values);
		$chart = new open_flash_chart();
		$chart->set_title($title);
		$chart->add_element($pie);
		//$chart->set_bg_colour('#303030');
		 
		echo $chart->toPrettyString();
		
	}
	
	/**
	 * json数据输出
	 */
	public function chart1Action() {
	     
	    $where = "";
	    $legend = "全部的";
	    $start_date = $this->getVar('start_date');
	    $end_date = $this->getVar('end_date');
	    if($start_date and $end_date){
	        $where = " and  (FROM_UNIXTIME(a.on_time,'%Y-%m-%d') BETWEEN '$start_date' and '$end_date') ";
	        $legend = " $start_date - $end_date ";
	    }
	    $data = Cola_Model::init()->sql("select a.cate_id, count(*) c from resource a
                            left join resource_file b 
                            on a.file_id  = b.file_id
                            where a.file_id >0 and cate_id >0 and cate_id<7 
                               $where
                            GROUP BY a.cate_id");
	    
	   $type_arr = Cola::getConfig('_resourceType');
	   $values = array();
	   $labels = array();
       foreach ($data as $v){
         if((int)$v['cate_id']>6){
         	continue;
         }
       	 $values[] = (int)$v['c'];
       	 $labels[] = $type_arr[$v['cate_id']];
       }
	   
       //var_dump($values,$labels);die;
       
	   include S_ROOT.'Models/Ofc/Base/open-flash-chart.php';
	   
        $title = new title( "资源类型统计图" );
        
        $bar = new bar();
        $bar->set_values( $values );
        $bar->key('visitor', 14 );
        $bar->set_tooltip( "#val#" );
        $bar->set_colour( '#47092E' );
        
        
        
        $x_axis = new x_axis();
        
        $x_axis->set_labels_from_array($labels);
        
        $y_axis = new y_axis();
        $y_axis->set_range(0,max($values),10);
        $y_axis->set_label_text("#val#");
        //$y_axis->set_offset(false);
        
        
        $x_legend = new x_legend( $legend );
        $x_legend->set_style( '{font-size: 20px; color: #778877}' );
        
        $t = new tooltip();
        $t->set_shadow( true );
        $t->set_stroke( 5 );
        $t->set_colour( "#6E604F" );
        $t->set_background_colour( "#BDB396" );
        $t->set_title_style( "{font-size: 14px; color: #CC2A43;}" );
        $t->set_body_style( "{font-size: 16px; font-weight: bold; color: #000000;}" );
        
        $chart = new open_flash_chart();
        $chart->set_title( $title );
        $chart->add_element( $bar );
        $chart->set_x_axis($x_axis);
        $chart->set_y_axis($y_axis);
        $chart->set_x_legend( $x_legend );
        $chart->set_tooltip( $t );
        
        echo $chart->toPrettyString();
	    
	}
 
 
	
}