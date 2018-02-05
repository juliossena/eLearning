
var numberQuestion = 0;

var idSelected = 1;
var lastQuestion = 1;
var aceptNewQuestion = true;



function setNumberQuestion ($number) {
	lastQuestion = $number;
}

function setIdSelected ($id) {
	idSelected = $id;
}

function setAceptNewQuestion ($sit) {
	aceptNewQuestion = $sit;
}


function insertNewQuestion($id, $idExercise) {
		$("li").attr('class', '');
		$("#" + $id).attr('class', 'selected');
		$("#body_" + idSelected).css('display', 'none');
		idSelected = $id;
		$("#body_" + $id).css('display', 'block');
		
		if ($("#" + $id).text() == '+ Nueva Pregunta') {
			if (aceptNewQuestion) {
				$.ajax({
					type: 'POST',
					url: '?site=coursesInstructor&subSite=setNewQuestion',
					data:  {
						"numberBody": lastQuestion,
						"idExercise": $idExercise
					} 
				}).done(function(e){
					$("#" + $id).text('Pregunta ' + lastQuestion);
					$("#bodyLateral").append(e);
					lastQuestion ++;
					$("#ulLateralMenu").append('<li id="' + lastQuestion + '" onclick="insertNewQuestion(' + lastQuestion + ', ' + $idExercise + ')">+ Nueva Pregunta</li>');
					setAceptNewQuestion(false);
				});
			} else {
				$valor = parseInt(idSelected) - 1;
				alert ('salve la pregunta ' + $valor + ' antes de crear una nueva');
			}
		}
		
}

function insertTextArea($id) {
	$('#' + $id).append('<div id="div_' + numberQuestion + '"><textarea name="question[]"></textarea><div onclick="deleteDivQuestion('+ "'div_" + numberQuestion + "'" +')" class="buttonDelete"></div></div>');
	numberQuestion++;
}

function insertTextAreaAlternative($id) {
	$('#TA' + $id).css('display', 'none');
	$('#IMG' + $id).css('display', 'none');
	$('#' + $id).append('<div id="altTextArea_' + numberAlternatives + '"><textarea name="alternative[]"></textarea></div>');
}

function deleteAlternative($id) {
	$('#' + $id).text('');
	$('#' + $id).css('display', 'none');
}

function deleteDivQuestion($id) {
	$('#' + $id).text('');
}

function setNumberQuestions($number) {
	numberQuestion = $number;
}



