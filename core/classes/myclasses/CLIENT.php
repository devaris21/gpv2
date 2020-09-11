<?php
namespace Home;
use Native\RESPONSE;
use Native\EMAIL;
use \DateTime;
use \DateInterval;
/**
/**
 * 
 */
class CLIENT extends TABLE
{
	public static $tableName = __CLASS__;
	public static $namespace = __NAMESPACE__;

	const ANONYME = 1;

	public $typeclient_id = TYPECLIENT::ENTREPRISE;
	public $boutique_id ;
	public $name;
	public $contact;
	public $email;
	public $adresse;

	public $acompte = 0;
	public $dette = 0;
	


	public function enregistre(){
		$data = new RESPONSE;
		if ($this->name != "") {
			$this->boutique_id = getSession("boutique_connecte_id");
			$data = $this->save();
			$data->setUrl("boutique", "master", "client", $data->lastid);
		}else{
			$data->status = false;
			$data->message = "Veuillez renseigner le nom du niveau d'administration !";
		}
		return $data;
	}


	public static function getSemaine(){
		return static::findBy(["DATE(created) >= " => dateAjoute(-7), "visibility ="=>1]);
	}



	public function crediter(int $montant, Array $post){
		$data = new RESPONSE;
		$params = PARAMS::findLastId();
		if (intval($montant) > 0 ) {
			$payement = new REGLEMENTCLIENT();
			$payement->hydrater($post);
			if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
				$payement->client_id = $this->id;
				$payement->comment = "Créditation du compte du client ".$this->name()." d'un montant de ".money($montant)." ".$params->devise;
				$data = $payement->enregistre();
				if ($data->status) {
					$payement->actualise();
					$id = $data->lastid;
					$this->acompte += intval($montant);
					$data = $this->save();

					$payement->acompteClient = $this->acompte;
					$payement->detteClient = $this->dette;
					$payement->save();

					$data->setUrl("fiches", "master", "boncaisse", $payement->mouvement->id);
				}
			}else{
				$data->status = false;
				$data->message = "Vous ne pouvez pas choisir ce mode de payement !";
			}			
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}


	public function rembourser(int $montant, Array $post){
		$data = new RESPONSE;
		$params = PARAMS::findLastId();
		if (intval($montant) > 0 ) {
			if ($this->acompte >= intval($montant)) {
				$payement = new OPERATION();
				$payement->hydrater($post);
				if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE) {
					$payement->categorieoperation_id = CATEGORIEOPERATION::RETOURFOND_CLIENT;
					$payement->client_id = $this->id;
					$payement->comment = "Retour de fonds au client ".$this->name()." pour ".$_POST["comment1"];
					$data = $payement->enregistre();
					if ($data->status) {
						$payement->actualise();
						$id = $data->lastid;
						$this->acompte -= intval($montant);
						$data = $this->save();

						$payement->acompteClient = $this->acompte;
						$payement->detteClient = $this->dette;
						$payement->save();

						$data->setUrl("fiches", "master", "boncaisse", $payement->mouvement->id);
					}
				}else{
					$data->status = false;
					$data->message = "Vous ne pouvez pas choisir ce mode de payement !";
				}
			}else{
				$data->status = false;
				$data->message = "Le montant à rembourser ne doit pas être supérieur au montant de son acompte!";
			}			
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}


