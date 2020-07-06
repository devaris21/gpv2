<?php 

namespace Home;

if ($this->getId() != null) {
	$datas = VENTE::findBy(["id ="=> $this->getId(), 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$vente = $datas[0];
		$vente->actualise();

		$vente->fourni("lignedevente");

		$title = "GPV | Reçu de vente ";
		
	}else{
		header("Location: ../ventes/ventedirecte");
	}
}else{
	header("Location: ../ventes/ventedirecte");
}

?>