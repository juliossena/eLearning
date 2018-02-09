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

class FilterUsers extends FilterSearch {
    private $users;
    private $order;
    private $administrator = false;
    
    public function __construct(Users $users) {
        $this->users = $users;
        $this->order = "";
    }
    
    public function setWhereAdm() {
        $this->administrator = true;
    }
    
    public function getWhere() {
        $pesquisa = null;
        
        if ($this->users != null) {
            if ($this->users instanceof Users) {
                if ($this->users->getEmail() == null && $this->users->getUploadTasks() != null && $this->users->getUploadTasks()->count() > 0) {
                    $uploadTasks = $this->users->getUploadTasks()->offsetGet(0);
                    if ($uploadTasks instanceof UploadTasks) {
                        $pesquisa = $this->getCampo($pesquisa) . sprintf(
                            "UTU.IdUploadTasks LIKE '%s'",
                            $uploadTasks->getIdUploadTasks());
                    }
                }else if ($this->users->getEmail() != null && $this->users->getUploadTasks() != null && $this->users->getUploadTasks()->count() > 0) {
                    $uploadTasks = $this->users->getUploadTasks()->offsetGet(0);
                    if ($uploadTasks instanceof UploadTasks) {
                        $pesquisa = $this->getCampo($pesquisa) . sprintf(
                            "Email LIKE '%s' AND U.Password LIKE '%s' AND UTU.IdUploadTasks LIKE '%s'",
                            $this->users->getEmail(),
                            $this->users->getPassword(),
                            $uploadTasks->getIdUploadTasks());
                    }
                } else if ($this->users->getEmail() != null && $this->users->getExercises() != null && $this->users->getExercises()->count() > 0) {
                    $exercise = $this->users->getExercises()->offsetGet(0);
                    if ($exercise instanceof Exercises) {
                        $pesquisa = $this->getCampo($pesquisa) . sprintf(
                            "Email LIKE '%s' AND Password LIKE '%s' AND UCO.IdExercises LIKE '%s'",
                            $this->users->getEmail(),
                            $this->users->getPassword(),
                            $exercise->getIdExercise());
                    }
                } else if ($this->users->getExercises() != null && $this->users->getExercises()->count() > 0) {
                    $exercise = $this->users->getExercises()->offsetGet(0);
                    if ($exercise instanceof Exercises) {
                        $pesquisa = $this->getCampo($pesquisa) . sprintf(
                            "EX.Id LIKE '%s'",
                            $exercise->getIdExercise());
                    }
                } else if ($this->users->getEmail() != null && $this->users->getPassword() != null) {
                    $pesquisa = $this->getCampo($pesquisa) . sprintf(
                        "Email LIKE '%s' AND Password LIKE '%s'",
                        $this->users->getEmail(),
                        $this->users->getPassword());
                } else if ($this->users->getType() != null) {
                    $pesquisa = $this->getCampo($pesquisa) . sprintf(
                        "Type LIKE '%s'",
                        $this->users->getType());
                } else if ($this->administrator && $this->users->getEmail() != null) {
                    $pesquisa = $this->getCampo($pesquisa) . sprintf(
                        "Email LIKE '%s'",
                        $this->users->getEmail());
                }
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