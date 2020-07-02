<?php 
namespace Home;
unset_session("ressources");

if ($this->getId() != "") {
	$tab = explode("@", $this->getId());
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = dateAjoute(-31);
	$date2 = dateAjoute();
}


$ressources = RESSOURCE::getAll();
$etiquettes = ETIQUETTE::getAll();
$emballages = EMBALLAGE::getAll();

$productionjours = PRODUCTIONJOUR::findBy([],[],["ladate"=>"DESC"]);
usort($productionjours, 'comparerLadate');

$title = "GPV | Stock des ressources ";
?>