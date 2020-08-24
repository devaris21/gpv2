$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $("#produits div.tab-pane:first").addClass('active')
	
	$("body").on("click", ".btnproduit", function(event) {
		var id = $(this).attr("data-id");
		$("td.produit-"+id).toggle(200);
		$("th.produit-"+id).toggle(200);
		$("button[data-id="+id+"]").toggleClass('btn-success');
	});

})