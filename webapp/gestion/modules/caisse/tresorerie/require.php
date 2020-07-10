<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();

if ($this->id != null) {
	$datas = EXERCICECOMPTABLE::findBy(["id ="=> $this->id]);
	if (count($datas) > 0) {
		$exercice = $datas[0];
		$exercice->actualise();

		$date1 = $exercice->created;
		$date2 = $exercice->datefin();

		$datas = COMPTEBANQUE::findBy(["id ="=> COMPTEBANQUE::COURANT]);
		$caisse = $datas[0];


		$operations = OPERATION::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
		foreach ($operations as $key => $value) {
			$value->actualise();
			$value->fiche = "boncaisse";
			$value->type = $value->categorieoperation->name();
		}
		$clients = REGLEMENTCLIENT::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
		foreach ($clients as $key => $value) {
			$value->actualise();
			$value->fiche = "boncaisse";
			$value->type = "Reglement de client";
		}

		$fournisseurs = REGLEMENTFOURNISSEUR::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
		foreach ($fournisseurs as $key => $value) {
			$value->actualise();
			$value->fiche = "boncaisse";
			$value->type = "Reglement de fournisseur";
		}
		$payes = LIGNEPAYEMENT::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
		foreach ($payes as $key => $value) {
			$value->actualise();
			$value->fiche = "boncaisse";
			$value->type = "Paye de commercial";
		}

	$tableau = array_merge($operations, $clients /*$fournisseurs, $payes*/);
	usort($tableau, "comparerDateCreated");


	$entrees = $depenses = 0;
	foreach ($tableau as $key => $value) {
		if ($value->mouvement->comptebanque_id == COMPTEBANQUE::COURANT) {
			if ($value->mouvement->typemouvement_id == TYPEMOUVEMENT::DEPOT) {
				$entrees += $value->mouvement->montant;
			}else{
				$depenses += $value->mouvement->montant;
			}
		}else{
			unset($tableau[$key]);
		}
	}


	$ca = REGLEMENTCLIENT::total($exercice->created , $exercice->datefin()) + CLIENT::dettes();
	$charges = OPERATION::sortie($exercice->created , $exercice->datefin());
	$appros = REGLEMENTFOURNISSEUR::total($exercice->created , $exercice->datefin()) + FOURNISSEUR::dettes();
	$payements = LIGNEPAYEMENT::total($exercice->created , $exercice->datefin());

	$marges = $ca - ($charges + $appros + $payements);

	$statistiques = OPERATION::statistiques();

	$stats = OPERATION::stats($exercice->created, $exercice->datefin());


	$title = "GPV | Trésorerie générale";

}else{
	header("Location: ../master/clients");
}
}else{
	header("Location: ../master/clients");
}
?>