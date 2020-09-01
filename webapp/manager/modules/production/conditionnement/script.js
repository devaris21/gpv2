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



    $(".formConditionnement").submit(function(event) {
        var formdata = new FormData($(this)[0]);
        alerty.confirm("Voulez-vous vraiment valider cet conditionnement ?", {
            title: "valider le conditionnement",
            cancelLabel : "Non",
            okLabel : "OUI, valider",
        }, function(){
            Loader.start();
            $(this).find("input.quantite").last().change();
            var url = "../../webapp/manager/modules/production/conditionnement/ajax.php";
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


})