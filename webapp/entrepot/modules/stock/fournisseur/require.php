<?php 
namespace Home;

unset_session("ressources");

if ($this->id != null) {
	$datas = FOURNISSEUR::findBy(["id ="=> $this->id]);
	if (count($datas) > 0) {
		$fournisseur = $datas[0];
		$fournisseur->actualise();

		$approvisionnements = $fournisseur->fourni("approvisionnement", ["etat_id ="=>ETAT::ENCOURS]);

		$fournisseur->fourni("approvisionnement");



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