$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#produits div.tab-pane:first").addClass('active')


    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".clients").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });



    $("input.ressource").change(function(){
        var url = "../../webapp/config/modules/master/production/ajax.php";
        var id = $(this).attr("id")
        var name = $(this).attr("name")
        var val = $(this).val()
        $.post(url, {action:"changement", name:name, id:id, val:val}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "Modification prise en compte avec succès !");
            }else{
                Alerter.error('Erreur !', data.message);
            }
        },"json");
    })

    

})