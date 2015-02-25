<?php

//
// This is the MODEL section:
//

include S_ROOT.'Models/Ofc/Base/open-flash-chart.php';

$title = new title( date("D M d Y") );

$bar = new bar();
$bar->set_values( array(192,184,172,261,375,454,643,792,441,542,756,889) );
$bar->key('visitor', 14 );
$bar->set_tooltip( "#val#" );
$bar->set_colour( '#47092E' );



$x_axis = new x_axis();

$x_axis->set_labels_from_array(array('2013-5','2013-6','2013-7','2013-8','2013-9','2013-10','2013-11','2013-12','2014-1','2014-2','2014-3','2014-4'));

$y_axis = new y_axis();
$y_axis->set_range(0,2500,500);
$y_axis->set_label_text("#val#");
//$y_axis->set_offset(false);

$x_legend = new x_legend( '2013-5 to 2014-2' );
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

?>

