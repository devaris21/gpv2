<?php 
namespace Home;
require '../../../../core/root/includes.php';
use Native\RESPONSE;
extract($_POST);

$data = new RESPONSE;




if ($action === "production") {
//	if ($manoeuvres != "" || (isset($groupemanoeuvre_id) && $groupemanoeuvre_id != "")) {
	$production = PRODUCTION::today();
	$test = true;
	foreach (RESSOURCE::getAll() as $key => $ressource) {
		$datas = $production->fourni("ligneconsommation", ["ressource_id ="=>$ressource->id]);
		if (count($datas) == 1) {
			$ligne = $datas[0];
			if (intval($_POST["conso-".$ressource->id]) > ($ressource->stock(dateAjoute()) + $ligne->consommation) ) {
				$test = false;
				break;
			}
		}
	}

	if ($test) {
		$montant = 0;
		$production->fourni("ligneproduction");
		foreach ($production->ligneproductions as $cle => $ligne) {
			if (isset($_POST["prod-".$ligne->produit_id])) {
				$ligne->production = intval($_POST["prod-".$ligne->produit_id]);

				//on augmente les etiquettes sur la perte
				if (isset($_POST["etiq-".$ligne->produit_id])) {
					$_POST["etiq-".$ligne->produit_id] += $ligne->production;
				}
				$ligne->save();
			}
				//$ligne->perte = intval($_POST["perte-".$ligne->produit_id]);

				//$ligne->actualise();
				//$montant += $ligne->prixdevente->coutProduction("production", $ligne->production);
		}


		$production->fourni("ligneetiquettejour");
		foreach ($production->ligneetiquettejours as $cle => $ligne) {
			if (isset($_POST["etiq-".$ligne->produit_id])) {
				$ligne->consommation = intval($_POST["etiq-".$ligne->produit_id]);

				$datas =  ETIQUETTE::findBy(["etiquette_id ="=>$ligne->produit_id]);
				if (count($datas) > 0) {
					$etiq = $datas[0];
					if ($etiq->stock(dateAjoute()) < $ligne->consommation) {
						$ligne->consommation = $etiq->stock(dateAjoute());
					}
					$ligne->save();
				}
			}
		}



		$production->fourni("ligneconsommation");
		foreach ($production->ligneconsommations as $cle => $ligne) {
			$ligne->consommation = intval($_POST["conso-".$ligne->ressource_id]);
			$ligne->save();
		}


			// $datas = $production->fourni("manoeuvredujour");
			// foreach ($datas as $cle => $ligne) {
			// 	$ligne->delete();
			// }

			// if (isset($manoeuvres) && $manoeuvres != "") {
			// 	$datas = explode(",", $manoeuvres);
			// 	foreach ($datas as $key => $value) {
			// 		$item = new MANOEUVREDUJOUR();
			// 		$item->production_id = $production->id;
			// 		$item->manoeuvre_id = $value;
			// 		$item->price = $montant / count($datas);
			// 		$item->enregistre();
			// 	}
			// }else{
			// 	$datas = MANOEUVRE::findBy(["groupemanoeuvre_id ="=>$groupemanoeuvre_id]);
			// 	foreach ($datas as $key => $value) {
			// 		$item = new MANOEUVREDUJOUR();
			// 		$item->production_id = $production->id;
			// 		$item->manoeuvre_id = $value->id;
			// 		$item->price = $montant / count($datas);
			// 		$item->enregistre();
			// 	}
			// }

		$production->hydrater($_POST);
		$production->etat_id = ETAT::PARTIEL;
		$production->total_production = $montant;
		$production->employe_id = getSession("employe_connecte_id");
		$data = $production->save();
	}else{
		$data->status = false;
		$data->message = "Vous ne pouvez pas consommé plus de quantité d'une ressource que ce que vous n'en possédez !";
	}
	// }else{
	// 	$data->status = false;
	// 	$data->message = "Veuillez définir les manoeuvres qui ont travaillé aujourd'hui !";
	// }
	echo json_encode($data);
}


if ($action == "voirPrixParZone") {
	$params = PARAMS::findLastId();
	include("../../../../composants/assets/modals/modal-prixparzone.php");
}



?>