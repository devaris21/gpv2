$(function(){
	
    $('input.i-checks.boutique').on('ifChanged', function(event){
        var url = "../../webapp/config/modules/master/organisation/ajax.php";
        var $this = $(this);
        var etat = $(this).is(":checked");
        var boutique_id = $(this).attr("boutique_id");
        var employe_id = $(this).attr("employe_id");

        $.post(url, {action:"autoriserBoutique", etat:etat, boutique_id:boutique_id, employe_id:employe_id}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "L'employé a maintenant cette boutique !");
                button.removeClass('btn-primary');
                button.addClass('btn-white');
            }else{
                Alerter.error('Erreur !', data.message);
                // $this.iCheck('toggle');
                // return false;
            }
        },"json");
    });



    $('input.i-checks.entrepot').on('ifChanged', function(event){
        var url = "../../webapp/config/modules/master/organisation/ajax.php";
        var $this = $(this);
        var etat = $(this).is(":checked");
        var entrepot_id = $(this).attr("entrepot_id");
        var employe_id = $(this).attr("employe_id");

        $.post(url, {action:"autoriserEntrepot", etat:etat, entrepot_id:entrepot_id, employe_id:employe_id}, (data)=>{
            if (data.status) {
                Alerter.success('Reussite !', "L'employé a maintenant cette usine !");
                button.removeClass('btn-primary');
                button.addClass('btn-white');
            }else{
                Alerter.error('Erreur !', data.message);
                // $this.iCheck('toggle');
                // return false;
            }
        },"json");
    });

})