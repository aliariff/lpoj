$(document).ready(function(){
	
	$(".ajax_solution").each(function(){
		score_temp=$(this).html().split();
				
		$.get("http://127.0.0.1/lpoj/index.php/refreshVerdict/"+score_temp[1],function(data){
			if(data!="Pending"){
				$("#"+score_temp[0]).html(data);
				 $(this).remove();
			}
		});			
	});
});
