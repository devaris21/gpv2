<?php 

namespace Home;

if ($this->id != null) {
	$datas = PRODUCTION::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$production = $datas[0];
		$production->actualise();

		$production->fourni("ligneproduction");

		$title = "GPV | Bon de livraison ";
		
	}else{
		header("Location: ../production/production");
	}
}else{
	header("Location: ../production/production");
}

?>