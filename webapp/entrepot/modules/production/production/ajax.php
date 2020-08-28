<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ($action == "nouvelleProduction") {
	$tests = $listeproduits = explode(",", $listeproduits);
	foreach ($tests as $key => $value) {
		$lot = explode("-", $value);
		$id = $lot[0];
		$qte = end($lot);
		if ($qte > 0) {
			$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=> $id]);
			if (count($datas) == 1) {
				$type = $datas[0];
				foreach ($type->fourni("exigenceproduction") as $key1 => $exi) {
					$datas = $exi->fourni("ligneexigenceproduction");
					foreach ($datas as $key2 => $ligne) {
						if ($ligne->quantite > 0) {
							$ligne->actualise();
							if (($qte*$ligne->quantite/$exi->quantite) <= $ligne->ressource->stock(dateAjoute(1), getSession("entrepot_connecte_id"))) {
								unset($datas[$key2]);
							}
						}
					}
				}
			}
		}
	}
	if (count($tests) == 0) {
		$datas = ENTREPOT::findBy(["id ="=>getSession("entrepot_connecte_id")]);
		if (count($datas) == 1) {
			$entrepot = $datas[0];
			$entrepot->actualise();
			if ($entrepot->comptebanque->solde() >= $transport) {
				$production = new PRODUCTION();
				$production->hydrater($_POST);
				$production->etat_id = ETAT::ENCOURS;
				$data = $production->enregistre();
				if ($data->status) {
					foreach ($listeproduits as $key => $value) {
						$lot = explode("-", $value);
						$id = $lot[0];
						$qte = end($lot);

						$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=> $id]);
						if (count($datas) == 1) {
							$type = $datas[0];
							$ligne = new LIGNEPRODUCTION();
							$ligne->production_id = $production->id;
							$ligne->typeproduit_parfum_id = $type->id;
							$ligne->quantite = intval($qte);
							$data = $ligne->enregistre();	

							foreach ($type->fourni("exigenceproduction") as $key1 => $exi) {
								foreach ($exi->fourni("ligneexigenceproduction") as $key2 => $lign) {
									if ($lign->quantite > 0) {
										$lign->actualise();
										$ligne = new LIGNECONSOMMATION();
										$ligne->production_id = $production->id;
										$ligne->ressource_id = $lign->ressource->id;
										$ligne->quantite = $qte*$lign->quantite/$exi->quantite;
										$data = $ligne->enregistre();
									}
								}
							}
						}
					}
				}
			}else{
				$data->status = false;
				$data->message = "Le solde du compte est insuffisant pour regler les frais de main d'oeuvre de la production !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Certaines productions neccessite plus de ressources que vous n'en possédez !";
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