<?php 
namespace Home;
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

$date1 = dateAjoute(-3);
$date2 = dateAjoute();

$title = "GPV | Compte de caisse";

?>