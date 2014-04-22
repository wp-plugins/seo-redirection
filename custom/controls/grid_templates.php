<?php


$template['link']['content'] = " we can see {param1} here {param2} my {db_OS}";

$template['edit']['content'] = "<a href='{param}'><div class='edit_template'></div></a>";
$template['edit']['options']['width']= '20px';
$template['edit']['options']['align']= 'center';



$template['go_link']['content'] = "<a target='_blank' href='{param}'><div class='go_link_template'></div></a>";
$template['go_link']['options']['width']= '20px';
$template['go_link']['options']['align']= 'center';


$template['redirect_link']['content'] = "<a href='{param}'><div class='go_link_template'></div></a>";
$template['redirect_link']['options']['width']= '20px';
$template['redirect_link']['options']['align']= 'center';


$template['del']['content'] = "<a href='#' onclick=\"if(confirm('Are you sure you want to delete this item?'))window.location='{param}';\"><div class='del_template'></div></a>";
$template['del']['options']['width']= '20px';
$template['del']['options']['align']= 'center';


$template['view']['content'] = "<a href='{param}'><img src='../cframework/style/icons/view.gif' /></a>";
$template['view']['options']['width']= '20px';
$template['view']['options']['align']= 'center';


$template['order']['content'] = "<a href='{param}&do=last'><img src='../cframework/style/icons/ord_last.gif' /></a><a href='{param}&do=up'><img src='../cframework/style/icons/ord_up.gif' /></a><a href='{param}&do=down'><img src='../cframework/style/icons/ord_down.gif' /></a><a href='{param}&do=first'><img src='../cframework/style/icons/ord_first.gif' /></a>";
$template['order']['options']['width']= '65px';
$template['order']['options']['align']= 'center';


$template['status']['content'] = "<img src='../adminx0097/images/{param}.gif' />";
$template['status']['options']['width']= '20px';
$template['status']['options']['align']= 'center';




?>