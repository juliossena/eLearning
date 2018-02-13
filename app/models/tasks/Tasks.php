<?php

class Tasks {
    private $idTask;
    private $weightTask;
    private $percentagem;
    private $pointes;
    
    public function getIdTask() {
        return $this->idTask;
    }
    
    public function setIdTask($idTask) {
        $this->idTask = $idTask;
    }
    
    public function getWeightTask() {
        return $this->weightTask;
    }
    
    public function setWeightTask($weightTask) {
        $this->weightTask = $weightTask;
        
        if ($this->percentagem != null) {
            $this->pointes = $this->percentagem * $this->weightTask;
        }
    }
    
    public function getPercentagem() {
        return $this->percentagem;
    }
    
    public function setPercentagem($percentagem) {
        $this->percentagem = $percentagem;
        
        if ($this->weightTask != null) {
            $this->pointes = $this->percentagem * $this->weightTask;
        }
    }
    
    public function getPointes() {
        return $this->pointes;
    }
    
    public function setPointes($pointes) {
        $this->pointes = $pointes;
    }
    
    
}