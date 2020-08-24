<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


$parfums = $typeproduits = $quantites = $entrepots = [];

foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, null, $item->id);
		$parfums[] = $item;
}

foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, null, null, $item->id);
		$typeproduits[] = $item;
}


foreach (ENTREPOT::getAll() as $key => $item) {
		$item->vendu = PRODUIT::totalProduit($date1, $date2, $item->id);
		$entrepots[] = $item;
}


$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]) ;



$stats = PRODUCTION::stats($date1, $date2, null);

$title = "GPV | Rapport de production ";

$lots = [];
?>