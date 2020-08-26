$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#produits div.tab-pane:first").addClass('active')


    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".clients").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });


    $('input.i-checks').on('ifChanged', function(event){
        var url = "../../webapp/config/modules/master/roles/ajax.php";
        var $this = $(this);
        var etat = $(this).is(":checked");
        var employe_id = $(this).attr("employe_id");
        var role_id = $(this).attr("role_id");

        $.post(url, {action:"autoriser", etat:etat, employe_id:employe_id, role_id:role_id}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "L'employé a maintenant cet acces !");
                button.removeClass('btn-primary');
                button.addClass('btn-white');
            }else{
                Alerter.error('Erreur !', data.message);
                // $this.iCheck('toggle');
                // return false;
            }
        },"json");
    });


    $("tr select[name=boutique_id]").change(function(){
        var url = "../../webapp/config/modules/master/roles/ajax.php";
        var id = $(this).val()
        var employe_id = $(this).attr("employe_id");
        $.post(url, {action:"change-boutique", id:id, employe_id:employe_id}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "L'employé a maintenant cet acces !");
                button.removeClass('btn-primary');
                button.addClass('btn-white');
            }else{
                Alerter.error('Erreur !', data.message);
            }
        },"json");
    })


    $("tr select[name=entrepot_id]").change(function(){
        var url = "../../webapp/config/modules/master/roles/ajax.php";
        var id = $(this).val()
        var employe_id = $(this).attr("employe_id");
        $.post(url, {action:"change-entrepot", id:id, employe_id:employe_id}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "L'employé a maintenant cet acces !");
                button.removeClass('btn-primary');
                button.addClass('btn-white');
            }else{
                Alerter.error('Erreur !', data.message);
            }
        },"json");
    })

 //    $(this).masonry({
	// 	itemSelector: '.bloc',
	// });
})