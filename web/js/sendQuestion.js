$(function(){
	charset = "ISO-8859-1";
	
	$('form#sendQuestion').submit(function(){
		$.ajax({
			type: 'POST',
			contentType: false,
    	    cache: false,
			processData:false,
			url: $('input[name=rotaQuestion]').val(),
			data:  new FormData(this), 
		}).done(function(e){
			$('#' + $('input[name=nameBody]').val()).html(e);
			setAceptNewQuestion(true);
		});
		return false;
	});
});