<?php 

namespace Home;

if ($this->id != null) {
	$datas = APPROEMBALLAGE::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$appro = $datas[0];
		$appro->actualise();

		$appro->fourni("ligneapproemballage");

		$title = "GPV | Bon d'approvisionnement ";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>