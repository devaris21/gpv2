<?php 

namespace Home;

if ($this->id != null) {
	$datas = MISEENBOUTIQUE::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$mise = $datas[0];
		$mise->actualise();

		$mise->fourni("lignemiseenboutique");

		$title = "GPV | Bon de livraison ";
		
	}else{
		header("Location: ../production/miseenboutique");
	}
}else{
	header("Location: ../production/miseenboutique");
}

?>