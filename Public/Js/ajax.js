$(function(){
	$('#person').click(function(){
		$.post("__APP__/Person/person",{},function(data){

			alert(data)
		});
 		
	})

})