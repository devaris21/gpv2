<?php 
namespace Home;
require '../../../../../core/root/includes.php';

use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($action === "rangement") {
	if ($manoeuvres != "" || (isset($groupemanoeuvre_id_rangement) && $groupemanoeuvre_id_rangement != "")) {
		$datas = PRODUCTION::findBy(["id="=>$id]);
		if (count($datas) == 1) {
			$production = $datas[0];

			$test = true;
			$production->fourni("ligneproduction");
			foreach ($production->ligneproductions as $cle => $ligne) {
				$range = intval($_POST["range-".$ligne->produit_id]);
				if (!($ligne->production >= $range)) {
					$test = false;
					break;
				}
			}

			if ($test) {
				$montant = 0;
				foreach ($production->ligneproductions as $cle => $ligne) {
					$range = intval($_POST["range-".$ligne->produit_id]);
					$ligne->perte = $ligne->production - $range;
					$ligne->save();
				}
				
				$lots = PAYE_PRODUIT::findBy(["produit_id ="=>$ligne->produit_id]);
				if (count($lots) > 0) {
					$ppr = $lots[0];
					$montant += $range * $ppr->price_rangement;
				}


				$datas = $production->fourni("manoeuvredurangement");
				foreach ($datas as $cle => $ligne) {
					$ligne->delete();
				}

				if (isset($manoeuvres) && $manoeuvres != "") {
					$datas = explode(",", $manoeuvres);
					foreach ($datas as $key => $value) {
						$item = new MANOEUVREDURANGEMENT();
						$item->production_id = $production->id;
						$item->manoeuvre_id = $value;
						$item->price = $montant / count($datas);
						$item->enregistre();
					}
				}else{
					$datas = MANOEUVRE::findBy(["groupemanoeuvre_id ="=>$groupemanoeuvre_id_rangement]);
					foreach ($datas as $key => $value) {
						$item = new MANOEUVREDURANGEMENT();
						$item->production_id = $production->id;
						$item->manoeuvre_id = $value->id;
						$item->price = $montant / count($datas);
						$item->enregistre();
					}
				}

				$production->hydrater($_POST);
				$production->dateRangement = dateAjoute();
				$production->etat_id = ETAT::VALIDEE;
				$data = $production->save();

			}else{
				$data->status = false;
				$data->message = "Vous ne pouvez pas rangé plus de quantité que ce que vous en avez produit !";
			}
		}else{
			$data->status = false;
			$data->message = "Erreur lors du processus de valisation, Veuillez recommencer !";
		}
	}else{
		$data->status = false;
		$data->message = "Veuillez définir les manoeuvres qui ont fait le rangement !";
	}


	echo json_encode($data);
}



if ($action == "approuver") {
	$datas = SINISTRE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$sinistre = $datas[0];
		$data = $sinistre->approuver();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}



if ($action == "entretien2") {
	if (getSession("sinistre") != null) {
		$entretien = new ENTRETIENVEHICULE;
		$sinistre = getSession("sinistre");
		$entretien->cloner($sinistre);
		$entretien->hydrater($_POST);
		$entretien->name = "Entretein suite au sinitre #".$sinistre->ticket." // ".$sinistre->typesinistre->name;
		$entretien->typeentretienvehicule_id = 1;
		$entretien->setId(null);
		$data = $entretien->enregistre();
		if ($data->status) {
			unset_session("sinistre");
		}
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}




if ($action == "refuser") {
	$datas = SINISTRE::findBy(["id ="=>$id]);
	if (count($datas) == 1) {
		$sinistre = $datas[0];
		$data = $sinistre->refuser();
	}else{
		$data->status = false;
		$data->message = "Une erreur s'est produite lors de l'opération! Veuillez recommencer";
	}
	echo json_encode($data);
}
