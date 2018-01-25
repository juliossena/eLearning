<?php
abstract class FilterSearch {
	public abstract function getWhere();
	public abstract function getOrder();
	
	public function getCampo($pesquisa) {
		if ($pesquisa == null) {
			return "";
		} else {
			return $pesquisa . " AND ";
		}
	}
}