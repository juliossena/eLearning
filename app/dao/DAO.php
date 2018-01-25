<?php

$requires = "";
$requires[] = 'app/dao/Connection.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

abstract class DAO extends Connection{
	
	protected function select($where = '', $order = '') {
		$sql = sprintf($this->getSelect(), $where, $order);
		return $this->runSelect($sql);
	}
	
	protected function getField($string) {
		$ret = "NULL";
		if ($string != NULL && $string != "") {
			$ret= "'" . $string. "'";
		}
		
		return $ret;
	}
	
	protected function multiplesInserts(ArrayObject $objects) {
	    $sql = '';
	    for ($i = 0 ; $i < $objects->count() ; $i++) {
	        $sql .= "(";
	        $newObject = $objects->offsetGet($i);
	        for ($k = 0 ; $k < count($newObject) ; $k++) {
	            if ($k == count($newObject) - 1) {
	                $sql .= "'".$newObject[$k]."'";
	            } else {
	                $sql .= "'".$newObject[$k]."', ";
	            }
	        }
	            
	        if ($i == $objects->count() - 1) {
	            $sql .= ")";
	        } else {
	            $sql .= "), ";
	        }
	    }
	    
	    return $sql;
	}
	
	/***
	 * @return Retorna a string para fazer select no banco de dados
	 */
	protected abstract function getSelect();
	
	/***
	 * 
	 * @param Objeto $objeto recebe o objeto corrensponde e insere no BD
	 */
	public abstract function insert($objeto);
	
	/***
	 *
	 * @param Objeto $objeto recebe o objeto corrensponde e edita no BD
	 */
	public abstract function update($objeto);
	
	/***
	 *
	 * @param Objeto $objeto recebe o objeto corrensponde e deleta do BD
	 */
	public abstract function drop($objeto);
	
	/***
	 *
	 * @param FiltroBusca $filtro recebe um filtro, insere no where do select e retorna um array de objetos
	 */
	public abstract function getObjects($filtro);
	
	/***
	 *
	 * @param Objeto $objeto recebe o objeto corrensponde e deleta do BD
	 */
	public abstract function instance($array);
	
}