$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#produits div.tab-pane:first").addClass('active')

    
    $("input.maj").change(function(){
        var url = "../../webapp/config/modules/master/adminentrepot/ajax.php";
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