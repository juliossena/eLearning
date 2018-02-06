<?php

class Tasks {
    private $idTask;
    private $weightTask;
    private $percentagem;
    
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
    }
    
    public function getPercentagem() {
        return $this->percentagem;
    }
    
    public function setPercentagem($percentagem) {
        $this->percentagem = $percentagem;
    }
    
    
}