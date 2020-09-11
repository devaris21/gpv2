<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;
use Native\ROOTER;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if ($action == "newressource") {
	$params = PARAMS::findLastId();
	$rooter = new ROOTER;
	$ressources = [];
	if (getSession("ressources") != null) {
		$ressources = getSession("ressources"); 
	}
	if (!in_array($id, $ressources)) {
		$ressources[] = $id;
		$datas = EMBALLAGE::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$item = $datas[0]; ?>
			<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
				<td><i class="fa fa-close text-red cursor" onclick="supprimeRessource(<?= $id ?>)" style="font-size: 18px;"></i></td>
				<td class="text-left">
					<small>Emballage</small>
					<h5 class="mp0 text-capitalize"><?= $item->name() ?></h5>
				</td>
				<td width="90">
					<label>Quantité</label>
					<input type="text" number name="quantite" class="form-control text-center gras" value="1" style="padding: 3px">
				</td>
				<td width="120">
					<label>Prix d'achat</label>
					<input type="text" number name="prix" class="form-control text-center gras prix" value="1" style="padding: 3px">
				</td>
				<td class="gras"><br><br><?= $params->devise  ?></td>			
			</tr>
			<?php
		}
	}
	session("ressources", $ressources);
}


if ($action == "supprimeRessource") {
	$ressources = [];
	if (getSession("ressources") != null) {
		$ressources = getSession("ressources"); 
		foreach ($ressources as $key => $value) {
			if ($value == $id) {
				unset($ressources[$key]);
			}
			session("ressources", $ressources);
		}
	}
}


if ($action == "calcul") {
	$params = PARAMS::findLastId();
	$rooter = new ROOTER;
	$total = 0;
	$ressources = explode(",", $tableau);
	foreach ($ressources as $key => $value) {
		$lot = explode("-", $value);
		$id = $lot[0];
		$qte = 0;
		if (isset($lot[1])) {
			$qte = $lot[1];
		}
		$prix = intval(end($lot));
		$datas = EMBALLAGE::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$item = $datas[0];
			$total += $prix; ?>
			<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
				<td><i class="fa fa-close text-red cursor" onclick="supprimeRessource(<?= $id ?>)" style="font-size: 18px;"></i></td>
				<td class="text-left">
					<small>Emballage </small>
					<h5 class="mp0 text-capitalize"><?= $item->name() ?></h5>
				</td>
				<td width="90">
					<label>Quantité</label>
					<input type="text" number name="quantite" class="form-control text-center gras" value="<?= $qte ?>" style="padding: 3px">
				</td>
				<td width="120">
					<label>Prix d'achat</label>
					<input type="text" number name="prix" class="form-control text-center gras prix" value="<?= $prix ?>" style="padding: 3px">
				</td>
				<td class="gras"><br><br><?= $params->devise  ?></td>				
			</tr>
			<?php
		}
	}

	session("total", $total);
}


if ($action == "total") {
	$params = PARAMS::findLastId();
	$data = new \stdclass();
	$data->total = money(getSession("total"))." ".$params->devise;
	echo json_encode($data);
}




