<?php 
namespace Home;

$datas = COMPTEBANQUE::findBy(["id ="=>$this->getId()]);
if (count($datas) == 1) {
	$comptebanque = $datas[0];
	$comptebanque->actualise();

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

	$title = "BRIXS | Compte de caisse";
}else{
	header("Location: ../master/dashboard");
}




?>