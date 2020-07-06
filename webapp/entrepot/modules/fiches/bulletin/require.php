<?php 

namespace Home;

if ($this->getId() != null) {
	$datas = PAYE::findBy(["id ="=> $this->getId()]);
	if (count($datas) > 0) {
		$paye = $datas[0];
		$paye->actualise();
		$stats = $paye->commercial->stats($paye->started, $paye->finished);

		$prospections = $paye->commercial->vendu($paye->started, $paye->finished);

		$title = "GPV | Bulletin de paye ";
		
	}else{
		header("Location: ../master/commerciaux");
	}
}else{
	header("Location: ../master/commerciaux");
}

?>