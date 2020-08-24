$(function(){

    $("#top-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table.table-prospection tr:not(.no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    
    annulerProspection = function(id){
        alerty.confirm("Voulez-vous vraiment annuler cette prospection ?", {
            title: "Annuler la prospection",
            cancelLabel : "Non",
            okLabel : "OUI, annuler",
        }, function(){
            var url = "../../webapp/manager/modules/ventes/prospections/ajax.php";
            alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
                title: 'Récupération du mot de passe !',
                inputType : "password",
                cancelLabel : "Annuler",
                okLabel : "Valider"
            }, function(password){
                Loader.start();
                $.post(url, {action:"annulerProspection", id:id, password:password}, (data)=>{
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
        var url = "../../webapp/manager/modules/ventes/prospections/ajax.php";
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
        $(this).find("input.vendus").last().change();
        var url = "../../webapp/manager/modules/ventes/prospections/ajax.php";
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