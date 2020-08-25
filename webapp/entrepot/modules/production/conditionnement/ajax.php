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




if ($action == "validerConditionnement") {
	$quantite = 0;
	foreach ($_POST as $key => $value) {
		if (strpos($key, "-") !== false && $value > 0) {
			$tab = explode("-", $key);
			$datas = PRODUIT::findBy(["id ="=>$tab[0]]);
			if (count($datas) == 1) {
				$produit = $datas[0];
				$datas = EMBALLAGE::findBy(["id ="=>$tab[1]]);
				if (count($datas) == 1) {
					$produit->actualise();
					$format = $datas[0];
					$quantite += $format->nombre() * $produit->quantite->name* $value;
				}
			}
		}
	}
	if ($quantite <= PRODUCTION::enStock(PARAMS::DATE_DEFAULT, dateAjoute(1), $produit->typeproduit->id, $produit->parfum->id, getSession("entrepot_connecte_id"))) {
		$conditionnement = new CONDITIONNEMENT();
		$conditionnement->hydrater($_POST);
		$conditionnement->parfum_id = $produit->parfum_id;
		$conditionnement->typeproduit_id = $produit->typeproduit_id;
		$conditionnement->quantite = $quantite;
		$conditionnement->etat_id = ETAT::ENCOURS;
		$data = $conditionnement->enregistre();
		if (count($datas) > 0) {
			foreach ($_POST as $key => $value) {
				if (strpos($key, "-") !== false && $value > 0) {
					$tab = explode("-", $key);
					$datas = PRODUIT::findBy(["id ="=>$tab[0]]);
					if (count($datas) == 1) {
						$produit = $datas[0];
						$datas = EMBALLAGE::findBy(["id ="=>$tab[1]]);
						$format = $datas[0];
						if (count($datas) == 1) {
							$ligne = new LIGNECONDITIONNEMENT;
							$ligne->conditionnement_id = $conditionnement->id;
							$ligne->produit_id = $produit->id;
							$ligne->emballage_id = $format->id;
							$ligne->quantite = $value;
							$ligne->enregistre();
						}
					}
				}
			}
		}
	}else{
		$data->status = false;
		$data->message = "La quantite totale des emballages dépassent la quantité de production, Veuillez vérifier les données !";
	}
	echo json_encode($data);
}