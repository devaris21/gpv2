<?php 

namespace Home;

if ($this->getId() != null) {
	$datas = PROSPECTION::findBy(["id ="=> $this->getId(), 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$prospection = $datas[0];
		$prospection->actualise();

		$prospection->fourni("ligneprospection");

		$title = "GPV | Bon de sortie ";
		
	}else{
		header("Location: ../production/prospections");
	}
}else{
	header("Location: ../production/prospections");
}

?>