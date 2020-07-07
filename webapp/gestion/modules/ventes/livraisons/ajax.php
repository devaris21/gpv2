<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ($action == "annulerLivraison") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = PROSPECTION::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$livraison = $datas[0];
				$data = $livraison->annuler();
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



if ($action == "validerLivraison") {
	$id = getSession("livraison_id");
	$datas = PROSPECTION::findBy(["id ="=>$id]);
	if (count($datas) > 0) {
		$livraison = $datas[0];
		$livraison->actualise();
		$livraison->fourni("ligneprospection");

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

				foreach ($livraison->ligneprospections as $cle => $lgn) {
					if (($lgn->id == $id) && ($lgn->quantite >= $qte) && ($lgn->quantite >= ($qte + $array1[$id])) ) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				foreach ($produits as $key => $value) {
					$lot = explode("-", $value);
					$id = $lot[0];
					$qte = end($lot);
					foreach ($livraison->ligneprospections as $key => $lgn) {
						if ($lgn->id == $id) {
							$lgn->quantite_vendu = $qte;
							$lgn->perte = $array1[$id];
							$lgn->reste = $lgn->quantite - $qte - $array1[$id];
							$lgn->save();

							if ($lgn->reste > 0) {
								$livraison->groupecommande->etat_id = ETAT::ENCOURS;
								$livraison->groupecommande->save();
							}
							break;
						}
					}
				}
				$livraison->hydrater($_POST);
				$data = $livraison->terminerLivraison();
				
			}else{
				$data->status = false;
				$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
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