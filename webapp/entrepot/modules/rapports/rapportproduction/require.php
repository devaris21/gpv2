<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();

if ($this->getId() != "") {
	$tab = explode("@", $this->getId());
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = dateAjoute(-31);
	$date2 = dateAjoute();
}

$id = dateDiffe($date1, $date2);

$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);
$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]);

$tableau = [];
foreach ($produits as $key => $produit) {
	$tab = [];
	foreach ($produit->fourni('prixdevente', ["isActive ="=>TABLE::OUI], [], ["quantite_id"=>"ASC"]) as $key => $pdv) {
		$pdv->actualise();
		$data = new \stdclass();
		$data->id = $pdv->getId();
		$data->pdv = $pdv;
		$pdv->tab = [];

		$data->name = $pdv->produit->name()." // ".$pdv->quantite->name()/*." ".$params->devise*/;
		$data->prix = $pdv->prix->price();
		$data->stock = $pdv->enEntrepot($date2, $entrepot->getId());
		$data->rupture = false;
		if (!($data->stock==0)) {
			$data->rupture = true;
		}	
		$tab[] = $data;
	}
	$tableau[$produit->getId()] = $tab;
}


$productionjours = PRODUCTIONJOUR::findBy([],[],["ladate"=>"DESC"], $id);
usort($productionjours, 'comparerLadate');

$title = "GPV | Rapport de la production ";

$lots = [];
?>