$(function(){
	
	$('form#enviarC').change(function(){
		$.ajax({
			type: 'POST',
			contentType: false,
    	    cache: false,
			processData:false,
			url: $('input[name=rota]').val(),
			data:  new FormData(this), 
		}).done(function(e){
			if (e != '') {
				$('#contentQuestion').append('<div id="div_' + numberQuestion + '"><textarea class="textAreaImg" name="question[]"> ' + e + '</textarea><img src="' + e + '"><div onclick="deleteDivQuestion('+ "'div_" + numberQuestion + "'" +')" class="buttonDelete"></div></div>');
				numberQuestion++;
			}
			$('input[name=imgQuestion]').val('');
		});
		return false;
	});
	
	
	$('form#enviarAlt').change(function(){
		$.ajax({
			type: 'POST',
			contentType: false,
    	    cache: false,
			processData:false,
			url: $('input[name=rota]').val(),
			data:  new FormData(this), 
		}).done(function(e){
			if (e != '') {
				$('#TAalt_' + numberAlt).css('display', 'none');
				$('#IMGalt_' + numberAlt).css('display', 'none');
				$('#alt_' + numberAlt).append('<textarea class="textAreaImg" name="alternative[]"> ' + e + '</textarea><img src="' + e + '">');
				numberQuestion++;
			}
			$('input[name=imgQuestion]').val('');
		});
		return false;
	});
	
		$('.tabs-menu ul li a').click(function(){
		    var a = $(this);
		    var active_tab_class = 'active-tab-menu';
		    
		    $('.tabs-menu ul li a').removeClass(active_tab_class);
		    a.addClass(active_tab_class);
		    
		    return false;
		});
	
	
		//Alterar Dados Aluno
		$("form#logar").submit(function(){
			$email = $('input[name=email]').val();
			$pass = $('input[name=pass]').val();
			if ($email == "") {
				alert ("Rellene todos los campos");
				$('input[name=email]').focus();
			} else if ($pass == "") {
				alert ("Rellene todos los campos");
				$('input[name=pass]').focus();
			} else {
				/*$.ajax({
					type: 'POST',
					url: 'index.php',
					data: {
						"email": $email,
						"pass": $pass
					}
				}).done(function(e){
					if (e == 'Usuario ou senha invalidos') {
						$("#detalhes").html(e);
					} else {
						$("#detalhes").html(e);
					}
				});*/
				return true;
			}
			return false;
		});
		
		
		$("form#createAdministrator").submit(function(){
			$email = $('input[name=emailUser]').val();
			$pass = $('input[name=passUser]').val();
			$pass2 = $('input[name=passUser2]').val();
			$name = $('input[name=nameUser]').val();
			$dateBirth = $('input[name=dateBirth]').val();
			$city = $('input[name=city]').val();
			$country = $('select[name=country]').val();
			if ($email == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=emailUser]').focus();
			} else if ($name == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameUser]').focus();
			} else if ($dateBirth == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=dateBirth]').focus();
			} else if ($pass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=passUser]').focus();
			} else if ($pass2 != $pass) {
				alert ("las contraseñas son diferentes");
				$('input[name=passUser2]').focus();
			} else {
				$.ajax({
					type: 'POST',
					url: 'index.php?site=administrators&subSite=createNewAdministrator',
					data: {
						"emailUser": $email,
						"passUser": $pass,
						"nameUser": $name,
						"dateBirth": $dateBirth,
						"city": $city,
						"country": $country
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		
		$("form#editAdministrator").submit(function(){
			$email = $('input[name=emailUser]').val();
			$pass = $('input[name=passUser]').val();
			$pass2 = $('input[name=passUser2]').val();
			$name = $('input[name=nameUser]').val();
			$dateBirth = $('input[name=dateBirth]').val();
			$city = $('input[name=city]').val();
			$country = $('select[name=country]').val();
			if ($email == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=emailUser]').focus();
			} else if ($name == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameUser]').focus();
			} else if ($dateBirth == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=dateBirth]').focus();
			} else if ($pass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=passUser]').focus();
			} else if ($pass2 != $pass) {
				alert ("las contraseñas son diferentes");
				$('input[name=passUser2]').focus();
			} else {
				$.ajax({
					type: 'POST',
					url: 'index.php?site=administrators&subSite=editAdmnistrator',
					data: {
						"emailUser": $email,
						"passUser": $pass,
						"nameUser": $name,
						"dateBirth": $dateBirth,
						"city": $city,
						"country": $country
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		
		$("form#createStudent").submit(function(){
			$email = $('input[name=emailUser]').val();
			$pass = $('input[name=passUser]').val();
			$pass2 = $('input[name=passUser2]').val();
			$name = $('input[name=nameUser]').val();
			$dateBirth = $('input[name=dateBirth]').val();
			$city = $('input[name=city]').val();
			$country = $('select[name=country]').val();
			if ($email == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=emailUser]').focus();
			} else if ($name == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameUser]').focus();
			} else if ($dateBirth == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=dateBirth]').focus();
			} else if ($pass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=passUser]').focus();
			} else if ($pass2 != $pass) {
				alert ("las contraseñas son diferentes");
				$('input[name=passUser2]').focus();
			} else {
				$.ajax({
					type: 'POST',
					url: 'index.php?site=students&subSite=createNewStudent',
					data: {
						"emailUser": $email,
						"passUser": $pass,
						"nameUser": $name,
						"dateBirth": $dateBirth,
						"city": $city,
						"country": $country
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		
		$("form#editStudent").submit(function(){
			$email = $('input[name=emailUser]').val();
			$pass = $('input[name=passUser]').val();
			$pass2 = $('input[name=passUser2]').val();
			$name = $('input[name=nameUser]').val();
			$dateBirth = $('input[name=dateBirth]').val();
			$city = $('input[name=city]').val();
			$country = $('select[name=country]').val();
			if ($email == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=emailUser]').focus();
			} else if ($name == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameUser]').focus();
			} else if ($pass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=passUser]').focus();
			} else if ($pass2 != $pass) {
				alert ("las contraseñas son diferentes");
				$('input[name=passUser2]').focus();
			} else {
				$.ajax({
					type: 'POST',
					url: 'index.php?site=students&subSite=editStudent',
					data: {
						"emailUser": $email,
						"passUser": $pass,
						"nameUser": $name,
						"dateBirth": $dateBirth,
						"city": $city,
						"country": $country
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#createInstructor").submit(function(){
			$email = $('input[name=emailUser]').val();
			$pass = $('input[name=passUser]').val();
			$pass2 = $('input[name=passUser2]').val();
			$name = $('input[name=nameUser]').val();
			$dateBirth = $('input[name=dateBirth]').val();
			$city = $('input[name=city]').val();
			$country = $('select[name=country]').val();
			if ($email == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=emailUser]').focus();
			} else if ($name == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameUser]').focus();
			} else if ($dateBirth == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=dateBirth]').focus();
			} else if ($pass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=passUser]').focus();
			} else if ($pass2 != $pass) {
				alert ("las contraseñas son diferentes");
				$('input[name=passUser2]').focus();
			} else {
				$.ajax({
					type: 'POST',
					url: 'index.php?site=instructors&subSite=createNewInstructor',
					data: {
						"emailUser": $email,
						"passUser": $pass,
						"nameUser": $name,
						"dateBirth": $dateBirth,
						"city": $city,
						"country": $country
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		
		$("form#editInstructor").submit(function(){
			$email = $('input[name=emailUser]').val();
			$pass = $('input[name=passUser]').val();
			$pass2 = $('input[name=passUser2]').val();
			$name = $('input[name=nameUser]').val();
			$dateBirth = $('input[name=dateBirth]').val();
			$city = $('input[name=city]').val();
			$country = $('select[name=country]').val();
			if ($email == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=emailUser]').focus();
			} else if ($name == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameUser]').focus();
			} else if ($dateBirth == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=dateBirth]').focus();
			} else if ($pass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=passUser]').focus();
			} else if ($pass2 != $pass) {
				alert ("las contraseñas son diferentes");
				$('input[name=passUser2]').focus();
			} else {
				$.ajax({
					type: 'POST',
					url: 'index.php?site=instructors&subSite=editInstructor',
					data: {
						"emailUser": $email,
						"passUser": $pass,
						"nameUser": $name,
						"dateBirth": $dateBirth,
						"city": $city,
						"country": $country
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#createClass").submit(function(){
			$nameClass = $('input[name=nameClass]').val();
			$students = $('#selectActive').val();
			$description = $('input[name=description]').val();
			if ($nameClass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else if ($students == "") {
				alert ("Seleccione un estudiante");
			} else {
				$.ajax({
					type: 'POST',
					url: 'index.php?site=classes&subSite=createNewClass',
					data: {
						"nameClass": $nameClass,
						"students": $students,
						"description": $description
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#editClass").submit(function(){
			$idClass = $('input[name=idClass]').val();
			$nameClass = $('input[name=nameClass]').val();
			$students = $('#selectActive').val();
			$description = $('input[name=description]').val();
			if ($nameClass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else if ($students == "") {
				alert ("Seleccione un estudiante");
			} else {
				$.ajax({
					type: 'POST',
					url: $('input[name=rota]').val(),
					data: {
						"nameClass": $nameClass,
						"students": $students,
						"description": $description,
						"idClass": $idClass
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		
		$("form#createCourse").submit(function(){
			$minimumTime = $('input[name=minimumTime]').val();
			$nameClass = $('input[name=nameClass]').val();
			$instructors = $('select[name=instructors]').val();
			$dateFinish = $('input[name=dateFinish]').val();
			$password = $('input[name=password]').val();
			$certifiedPercentage = $('input[name=certifiedPercentage]').val();
			$dateNew = $('input[name=dateNew]').val();
			$selectActiveClass = $('textarea[name=selectActiveClass]').val();
			$selectActive = $('textarea[name=selectActive]').val();
			if ($nameClass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else if ($instructors == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else if ($selectActive == "" && $selectActiveClass =="") {
				alert ("Seleccione un estudiante o clase");
			} else {
				$.ajax({
					type: 'POST',
					url: $('input[name=rota]').val(),
					data: {
						"nameClass": $nameClass,
						"instructors": $instructors,
						"dateFinish": $dateFinish,
						"password": $password,
						"certifiedPercentage": $certifiedPercentage,
						"dateNew": $dateNew,
						"selectActiveClass": $selectActiveClass,
						"selectActive": $selectActive,
						"minimumTime": $minimumTime
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#editCourse").submit(function(){
			$idCourse = $('input[name=idCourse]').val();
			$minimumTime = $('input[name=minimumTime]').val();
			$nameClass = $('input[name=nameClass]').val();
			$instructors = $('select[name=instructors]').val();
			$dateFinish = $('input[name=dateFinish]').val();
			$password = $('input[name=password]').val();
			$certifiedPercentage = $('input[name=certifiedPercentage]').val();
			$dateNew = $('input[name=dateNew]').val();
			$selectActiveClass = $('textarea[name=selectActiveClass]').val();
			$selectActive = $('textarea[name=selectActive]').val();
			if ($nameClass == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else if ($instructors == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else if ($selectActive == "" && $selectActiveClass =="") {
				alert ("Seleccione un estudiante o clase");
			} else {
				$.ajax({
					type: 'POST',
					url: $('input[name=rota]').val(),
					data: {
						"idCourse": $idCourse,
						"nameClass": $nameClass,
						"instructors": $instructors,
						"dateFinish": $dateFinish,
						"password": $password,
						"certifiedPercentage": $certifiedPercentage,
						"dateNew": $dateNew,
						"selectActiveClass": $selectActiveClass,
						"selectActive": $selectActive,
						"minimumTime": $minimumTime
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#createForum").submit(function(){
			$idCourse = $('input[name=idCourse]').val();
			$nameForum = $('input[name=nameForum]').val();
			$textArea = $('textarea[name=textArea]').val();
			if ($nameForum == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else if ($textArea == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameClass]').focus();
			} else  {
				$.ajax({
					type: 'POST',
					url: $('input[name=rota]').val(),
					data: {
						"idCourse": $idCourse,
						"nameForum": $nameForum,
						"textArea": $textArea
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#answerForum").submit(function(){
			$idForum = $('input[name=idForum]').val();
			$textArea = $('textarea[name=textArea]').val();
			if ($textArea == "") {
				alert ("Rellene todos los campos");
				$('input[name=textArea]').focus();
			} else  {
				$.ajax({
					type: 'POST',
					url: $('input[name=rota]').val(),
					data: {
						"idForum": $idForum,
						"textArea": $textArea
					}
				}).done(function(e){
					$("#result").html(e);
					$('#markItUp').val('');
				});
			}
			return false;
		});
		
		
		
		$("form#createExercise").submit(function(){
			$idCourse = $('input[name=idCourse]').val();
			$nameExercise = $('input[name=nameExercise]').val();
			$weightExercise = $('input[name=weightExercise]').val();
			$dateLimit = $('input[name=dateLimit]').val();
			if ($nameExercise == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameExercise]').focus();
			} else if ($weightExercise == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=weightExercise]').focus();
			} else if ($dateLimit == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=dateLimit]').focus();
			} else  {
				$.ajax({
					type: 'POST',
					url: $('input[name=rota]').val(),
					data: {
						"idCourse": $idCourse,
						"nameExercise": $nameExercise,
						"weightExercise": $weightExercise,
						"dateLimit": $dateLimit
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#editExercise").submit(function(){
			if ($('input[name=released]').prop('checked')) {
				$released = 1;
			} else {
				$released = 0;
			}
			$idExercise = $('input[name=idExercise]').val();
			$nameExercise = $('input[name=nameExercise]').val();
			$weightExercise = $('input[name=weightExercise]').val();
			$dateLimit = $('input[name=dateLimit]').val();
			$idTask = $('input[name=idTask]').val();
			if ($nameExercise == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=nameExercise]').focus();
			} else if ($weightExercise == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=weightExercise]').focus();
			} else if ($dateLimit == "") {
				alert ("Rellene todos los campos obligatorio");
				$('input[name=dateLimit]').focus();
			} else  {
				$.ajax({
					type: 'POST',
					url: $('input[name=rota]').val(),
					data: {
						"idExercise": $idExercise,
						"idTask": $idTask,
						"nameExercise": $nameExercise,
						"weightExercise": $weightExercise,
						"dateLimit": $dateLimit,
						"released": $released
					}
				}).done(function(e){
					$("#result").html(e);
				});
			}
			return false;
		});
		
		$("form#sendQuestionStudent").change(function(){
			$.ajax({
				type: 'POST',
				contentType: false,
	    	    cache: false,
				processData:false,
				url: $('input[name=rota]').val(),
				data:  new FormData(this),
			}).done(function(e){
			});
			return false;
		});
	
});