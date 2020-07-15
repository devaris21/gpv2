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

		$groupes = $client->fourni("groupecommande",["etat_id ="=>ETAT::ENCOURS]);

		$client->fourni("groupecommande");

		$datas1 = $datas2 = [];
		foreach ($client->groupecommandes as $key => $groupecommande) {
			$datas1 = array_merge($datas1, $groupecommande->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]));
			$datas2 = array_merge($datas2, $groupecommande->fourni("prospection", ["etat_id !="=>ETAT::ANNULEE]));
		}
		foreach ($datas1 as $key => $ligne) {
			$ligne->fourni("lignecommande");
			$ligne->type = "commande";
		}
		foreach ($datas2 as $key => $ligne) {
			$ligne->fourni("ligneprospection");
			$ligne->type = "prospection";
		}
		$flux = array_merge($datas1, $datas2);
		usort($flux, "comparerDateCreated2");


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