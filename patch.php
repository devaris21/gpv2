<?php 
namespace Home;

// foreach (PRIXDEVENTE::getAll() as $key => $value) {
// 	$emb = new ETIQUETTE();
// 	$emb->prixdevente_id = $value->getId();
// 	$emb->enregistre();

// 	$value->prix_id_gros = $value->prix_id;
// 	$value->save();
// }

// foreach (QUANTITE::getAll() as $key => $value) {
// 	$emb = new EMBALLAGE();
// 	$emb->quantite_id = $value->getId();
// 	$emb->enregistre();
// }
// // //mise en place de compte courant
// $datas = ["Prix normal de boutique", "Prix de gros"];
// foreach ($datas as $key => $value) {
// 	$item = new TYPEBAREME();
// 	$item->name = $value;
// 	$item->setProtected(1);
// 	$item->save();
// }

// $datas = ["Vente en cave"];
// foreach ($datas as $key => $value) {
// 	$item = new TYPEPROSPECTION();
// 	$item->name = $value;
// 	$item->setProtected(1);
// 	$item->save();
// }

foreach (BOUTIQUE::getAll() as $key => $value) {
	$value->comptebanque_id = COMPTEBANQUE::COURANT;
	$value->save();
}

foreach (VENTE::getAll() as $key => $value) {
	$value->boutique_id = BOUTIQUE::PRINCIPAL;
	$value->save();
}

foreach (COMMANDE::getAll() as $key => $value) {
	$value->boutique_id = BOUTIQUE::PRINCIPAL;
	$value->save();
}

foreach (GROUPECOMMANDE::getAll() as $key => $value) {
	$value->boutique_id = BOUTIQUE::PRINCIPAL;
	$value->save();
}

foreach (PROSPECTION::getAll() as $key => $value) {
	$value->boutique_id = BOUTIQUE::PRINCIPAL;
	$value->save();
}

foreach (MISEENBOUTIQUE::getAll() as $key => $value) {
	$value->boutique_id = BOUTIQUE::PRINCIPAL;
	$value->entrepot_id = ENTREPOT::PRINCIPAL;
	$value->datereception = $value->modified;
	$value->save();
}


foreach (LIGNEMISEENBOUTIQUE::getAll() as $key => $value) {
	$value->perte = 0;
	$value->quantite_depart = $value->quantite;
	$value->save();
}

foreach (OPERATION::getAll() as $key => $value) {
	$value->boutique_id = BOUTIQUE::PRINCIPAL;
	$value->save();
}


foreach (REGLEMENTCLIENT::getAll() as $key => $value) {
	$value->boutique_id = BOUTIQUE::PRINCIPAL;
	$value->save();
}

foreach (PRODUCTIONJOUR::getAll() as $key => $value) {
	$value->entrepot_id = ENTREPOT::PRINCIPAL;
	$value->save();
}
// foreach (LIGNECOMMANDE::getAll() as $key => $value) {
// 	$value->price = $value->prixdevente->prix->price * $value->quantite;
// 	$value->save();
// }

// //mise en place de compte courant
// $datas = ["Caisse courante"];
// foreach ($datas as $key => $value) {
// 	$item = new COMPTEBANQUE();
// 	$item->name = $value;
// 	$item->initial = 0;
// 	$item->setProtected(1);
// 	$item->save();
// }


// $datas = ["Dépôt", "Retrait"];
// foreach ($datas as $key => $value) {
// 	$item = new TYPEMOUVEMENT();
// 	$item->name = $value;
// 	$item->setProtected(1);
// 	$item->save();
// }

// $datas = ["Amortissement linéaire", "Amortissement dégressif"];
// foreach ($datas as $key => $value) {
// 	$item = new TYPEAMORTISSEMENT();
// 	$item->name = $value;
// 	$item->setProtected(1);
// 	$item->save();
// }


// $item = new TYPEBIEN();
// $item->name = "Magasin / Entrepot / Usine";
// $item->min = 15;
// $item->max = 50;
// $item->setProtected(1);
// $item->save();


// $item = new TYPEBIEN();
// $item->name = "Meubles / Mobiliers";
// $item->min = 5;
// $item->max = 10;
// $item->setProtected(1);
// $item->save();


