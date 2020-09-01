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


    $("input[name=quantite]").change(function(){
        var url = "../../webapp/entrepot/modules/production/production/ajax.php";
        var formdata = new FormData();
        $this = $(this);
        formdata.append('id', $(this).attr('id'));
        formdata.append('val', $(this).val());
        formdata.append('action', "calcul");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            $this.parent().parent().parent().find("div.ajax").html(data);
        }, 'html')
    })



    nouvelleProduction = function(id){
        var formdata = new FormData($("#formProduction")[0]);
        tableau = new Array();
        $("#modal-production"+id+" input[name=quantite]").each(function(index, el) {
            var id = $(this).attr('id');
            var val = $(this).val();
            if (val > 0) {
                var item = id+"-"+val;
                tableau.push(item);
            }       
        });
        formdata.append('listeproduits', tableau);

        alerty.confirm("Voulez-vous vraiment confirmer cette production ?", {
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

    // nouvelleProduction = function(){

    //     var formdata = new FormData($("#formProduction")[0]);
        
    //     tableau = new Array();
    //     $("#modal-production tr input").each(function(index, el) {
    //         var id = $(this).attr('data-id');
    //         var val = $(this).val();
    //         if (val > 0) {
    //             var item = id+"-"+val;
    //             tableau.push(item);
    //         }       
    //     });
    //     formdata.append('listeproduits', tableau);

    //     alerty.confirm("Voulez-vous vraiment confirmer la production de ces produits ?", {
    //         title: "Confirmation de la production",
    //         cancelLabel : "Non",
    //         okLabel : "OUI, Valider",
    //     }, function(){
    //         Loader.start();
    //         var url = "../../webapp/entrepot/modules/production/production/ajax.php";
    //         formdata.append('action', "nouvelleProduction");
    //         $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
    //             if (data.status) {
    //                 window.location.reload();
    //             }else{
    //                 Alerter.error('Erreur !', data.message);
    //             }
    //         }, 'json')
    //     })
    // }




    
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


    $("#formValiderMiseenboutique").submit(function(event) {
        Loader.start();
        $(this).find("input.vendus").last().change();
        var url = "../../webapp/boutique/modules/production/miseenboutique/ajax.php";
        var formdata = new FormData($(this)[0]);
        var tableau = new Array();
        $(this).find("table tr input.recu").each(function(index, el) {
            var id = $(this).attr('data-id');
            
            var vendu = $(this).val();
            tableau.push(id+"-"+vendu);
        });
        formdata.append('tableau', tableau);

        formdata.append('action', "validerMiseenboutique");
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