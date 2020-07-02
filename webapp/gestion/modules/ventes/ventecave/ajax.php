<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ($action == "annulerProspection") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = PROSPECTION::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$prospection = $datas[0];
				$data = $prospection->annuler();
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
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



if ($action == "calcul") {
	$params = PARAMS::findLastId();
	$montant = 0;
	$tableau = explode(",", $tableau);
	foreach ($tableau as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0];
		$val = end($data);

		$datas = LIGNEPROSPECTION::findBy(["id = "=>$id]);
		if (count($datas) == 1) {
			$ligne = $datas[0];
			$ligne->actualise();
			$montant += $ligne->prixdevente->prix->price * intval($val);
		}
	}
	session("total", $montant);

	$data = new \stdclass();
	$data->total = $montant." ".$params->devise;
	echo json_encode($data);
}


if ($action == "validerProspection") {
	$id = getSession("prospection_id");
	$datas = PROSPECTION::findBy(["id ="=>$id]);
	if (count($datas) > 0) {
		$prospection = $datas[0];
		$prospection->actualise();
		$prospection->fourni("ligneprospection");

		$produits = explode(",", $tableau);
		foreach ($produits as $key => $value) {
			$lot = explode("-", $value);
			$array[$lot[0]] = end($lot);
		}

		$produits1 = explode(",", $tableau1);
		foreach ($produits1 as $key => $value) {
			$lot = explode("-", $value);
			$array1[$lot[0]] = end($lot);
		}

		if (count($produits) > 0) {
			foreach ($array as $key => $value) {
				if (!is_numeric($value)) {
					$array[$key] = 0;
				}
			}
			$tests = $array;
			foreach ($tests as $key => $value) {
				foreach ($prospection->ligneprospections as $cle => $lgn) {
					$lgn->actualise();
					if (($lgn->getId() == $key) && ($lgn->quantite >= ($value + intval($array1[$key])))) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				foreach ($array as $key => $value) {
					if (!is_numeric($array1[$key])) {
						$array1[$key] = 0;
					}
					foreach ($prospection->ligneprospections as $cle => $lgn) {
						if ($lgn->getId() == $key) {
							$lgn->quantite_vendu = $value;
							$lgn->perte = $array1[$key];
							$lgn->reste = $lgn->quantite - $value - intval($array1[$key]);
							$lgn->save();
							break;
						}
					}
				}
				$prospection->hydrater($_POST);
				$prospection->vendu = getSession("total");
				$data = $prospection->terminer($_POST);
				
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien vérifier les quantités des différents produits, certaines sont incorrectes !";
			}			
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}