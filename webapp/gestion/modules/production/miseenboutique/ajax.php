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

	if(!(isset($etat_id) && ($etat_id == ETAT::PARTIEL))){
		foreach (PRIXDEVENTE::findBy(["isActive ="=>TABLE::OUI]) as $key => $pdv) {
			if (isset($_POST["mise-".$pdv->getId()]) && intval($_POST["mise-".$pdv->getId()]) > 0) {
				if($pdv->enEntrepot(dateAjoute(), $entrepot_id) < intval($_POST["mise-".$pdv->getId()])){
					$test = false;
					break;
				}else{
					$tableau[] = $pdv;
				}
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
				$ligne->miseenboutique_id = $meb->getId();
				$ligne->prixdevente_id = $pdv->getId();
				$ligne->quantite_depart = intval($_POST["mise-".$pdv->getId()]);
				$data = $ligne->enregistre();
			}
		}
	}else{
		$data->status = false;
		$data->message = "Vous ne pouvez pas mettre en boutique plus de quantité d'un produit que ce que vous n'en possédez !";
	}
	echo json_encode($data);
}



