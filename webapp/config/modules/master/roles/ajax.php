<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';
use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "autoriser") {
	$datas = ROLE_EMPLOYE::findBy(["employe_id ="=> $employe_id, "role_id ="=> $role_id]);
	if ($etat == "true") {
		if (count($datas) == 0) {
			$rem = new ROLE_EMPLOYE();
			$rem->hydrater($_POST);
			$data = $rem->enregistre();
		}else{
			$data->status = false;
			$data->message = "L'employé dispose déjà de ce droit !";
		}
	}else{
		if (count($datas) == 1) {
			$rem = $datas[0];
			if (!$rem->isProtected()) {
				$rem = $datas[0];
				$data = $rem->delete();
			}else{
				$data->status = false;
				$data->message = "Vous ne pouvez pas supprimer cet accès, il est protégé !";
			}
		}else{
			$data->status = false;
			$data->message = "L'accès est déjà refusé à cet employé !";
		}
	}
	echo json_encode($data);
}




if ($action == "change-boutique") {
	$datas = EMPLOYE::findBy(["id ="=> $employe_id]);
	if ($id == '') {
		$id = null;
	}
	if (count($datas) == 1) {
		$employe = $datas[0];
		$employe->boutique_id = $id;
		$data = $employe->save();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite, veuillez recommencer !";
	}
	echo json_encode($data);
}



if ($action == "change-entrepot") {
	$datas = EMPLOYE::findBy(["id ="=> $employe_id]);
	if ($id == '') {
		$id = null;
	}
	if (count($datas) == 1) {
		$employe = $datas[0];
		$employe->entrepot_id = $id;
		$data = $employe->save();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite, veuillez recommencer !";
	}
	echo json_encode($data);
}
