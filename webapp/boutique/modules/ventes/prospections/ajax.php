<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);
$params = PARAMS::findLastId();

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
	$montant = 0;
	$tableau = explode(",", $tableau);
	foreach ($tableau as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0];
		$val = end($data);

		$datas = LIGNEPROSPECTION::findBy(["id = "=>$id]);
		if (count($datas) == 1) {
			$ligne = $datas[0];
			$montant += ($ligne->price / $ligne->quantite) * intval($val);
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
		$produits1 = explode(",", $tableau1);

		if (count($produits) > 0) {
			foreach ($produits1 as $key => $value) {
				$lot = explode("-", $value);
				$array1[$lot[0]] = end($lot);
			}

			$tests = $produits;
			foreach ($tests as $key => $value) {
				$lot = explode("-", $value);
				$id = $lot[0];
				$qte = end($lot);

				foreach ($prospection->ligneprospections as $cle => $lgn) {
					if (($lgn->id == $id ) && ($lgn->quantite >= $qte) && ($lgn->quantite >= ($qte + intval($array1[$id]) )) ) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				foreach ($produits as $key => $value) {
					$lot = explode("-", $value);
					$id = $lot[0];
					$qte = end($lot);
					foreach ($prospection->ligneprospections as $cle => $lgn) {
						if ($lgn->id == $id) {
							$lgn->quantite_vendu = $qte;
							$lgn->perte = intval($array1[$id]);
							$lgn->reste = $lgn->quantite - $qte - intval($array1[$id]);
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