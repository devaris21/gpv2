<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

if ($this->id != null) {
	$datas = BOUTIQUE::findBy(["id ="=>$this->id]);
	if (count($datas) > 0) {
		$boutique = $datas[0];
		$boutique->actualise();
		
		$emballages = EMBALLAGE::findBy(["isActive ="=>TABLE::OUI], [], ["name"=>"ASC"]);
		$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI], [], ["name"=>"ASC"]);
		$parfums = PARFUM::findBy(["isActive ="=>TABLE::OUI], [], ["name"=>"ASC"]);
		$types_parfums = TYPEPRODUIT_PARFUM::findBy(["isActive ="=>TABLE::OUI]);
		$types = TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI], [], ["name"=>"ASC"]);
		$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);
		$ressources = RESSOURCE::getAll([], [], ["name"=>"ASC"]);


		$title = "GPV | Espace de configuration des stocks initiaux ";

	}else{
		header("Location: ../master/dashboard");
	}
}else{
	header("Location: ../master/dashboard");
}






?>