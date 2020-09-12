<?php 
namespace Home;
use Faker\Factory;
unset_session("produits");
unset_session("commande-encours");
$faker = Factory::create();

if ($this->id != null) {
	$datas = BOUTIQUE::findBy(["id ="=>$this->id]);
	if (count($datas) > 0) {
		$boutique = $datas[0];
		$boutique->actualise();

		$comptebanque = $boutique->comptebanque;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$stats1 = VENTE::stats2(dateAjoute(-14), dateAjoute(), $boutique->id);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$parfums = $typeproduits = $quantites = [];
		foreach (PARFUM::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
			$item->vendu = PRODUIT::totalVendu($date1, $date2, $boutique->id, null, $item->id);
			$parfums[] = $item;
		}

		foreach (TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
			$item->vendu = PRODUIT::totalVendu($date1, $date2, $boutique->id, $item->id);
			$typeproduits[] = $item;
		}

		foreach (QUANTITE::findBy(["isActive ="=>TABLE::OUI]) as $key => $item) {
			$item->vendu = PRODUIT::totalVendu($date1, $date2, $boutique->id, null, null, $item->id);
			$quantites[] = $item;
		}

		$stats2 = VENTE::stats($date1, $date2, $boutique->id);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		$mouvements = $comptebanque->fourni("mouvement", ["DATE(created) >= "=> $date1, "DATE(created) <= "=> $date2]);

		$transferts = TRANSFERTFOND::findBy(["comptebanque_id_source="=>$comptebanque->id, "DATE(created) >= "=> $date1, "DATE(created) <= "=> $date2]);

		$operations = OPERATION::findBy(["DATE(created) >= "=> dateAjoute(-7)]);
		$entrees = $depenses = [];
		foreach ($operations as $key => $value) {
			$value->actualise();
			if ($value->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
				$entrees[] = $value;
			}else{
				$depenses[] = $value;
			}
		}
		$stats3 = $comptebanque->stats($date1, $date2);

		$title = "GPV | Vue générale sur ".$boutique->name();
	}else{
		header("Location: ../master/dashboard");
	}
}else{
	header("Location: ../master/dashboard");
}
?>