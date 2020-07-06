<?php 

namespace Home;

if ($this->getId() != null) {
	$datas = PROSPECTION::findBy(["id ="=> $this->getId(), 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$livraison = $datas[0];
		$livraison->actualise();

		$livraison->fourni("ligneprospection");

		$title = "GPV | Bon de livraison ";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>