// $item = new TYPEBIEN();
// $item->name = "Véhicules";
// $item->min = 3;
// $item->max = 5;
// $item->setProtected(1);
// $item->save();


// $item = new TYPEBIEN();
// $item->name = "Materiels industriels / Outillages";
// $item->min = 5;
// $item->max = 10;
// $item->setProtected(1);
// $item->save();


// $item = new TYPEBIEN();
// $item->name = "Materiels informatiques";
// $item->min = 2;
// $item->max = 5;
// $item->setProtected(1);
// $item->save();


// $item = new TYPEBIEN();
// $item->name = "Brevets";
// $item->min = 3;
// $item->max = 5;
// $item->setProtected(1);
// $item->save();


// $item = new TYPEBIEN();
// $item->name ="Logiciels / Sites internet";
// $item->min = 2;
// $item->max = 3;
// $item->setProtected(1);
// $item->save();



// $datas = ["Immobilisation corporelle", "Immobilisation incorporelle", "Immobilisation financière"];
// foreach ($datas as $key => $value) {
// 	$item = new TYPEIMMOBILISATION();
// 	$item->name = $value;
// 	$item->setProtected(1);
// 	$item->save();
// }



// $datas = [0.25, 0.33, 0.50, 1];
// foreach ($datas as $key => $value) {
// 	$item = new QUANTITE();
// 	$item->name = $value;
// 	$item->isActive = TABLE::OUI;
// 	$item->setProtected(1);
// 	$item->save();
// }


//ajustement 
foreach (OPERATION::findBy(["categorieoperation_id ="=>CATEGORIEOPERATION::VENTE]) as $key => $ope) {
	$reglementclient = new REGLEMENTCLIENT();
	$reglementclient->cloner($ope);
	$reglementclient->setId(null);
	$data = $reglementclient->enregistre();
	if ($data->status) {
		foreach ($ope->fourni("vente") as $key => $vente) {
			$vente->reglementclient_id = $reglementclient->getId();
			$vente->save();
			$ope->delete();
		}
		foreach ($ope->fourni("commande") as $key => $commande) {
			$commande->reglementclient_id = $reglementclient->getId();
			$commande->save();
			$ope->delete();
		}
		$ope->delete();
	}
}




foreach (OPERATION::findBy(["categorieoperation_id ="=>4]) as $key => $ope) {
	$pay = new MOUVEMENT();
	$pay->cloner($ope);
	$pay->comptebanque_id = COMPTEBANQUE::COURANT;
	$pay->typemouvement_id = TYPEMOUVEMENT::DEPOT;
	$pay->setId(null);
	$data = $pay->enregistre();
	if ($data->status) {
		$ope->delete();
	}
}

foreach (OPERATION::findBy(["categorieoperation_id ="=>19]) as $key => $ope) {
	$pay = new MOUVEMENT();
	$pay->cloner($ope);
	$pay->comptebanque_id = COMPTEBANQUE::COURANT;
	$pay->typemouvement_id = TYPEMOUVEMENT::DEPOT;
	$pay->setId(null);
	$data = $pay->enregistre();
	if ($data->status) {
		$ope->delete();
	}
}


foreach (OPERATION::findBy(["categorieoperation_id ="=>CATEGORIEOPERATION::APPROVISIONNEMENT]) as $key => $ope) {
	$reglementfour = new REGLEMENTFOURNISSEUR();
	$reglementfour->cloner($ope);
	$reglementfour->setId(null);
	$data = $reglementfour->enregistre();
	if ($data->status) {
		foreach ($ope->fourni("approvisionnement") as $key => $vente) {
			$vente->reglementfournisseur_id = $reglementfour->getId();
			$vente->save();
			$ope->delete();
		}
	}
}


foreach (OPERATION::findBy(["categorieoperation_id ="=> 10]) as $key => $ope) {
	$pay = new MOUVEMENT();
	$pay->cloner($ope);
	$pay->comptebanque_id = COMPTEBANQUE::COURANT;
	$pay->typemouvement_id = TYPEMOUVEMENT::RETRAIT;
	$pay->setId(null);
	if ($ope->montant >= 100000) {
		$pay->comptebanque_id = COMPTEBANQUE::FONDCOMMERCE;
	}
	$data = $pay->enregistre();
	$ope->delete();
}


