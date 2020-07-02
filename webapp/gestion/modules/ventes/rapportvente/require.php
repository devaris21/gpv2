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

$produits = PRODUIT::getAll();

$tableau = [];
foreach (PRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $produit) {
	$tab = [];
	foreach ($produit->fourni('prixdevente', ["isActive ="=>TABLE::OUI], [], ["quantite_id"=>"ASC"]) as $key => $pdv) {
		$pdv->actualise();
		$data = new \stdclass();
		$data->id = $pdv->getId();
		$data->pdv = $pdv;
		$pdv->tab = [];

		$data->name = $pdv->produit->name()." // ".$pdv->quantite->name();
		$data->prix = $pdv->prix->price();
		$data->boutique = $pdv->enBoutique($date2);
		$data->stock = $pdv->enEntrepot($date2);
		$tab[] = $data;
		if (!($data->boutique==0 && $data->stock==0)) {

		}	
	}
	$tableau[$produit->getId()] = $tab;
}

$id = dateDiffe($date1, $date2);

$stats = VENTE::stats($date1, $date2);

$productionjours = PRODUCTIONJOUR::findBy([],[],["ladate"=>"DESC"], $id);
usort($productionjours, 'comparerLadate');

$title = "GPV | Stock de la production ";

$lots = [];
?>