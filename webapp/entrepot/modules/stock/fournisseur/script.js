$(function(){


	$("#formAcompte").submit(function(event) {
		var url = "../../webapp/entrepot/modules/stock/fournisseur/ajax.php";
		alerty.confirm("Voulez-vous vraiment créditer ce montant sur ce compte ?", {
			title: "Créditer l'acompte",
			cancelLabel : "Non",
			okLabel : "OUI, créditer",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				var formdata = new FormData($("#formAcompte")[0]);
				formdata.append('password', password);
				formdata.append('action', "acompte");
				Loader.start();
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						window.open(data.url, "_blank");
						window.location.reload();
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json')
			})
		})
		return false;
	});


	$("#formDette").submit(function(event) {
		var url = "../../webapp/entrepot/modules/stock/fournisseur/ajax.php";
		alerty.confirm("Voulez-vous vraiment faire le réglement de ce montant ?", {
			title: "Reglement de dette",
			cancelLabel : "Non",
			okLabel : "OUI, régler la dette",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				var formdata = new FormData($("#formDette")[0]);
				formdata.append('password', password);
				formdata.append('action', "dette");
				Loader.start();
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						if (data.url != null) {
							window.open(data.url, "_blank");
						}
						window.location.reload();
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json')
			})
		})
		return false;
	});


	reglerToutesDettes = function(id){
		alerty.confirm("Voulez-vous vraiment regler toutes les dettes de ce client ? \n Le Recouvrement se fera via la caisse directement. veuillez donc vous assurer d'un solde adéquat. \n Le recouvrement se fera également dans la limite des fonds disponibles", {
			title: "Recouvrement de dettes",
			cancelLabel : "Non",
			okLabel : "OUI, valider",
		}, function(){
			var url = "../../webapp/entrepot/modules/stock/fournisseur/ajax.php";
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				Loader.start();
				$.post(url, {action:"reglerToutesDettes", id:id, password:password}, (data)=>{
					if (data.status) {
						window.location.reload()
					}else{
						Alerter.error('Erreur !', data.message);
					}
				},"json");
			})
		})
	}



	$("#formRembourser").submit(function(event) {
		var url = "../../webapp/entrepot/modules/stock/fournisseur/ajax.php";
		alerty.confirm("Voulez-vous vraiment rembourser ce montant à ce fournisseur ?", {
			title: "rembourser l'acompte",
			cancelLabel : "Non",
			okLabel : "OUI, créditer",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				var formdata = new FormData($("#formRembourser")[0]);
				formdata.append('password', password);
				formdata.append('action', "rembourser");
				Loader.start();
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						window.open(data.url, "_blank");
						window.location.reload();
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json')
			})
		})
		return false;
	});


	$('.input-group.date').datepicker({
		autoclose: true,
		format: "dd MM yyyy",
		language: "fr"
	});

})