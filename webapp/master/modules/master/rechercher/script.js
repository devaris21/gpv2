$(function(){

	$("form#rechercher").submit(function() {
		Loader.start();
		var url = "../../webapp/master/modules/master/rechercher/ajax.php";
		var formdata = new FormData($(this)[0]);
		formdata.append('action', "filtrer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			$(".box").html(data);
			Loader.stop();
		}, 'html')
		return false;
	});


})