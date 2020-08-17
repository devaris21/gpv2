<?php 
namespace Home;

$datas = BOUTIQUE::findBy(["id ="=>getSession("boutique_connecte_id")]);
if (count($datas) == 1) {
	$boutique = $datas[0];
	$boutique->actualise();
	$comptebanque = $boutique->comptebanque;

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

	$title = "BRIXS | Compte de caisse";
}else{
	header("Location: ../master/dashboard");
}




?>