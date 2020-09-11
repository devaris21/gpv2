<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


$parfums = $typeproduits = $quantites = $boutiques = [];

foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
	$item->vendu = PRODUIT::totalVendu($date1, $date2, null, $item->id);
	$parfums[] = $item;
}

foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
	$item->vendu = PRODUIT::totalVendu($date1, $date2, null, null, $item->id);
	$typeproduits[] = $item;
}

foreach (QUANTITE::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
	$item->vendu = PRODUIT::totalVendu($date1, $date2, null, null, null, $item->id);
	$quantites[] = $item;
}

foreach (BOUTIQUE::getAll() as $key => $item) {
	$item->vendu = PRODUIT::totalVendu($date1, $date2);
	$boutiques[] = $item;
}

$stats = VENTE::stats($date1, $date2);

$title = "GPV | Rapport de vente ";

$lots = [];
?>