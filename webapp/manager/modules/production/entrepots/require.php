<?php 
namespace Home;
use Faker\Factory;
unset_session("produits");
unset_session("commande-encours");
$faker = Factory::create();

if ($this->id != null) {
	$datas = ENTREPOT::findBy(["id ="=>$this->id]);
	if (count($datas) > 0) {
		$entrepot = $datas[0];
		$entrepot->actualise();

		$comptecourant = $entrepot->comptebanque;

		$date1 = getSession("date1");
		$date2 = getSession("date2");
		if ($date1  == null) {
			$date1 = dateAjoute(-10);
		}
		if ($date2  == null) {
			$date2 = dateAjoute();
		}



		$fournisseurs = REGLEMENTFOURNISSEUR::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
		foreach ($fournisseurs as $key => $value) {
			$value->actualise();
			$value->fiche = "boncaisse";
			$value->type = "Reglement de fournisseur";
		}
		$payes = LIGNEPAYEMENT::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
		foreach ($payes as $key => $value) {
			$value->actualise();
			$value->fiche = "boncaisse";
			$value->type = "Paye de commercial";
		}

		$tableau = array_merge($fournisseurs, $payes);
		usort($tableau, "comparerDateCreated");

		$entrees = $depenses = 0;
		foreach ($tableau as $key => $value) {
			if ($value->mouvement->comptebanque_id == $comptecourant->id) {
				if ($value->mouvement->typemouvement_id == TYPEMOUVEMENT::DEPOT) {
					$entrees += $value->mouvement->montant;
				}else{
					$depenses += $value->mouvement->montant;
				}
			}else{
				unset($tableau[$key]);
			}

		}
		$statistiques = OPERATION::statistiques($entrepot->id);


		session("boutique_id", $this->id);
		$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]);
		$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);
		$rupture = 0;
		$tableaux = [];
		foreach ($produits as $key => $produit) {
			$tab = [];
			foreach ($produit->fourni('prixdevente', ["isActive ="=>TABLE::OUI]) as $key => $pdv) {
				$pdv->actualise();
				$data = new \stdclass();
				$data->id = $pdv->id;
				$data->pdv = $pdv;
				$pdv->tab = [];

				$data->name = $pdv->produit->name()." // ".$pdv->quantite->name()/*." ".$params->devise*/;
				$data->prix = $pdv->prix->price()." ".$params->devise;
				$data->quantite = $pdv->quantite->name();
				$data->boutique = $pdv->enEntrepot($date2, $entrepot->id);
				$data->commande = $pdv->commandee($entrepot->id);
				$data->rupture = false;
				if ($data->boutique <= $params->ruptureStock) {
					$data->rupture = true;
					$rupture++;
				}	
				$tab[] = $data;
			}
			$tableaux[$produit->id] = $tab;
		}

		$title = "GPV | ".$entrepot->name();

		$stats = VENTE::stats($date1, $date2, $entrepot->id);

		$ressources = RESSOURCE::getAll();
		$etiquettes = ETIQUETTE::getAll();
		$emballages = EMBALLAGE::getAll();


		$productionjours = PRODUCTIONJOUR::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2], [],["ladate"=>"DESC"]);
		usort($productionjours, 'comparerLadate');

	}else{
		header("Location: ../master/dashboard");
	}
}else{
	header("Location: ../master/dashboard");
}
?>