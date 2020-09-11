<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;
$params = PARAMS::findLastId();
$rooter = new ROOTER;
$data = new RESPONSE;
extract($_POST);


if ($action == "changer") {
	$data->setUrl("boutique", "master", "client", $id);
	echo json_encode($data);
}


if ($action == "newproduit") {
	$produits = [];
	if (getSession("produits") != null) {
		$produits = getSession("produits"); 
	}
	if (!in_array($id, $produits)) {
		$produits[] = $id;
		$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=>$id]);
		if (count($datas) > 0) {
			$type = $datas[0];
			$datas = $type->fourni("produit", ["isActive = "=> TABLE::OUI]);
			if (count($datas) > 0) { ?>
				<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
					<td><i class="fa fa-close text-red cursor" onclick="supprimeProduit('<?= $id ?>')" style="font-size: 18px;"></i></td>
					<td class="text-left">
						<h5 class="mp0 text-uppercase"><?= $type->name() ?></h5>
					</td>
					<td>
						<div class="row">
							<?php foreach ($datas as $key => $produit) {
								$produit->actualise(); ?>
								<div class="col-sm">
									<div class="row">
										<?php foreach ($produit->getListeEmballageProduit() as $key => $emballage) {
											$a = $produit->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $emballage->id, getSession("boutique_connecte_id"));
											if ($a > 0) { ?>
												<div class="col-sm">
													<td width="100" class="text-center">
														<img style="height: 20px" src="<?= $rooter->stockage("images", "emballages", $emballage->image) ?>" ><br>
														<small><?= $emballage->name() ?></small><br>
														<input type="text" data-id="<?= $produit->id ?>" data-format="<?= $emballage->id ?>" number class="form-control text-center gras" style="padding: 3px">
													</td>
												</div>
											<?php }
										} ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</td>			
				</tr>
				<?php
			}
		}
	}
	session("produits", $produits);
}



if ($action == "newproduit2") {
	$produits = [];
	if (getSession("produits") != null) {
		$produits = getSession("produits"); 
	}
	if (!in_array($id, $produits)) {
		$produits[] = $id;
		$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=>$id]);
		if (count($datas) > 0) {
			$type = $datas[0];
			$datas = $type->fourni("produit", ["isActive = "=> TABLE::OUI]);
			if (count($datas) > 0) { ?>
				<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
					<td><i class="fa fa-close text-red cursor" onclick="supprimeProduit('<?= $id ?>')" style="font-size: 18px;"></i></td>
					<td class="text-left">
						<h5 class="mp0 text-uppercase"><?= $type->name() ?></h5>
					</td>
					<td>
						<div class="row">
							<?php foreach ($datas as $key => $produit) {
								$produit->actualise(); ?>
								<div class="col-sm">
									<div class="row">
										<?php foreach ($produit->getListeEmballageProduit() as $key => $emballage) {
											$a = $produit->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $emballage->id, getSession("boutique_connecte_id")); ?>
											<div class="col-sm">
												<td width="110" class="text-center">
													<img style="height: 20px" src="<?= $rooter->stockage("images", "emballages", $emballage->image) ?>" ><br>
													<small><?= $emballage->name() ?></small><br>
													<input type="text" data-id="<?= $produit->id ?>" data-format="<?= $emballage->id ?>" number class="form-control text-center gras" style="padding: 3px">
												</td>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</td>			
				</tr>
				<?php
			}
		}
	}
	session("produits", $produits);
}



