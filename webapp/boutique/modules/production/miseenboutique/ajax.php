<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if ($action === "miseenboutique") {
	$tableau = [];
	$test = true;

	$datas = PRIXDEVENTE::getAll();
	foreach (PRIXDEVENTE::getAll() as $key => $pdv) {
		if (isset($_POST["mise-".$pdv->id]) && intval($_POST["mise-".$pdv->id]) > 0) {
			if($pdv->enEntrepot(dateAjoute()) < intval($_POST["mise-".$pdv->id])){
				$test = false;
				break;
			}else{
				$tableau[] = $pdv;
			}
		}
	}
	if ($test) {
		$meb = new MISEENBOUTIQUE();
		$meb->hydrater($_POST);
		$data = $meb->enregistre();
		if ($data->status) {
			foreach ($tableau as $key => $pdv) {
				$ligne = new LIGNEMISEENBOUTIQUE();
				$ligne->miseenboutique_id = $meb->id;
				$ligne->produit_id = $pdv->id;
				$ligne->quantite = intval($_POST["mise-".$pdv->id]);
				$ligne->restant = $pdv->enEntrepot(dateAjoute()) - intval($_POST["mise-".$pdv->id]);
				$data = $ligne->enregistre();
			}
		}
	}else{
		$data->status = false;
		$data->message = "Vous ne pouvez pas mettre en boutique plus de quantité d'un produit que ce que vous n'en possédez !";
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