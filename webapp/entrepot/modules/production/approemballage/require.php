<?php 
namespace Home;

unset_session("ressources");

$title = "GPV | Toutes les livraisons en cours";

$approvisionnements = $entrepot->fourni("approemballage", [], [], ["created"=>"DESC"]);
$total = 0;
foreach ($approvisionnements as $key => $liv) {
	if ($liv->etat_id == ETAT::ENCOURS) {
		$total++;
	}
}


?>