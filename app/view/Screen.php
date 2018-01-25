<?php

require_once '../app/view/CabecalhoPadrao.php';
require_once '../app/view/View.php';


abstract class Screen implements View {
	private $cabecalho;
	
	public function getCabecalho() {
		$this->cabecalho = new CabecalhoPadrao();
		return $this->cabecalho->getCabecalho();
	}
	
	public abstract function getCorpo();
	
	public function getView() {
		return '<html>
					<head>
						'. $this->getCabecalho().'
					</head>
					<body id="body">
						'. $this->getCorpo().'
					</body>
				</html>';
	}
}