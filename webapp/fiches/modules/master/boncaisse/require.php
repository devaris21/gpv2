<?php 

namespace Home;

if ($this->id != null) {
	$datas = OPERATION::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$operation = $datas[0];
		$operation->actualise();

		$title = "GPV | Bon de caisse ";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>