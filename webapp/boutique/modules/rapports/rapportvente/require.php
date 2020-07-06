<?php 
namespace Home;
use Faker\Factory;
$faker = Factory::create();


if ($this->getId() != "") {
	$tab = explode("@", $this->getId());
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = dateAjoute(-7);
	$date2 = dateAjoute();
}

$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);

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
		$data->boutique = $pdv->enBoutique($date2, $boutique->getId());
		$tab[] = $data;
	}
	$tableau[$produit->getId()] = $tab;
}

$id = dateDiffe($date1, $date2);

$stats = VENTE::stats($date1, $date2, $boutique->getId());

$productionjours = PRODUCTIONJOUR::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2],[],["ladate"=>"DESC"]);
usort($productionjours, 'comparerLadate');

$title = "GPV | Stock de la production ";

$lots = [];
?>