if ($action == "newproduit3") {
	$produits = [];
	if (getSession("produits") != null) {
		$produits = getSession("produits"); 
	}
	if (!in_array($id, $produits)) {
		$produits[] = $id;
		$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=>$id]);
		if (count($datas) > 0) {
			$type = $datas[0];
			$datas = $type->fourni("produit", ["isActive = "=> TABLE::OUI]);
			if (count($datas) > 0) { 
				foreach ($datas as $key => $produit) {
					$produit->actualise(); ?>
					<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
						<td><i class="fa fa-close text-red cursor" onclick="supprimeProduit('<?= $id ?>')" style="font-size: 18px;"></i></td>
						<td class="text-left">
							<h5 class="mp0 text-uppercase"><?= $produit->name() ?></h5>
						</td>
						<?php foreach (EMBALLAGE::findBy(["isActive = "=> TABLE::OUI]) as $key => $emballage) { 
							if ($produit->enEntrepot(PARAMS::DATE_DEFAULT, dateAjoute(1), $emballage->id, getSession("entrepot_connecte_id")) > 0) { ?>
								<td width="110" class="text-center">
									<img style="height: 20px" src="<?= $rooter->stockage("images", "emballages", $emballage->image) ?>" ><br>
									<small><?= $emballage->name() ?></small><br>
									<input type="text" data-id="<?= $produit->id ?>" data-format="<?= $emballage->id ?>" number class="form-control text-center gras" style="padding: 3px">
								</td>
							<?php } 
						} ?>
					</tr>
				<?php } 
			}
		}
	}
	session("produits", $produits);
}



if ($action == "newproduit4") {
	$produits = [];
	if (getSession("produits") != null) {
		$produits = getSession("produits"); 
	}
	if (!in_array($id, $produits)) {
		$produits[] = $id;
		$datas = TYPEPRODUIT_PARFUM::findBy(["id ="=>$id]);
		if (count($datas) > 0) {
			$type = $datas[0];
			$type->actualise();
			?>
			<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
				<td><i class="fa fa-close text-red cursor" onclick="supprimeProduit('<?= $id ?>')" style="font-size: 18px;"></i></td>
				<td class="text-left">
					<h5 class="mp0 text-uppercase">production de <?= $type->name() ?> </h5>
				</td>
				<td width="150" class="text-center">
					<small>Nb de <?= $type->typeproduit->unite ?>(s) produit</small>
					<input type="text" data-id="<?= $id ?>" number class="form-control text-center gras" style="padding: 3px">
				</td>				
			</tr>
			<?php
		}
		session("produits", $produits);
	}
}



if ($action == "supprimeProduit") {
	$produits = [];
	if (getSession("produits") != null) {
		$produits = getSession("produits"); 
		foreach ($produits as $key => $value) {
			if ($value == $id) {
				unset($produits[$key]);
			}
			session("produits", $produits);
		}
	}
}


if ($action == "calcul") {
	$params = PARAMS::findLastId();
	$montant = 0;
	$listeproduits = explode(",", $listeproduits);
	foreach ($listeproduits as $key => $value) {
		$data = explode("-", $value);
		$id = $data[0];
		$emballage_id = $data[1];
		$qte = end($data);

		$datas = PRICE::findBy(["produit_id = "=>$id, "emballage_id = "=>$emballage_id]);
		if (count($datas) == 1) {
			$price = $datas[0];
			if ($typebareme_id == TYPEBAREME::NORMAL) {
				$montant += $price->prix * intval($qte);
			}else{
				$montant += $price->prix_gros * intval($qte);
			}
		}
	}

	$redis = 0;
	if ($params->prixParPalier == TABLE::OUI) {
		$datas = PALIER::findBy(["min <= "=>$montant], [], ["min"=>"DESC"]);
		if (count($datas) > 0) {
			$palier = $datas[0];
			if ($palier->typereduction_id ==TYPEREDUCTION::BRUT) {
				$redis = $palier->reduction;
			}else{
				$redis = ($palier->reduction * $montant)/100;
			}
		}
	}
	$total = $montant - $redis;

	$tva = ($total * $params->tva) / 100;
	$total += $tva;


	session("tva", $tva);
	session("reduction", $redis);
	session("montant", $montant);
	session("total", $total);
	session("recu", $recu);
	session("rendu", intval($recu) - $total);

	$data = new \stdclass();
	$data->tva = money(getSession("tva"))." ".$params->devise;
	$data->montant = money(getSession("montant"))." ".$params->devise;
	$data->reduction = money(getSession("reduction"))." ".$params->devise;
	$data->total = money(getSession("total"))." ".$params->devise;
	$data->rendu = money(getSession("rendu"))." ".$params->devise;
	echo json_encode($data);
}




