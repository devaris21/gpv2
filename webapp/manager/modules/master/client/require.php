<?php 
namespace Home;

GROUPECOMMANDE::etat();

unset_session("produits");
unset_session("commande-encours");

if ($this->id != null) {
	$datas = CLIENT::findBy(["id ="=> $this->id]);
	if (count($datas) > 0) {
		$client = $datas[0];
		$client->actualise();

		$encours = $client->fourni("groupecommande", ["boutique_id ="=>$boutique->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

		$groupes = $client->fourni("groupecommande", ["boutique_id ="=>$boutique->id, "etat_id !="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);


		$fluxcaisse = $client->fourni("reglementclient");
		usort($fluxcaisse, "comparerDateCreated2");

		$title = "GPV | ".$client->name();

		session("client_id", $client->id);
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}
?>