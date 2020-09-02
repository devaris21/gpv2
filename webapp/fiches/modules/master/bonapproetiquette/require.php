<?php 

namespace Home;

if ($this->id != null) {
	$datas = APPROETIQUETTE::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$appro = $datas[0];
		$appro->actualise();

		$appro->fourni("ligneapproetiquette");

		$title = "GPV | Bon d'approvisionnement d'etiquettes";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>