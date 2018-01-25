<?php

$requires = "";
$requires[] = 'app/dao/FilterSearch.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class FilterClasses extends FilterSearch {
    private $classes;
    private $order;
    private $administrator = false;
    
    public function __construct(Classes $class) {
        $this->classes = $class;
        $this->order = "";
    }
    
    public function setWhereAdm() {
        $this->administrator = true;
    }
    
    public function getWhere() {
        $pesquisa = null;
        
        if ($this->classes->getId() != null || $this->classes->getName() != null || $this->classes->getStudents() != null) {
            if ($this->classes->getId() != null) {
                $pesquisa = $this->getCampo($pesquisa) . sprintf(
                    "IdClass LIKE '%s'",
                    $this->classes->getId());
            }
        } else {
            $pesquisa = '1';
        }
        
        return $pesquisa;
    }
    
    public function setOrder($order) {
        $this->order = $order;
    }
    
    public function getOrder() {
        return $this->order;
    }
}