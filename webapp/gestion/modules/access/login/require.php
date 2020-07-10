<?php 
namespace Home;

@session_destroy();
unset($_GET);
unset($_POST);
$params = PARAMS::findLastId();

$title = "GPV | Espace de connexion";



foreach (OPERATION::findBy(["mouvement_id = "=> 0]) as $key => $value) {
	$datas = MOUVEMENT::findBy(["comment ="=> $value->comment]);
	if (count($datas) == 1) {
		$mvt = $datas[0];
		$value->mouvement_id = $mvt->id;
		$value->save();
	}
}

?>