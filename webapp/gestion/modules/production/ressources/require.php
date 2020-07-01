<?php 
namespace Home;
if ($this->getId() > 0) {
	$id = $this->getId();
}else{
	$id = 7;
}
unset_session("ressources");

$ressources = RESSOURCE::getAll();

$productionjours = PRODUCTIONJOUR::findBy([],[],["ladate"=>"DESC"], $id);
usort($productionjours, 'comparerLadate');

$title = "GPV | Stock des ressources ";
?>