<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);


if ($action == "changer") {
	$data->setUrl("gestion", "master", "client", $id);
	echo json_encode($data);
}


if ($action == "newproduit") {
	$params = PARAMS::findLastId();
	$rooter = new ROOTER;
	$produits = [];
	if (getSession("produits") != null) {
		$produits = getSession("produits"); 
	}
	if (!in_array($id, $produits)) {
		$produits[] = $id;
		$datas = PRODUIT::findBy(["id ="=> $id]);
		if (count($datas) == 1) {
			$produit = $datas[0];
			$produit->fourni("prixdevente", ["isActive = "=> TABLE::OUI]);
			?>
			<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
				<td><i class="fa fa-close text-red cursor" onclick="supprimeProduit(<?= $id ?>)" style="font-size: 18px;"></i></td>
				<td >
					<img style="width: 40px" src="<?= $rooter->stockage("images", "produits", $produit->image) ?>">
				</td>
				<td class="text-left">
					<h4 class="mp0 text-uppercase"><?= $produit->name() ?></h4>
				</td>
				<?php foreach ($produit->prixdeventes as $key => $pdv) {
					if ($pdv->enBoutique(dateAjoute()) > 0) {
						$pdv->actualise(); ?>
						<td width="80" class="text-center">
							<label><?= $pdv->quantite->name() ?></label>
							<input type="text" data-pdv="<?= $pdv->id ?>" number class="form-control text-center gras" style="padding: 3px">
						</td>
					<?php } } ?>				
				</tr>
				<?php
			}
		}
		session("produits", $produits);
	}



	if ($action == "newproduit2") {
		$params = PARAMS::findLastId();
		$rooter = new ROOTER;
		$produits = [];
		if (getSession("produits") != null) {
			$produits = getSession("produits"); 
		}
		if (!in_array($id, $produits)) {
			$produits[] = $id;
			$datas = PRODUIT::findBy(["id ="=> $id]);
			if (count($datas) == 1) {
				$produit = $datas[0];
				$produit->fourni("prixdevente", ["isActive = "=> TABLE::OUI]);
				?>
				<tr class="border-0 border-bottom " id="ligne<?= $id ?>" data-id="<?= $id ?>">
					<td><i class="fa fa-close text-red cursor" onclick="supprimeProduit(<?= $id ?>)" style="font-size: 18px;"></i></td>
					<td >
						<img style="width: 40px" src="<?= $rooter->stockage("images", "produits", $produit->image) ?>">
					</td>
					<td class="text-left">
						<h4 class="mp0 text-uppercase"><?= $produit->name() ?></h4>
					</td>
					<?php foreach ($produit->prixdeventes as $key => $pdv) {
						$pdv->actualise(); ?>
						<td width="80" class="text-center">
							<label><?= $pdv->quantite->name() ?></label>
							<input type="text" data-pdv="<?= $pdv->id ?>" number class="form-control text-center gras" style="padding: 3px">
						</td>
					<?php } ?>				
				</tr>
				<?php
			}
		}
		session("produits", $produits);
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
		$prixdeventes = explode(",", $prixdeventes);
		foreach ($prixdeventes as $key => $value) {
			$data = explode("-", $value);
			$id = $data[0];
			$val = end($data);

			$datas = PRIXDEVENTE::findBy(["id = "=>$id, "isActive ="=>TABLE::OUI]);
			if (count($datas) == 1) {
				$pdv = $datas[0];
				$pdv->actualise();
				if ($typebareme_id == TYPEBAREME::NORMAL) {
					$montant += $pdv->prix->price * intval($val);
				}else{
					$montant += $pdv->prix_gros->price * intval($val);
				}
			}
		}
		session("total", $montant);
		session("recu", $recu);
		session("rendu", intval($recu) - $montant);

		$data = new \stdclass();
		$data->total = money(getSession("total"))." ".$params->devise;
		$data->rendu = money(getSession("rendu"))." ".$params->devise;
		echo json_encode($data);
	}




	if ($action == "venteDirecte") {
		$montant = 0;
		$params = PARAMS::findLastId();
		$datas = CLIENT::findBy(["id ="=> $client_id]);
		if (count($datas) > 0) {
			$client = $datas[0];
			$prixdeventes = explode(",", $prixdeventes);
			if (count($prixdeventes) > 0) {
				$test = true;
				foreach ($prixdeventes as $key => $value) {
					$lot = explode("-", $value);
					$id = $lot[0];
					$qte = end($lot);
					$datas = PRIXDEVENTE::findBy(["id ="=> $id]);
					if (count($datas) == 1) {
						$pdv = $datas[0];
						if ($pdv->enBoutique(dateAjoute()) < $qte) {
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
							$vente->montant = $vente->vendu = getSession("total");
							$vente->recu = getSession("recu");
							$vente->rendu = getSession("rendu");
							$data = $vente->enregistre();
							if ($data->status) {
								foreach ($prixdeventes as $key => $value) {
									$lot = explode("-", $value);
									$id = $lot[0];
									$qte = end($lot);
									$datas = PRIXDEVENTE::findBy(["id ="=> $id]);
									if (count($datas) == 1) {
										$pdv = $datas[0];
										$pdv->actualise();
										if ($typebareme_id == TYPEBAREME::NORMAL) {
											$montant += $pdv->prix->price * intval($qte);
										}else{
											$montant += $pdv->prix_gros->price * intval($qte);
										}

										$lignedevente = new LIGNEDEVENTE;
										$lignedevente->vente_id = $vente->id;
										$lignedevente->prixdevente_id = $id;
										$lignedevente->quantite = intval($qte);
										$lignedevente->enregistre();	
									}
								}
								$data = $vente->payement($montant, $_POST);							
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
		}else{
			$data->status = false;
			$data->message = "Erreur lors de la validation de la commande, veuillez recommencer !";
		}
		echo json_encode($data);
	}



	if ($action == "validerPropection") {
		$montant = 0;
		$params = PARAMS::findLastId();
		$datas = CLIENT::findBy(["id ="=> $client_id]);
		if (count($datas) > 0) {
			$client = $datas[0];
			$prixdeventes = explode(",", $prixdeventes);
			if (count($prixdeventes) > 0) {
				if ( $commercial_id != COMMERCIAL::MAGASIN && ( ($typeprospection_id == TYPEPROSPECTION::VENTECAVE) || ($typeprospection_id == TYPEPROSPECTION::PROSPECTION && $zonedevente_id != ZONEDEVENTE::MAGASIN)) ) {
					if (getSession("total") > 0) {
						
						$tests = $prixdeventes;
						foreach ($tests as $key => $value) {
							$lot = explode("-", $value);
							$id = $lot[0];
							$qte = end($lot);
							$pdv = PRIXDEVENTE::findBy(["id ="=>$id])[0];
							$pdv->actualise();
							if ($qte > 0 && $pdv->enBoutique(dateAjoute()) >= $qte ) {
								unset($tests[$key]);
							}
						}
						if (count($tests) == 0) {
							
							$prospection = new PROSPECTION();
							$prospection->hydrater($_POST);
							$data = $prospection->enregistre();
							if ($data->status) {
								foreach ($prixdeventes as $key => $value) {
									$lot = explode("-", $value);
									$id = $lot[0];
									$qte = end($lot);
									$datas = PRIXDEVENTE::findBy(["id ="=> $id]);
									if (count($datas) == 1) {
										$pdv = $datas[0];
										$pdv->actualise();
										if ($typebareme_id == TYPEBAREME::NORMAL) {
											$montant += $pdv->prix->price * intval($qte);
										}else{
											$montant += $pdv->prix_gros->price * intval($qte);
										}

										$ligneprospection = new LIGNEPROSPECTION;
										$ligneprospection->prospection_id = $prospection->id;
										$ligneprospection->prixdevente_id = $id;
										$ligneprospection->quantite = intval($qte);
								//$ligneprospection->price =  $pdv->prix->price * $qte;
										$ligneprospection->enregistre();										
									}
								}

								$prospection->montant = $montant;
								$data = $prospection->save();
								$data->setUrl("gestion", "fiches", "bonsortie", $data->lastid);
							// $data->url2 = $data->setUrl("gestion", "fiches", "boncommande", $data->lastid);
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
					$data->message = "Veuillez definir le commercial et la zone pour cette prospection !";
				}
			}else{
				$data->status = false;
				$data->message = "Veuillez selectionner des produits et leur quantité pour valider la prospection !";
			}
		}else{
			$data->status = false;
			$data->message = "Erreur lors de la validation de la prospection, veuillez recommencer !";
		}
		echo json_encode($data);
	}



	if ($action == "validerCommande") {
		$montant = 0;
		$params = PARAMS::findLastId();
		$datas = CLIENT::findBy(["id ="=> $client_id]);
		if (count($datas) > 0) {
			$client = $datas[0];
			$prixdeventes = explode(",", $prixdeventes);
			if (count($prixdeventes) > 0) {

				if (getSession("total") > 0) {
					if ($modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE || ($modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE && intval($avance) <= getSession("total") && intval($avance) > 0)) {
						if ((getSession("total") - intval($avance) + $client->dette) <= $params->seuilCredit ) {
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
								foreach ($prixdeventes as $key => $value) {
									$lot = explode("-", $value);
									$id = $lot[0];
									$qte = end($lot);
									$datas = PRIXDEVENTE::findBy(["id ="=> $id]);
									if (count($datas) == 1) {
										$pdv = $datas[0];
										$pdv->actualise();
										if ($typebareme_id == TYPEBAREME::NORMAL) {
											$prix = $pdv->prix->price * intval($qte);
										}else{
											$prix = $pdv->prix_gros->price * intval($qte);
										}
										$montant += $prix;

										$lignecommande = new LIGNECOMMANDE;
										$lignecommande->commande_id = $commande->id;
										$lignecommande->prixdevente_id = $id;
										$lignecommande->quantite = $qte;
										$lignecommande->price =  $prix;
										$lignecommande->enregistre();	
									}
								}

								$tva = ($montant * $params->tva) / 100;
								$total = $montant + $tva;

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
									$payement->detteClient = $client->dette;
									$payement->save();
								}

								$commande->tva = $tva;
								$commande->montant = $total;
								$commande->reste = $commande->montant - $commande->avance;
								
								$commande->acompteClient = $client->acompte;
								$commande->detteClient = $client->dette;
								$data = $commande->save();

								$data->url1 = $data->setUrl("gestion", "fiches", "boncaisse", $lot->lastid);
								$data->url2 = $data->setUrl("gestion", "fiches", "boncommande", $data->lastid);
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

				$prixdeventes = explode(",", $prixdeventes);
				if (count($prixdeventes) > 0) {
					$tests = $prixdeventes;
					foreach ($tests as $key => $value) {
						$lot = explode("-", $value);
						$id = $lot[0];
						$qte = end($lot);
						$pdv = PRIXDEVENTE::findBy(["id ="=>$id])[0];
						$pdv->actualise();
						if ($qte > 0 && $groupecommande->reste($pdv->id) >= $qte && $qte <= $pdv->enBoutique(dateAjoute())) {
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
							$productionjour = PRODUCTIONJOUR::today();

							foreach ($prixdeventes as $key => $value) {
								$lot = explode("-", $value);
								$id = $lot[0];
								$qte = end($lot);

								$datas = PRIXDEVENTE::findBy(["id="=>$id]);
								if (count($datas) > 0) {
									$pdv = $datas[0];
									$pdv->actualise();

									// $paye = $produit->coutProduction("livraison", $qte);
									// if (isset($chargement_manoeuvre) && $chargement_manoeuvre == "on") {
									// 	$montant += $paye / 2;
									// }

									// if (isset($dechargement_manoeuvre) && $dechargement_manoeuvre == "on") {
									// 	$montant += $paye / 2;
									// }

									$ligneprospection = new LIGNEPROSPECTION;
									$ligneprospection->prospection_id = $prospection->id;
									$ligneprospection->prixdevente_id = $id;
									$ligneprospection->quantite = $qte;
									$ligneprospection->enregistre();
								}
							}

							// $productionjour->total_livraison += $montant;
							// $productionjour->save();

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
							$data->setUrl("gestion", "fiches", "bonlivraison", $data->lastid);				
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

								$data->setUrl("gestion", "fiches", "bonlivraison", $data->lastid);				
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

			$datas = $groupecommande->lesRestes();
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



	if ($action == "dette") {
		$datas = EMPLOYE::findBy(["id = "=>getSession("employe_connecte_id")]);
		if (count($datas) > 0) {
			$employe = $datas[0];
			$employe->actualise();
			if ($employe->checkPassword($password)) {
				$datas = CLIENT::findBy(["id=" => $client_id]);
				if (count($datas) > 0) {
					$client = $datas[0];
					$data = $client->reglerDette(intval($montant), $_POST);
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