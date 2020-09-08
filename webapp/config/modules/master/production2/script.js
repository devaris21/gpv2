$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#produits div.tab-pane:first").addClass('active')


    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".clients").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });


    $(".formExigence").submit(function(event) {
        Loader.start();
        var url = "../../webapp/config/modules/master/production2/ajax.php";
        var formdata = new FormData($(this)[0]);
        formdata.append('action', "exigence");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            if (data.status) {
                window.location.reload();
            }else{
                Alerter.error('Erreur !', data.message);
            }
        }, 'json')
        return false;
    });



    $(".produits input").change(function(){
        var url = "../../webapp/config/modules/master/production2/ajax.php";
        var id = $(this).attr("id")
        var name = $(this).attr("name")
        var val = $(this).val()
        $.post(url, {action:"changement", id:id, name:name, val:val}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "Modification prise en compte avec succès !");
            }else{
                Alerter.error('Erreur !', data.message);
            }
        },"json");
    })



    $(".price input").change(function(){
        var url = "../../webapp/config/modules/master/production2/ajax.php";
        var id = $(this).attr("id")
        var name = $(this).attr("name")
        var val = $(this).val()
        $.post(url, {action:"changementPrice", id:id, name:name, val:val}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "Modification prise en compte avec succès !");
            }else{
                Alerter.error('Erreur !', data.message);
            }
        },"json");
    })


 //    $(this).masonry({
	// 	itemSelector: '.bloc',
	// });
})