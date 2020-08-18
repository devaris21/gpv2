<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


$parfums = $typeproduits = $quantites = [];

foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalVendu($date1, $date2, $boutique->id, $item->id);
		$parfums[] = $item;
}

foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalVendu($date1, $date2, $boutique->id, null, $item->id);
		$typeproduits[] = $item;
}

foreach (QUANTITE::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
		$item->vendu = PRODUIT::totalVendu($date1, $date2, $boutique->id, null, null, $item->id);
		$quantites[] = $item;
}



$stats = VENTE::stats($date1, $date2, $boutique->id);

$title = "GPV | Rapport de vente ";

$lots = [];
?>