var idSelected = 1;
var lastQuestion = 2;



function insertNewQuestion($id) {
	$("li").attr('class', '');
	$("#" + $id).attr('class', 'selected');
	$("#body_" + idSelected).css('display', 'none');
	
	idSelected = $id;
	$("#body_" + $id).css('display', 'block');
	
	if ($("#" + $id).text() == '+ Nueva Pregunta') {
		
		$("#" + $id).text('Pregunta ' + lastQuestion);
		lastQuestion ++;
		$("#bodyLateral").append('<div style="display: none;" id="body_' + lastQuestion + '">Pregunta ' + lastQuestion + '</div>');
		$("#ulLateralMenu").append('<li id="' + lastQuestion + '" onclick="insertNewQuestion(' + lastQuestion + ')">+ Nueva Pregunta</li>');
	}
}