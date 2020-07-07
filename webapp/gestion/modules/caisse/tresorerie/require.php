<?php 
namespace Home;


if ($this->id != null) {
	$datas = EXERCICECOMPTABLE::findBy(["id ="=> $this->id]);
	if (count($datas) > 0) {
		$exercice = $datas[0];
		$exercice->actualise();

		$datas = COMPTEBANQUE::findBy(["id ="=> COMPTEBANQUE::COURANT]);
		$caisse = $datas[0];

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
		$statistiques = OPERATION::statistiques();

		$stats = OPERATION::stats($exercice->created, $exercice->datefin());


		$title = "GPV | Compte de caisse";

	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}
?>