<?php
namespace Home;
use Native\RESPONSE;/**
 * 
 */
class PRICE extends TABLE
{

	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $produit_id;
	public $emballage_id;
	public $price;
	public $price_gros;
	public $isActive = TABLE::OUI;

	public function enregistre(){
		$data = new RESPONSE;
		$datas = PRODUIT::findBy(["id ="=>$this->produit_id]);
		if (count($datas) == 1) {
			$datas = EMBALLAGE::findBy(["id ="=>$this->emballage_id]);
			if (count($datas) == 1) {
				$data = $this->save();
				if ($this->price >= 0) {
					$data = $this->save();
				}else{
					$data->status = false;
					$data->message = "Le prix n'est pas correct, veuillez recommencer !";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'opération, veuillez recommencer !";
		}
		return $data;
	}


	public function price(){
		return money($this->price);
	}

	public function name(){
		return money($this->price);
	}

	public function enBoutique(string $date){
		$total = 0;
		foreach ($this->fourni("prixdevente") as $key => $value) {
			$total += $value->totalMiseEnBoutique("2020-06-01", $date) - ($value->enProspection($date) + $value->livree("2020-06-01", $date) + $value->vendu("2020-06-01", $date) + $value->perte("2020-06-01", $date));
		}
		return $total;
	}


	public function enEntrepot(string $date){
		$total = 0;
		foreach ($this->fourni("prixdevente") as $key => $value) {
			$total += intval($value->stock) + $value->production("2020-06-01", $date) - $value->totalMiseEnBoutique("2020-06-01", $date);
		}
		return $total;
	}



	public function livree(string $date1 = "2020-06-01", string $date2){
		$total = 0;
		foreach ($this->fourni("prixdevente") as $key => $value) {
			$total += $value->livree($date1, $date2);
		}
		return $total;
	}



	public function perte(string $date1 = "2020-06-01", string $date2){
		$total = 0;
		foreach ($this->fourni("prixdevente") as $key => $value) {
			$total += $value->perte($date1, $date2);
		}
		return $total;
	}


	public function vendu(string $date1 = "2020-06-01", string $date2){
		$total = 0;
		foreach ($this->fourni("prixdevente") as $key => $value) {
			$total += $value->vendu($date1, $date2);
		}
		return $total;
	}



	public function stockGlobal(){
		return $this->enBoutique(dateAjoute()) + $this->enEntrepot(dateAjoute());
	}

	public function montantStock(){
		return $this->stockGlobal() * $this->price;;
	}


	public function montantVendu(string $date1 = "2020-06-01", string $date2){
		$total = 0;
		foreach ($this->fourni("prixdevente") as $key => $value) {
			$value->actualise();
			return ($value->vendu($date1, $date2) + $value->livree($date1, $date2)) * $value->prix->price;
		}
	}



	public function sentenseCreate(){
		return $this->sentense = "Ajout d'une nouvelle zone de livraison : $this->price dans les paramétrages";
	}
	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de la zone de livraison $this->id : $this->price ";
	}
	public function sentenseDelete(){
		return $this->sentense = "Suppression definitive de la zone de livraison $this->id : $this->price";
	}


}
?>