<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


$parfums = $typeproduits = $quantites = [];

foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, $entrepot->id, $item->id);
		$parfums[] = $item;
}

foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, $entrepot->id, null, $item->id);
		$typeproduits[] = $item;
}

$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]) ;



$stats = PRODUCTION::stats($date1, $date2, $entrepot->id);

$title = "GPV | Rapport de production ";

$lots = [];
?>