if ($action == "validerApprovisionnement") {
	$datas = FOURNISSEUR::findBy(["id ="=>$fournisseur_id]);
	if (count($datas) == 1) {
		$fournisseur = $datas[0];

		$ressources = explode(",", $tableau);
		if (count($ressources) > 0) {
			$tests = $ressources;
			foreach ($tests as $key => $value) {
				$lot = explode("-", $value);
				$id = $lot[0];
				$qte = 0;
				if (isset($lot[1])) {
					$qte = $lot[1];
				};
				$prix = end($lot);
				if ($qte > 0) {
					unset($tests[$key]);
				}
			}

			$approvisionnement = new APPROEMBALLAGE();
			if (count($tests) == 0) {
				$datas = ENTREPOT::findBy(["id ="=>getSession("entrepot_connecte_id")]);
				if (count($datas) == 1) {
					$entrepot = $datas[0];
					$entrepot->actualise();
					if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
						$avance = 0;
					}
					if ($entrepot->comptebanque->solde() >= ($transport + $avance)) {
						$total = getSession("total");
						$data->status = true;
						$data->lastid = null;
						if (intval($total) > 0) {
							if (intval($total) >= $avance) {
								if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
									$approvisionnement->avance = ($fournisseur->acompte >= $total) ? $total : $fournisseur->acompte;
									$data = $fournisseur->debiter($total);
								}else{
									$fournisseur->dette($total - intval($avance));

									$payement = new REGLEMENTFOURNISSEUR();
									$payement->hydrater($_POST);
									$payement->montant = $avance;
									$payement->fournisseur_id = $fournisseur_id;
									$data = $payement->enregistre();
								}
								if ($data->status) {

									$fournisseur->actualise();
									if ($modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
										$approvisionnement->reglementfournisseur_id = $data->lastid;
									}
									if ($data->status) {

										$approvisionnement->hydrater($_POST);
										if ($approvisionnement->etat_id == ETAT::VALIDEE) {
											$approvisionnement->datelivraison = date("Y-m-d H:i:s");
										}
										$approvisionnement->montant = $total;
										$approvisionnement->reste = $total - $approvisionnement->avance;
										$approvisionnement->acompteFournisseur = $fournisseur->acompte;
										$approvisionnement->detteFournisseur = $fournisseur->resteAPayer() + $total;
										$data = $approvisionnement->enregistre();
										if ($data->status) {
											foreach ($ressources as $key => $value) {
												$lot = explode("-", $value);
												$id = $lot[0];
												$qte = $lot[1];
												$prix = end($lot);
												$datas = EMBALLAGE::findBy(["id ="=> $id]);
												if (count($datas) == 1) {
													$ressource = $datas[0];
													$lignecommande = new LIGNEAPPROEMBALLAGE;
													$lignecommande->approemballage_id = $approvisionnement->id;
													$lignecommande->emballage_id = $id;
													$lignecommande->quantite = $qte;
													$lignecommande->price =  $prix;
													$lignecommande->enregistre();	
												}
											}

											if ($modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE && $total > 0) {
												$payement->comment = "Réglement de la facture d'approvisionnement d'emballage N°".$approvisionnement->reference;
												$data = $payement->save();
											}
											$data->setUrl("fiches", "master", "bonapproemballage", $approvisionnement->id);
										}
									}
								}

							}else{
								$data->status = false;
								$data->message = "Le montant avancé est plus élévé que le total de l'approvisionnement !";
							}	
						}else{
							$data->status = false;
							$data->message = "Veuillez verifier le prix d'achat des différents produits !";
						}
					}else{
						$data->status = false;
						$data->message = "Le solde du compte est insuffisant pour regler l'avance et les frais de transport de l'approvisionnement !";
					}
				}else{
					$data->status = false;
					$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez selectionner des ressources et leur quantité pour passer la commande !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez selectionner des ressources et leur quantité pour passer la commande !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez selectionner un fournisseur pour passer la commande !";
	}

	echo json_encode($data);
}




if ($action == "annuler") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = APPROEMBALLAGE::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$approvisionnement = $datas[0];
				$data = $approvisionnement->annuler();
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




if ($action == "validerAppro") {
	$id = getSession("approemballage_id");
	$datas = APPROEMBALLAGE::findBy(["id ="=>$id]);
	if (count($datas) > 0) {
		$appro = $datas[0];
		$appro->fourni("ligneapproemballage");

		$ressources = explode(",", $tableau);
		if (count($ressources) > 0) {
			$tests = $ressources;
			foreach ($tests as $key => $value) {
				$lot = explode("-", $value);
				$id = $lot[0];
				$qte = end($lot);
				foreach ($appro->ligneapproemballages as $key => $lgn) {
					if (($lgn->emballage_id == $id) && ($lgn->quantite >= $qte)) {
						unset($tests[$key]);
					}
				}
			}
			if (count($tests) == 0) {
				$appro->hydrater($_POST);
				$data = $appro->terminer();
				if ($data->status) {
					foreach ($ressources as $key => $value) {
						$lot = explode("-", $value);
						$id = $lot[0];
						$qte = end($lot);
						foreach ($appro->ligneapproemballages as $key => $lgn) {
							if ($lgn->emballage_id == $id) {
								$lgn->quantite_recu = $qte;
								$lgn->save();
								break;
							}
						}
					}
				}
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