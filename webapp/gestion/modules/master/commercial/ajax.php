<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "filtrer") {
	session("date1", $date1);
	session("date2", $date2);
}


if ($action == "changer") {
	$data->setUrl("gestion", "master", "commercial", $id);
	echo json_encode($data);
}


if ($action == "paye") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = COMMERCIAL::findBy(["id=" => $commercial_id]);
			if (count($datas) > 0) {
				$commercial = $datas[0];
				
				$lignepayement = new LIGNEPAYEMENT();
				$lignepayement->hydrater($_POST);
				$lignepayement->commercial_id = $commercial_id;
				$data = $lignepayement->enregistre();
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
			}
		}else{
			$data->status = false;
			$data->message = "Votre mot de passe ne correspond pas !";
		}
	}else{
		$data->status = false;
		$data->message = "Vous ne pouvez pas effectué cette opération !";
	}
	echo json_encode($data);
}





