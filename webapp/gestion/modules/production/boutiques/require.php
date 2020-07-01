<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");


if ($this->getId() != null) {
	$datas = BOUTIQUE::findBy(["id ="=>$this->getId()]);
	if (count($datas) > 0) {
		$boutique = $datas[0];

		session("boutique_id", $this->getId());
		$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);
		$rupture = 0;
		$tableau = [];
		foreach ($produits as $key => $produit) {
			$tab = [];
			foreach ($produit->fourni('prixdevente', ["isActive ="=>TABLE::OUI]) as $key => $pdv) {
				$pdv->actualise();
				$data = new \stdclass();
				$data->name = $pdv->produit->name()." // ".$pdv->prix->price()/*." ".$params->devise*/;
				$data->prix = $pdv->prix->price()." ".$params->devise;
				$data->quantite = $pdv->quantite->name();
				$data->boutique = $pdv->enBoutique(dateAjoute());
				$data->stock = $pdv->enEntrepot(dateAjoute());
				$data->commande = $pdv->commandee();
				$data->rupture = false;
				if ($pdv->stockGlobal() <= $params->ruptureStock) {
					$data->rupture = true;
					$rupture++;
				}	
				$tab[] = $data;
			}
			$tableau[$produit->getId()] = $tab;
		}

		$title = "GPV | ".$boutique->name();

		$stats = VENTE::stats(dateAjoute(-30), dateAjoute());
	}else{
		header("Location: ../master/dashboard");
	}
}else{
	header("Location: ../master/dashboard");
}
?>