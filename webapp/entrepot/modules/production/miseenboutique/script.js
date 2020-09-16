$(function(){


    miseenboutique = function(){
        var formdata = new FormData($("#formMiseenboutique")[0]);
        tableau = new Array();
        $("#modal-miseenboutique tr input").each(function(index, el) {
            var id = $(this).attr('data-id');
            var format = $(this).attr('data-format');
            var val = $(this).val();
            if (val > 0) {
                var item = id+"-"+format+"-"+val;
                tableau.push(item);
            }      
        });
        formdata.append('listeproduits', tableau);

        alerty.confirm("Voulez-vous vraiment confirmer la demande de mise en boutique de ces produits ?", {
            title: "Confirmation de la demande",
            cancelLabel : "Non",
            okLabel : "OUI, Valider",
        }, function(){
            Loader.start();
            var url = "../../webapp/entrepot/modules/production/miseenboutique/ajax.php";
            formdata.append('action', "miseenboutique");
            $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                if (data.status) {
                    window.location.reload();
                }else{
                    Alerter.error('Erreur !', data.message);
                }
            }, 'json')
        })
    }


    accepter = function(id){
        alerty.confirm("Voulez-vous vraiment confirmer cette demande de mise en boutique ?", {
            title: "Confirmation de la demande",
            cancelLabel : "Non",
            okLabel : "OUI, Accepter",
        }, function(){
            session("miseenboutique_id", id);
            modal("#modal-acceptermiseenboutique"+id);
        })
    }


    
    annulerMiseenboutique = function(id){
        alerty.confirm("Voulez-vous vraiment annuler cette mise en boutique ?", {
            title: "Annuler la mise en boutique",
            cancelLabel : "Non",
            okLabel : "OUI, annuler",
        }, function(){
            var url = "../../webapp/entrepot/modules/production/miseenboutique/ajax.php";
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
        var url = "../../webapp/entrepot/modules/production/miseenboutique/ajax.php";
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