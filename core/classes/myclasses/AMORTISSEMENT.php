<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use Carbon\Carbon;
/**
 * 
 */
class AMORTISSEMENT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	public $typeamortissement_id = TYPEAMORTISSEMENT::LINEAIRE;
	public $immobilisation_id;
	public $etat_id = ETAT::ENCOURS;
	public $duree;


	public function enregistre(){
		$data = new RESPONSE;
		$datas = TYPEAMORTISSEMENT::findBy(["id ="=>$this->typeamortissement_id]);
		if (count($datas) == 1) {
			$datas = IMMOBILISATION::findBy(["id ="=>$this->immobilisation_id]);
			if (count($datas) == 1) {
				$immobilisation = $datas[0];
				if ($this->duree > 0 ) {
					$data = $this->save();
					if ($data->status ) {
						$diff = date("Y", strtotime($this->started)) - date("Y");
						if ($diff > 0) {
							if ($amortissement->typeamortissement_id == TYPEAMORTISSEMENT::LINEAIRE) {
								$annuite = round(($immobilisation->montant * (1 / $this->duree)), 2);

							}else if($amortissement->typeamortissement_id == TYPEAMORTISSEMENT::DEGRESSIF) {
								if ($this->duree < 4) {
									$taux = 1.25;
								}elseif ($this->duree < 6) {
									$taux = 1.75;
								}else{
									$taux = 2.25;
								}

								$annuite = round(($immobilisation->montant * (1 / $this->duree) * $taux), 2);
							}
							$ligne = new LIGNEAMORTISSEMENT();
							$ligne->amortissement_id = $this->id;
							$ligne->montant = $annuite * (dateDiffe($this->started, date("Y")."-01-01") / 360);
							$data = $ligne->enregistre();
							if ($data->status) {
								$ligne->restait = $immobilisation->resteAmortissement();
								$ligne->save();
							}
						}
					}
				}else{
					$data->status = false;
					$data->message = "Le nombre d'année pour l'amortissement n'est pas correcte !";
				}
			}else{
				$data->status = false;
				$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
			}
		}else{
			$data->status = false;
			$data->message = "Une erreur s'est produite lors de l'ajout du produit !";
		}
		return $data;
	}


	public static function encours(){
		return static::findBy(["etat_id ="=>ETAT::ENCOURS]);
	}
	


	public static function cloture(){
		$exercice = EXERCICECOMPTABLE::encours();
		foreach (static::encours() as $key => $amor) {
			$amor->actualise();
			if ($amor->immobilisation->resteAmortissement() > 0) {
				$nb = ceil(dateDiffe($exercice->created, dateAjoute()) / 12);

				$annuite = round(($amor->immobilisation->montant * (1 / $amor->duree) * $nb/12), 2);
				if($amor->typeamortissement_id == TYPEAMORTISSEMENT::DEGRESSIF) {
					if ($amor->duree < 4) {
						$taux = 1.25;
					}elseif ($amor->duree < 6) {
						$taux = 1.75;
					}else{
						$taux = 2.25;
					}
					$a = round(($amor->immobilisation->resteAmortissement() * (1 / $amor->duree) * $taux * $nb/12), 2);
					if ($a > $annuite) {
						$annuite = $a;
					}
				}

				if ($annuite > $amor->immobilisation->resteAmortissement()) {
					$annuite = $amor->immobilisation->resteAmortissement();
				}

				$ligne = new LIGNEAMORTISSEMENT();
				$ligne->exercicecomptable_id = $exercice->id;
				$ligne->amortissement_id = $amor->id;
				$ligne->montant = $annuite;
				$data = $ligne->enregistre();
				if ($data->status) {
					$ligne->restait = $amor->immobilisation->resteAmortissement();
					$ligne->save();
				}
			}else{
				$amor->etat_id ==  ETAT::VALIDEE;
				$amor->save();
			}
		}
	}

	
	public function sentenseCreate(){}
	public function sentenseUpdate(){}
	public function sentenseDelete(){}

}



?>