foreach (OPERATION::findBy(["categorieoperation_id ="=> 18]) as $key => $ope) {
	$pay = new MOUVEMENT();
	$pay->cloner($ope);
	$pay->comptebanque_id = COMPTEBANQUE::COURANT;
	$pay->typemouvement_id = TYPEMOUVEMENT::RETRAIT;
	$pay->setId(null);
	$data = $pay->enregistre();
	$ope->delete();
}


foreach (OPERATION::findBy(["categorieoperation_id ="=>CATEGORIEOPERATION::PAYE]) as $key => $ope) {
	$pay = new PAYE();
	$pay->cloner($ope);
	$pay->setId(null);
	$data = $pay->enregistre();
	if ($data->status) {
		$ope->delete();
	}
}


foreach (OPERATION::findBy(["categorieoperation_id >="=>14, "categorieoperation_id <="=>17]) as $key => $ope) {
	if ($ope->montant >= 350000) {
		$immobilisation = new IMMOBILISATION();
		$immobilisation->cloner($ope);
		$immobilisation->setId(null);
		$immobilisation->name = $ope->comment;
		$immobilisation->typeimmobilisation_id = TYPEIMMOBILISATION::CORPORELLE;
		$immobilisation->typeamortissement_id = TYPEAMORTISSEMENT::LINEAIRE;
		$immobilisation->comptebanque_id = COMPTEBANQUE::FONDCOMMERCE;
		$immobilisation->duree = 3;
		$data = $immobilisation->enregistre();
	}else{
		$pay = new MOUVEMENT();
		$pay->cloner($ope);
		$pay->comptebanque_id = COMPTEBANQUE::FONDCOMMERCE;
		$pay->typemouvement_id = TYPEMOUVEMENT::RETRAIT;
		$pay->setId(null);
		$data = $pay->enregistre();
	}
	if ($data->status) {
		$ope->delete();
	}
}


foreach (OPERATION::findBy(["categorieoperation_id ="=>12]) as $key => $ope) {
	$immobilisation = new IMMOBILISATION();
	$immobilisation->cloner($ope);
	$immobilisation->setId(null);
	$immobilisation->name = $ope->comment;
	$immobilisation->typeimmobilisation_id = TYPEIMMOBILISATION::CORPORELLE;
	$immobilisation->typeamortissement_id = TYPEAMORTISSEMENT::LINEAIRE;
	$immobilisation->comptebanque_id = COMPTEBANQUE::FONDCOMMERCE;
	$immobilisation->duree = 3;
	$data = $immobilisation->enregistre();
	if ($data->status) {
		$ope->delete();
	}
}


foreach (OPERATION::findBy(["categorieoperation_id >="=>13]) as $key => $ope) {
	$immobilisation = new IMMOBILISATION();
	$immobilisation->cloner($ope);
	$immobilisation->setId(null);
	$immobilisation->name = $ope->comment;
	$immobilisation->typeimmobilisation_id = TYPEIMMOBILISATION::FINANCIERE;
	$immobilisation->typeamortissement_id = TYPEAMORTISSEMENT::LINEAIRE;
	$immobilisation->comptebanque_id = COMPTEBANQUE::FONDCOMMERCE;
	$immobilisation->duree = 3;
	$data = $immobilisation->enregistre();
	if ($data->status) {
		$ope->delete();
	}
}



// QUANTITE::query("UPDATE prixdevente SET quantite_id = 1 WHERE prix_id <= 3");
// QUANTITE::query("UPDATE prixdevente SET quantite_id = 3 WHERE prix_id = 4 OR prix_id = 8 ");
// QUANTITE::query("UPDATE prixdevente SET quantite_id = 3 WHERE prix_id = 8 ");
// QUANTITE::query("UPDATE prixdevente SET quantite_id = 4 WHERE prix_id > 4 AND  prix_id < 8 ");

// PRODUIT::query("UPDATE produit SET isActive = 1");
// QUANTITE::query("UPDATE quantite SET isActive = 1");
// PRIX::query("UPDATE prix SET isActive = 1");

?>