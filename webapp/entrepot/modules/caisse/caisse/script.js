$(function(){

	filtrer = function(){
		var url = "../../webapp/gestion/modules/caisse/caisse/ajax.php";
		var formdata = new FormData($("#formFiltrer")[0]);
		formdata.append('action', "filtrer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.href = data.url;
		}, "json")
	}


	$("#top-search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".table-operation tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$("#search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tableau-attente tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});



	valider = function(id){
		var url = "../../webapp/gestion/modules/caisse/caisse/ajax.php";
		alerty.confirm("Confirmez-vous être maintenant en possession effective de ladite somme ?", {
			title: "Validation de l'opération",
			cancelLabel : "Non",
			okLabel : "OUI, valider",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				Loader.start();
				$.post(url, {action:"valider", password:password, id:id}, (data)=>{
					if (data.status) {
						window.location.reload()
					}else{
						Alerter.error('Erreur !', data.message);
					}
				},"json");
			})
		})
	}




	modifierOperation = function(id){
		var url = "../../composants/dist/shamman/traitement.php";
		alerty.confirm("Vous êtes sur le point de modifier cette opération de caisse, voulez-vous continuer ?", {
			title: "Modification de l'opération",
			cancelLabel : "Non",
			okLabel : "OUI, modifier",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				Loader.start();
				$.post(url, {action:"verifierPassword", password:password}, (data)=>{
					if (data.status) {
						modification('operation', id);
						$("#modal-operation").modal("show");
					}else{
						Alerter.error('Erreur !', data.message);
					}
				},"json");
			})
		})
	}

})