	public function debiter(int $montant){
		$data = new RESPONSE;
		if (intval($montant) > 0 ) {
			if ($this->acompte >= $montant) {
				$this->acompte -= intval($montant);
			}else{
				$this->dette += $montant - $this->acompte;
				$this->acompte = 0;
			}	
			$data = $this->save();	
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}



	public function dette(int $montant){
		$data = new RESPONSE;
		if (intval($montant) > 0 ) {
			$this->dette += intval($montant);
			$data = $this->save();			
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}


	public function reglerDette(int $montant, Array $post){
		$data = new RESPONSE;
		$params = PARAMS::findLastId();
		if (intval($montant) > 0 ) {
			if (intval($montant) <= $this->dette ) {
				$payement = new REGLEMENTCLIENT();
				$payement->hydrater($post);

				if ($payement->modepayement_id != MODEPAYEMENT::PRELEVEMENT_ACOMPTE || ($payement->modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE && $montant <= $this->acompte)) {

					if ($payement->modepayement_id == MODEPAYEMENT::PRELEVEMENT_ACOMPTE ) {
						$this->acompte -= intval($montant);
						$this->dette -= intval($montant);
						$data = $this->save();
					}else{
						$this->dette -= intval($montant);
						$payement->client_id = $this->id;
						$payement->comment = "Reglement de la dette du client ".$this->name()." d'un montant de ".money($montant)." ".$params->devise;
						$data = $payement->enregistre();
						if ($data->status) {
							$id = $data->lastid;
							$data = $this->save();

							$payement->acompteClient = $this->acompte;
							$payement->detteClient = $this->dette;
							$payement->save();
							
							$data->setUrl("fiches", "master", "boncaisse", $id);
						}
					}
				}else{
					$data->status = false;
					$data->message = "Le montant sur son acompte est insuffisant pour regler cette somme";
				}	
			}else{
				$data->status = false;
				$data->message = "Le montant à rembourser doit être inférieur à la dette !";
			}
		}else{
			$data->status = false;
			$data->message = "Veuillez saisir un montant en chiffre supérieur à 0 !";
		}
		return $data;
	}


	public function versements(string $date1 = "2020-04-01", string $date2){
		$datas = $this->fourni("operation", ["DATE(created) >= " => $date1, "DATE(created) <= " => $date2]);
		foreach ($datas as $key => $ope) {
			$ope->actualise();
			if ($ope->categorieoperation->typeoperationcaisse_id != TYPEOPERATIONCAISSE::ENTREE) {
				unset($datas[$key]);
			}
		}
		return comptage($datas, "montant", "somme");
	}



	public static function dettes(int $boutique_id = null){
		$total = 0;
		if ($boutique_id != null) {
			foreach (static::findBy(["boutique_id ="=> $boutique_id]) as $key => $client) {
				$total += $client->resteAPayer();
			}
		}else{
			foreach (static::findBy([]) as $key => $client) {
				$total += $client->resteAPayer();
			}
		}
		return $total;
	}


	public function resteAPayer(){
		$total = 0;
		foreach ($this->fourni("groupecommande", ["etat_id !="=>ETAT::ANNULEE]) as $key => $groupe) {
			foreach ($groupe->fourni("commande", ["etat_id !="=>ETAT::ANNULEE]) as $key => $commande) {
				$total += $commande->reste();
			}		
		}
		return $total;
	}


	public static function stats(string $date1 = "2020-04-01", string $date2){
		$tableaux = [];
		$nb = ceil(dateDiffe($date1, $date2) / 12);
		$index = $date1;
		while ( $index <= $date2 ) {
			$debut = $index;
			$fin = dateAjoute1($index, 1);

			$data = new \stdclass;
			$data->year = date("Y", strtotime($index));
			$data->month = date("m", strtotime($index));
			$data->day = date("d", strtotime($index));
			$data->nb = $nb;
			////////////

			$data->commandes = count(COMMANDE::findBy(["DATE(created) >= " => $debut, "DATE(created) < " => $fin, "etat_id !="=>ETAT::ANNULEE]));
			$data->livraisons = count(VENTE::findBy(["DATE(created) >= " => $debut, "DATE(created) < " => $fin, "etat_id !="=>ETAT::ANNULEE]));
			$data->versement = OPERATION::versements($debut, $fin);

			$tableaux[] = $data;
			///////////////////////

			$index = $fin;
		}
		return $tableaux;
	}





	public function sentenseCreate(){
		return $this->sentense = "Ajout d'un nouvel employé dans votre gestion :". $this->name();
	}


	public function sentenseUpdate(){
		return $this->sentense = "Modification des informations de l'employé ".$this->name();
	}


	public function sentenseDelete(){
		return $this->sentense = "Suppression définitive de l'employé ".$this->name();
	}



}

?>