if ($action == "venteDirecte") {
	$total = 0;
	$listeproduits = explode(",", $listeproduits);
	if (count($listeproduits) > 0) {
		$test = true;
		foreach ($listeproduits as $key => $value) {
			$lot = explode("-", $value);
			$id = $lot[0];
			$emballage_id = $lot[1];
			$qte = end($lot);
			$datas = PRODUIT::findBy(["id ="=> $id]);
			if (count($datas) == 1) {
				$produit = $datas[0];
				if ($produit->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $emballage_id, getSession("boutique_connecte_id")) < $qte) {
					$test = false;
					break;
				}	
			}
		}

		if ($test) {
			if (getSession("total") > 0 && getSession("rendu") >= 0) {
				if ($modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {

					$vente = new VENTE();
					$vente->hydrater($_POST);
					$vente->montant = getSession("total");
					$vente->tva = getSession("tva");
					$vente->reduction = getSession("reduction");
					$vente->recu = getSession("recu");
					$data = $vente->enregistre();
					if ($data->status) {
						foreach ($listeproduits as $key => $value) {
							$lot = explode("-", $value);
							$id = $lot[0];
							$emballage_id = $lot[1];
							$qte = end($lot);
							$datas = PRICE::findBy(["produit_id = "=>$id, "emballage_id = "=>$emballage_id]);
							if (count($datas) == 1) {
								$price = $datas[0];
								if ($typebareme_id == TYPEBAREME::NORMAL) {
									$prix = $price->prix * intval($qte);
								}else{
									$prix = $price->prix_gros * intval($qte);
								}

								$lignedevente = new LIGNEDEVENTE;
								$lignedevente->vente_id = $vente->id;
								$lignedevente->produit_id = $id;
								$lignedevente->emballage_id = $emballage_id;
								$lignedevente->quantite = intval($qte);
								$lignedevente->price = intval($prix);
								$lignedevente->enregistre();	
							}
						}
						$data = $vente->payement($vente->montant, $_POST);	
						$data->setUrl("fiches", "master", "bonvente", $vente->id);						
					}

				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas utiliser ce mode de payement pour cette opération!";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez verifier le montant de la vente et/ou de la monnaie!";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
		}				
	}else{
		$data->status = false;
		$data->message = "Veuillez selectionner des produits et leur quantité pour passer la vente !";
	}
	echo json_encode($data);
}



if ($action == "validerPropection") {
	$total = 0;
	$listeproduits = explode(",", $listeproduits);
	if (count($listeproduits) > 0) {
		if (getSession("total") > 0) {

			$tests = $listeproduits;
			foreach ($tests as $key => $value) {
				$lot = explode("-", $value);
				$id = $lot[0];
				$emballage_id = $lot[1];
				$qte = end($lot);
				$produit = PRODUIT::findBy(["id ="=>$id])[0];
				$produit->actualise();
				if ($qte > 0 && $produit->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $emballage_id, getSession("boutique_connecte_id")) >= $qte ) {
					unset($tests[$key]);
				}
			}
			$datas = BOUTIQUE::findBy(["id ="=>getSession("boutique_connecte_id")]);
			if (count($datas) == 1) {
				$boutique = $datas[0];
				$boutique->actualise();
				if ($boutique->comptebanque->solde() >= $transport) {
					if (count($tests) == 0) {
						$prospection = new PROSPECTION();
						$prospection->hydrater($_POST);
						$prospection->tva = getSession("tva");
						$prospection->reduction = getSession("reduction");
						$prospection->montant = getSession("total");
						$data = $prospection->enregistre();
						if ($data->status) {
							foreach ($listeproduits as $key => $value) {
								$lot = explode("-", $value);
								$id = $lot[0];
								$emballage_id = $lot[1];
								$qte = end($lot);
								$datas = PRICE::findBy(["produit_id = "=>$id, "emballage_id = "=>$emballage_id]);
								if (count($datas) == 1) {
									$price = $datas[0];
									if ($typebareme_id == TYPEBAREME::NORMAL) {
										$prix = $price->prix * intval($qte);
									}else{
										$prix = $price->prix_gros * intval($qte);
									}

									$ligneprospection = new LIGNEPROSPECTION;
									$ligneprospection->prospection_id = $prospection->id;
									$ligneprospection->produit_id = $id;
									$ligneprospection->emballage_id = $emballage_id;
									$ligneprospection->quantite = intval($qte);
									$ligneprospection->price =  $prix;
									$ligneprospection->enregistre();										
								}
							}
							$data->setUrl("fiches", "master", "bonsortie", $data->lastid);
						}
					}else{
						$data->status = false;
						$data->message = "Le solde du compte est insuffisant pour regler les frais de transport de la production !";
					}
				}else{
					$data->status = false;
					$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
				}						
			}else{
				$data->status = false;
				$data->message = "Veuillez verifier le montant total de la prospection !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez selectionner des produits et leur quantité pour valider la prospection !";
	}
	echo json_encode($data);
}



if ($action == "validerCommande") {
	$total = 0;
	$datas = CLIENT::findBy(["id ="=> $client_id]);
	if (count($datas) > 0) {
		$client = $datas[0];
		$listeproduits = explode(",", $listeproduits);
		if (count($listeproduits) > 0) {

			if (getSession("total") > 0) {
				if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE || ($modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE && intval($avance) <= getSession("total") && intval($avance) > 0)) {
					if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
						$avance = $client->acompte ;
					}
					if ((getSession("total") - intval($avance) + $client->resteAPayer()) <= $params->seuilCredit ) {
						if (getSession("commande-encours") != null) {
							$datas = GROUPECOMMANDE::findBy(["id ="=>getSession("commande-encours")]);
							if (count($datas) > 0) {
								$groupecommande = $datas[0];
								$groupecommande->etat_id = ETAT::ENCOURS;
								$groupecommande->save();
							}else{
								$groupecommande = new GROUPECOMMANDE();
								$groupecommande->hydrater($_POST);
								$groupecommande->enregistre();
							}
						}else{
							$groupecommande = new GROUPECOMMANDE();
							$groupecommande->hydrater($_POST);
							$groupecommande->enregistre();
						}

						$commande = new COMMANDE();
						$commande->hydrater($_POST);
						$commande->groupecommande_id = $groupecommande->id;
						$data = $commande->enregistre();
						if ($data->status) {
							foreach ($listeproduits as $key => $value) {
								$lot = explode("-", $value);
								$id = $lot[0];
								$emballage_id = $lot[1];
								$qte = end($lot);
								$datas = PRICE::findBy(["produit_id = "=>$id, "emballage_id = "=>$emballage_id]);
								if (count($datas) == 1) {
									$price = $datas[0];
									if ($typebareme_id == TYPEBAREME::NORMAL) {
										$prix = $price->prix * intval($qte);
									}else{
										$prix = $price->prix_gros * intval($qte);
									}

									$lignecommande = new LIGNECOMMANDE;
									$lignecommande->commande_id = $commande->id;
									$lignecommande->produit_id = $id;
									$lignecommande->emballage_id = $emballage_id;
									$lignecommande->quantite = $qte;
									$lignecommande->price =  $prix;
									$lignecommande->enregistre();	
								}
							}



							$total =  getSession("total");

							if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
								if ($client->acompte >= $total) {
									$commande->avance = $total;
								}else{
									$commande->avance = $client->acompte;
								}
								$lot = $client->debiter($total);

							}else{

								if ($total > intval($avance)) {
									$client->dette($total - intval($avance));
								}

								$payement = new REGLEMENTCLIENT();
								$payement->hydrater($_POST);
								$payement->montant = $commande->avance;
								$payement->client_id = $client_id;
								$payement->comment = "Réglement de la facture pour la commande N°".$commande->reference;
								$lot = $payement->enregistre();
								$commande->reglementclient_id = $lot->lastid;

								$client->actualise();
								$payement->acompteClient = $client->acompte;
								$payement->detteClient = $client->resteAPayer() + $total;
								$payement->save();
							}

							$commande->tva = getSession("tva");
							$commande->reduction = getSession("reduction");
							$commande->montant = $total;
							$commande->reste = $commande->montant - $commande->avance;

							$commande->acompteClient = $client->acompte;
							$commande->detteClient = $client->resteAPayer() + $total;
							$data = $commande->save();

							$data->url2 = $data->setUrl("fiches", "master", "boncommande", $data->lastid);
						}

					}else{
						$data->status = false;
						$data->message = "Le crédit restant pour la commande ne doit pas excéder ".money($params->seuilCredit)." ".$params->devise;
					}
				}else{
					$data->status = false;
					$data->message = "Le montant de l'avance de la commande est incorrect, verifiez-le!";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez verifier le montant de la commande !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez selectionner des produits et leur quantité pour passer la commande !";
		}
	}else{
		$data->status = false;
		$data->message = "Erreur lors de la validation de la commande, veuillez recommencer !";
	}
	echo json_encode($data);
}



if ($action == "annulerCommande") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = COMMANDE::findBy(["id ="=>$id]);
			if (count($datas) == 1) {
				$commande = $datas[0];
				$data = $commande->annuler();
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




if ($action == "livraisonCommande") {
	$params = PARAMS::findLastId();
	if (getSession("commande-encours") != null) {
		$datas = GROUPECOMMANDE::findBy(["id ="=>getSession("commande-encours")]);
		if (count($datas) > 0) {
			$groupecommande = $datas[0];
			$groupecommande->actualise();

			if (isset($modepayement_id) && $modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
				$avance = 0;
			}

			// if ((isset($isLouer) && $isLouer == 0) || (isset($montant_location) && ((intval($montant_location) - intval($avance) + $groupecommande->client->dette) <= $params->seuilCredit))) {

			$listeproduits = explode(",", $listeproduits);
			if (count($listeproduits) > 0) {
				$tests = $listeproduits;
				foreach ($tests as $key => $value) {
					$lot = explode("-", $value);
					$id = $lot[0];
					$emballage_id = $lot[1];
					$qte = end($lot);
					$produit = PRODUIT::findBy(["id ="=>$id])[0];
					if ($qte >= 0 && $groupecommande->reste($produit->id, $emballage_id) >= $qte && $qte <= $produit->enBoutique(PARAMS::DATE_DEFAULT, dateAjoute(1), $emballage_id, getSession("boutique_connecte_id"))) {
						unset($tests[$key]);
					}
				}
				if (count($tests) == 0) {
					$prospection = new PROSPECTION();
						// if ($vehicule_id <= VEHICULE::TRICYCLE) {
						// 	$_POST["chauffeur_id"] = 0;
						// }
					$prospection->hydrater($_POST);
					$prospection->groupecommande_id = $groupecommande->id;
					$prospection->typeprospection_id = TYPEPROSPECTION::LIVRAISON;
					$prospection->montant = getSession("total");
					$data = $prospection->enregistre();
					if ($data->status) {
						$montant = 0;

						foreach ($listeproduits as $key => $value) {
							$lot = explode("-", $value);
							$id = $lot[0];
							$emballage_id = $lot[1];
							$qte = end($lot);

								// $paye = $produit->coutProduction("livraison", $qte);
									// if (isset($chargement_manoeuvre) && $chargement_manoeuvre == "on") {
									// 	$montant += $paye / 2;
									// }

									// if (isset($dechargement_manoeuvre) && $dechargement_manoeuvre == "on") {
									// 	$montant += $paye / 2;
									// }

							$ligneprospection = new LIGNEPROSPECTION;
							$ligneprospection->prospection_id = $prospection->id;
							$ligneprospection->produit_id = $id;
							$ligneprospection->emballage_id = $emballage_id;
							$ligneprospection->quantite = $qte;
							$ligneprospection->price = 0;
							$ligneprospection->enregistre();
						}

						//$production = PRODUCTION::today();
							// $production->total_livraison += $montant;
							// $production->save();

							// if ($vehicule_id != VEHICULE::AUTO && $vehicule_id != VEHICULE::TRICYCLE) {
							// 	$datas = VEHICULE::findBy(["id="=>$vehicule_id]);
							// 	if (count($datas) > 0) {
							// 		$vehicule = $datas[0];
							// 		$vehicule->etatvehicule_id = ETATVEHICULE::MISSION;
							// 		$vehicule->save();
							// 	}

							// 	if($isLouer == 1 && $montant_location > 0 ){
							// 		if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
							// 			$lot = $client->debiter($montant_location);

							// 		}else{

							// 			if ($montant_location > intval($avance)) {
							// 				$client->dette($montant_location - intval($avance));
							// 			}

							// 			$livraison->actualise();
							// 			$payement = new REGLEMENTCLIENT();
							// 			$payement->hydrater($_POST);
							// 			$payement->categorieoperation_id = CATEGORIEOPERATION::LOCATION_VENTE;
							// 			$payement->montant = $avance;
							// 			$payement->client_id = $livraison->groupecommande->client_id;
							// 			$payement->comment = "Réglement pour la location d'engins de livraison pour la livraison N°".$livraison->reference;
							// 			$lot = $payement->enregistre();

							// 			$livraison->operation_id = $lot->lastid;
							// 		}


							// 	}
							// }

						$data = $prospection->save();
						$data->setUrl("fiches", "master", "bonlivraison", $data->lastid);				
					}	
				}else{
					$data->status = false;
					$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez selectionner des produits et leur quantité pour passer la commande !";
			}
			// }else{
			// 	$data->status = false;
			// 	$data->message = "Le seuil de credit pour ce client sera dépassé !";
			// }
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
	}
	echo json_encode($data);
}




if ($action == "validerProgrammation") {
	if ($datelivraison >= dateAjoute()) {
		if (getSession("commande-encours") != null) {
			$datas = GROUPECOMMANDE::findBy(["id ="=>getSession("commande-encours")]);
			if (count($datas) > 0) {
				$groupecommande = $datas[0];

				$produits = explode(",", $tableau);
				if (count($produits) > 0) {
					$tests = $produits;
					foreach ($tests as $key => $value) {
						$lot = explode("-", $value);
						$id = $lot[0];
						$qte = end($lot);
						if ($groupecommande->reste($id) >= $qte) {
							unset($tests[$key]);
						}
					}
					if (count($tests) == 0) {
						$livraison = new VENTE();
						$livraison->hydrater($_POST);
						$livraison->groupecommande_id = $groupecommande->id;
						$livraison->etat_id = ETAT::PARTIEL;
						$data = $livraison->save();
						if ($data->status) {
							foreach ($produits as $key => $value) {
								$lot = explode("-", $value);
								$id = $lot[0];
								$qte = end($lot);

								$datas = PRODUIT::findBy(["id="=>$id]);
								if (count($datas) > 0) {
									$produit = $datas[0];

									$lignecommande = new LIGNEDEVENTE;
									$lignecommande->livraison_id = $livraison->id;
									$lignecommande->produit_id = $id;
									$lignecommande->quantite = $qte;
									$lignecommande->enregistre();
								}

							}

							$data->setUrl("fiches", "master", "bonlivraison", $data->lastid);				
						}	
					}else{
						$data->status = false;
						$data->message = "Veuillez à bien vérifier les quantités des différents produits à livrer, certaines sont incorrectes !";
					}
				}else{
					$data->status = false;
					$data->message = "Veuillez selectionner des produits et leur quantité pour passer la commande !";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'operation, veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez vérifier la date de programmation de la livraison !";
	}
	echo json_encode($data);
}



if ($action == "fichecommande") {
	$rooter = new ROOTER;
	$params = PARAMS::findLastId();
	$datas = GROUPECOMMANDE::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		session('commande-encours', $id);
		$groupecommande = $datas[0];
		$groupecommande->actualise();

		$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
		$employe = $datas[0];

		$datas = $groupecommande->toutesLesLignes();
		include("../../../../../composants/assets/modals/modal-groupecommande.php");
	}
}


if ($action == "modalcommande") {
	$rooter = new ROOTER;
	$params = PARAMS::findLastId();
	session("commande-encours", $id);
	include("../../../../../composants/assets/modals/modal-newcommande.php");
}



if ($action == "newlivraison") {
	$rooter = new ROOTER;
	$params = PARAMS::findLastId();
	$datas = GROUPECOMMANDE::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		session('commande-encours', $id);
		$groupecommande = $datas[0];
		$groupecommande->actualise();
		$groupecommande->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]);
		include("../../../../../composants/assets/modals/modal-newlivraison.php");
	}
}


if ($action == "newProgrammation") {
	$rooter = new ROOTER;
	$params = PARAMS::findLastId();
	$datas = GROUPECOMMANDE::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		session('commande-encours', $id);
		$groupecommande = $datas[0];
		$groupecommande->actualise();
		$groupecommande->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]);
		include("../../../../../composants/assets/modals/modal-programmation.php");
	}
}



if ($action == "acompte") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = CLIENT::findBy(["id=" => $client_id]);
			if (count($datas) > 0) {
				$client = $datas[0];
				$data = $client->crediter(intval($montant), $_POST);
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
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



if ($action == "reglerCommande") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = COMMANDE::findBy(["id=" => $commande_id]);
			if (count($datas) > 0) {
				$commande = $datas[0];
				$data = $client->recouvrir(intval($montant), $_POST);
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
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


// if ($action == "dette") {
// 	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
// 	if (count($datas) > 0) {
// 		$employe = $datas[0];
// 		$employe->actualise();
// 		if ($employe->checkPassword($password)) {
// 			$datas = CLIENT::findBy(["id=" => $client_id]);
// 			if (count($datas) > 0) {
// 				$client = $datas[0];
// 				$data = $client->reglerDette(intval($montant), $_POST);
// 			}else{
// 				$data->status = false;
// 				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
// 			}
// 		}else{
// 			$data->status = false;
// 			$data->message = "Votre mot de passe ne correspond pas !";
// 		}
// 	}else{
// 		$data->status = false;
// 		$data->message = "Vous ne pouvez pas effectué cette opération !";
// 	}
// 	echo json_encode($data);
// }


if ($action == "reglerToutesDettes") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = CLIENT::findBy(["id=" => $id]);
			if (count($datas) > 0) {
				$client = $datas[0];
				if ($client->acompte > 0) {
					foreach ($client->fourni("groupecommande", ["etat_id !="=>ETAT::ANNULEE]) as $key => $groupe) {
						foreach ($groupe->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]) as $key => $commande) {
							$data = $commande->reglementDeCommande();
						}		
					}
				}else{
					$data->status = false;
					$data->message = "L'acompte du client est de 0F. Veuillez le crediter pour effectuer cette opération !!";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
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


if ($action == "rembourser") {
	$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
	if (count($datas) > 0) {
		$employe = $datas[0];
		$employe->actualise();
		if ($employe->checkPassword($password)) {
			$datas = CLIENT::findBy(["id=" => $client_id]);
			if (count($datas) > 0) {
				$client = $datas[0];
				$data = $client->rembourser(intval($montant), $_POST);
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
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


if ($action == "annuler") {
	$datas = MISSION::findBy(["id ="=> $id]);
	if (count($datas) == 1) {
		$mission = $datas[0];
		$data = $mission->annuler();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite pendant le processus, veuillez recommencer !";
	}	
	echo json_encode($data);
}