<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();

if ($this->id != "") {
	$tab = explode("@", $this->id);
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
		$data->id = $pdv->id;
		$data->pdv = $pdv;
		$pdv->tab = [];

		$data->name = $pdv->produit->name()." // ".$pdv->quantite->name()/*." ".$params->devise*/;
		$data->prix = $pdv->prix->price();
		$data->stock = $pdv->enEntrepot($date2, $entrepot->id);
		$data->rupture = false;
		if (!($data->stock==0)) {
			$data->rupture = true;
		}	
		$tab[] = $data;
	}
	$tableau[$produit->id] = $tab;
}


$productions = PRODUCTION::findBy([],[],["ladate"=>"DESC"], $id);
usort($productions, 'comparerLadate');

$title = "GPV | Rapport de la production ";

$lots = [];
?>