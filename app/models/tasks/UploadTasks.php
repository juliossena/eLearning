<?php

$requiresUT[] = 'app/models/tasks/Tasks.php';

for ($i = 0 ; $i < count($requiresUT) ; $i ++) {
    while (!file_exists($requiresUT[$i])) {
        $requiresUT[$i] = '../' . $requiresUT[$i];
    }
    require_once $requiresUT[$i];
}

class UploadTasks extends Tasks{
    private $idUploadTasks;
    private $name;
    private $dateFinish;
    private $daysDelay;
    private $dateSend;
    private $file;
    
    public function getIdUploadTasks() {
        return $this->idUploadTasks;
    }
    
    public function setIdUploadTasks($idUploadTasks) {
        $this->idUploadTasks = $idUploadTasks;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getDateFinish() {
        return $this->dateFinish;
    }
    
    public function setDateFinish(DateTime $dateFinish) {
        $this->dateFinish = $dateFinish;
    }
    
    public function getDaysDelay() {
        return $this->daysDelay;
    }
    
    public function setDaysDelay($daysDelay) {
        $this->daysDelay = $daysDelay;
    }
    
    public function getDateSend() {
        return $this->dateSend;
    }
    
    public function setDateSend(DateTime $dateSend) {
        $this->dateSend = $dateSend;
    }
    
    public function getFile() {
        return $this->file;
    }
    
    public function setFile(Files $file) {
        $this->file = $file;
    }
    
}