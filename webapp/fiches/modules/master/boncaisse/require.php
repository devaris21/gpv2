<?php 

namespace Home;

if ($this->id != null) {
	$datas = MOUVEMENT::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$mouvement = $datas[0];
		$mouvement->actualise();

		$title = "GPV | Bon de caisse ";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>