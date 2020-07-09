$(function(){
	$(".tabs-container li:nth-child(1) a.nav-link").addClass('active')
	ele = $(".tabs-container.produits div.tab-pane:first").addClass('active')


	$("#search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".clients").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});



	filtrer = function(){
		var url = "../../webapp/gestion/modules/production/entrepots/ajax.php";
		var formdata = new FormData($("#formFiltrer")[0]);
		formdata.append('action', "filtrer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.reload();
		})
	}


	$("select[name=id]").change(function(){
		var url = "../../webapp/gestion/modules/production/entrepots/ajax.php";
		var id = $(this).val();
		var formdata = new FormData();
		formdata.append('id', id);
		formdata.append('action', "changer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.href = data.url;
		}, 'json')
	})

	$(".loading-data").removeClass("loading-data");
	
})