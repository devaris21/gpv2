<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ($action == "nouvelleProduction") {
	$production = new PRODUCTION();
	$production->hydrater($_POST);
	$production->etat_id = ETAT::ENCOURS;
	$data = $production->enregistre();
	if ($data->status) {
		$listeproduits = explode(",", $listeproduits);
		foreach ($listeproduits as $key => $value) {
			$lot = explode("-", $value);
			$id1 = $lot[0];
			$id2 = $lot[1];
			$qte = end($lot);
			if ($qte > 0) {
				$datas = PARFUM::findBy(["id ="=> $id1]);
				if (count($datas) == 1) {
					$parfum = $datas[0];
					$datas = TYPEPRODUIT::findBy(["id ="=> $id2]);
					if (count($datas) == 1) {
						$typeproduit = $datas[0];

						$ligne = new LIGNEPRODUCTION();
						$ligne->production_id = $production->id;
						$ligne->parfum_id = $parfum->id;
						$ligne->typeproduit_id = $typeproduit->id;
						$ligne->quantite = intval($qte);
						$data = $ligne->enregistre();	
					}	
				}
			}
		}
	}
	echo json_encode($data);
}




if ($action == "annulerMiseenboutique") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = MISEENBOUTIQUE::findBy(["id ="=>$id]);
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




if ($action == "validerMiseenboutique") {
	$id = getSession("miseenboutique_id");
	$datas = MISEENBOUTIQUE::findBy(["id ="=>$id, "etat_id = "=>ETAT::ENCOURS]);
	if (count($datas) > 0) {
		$mise = $datas[0];
		$mise->actualise();
		$mise->fourni("lignemiseenboutique");

		$produits = explode(",", $tableau);
		foreach ($produits as $key => $value) {
			$lot = explode("-", $value);
			$array[$lot[0]] = end($lot);
		}

		if (count($produits) > 0) {
			$tests = $array;
			foreach ($tests as $key => $value) {
				foreach ($mise->lignemiseenboutiques as $cle => $lgn) {
					if (($lgn->id == $key) && ($lgn->quantite_depart >= $value)) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				foreach ($array as $key => $value) {
					foreach ($mise->lignemiseenboutiques as $cle => $lgn) {
						if ($lgn->id == $key) {
							$lgn->quantite = $value;
							$lgn->perte = $lgn->quantite_depart - $value;
							$lgn->save();
							break;
						}
					}					
				}
				$mise->hydrater($_POST);
				$data = $mise->valider();
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