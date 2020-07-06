<?php 
namespace Home;

$title = "GPV | Toutes les livraisons en cours";

$livraisons = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::LIVRAISON, "boutique_id ="=>$boutique->getId()], [], ["created"=>"DESC"]);
$total = 0;
foreach ($livraisons as $key => $liv) {
	if ($liv->etat_id == ETAT::ENCOURS) {
		$total++;
	}
}

?>