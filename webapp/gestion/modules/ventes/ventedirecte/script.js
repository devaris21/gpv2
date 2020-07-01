$(function(){


    $("tr.fini").hide()

    $("input[type=checkbox].onoffswitch-checkbox").change(function(event) {
        if($(this).is(":checked")){
            Loader.start()
            setTimeout(function(){
                Loader.stop()
                $("tr.fini").fadeIn(400)
                $(".aucun").hide()
            }, 500);
        }else{
            $("tr.fini").fadeOut(400)
            $(".aucun").show()
        }
    });

    $("#top-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table.table-vente tr:not(.no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    
    annulerVente = function(id){
        alerty.confirm("Voulez-vous vraiment annuler cette vente directe ?", {
            title: "Annuler la vente",
            cancelLabel : "Non",
            okLabel : "OUI, annuler",
        }, function(){
            var url = "../../webapp/gestion/modules/ventes/ventedirecte/ajax.php";
            alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
                title: 'Récupération du mot de passe !',
                inputType : "password",
                cancelLabel : "Annuler",
                okLabel : "Valider"
            }, function(password){
                Loader.start();
                $.post(url, {action:"annulerVente", id:id, password:password}, (data)=>{
                    if (data.status) {
                        window.location.reload()
                    }else{
                        Alerter.error('Erreur !', data.message);
                    }
                },"json");
            })
        })
    }


    terminer = function(id){
        alerty.confirm("Cette prospection est-elle vraiment terminée ?", {
            title: "Prospection terminée",
            cancelLabel : "Non",
            okLabel : "OUI, terminer",
        }, function(){
            session("prospection_id", id);
            modal("#modal-prospection"+id);
        })
    }


    $("input.vendus").change(function(){
        var url = "../../webapp/gestion/modules/ventes/prospections/ajax.php";
        var formdata = new FormData();
        var tableau = new Array();
        $(this).parent("td").parent("tr").parent("tbody").parent("table").find("tr").each(function(index, el) {
            var id = $(this).find("input.vendus").attr('data-id');
            var val = $(this).find("input.vendus").val();
            var item = id+"-"+val;
            tableau.push(item);
        });
        formdata.append('tableau', tableau);
        formdata.append('action', "calcul");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            $(".total").html(data.total);
        }, 'json');
    });



    $(".formValiderProspection").submit(function(event) {
        Loader.start();
        var url = "../../webapp/gestion/modules/ventes/prospections/ajax.php";
        var formdata = new FormData($(this)[0]);
        var tableau = new Array();
        var tableau1 = new Array();
        $(this).find("table tr").each(function(index, el) {
            var id = $(this).attr('data-id');
            
            var vendu = $(this).find('input.vendus').val();
            tableau.push(id+"-"+vendu);

            var perdu = $(this).find('input.perdus').val();
            tableau1.push(id+"-"+perdu);
        });
        formdata.append('tableau', tableau);
        formdata.append('tableau1', tableau1);

        formdata.append('action', "validerProspection");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            if (data.status) {
                window.location.reload()
            }else{
                Alerter.error('Erreur !', data.message);
            }
        }, 'json');
        return false;
    });


    
})