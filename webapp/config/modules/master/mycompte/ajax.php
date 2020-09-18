<?php 
namespace Home;
use Native\ROOTER;
require '../../../../../core/root/includes.php';
use Native\RESPONSE;

$data = new RESPONSE;
extract($_POST);
$mycompte = MYCOMPTE::findLastId();

if ($action == "abonnement") {
	if ($mycompte->tentative < 3) {
		$data->status = true;
		$code = "";
		for ($i=1; $i < 6 ; $i++) { 
			$name = "bloc".$i;
			if (isset($$name) && strlen($$name) == 5) {
				$code .= $$name;
			}else{
				$data->status = false;
				$data->message = "Le bloc N°$i n'est pas correct, veuillez recommencer !";
				break;
			}
		}

		if ($data->status) {
			if (strlen($code) == 25) {
				$url = "http://activation.payiel.com/api/root/index.php";
				$datas = [
					"action" => "abonnement",
					"code" => strtoupper($code),
					"identifiant" => $mycompte->identifiant
				];

				$options=array(
					CURLOPT_URL            => $url,
					CURLOPT_RETURNTRANSFER => true,      
					CURLOPT_HEADER         => false,    
					CURLOPT_FAILONERROR    => true,       
					CURLOPT_POST           => true,      
					CURLOPT_POSTFIELDS     => $datas 
				);
				$CURL=curl_init();
				if( empty($CURL) ){
					die("ERREUR curl_init : Il semble que cURL ne soit pas disponible.");
				}

				curl_setopt_array($CURL, $options);

				$data = curl_exec($CURL);
				$data = json_decode($data);

				if(curl_errno($CURL)){
            		// Le message d'erreur correspondant est affiché
					echo "ERREUR curl_exec : ".curl_error($CURL);
				}

				curl_close($CURL);

				if ($data->status) {
					$mycompte->tentative = 0;
					$mycompte->expired = dateAjoute1($mycompte->expired, $data->days);
					$data = $mycompte->save();
				}else{
					//$mycompte->tentative++;
					$mycompte->save();
				}
			}else{
				$data->status = false;
				$data->message = "Le nombre de caractères de votre code n'est pas correct, veuillez recommencer !";
			}
		}
	}else{
		$data->status = false;
		$data->message = "Vous avez éssayé plusieurs fois de suite un code érroné! Votre compte est bloqué. \n Veuillez contacter votre fournisseur officiel de l'application !";
	}
	echo json_encode($data);
}