<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';
use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);




if ($action == "changement") {
	$datas = TABLE::fullyClassName($name)::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$item = $datas[0];
		$item->quantite = $val;
		$data = $item->save();
	}
	echo json_encode($data);
}