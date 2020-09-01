<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';
use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);



if ($action == "changement") {
	$datas = RESSOURCE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$ressource = $datas[0];
		$ressource->$name = $val;
		$data = $ressource->save();
	}
	echo json_encode($data);
}