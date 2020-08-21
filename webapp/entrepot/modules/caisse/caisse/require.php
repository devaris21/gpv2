<?php 
namespace Home;

$datas = BOUTIQUE::findBy(["id ="=>getSession("boutique_connecte_id")]);
if (count($datas) == 1) {
	$entrepot = $datas[0];
	$entrepot->actualise();
	$comptebanque = $entrepot->comptebanque;

	$mouvements = $comptebanque->fourni("mouvement", ["DATE(created) >= "=> $date1, "DATE(created) <= "=> $date2]);

	$transferts = TRANSFERTFOND::findBy(["comptebanque_id_source="=>$comptebanque->id, "DATE(created) >= "=> $date1, "DATE(created) <= "=> $date2]);

	$operations = OPERATION::findBy(["DATE(created) >= "=> dateAjoute(-7)]);
	$entrees = $depenses = [];
	foreach ($operations as $key => $value) {
		$value->actualise();
		if ($value->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
			$entrees[] = $value;
		}else{
			$depenses[] = $value;
		}
	}


	$stats = $comptebanque->stats($date1, $date2);

	$title = "GPV | Compte de caisse";
}else{
	header("Location: ../master/dashboard");
}




?>