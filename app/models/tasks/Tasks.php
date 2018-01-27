<?php

class Tasks {
    private $idTask;
    private $weightTask;
    
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
    
    
}