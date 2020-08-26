    $(function(){  	

    	$("#formProductionJour").submit(function(event) {
    		Loader.start();
    		var url = "../../webapp/manager/elements/templates/traitement.php";
    		var formdata = new FormData($(this)[0]);
    		// var val = $(this).find("select[name=manoeuvre_id]").val();
    		// formdata.append('manoeuvres', val);
    		formdata.append('action', "production");
    		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
    			if (data.status) {
    				window.location.reload();
    			}else{
    				Alerter.error('Erreur !', data.message);
    			}
    		}, 'json')
    		return false;
    	});


        voirPrixParZone = function(){    
            Loader.start();    
            var  url = "../../webapp/manager/elements/templates/traitement.php";
            $.post(url, {action:"voirPrixParZone"}, (data)=>{
                $("body #modal-prixparzone").remove();
                $("body").append(data);
                $("body #modal-prixparzone").modal("show");
                $("select.select2").select2();
                Loader.stop();    
            },"html");
        }


        $("body").on("keyup", "#search", function() {
            var value = $(this).val().toLowerCase();
            $("body").find(".clients").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


        $("div.modepayement_facultatif").hide();
        $("body").on("change", "select[name=modepayement_id]", function(event) {
            if($(this).val() > 2){
                $("div.modepayement_facultatif").show()
            }else{
                $("div.modepayement_facultatif").hide()
            }

            if($(this).val() != 2){
                $("div.no_modepayement_facultatif").show()
            }else{
                $("div.no_modepayement_facultatif").hide()
            }
        });



        $("body").on("change", "select[name=vehicule_id]", function(event) {
            //son vehicule
            if($(this).val() == 1){
                $("div.tricycle").hide()
                $("div.location").hide()
                $("div.montant_location").hide()
                $("div.chauffeur").hide()

            //tricycle
        }else if($(this).val() == 2){
            $("div.tricycle").show()
            $("div.location").hide()
            $("div.montant_location").hide()
            $("div.chauffeur").hide()

        }else{
            $("div.tricycle").hide()
            $("div.location").show()
            $("div.chauffeur").show()
        }
    });


        $("body").on("change", "select[name=isLouer]", function(event) {
            if($(this).val() == 0){
                $("div.montant_location").hide()
            }else{
                $("div.montant_location").show()
            }
        });


    })