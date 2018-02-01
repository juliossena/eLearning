var numberAlternatives = 0;
var numberAlt = 0;

function setAlternativeFalse ($id) {
	$('#' + $id).attr('class', 'divAlternatives');
}

function setAlternativeTrue ($id) {
	$('#' + $id).attr('class', 'divAlternativesTrue');
}

function insertNewAlternative ($id, $idBody) {
	if ($id == numberAlternatives) {
		$('#alt_' + $id).text('');
		$('#alt_' + $id).append('<div class="radioTrue"><input type="radio" name="resp['+ numberAlternatives +']" id="respC'+ numberAlternatives +'" value="0" checked><label onclick="setAlternativeFalse('+ "'alt_" + $id + "'" +')" for="respC'+ numberAlternatives +'"><span></span></label><input id="respE'+ numberAlternatives +'" type="radio" name="resp['+ numberAlternatives +']" value="1"><label onclick="setAlternativeTrue('+ "'alt_" + $id + "'" +')" for="respE'+ numberAlternatives +'"><span class="true"></span></label></div><div id="alt_' + numberAlternatives + '"></div><img id="TAalt_' + numberAlternatives + '" onclick="insertTextAreaAlternative(' + "'alt_" + numberAlternatives + "'" + ')" class="icon" src="imagens/textArea.png"><label id="IMGalt_' + numberAlternatives + '" onclick="setNumberAlt('+ numberAlternatives + ')" for="imgAlternative" class="insertImg"></label><div onclick="deleteAlternative(' + "'alt_" + $id + "'" + ')" class="deleteAlternative"></div>');
		$('#alt_' + $id).attr('class', 'divAlternatives');
		numberAlternatives ++;
		$("#body_" + $idBody).append('<div id="alt_' + numberAlternatives + '" onclick="insertNewAlternative(' + "'" + numberAlternatives + "', " + $idBody + ')" class="divNewAlternatives">Nueva Alternativa</div>');
	}
	
}

function setNumberAlt($number) {
	numberAlt = $number;
}