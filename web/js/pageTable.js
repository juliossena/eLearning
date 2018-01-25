var countLines = 0;
var limitLines = 0;
var pageCurrent = 0;

$(function(){
		
	
		countLines = $('#pageTable tbody tr').length;
		limitLines = $('#limitLines').val();
		pageCurrent = 0;
		
		$('#limitLines').change(function(){
			pageCurrent = 0;
			limitLines = $('#limitLines').val();
			hideAllRows();
			showRows();
			createPagination();
		});
		
		hideAllRows();
		
		showRows();
		
		createPagination();
		
});

//Função para carregar referente a página recebida
function changePage($numberPage) {
	pageCurrent = $numberPage;
	hideAllRows();
	showRows();
	createPagination();
}

//Função para exibir todas as linhas da página
function showRows() {
	var limit = ((pageCurrent * limitLines) + parseInt(limitLines));
	for ($i = (pageCurrent * limitLines) + parseInt(1) ; $i <= limit ; $i++) {
		$("tbody tr:nth-child("+ $i +")").show();
	}
}

//Função para esconder todas as linhas
function hideAllRows() {
	for ($i = 1 ; $i <= countLines ; $i++) {
		$("tbody tr:nth-child("+ $i +")").hide();
	}
}

//Função para criar os botões de paginação
function createPagination() {
	var countPages = Math.ceil(countLines / limitLines);
	var $html = "";
	if (countPages > 1) {
		if (pageCurrent == 0) {
			$html += '<button class="pageCurrent"><</button>';
		} else {
			previousPage = parseInt(pageCurrent) - 1;
			$html += '<button class="pagination" onclick="changePage(' + previousPage + ')"><</button>';
		}
		
		
		for ($i = 0 ; $i < countPages ; $i++) {
			var $page = parseInt($i) + 1;
			if ($i == pageCurrent) {
				$html += '<button class="pageCurrent">' + $page  + '</button>';
			} else {
				$html += '<button class="pagination" onclick="changePage(' + $i + ')">' + $page  + '</button>';
			}
		}
		
		pageCurrentNow = parseInt(pageCurrent) + 1;
		if (pageCurrentNow == countPages) {
			$nextPage = parseInt(pageCurrent) + 1;
			$html += '<button class="pageCurrent">></button>';
		} else {
			$nextPage = parseInt(pageCurrent) + 1;
			$html += '<button class="pagination" onclick="changePage(' + $nextPage + ')">></button>';
		}
	}
	$('#pagination').html($html);
}
