$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#produits div.tab-pane:first").addClass('active')
	
	$("body").on("click", ".btnproduit", function(event) {
		var id = $(this).attr("data-id");
		$("td.produit-"+id).toggle(200);
		$("th.produit-"+id).toggle(200);
		$("button[data-id="+id+"]").toggleClass('btn-success');
	});



	filtrer = function(){
		var url = "../../webapp/gestion/modules/ventes/rapportvente/ajax.php";
		var formdata = new FormData($("#formFiltrer")[0]);
		formdata.append('action', "filtrer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.href = data.url;
		}, 'json')
	}

})