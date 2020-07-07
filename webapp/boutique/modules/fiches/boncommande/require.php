<?php 

namespace Home;

if ($this->id != null) {
	$datas = COMMANDE::findBy(["id ="=> $this->id, 'etat_id !='=>ETAT::ANNULEE]);
	if (count($datas) > 0) {
		$commande = $datas[0];
		$commande->actualise();

		$commande->fourni("lignecommande");

		$title = "GPV | Bon de commande ";
		
	}else{
		header("Location: ../master/clients");
	}
}else{
	header("Location: ../master/clients");
}

?>