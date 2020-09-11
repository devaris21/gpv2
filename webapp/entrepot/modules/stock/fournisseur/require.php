<?php 
namespace Home;

unset_session("ressources");

if ($this->id != null) {
	$datas = FOURNISSEUR::findBy(["id ="=> $this->id]);
	if (count($datas) > 0) {
		$fournisseur = $datas[0];
		$fournisseur->actualise();

		$encours1 = $fournisseur->fourni("approvisionnement", ["entrepot_id ="=>$entrepot->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);
		$encours2 = $fournisseur->fourni("approemballage", ["entrepot_id ="=>$entrepot->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);
		$encours3 = $fournisseur->fourni("approetiquette", ["entrepot_id ="=>$entrepot->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

		$encours = array_merge(
			$encours1, $encours2, $encours3
		);


		$datas1 = $fournisseur->fourni("approvisionnement", ["entrepot_id ="=>$entrepot->id, "etat_id !="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);
		$datas2 = $fournisseur->fourni("approemballage", ["entrepot_id ="=>$entrepot->id, "etat_id !="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);
		$datas3 = $fournisseur->fourni("approetiquette", ["entrepot_id ="=>$entrepot->id, "etat_id !="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

		$datas = array_merge(
			$datas1, $datas2, $datas3
		);




		$fluxcaisse = $fournisseur->fourni("reglementfournisseur");
		usort($fluxcaisse, "comparerDateCreated2");

		$title = "GPV | ".$fournisseur->name();

		session("fournisseur_id", $fournisseur->id);
		
	}else{
		header("Location: ../master/fournisseurs");
	}
}else{
	header("Location: ../master/fournisseurs");
}
?>