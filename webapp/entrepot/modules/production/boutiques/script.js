$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#produits div.tab-pane:first").addClass('active')


    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".clients").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });



	filtrer = function(){
		var url = "../../webapp/gestion/modules/master/commercial/ajax.php";
		var formdata = new FormData($("#formFiltrer")[0]);
		formdata.append('action', "filtrer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.reload();
		})
	}
	
})