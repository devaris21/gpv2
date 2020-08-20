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

$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);

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
		$data->boutique = $pdv->enBoutique($date2);
		$data->stock = $pdv->enEntrepot($date2);
			$tab[] = $data;
		if (!($data->boutique==0 && $data->stock==0)) {

		}	
	}
	$tableau[$produit->id] = $tab;
}

$id = dateDiffe($date1, $date2);

$stats = VENTE::stats($date1, $date2);

$productions = PRODUCTION::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2],[],["ladate"=>"DESC"]);
usort($productions, 'comparerLadate');

$title = "GPV | Stock de la production ";

$lots = [];
?>