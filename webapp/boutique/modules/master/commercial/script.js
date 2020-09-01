$(function(){


	$("#formPaye").submit(function(event) {
		var url = "../../webapp/boutique/modules/master/commercial/ajax.php";
		alerty.confirm("Voulez-vous vraiment effectuer la paye de ce commercial ?", {
			title: "Paye du commercial",
			cancelLabel : "Non",
			okLabel : "OUI, faire la paye",
		}, function(){
			alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
				title: 'Récupération du mot de passe !',
				inputType : "password",
				cancelLabel : "Annuler",
				okLabel : "Valider"
			}, function(password){
				var formdata = new FormData($("#formPaye")[0]);
				formdata.append('password', password);
				formdata.append('action', "paye");
				Loader.start();
				$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
					if (data.status) {
						//window.open(data.url, "_blank");
						window.location.reload();
					}else{
						Alerter.error('Erreur !', data.message);
					}
				}, 'json')
			})
		})
		return false;
	});


	filtrer = function(){
		var url = "../../webapp/boutique/modules/master/commercial/ajax.php";
		var formdata = new FormData($("#formFiltrer")[0]);
		formdata.append('action', "filtrer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.reload();
		})
	}


	$("select[name=id]").change(function(){
		var url = "../../webapp/boutique/modules/master/commercial/ajax.php";
		var id = $(this).val();
		var formdata = new FormData();
		formdata.append('id', id);
		formdata.append('action', "changer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.href = data.url;
		}, "json")
	})

})