<?php 
namespace Home;
unset_session("ressources");

if ($this->id != "") {
	$tab = explode("@", $this->id);
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = dateAjoute(-7);
	$date2 = dateAjoute();
}


$ressources = RESSOURCE::getAll();
$etiquettes = ETIQUETTE::getAll();
$emballages = EMBALLAGE::getAll();

$productions = PRODUCTION::findBy(["DATE(created) >= "=>$date1, "DATE(created) <= "=>$date2],[],["created"=>"DESC"]);
usort($productions, 'comparerDateCreated');

$title = "GPV | Stock des ressources ";
?>