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


    $("#formMiseenboutique").submit(function(event) {
        Loader.start();
        var url = "../../webapp/gestion/modules/production/miseenboutique/ajax.php";
        var formdata = new FormData($(this)[0]);
        formdata.append('action', "miseenboutique");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            if (data.status) {
                window.location.reload();
            }else{
                Alerter.error('Erreur !', data.message);
            }
        }, 'json')
        return false;
    });


})