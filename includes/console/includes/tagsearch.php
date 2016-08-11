<?php
$q=$_GET["query"];

$global = new DB_global;
$result = $global->sqlquery('SELECT * FROM dd_tags WHERE tag_name LIKE "%'.$q.'%"');
$tagresults = array();
if($result->num_rows > 0){
	while($row=$result->fetch_array()){
	$tagresults[]=array('suggestion'=>$row['tag_name'],
	'value'=>$row['tag_name']);
    }
} else {
	echo 'No tags found';
}
$arr2= array();
$arr2['suggestions']=$tagresults;	
 echo json_encode($arr2);
 exit;