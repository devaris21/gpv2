$(function(){


    $("tr.fini").hide()

    $("input[type=checkbox].onoffswitch-checkbox").change(function(event) {
        if($(this).is(":checked")){
            Loader.start()
            setTimeout(function(){
                Loader.stop()
                $("tr.fini").fadeIn(400)
            }, 500);
        }else{
            $("tr.fini").fadeOut(400)
        }
    });

    $("#top-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table.table-mise tr:not(.no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });




    nouvelleProduction = function(){
        var formdata = new FormData($("#formProduction")[0]);
        
        tableau = new Array();
        $("#modal-production tr input").each(function(index, el) {
            var id = $(this).attr('data-id');
            var val = $(this).val();
            if (val > 0) {
                var item = id+"-"+val;
                tableau.push(item);
            }       
        });
        formdata.append('listeproduits', tableau);

        alerty.confirm("Voulez-vous vraiment confirmer la production de ces produits ?", {
            title: "Confirmation de la production",
            cancelLabel : "Non",
            okLabel : "OUI, Valider",
        }, function(){
            Loader.start();
            var url = "../../webapp/entrepot/modules/production/production/ajax.php";
            formdata.append('action', "nouvelleProduction");
            $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                if (data.status) {
                    window.location.reload();
                }else{
                    Alerter.error('Erreur !', data.message);
                }
            }, 'json')
        })
    }




    
    annulerProduction = function(id){
        alerty.confirm("Voulez-vous vraiment annuler cette mise en boutique ?", {
            title: "Annuler la mise en boutique",
            cancelLabel : "Non",
            okLabel : "OUI, annuler",
        }, function(){
            var url = "../../webapp/boutique/modules/production/miseenboutique/ajax.php";
            alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
                title: 'Récupération du mot de passe !',
                inputType : "password",
                cancelLabel : "Annuler",
                okLabel : "Valider"
            }, function(password){
                Loader.start();
                $.post(url, {action:"annulerMiseenboutique", id:id, password:password}, (data)=>{
                    if (data.status) {
                        window.location.reload()
                    }else{
                        Alerter.error('Erreur !', data.message);
                    }
                },"json");
            })
        })
    }


    $(".formConditionnement").submit(function(event) {
        var formdata = new FormData($(this)[0]);
        alerty.confirm("Voulez-vous vraiment valider cet conditionnement ?", {
            title: "valider le conditionnement",
            cancelLabel : "Non",
            okLabel : "OUI, valider",
        }, function(){
            Loader.start();
            $(this).find("input.quantite").last().change();
            var url = "../../webapp/entrepot/modules/production/conditionnement/ajax.php";
            formdata.append('action', "validerConditionnement");
            $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                if (data.status) {
                    window.location.reload()
                }else{
                    Alerter.error('Erreur !', data.message);
                }
            }, 'json');
        });
        return false;
    });


})