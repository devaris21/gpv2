<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ($action == "miseenboutique") {
	$tests = $listeproduits = explode(",", $listeproduits);
	foreach ($tests as $key => $value) {
		$lot = explode("-", $value);
		$format_id = $lot[1];
		$id = $lot[0];
		$qte = end($lot);
		$datas = PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$produit = $datas[0];
			if ($produit->enEntrepot(PARAMS::DATE_DEFAULT, dateAjoute(1), $format_id, getSession("entrepot_connecte_id")) >= $qte) {
				unset($tests[$key]);
			}	
		}
	}
	if (count($tests) == 0) {
		$meb = new MISEENBOUTIQUE();
		$meb->hydrater($_POST);
		$meb->etat_id = ETAT::ENCOURS;
		$data = $meb->enregistre();
		if ($data->status) {
			foreach ($listeproduits as $key => $value) {
				$lot = explode("-", $value);
				$format_id = $lot[1];
				$id = $lot[0];
				$qte = end($lot);
				$datas = PRODUIT::findBy(["id ="=> $id]);
				if (count($datas) == 1) {
					$produit = $datas[0];
					if ($qte > 0) {
						$ligne = new LIGNEMISEENBOUTIQUE();
						$ligne->miseenboutique_id = $meb->id;
						$ligne->emballage_id = $format_id;
						$ligne->produit_id = $produit->id;
						$ligne->quantite_depart = intval($qte);
						$data = $ligne->enregistre();
					}

				}
			}
		}
	}else{
		$data->status = false;
		$data->message = "Certains des produits sont en quantité insuffisantes pour faire cette sortie d'entrepôt !";
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
	$datas = MISEENBOUTIQUE::findBy(["id ="=>$id, "etat_id = "=>ETAT::PARTIEL]);
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
					if (($lgn->id == $key) && ($lgn->quantite_demande >= $value)) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				foreach ($array as $key => $value) {
					foreach ($mise->lignemiseenboutiques as $cle => $lgn) {
						if ($lgn->id == $key) {
							$lgn->quantite_depart = $value;
							$lgn->save();
							break;
						}
					}					
				}
				$mise->hydrater($_POST);
				$data = $mise->accepter();
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien vérifier les quantités des différents produits, certaines sont incorrectes !";
			}			
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer 0";
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer 1";
	}
	echo json_encode($data);
}