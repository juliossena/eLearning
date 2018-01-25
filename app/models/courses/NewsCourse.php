<?php

class NewsCourse {
    private $id;
    private $user;
    private $type;
    private $change;
    private $timeChange;
    
    public function getId() {
             return $this->id;
    }
    
    public function setId($id) {
             $this->id = $id;
    }
    
    public function getUser() {
             return $this->user;
    }
    
    public function setUser(Users $user) {
             $this->user = $user;
    }
    
    public function getType() {
             return $this->type;
    }
    
    public function setType($type) {
             $this->type = $type;
    }
    
    public function getChange() {
             return $this->change;
    }
    
    public function setChange($change) {
             $this->change = $change;
    }
    
    public function getTimeChange() {
             return $this->timeChange;
    }
    
    public function setTimeChange(DateTime $timeChange) {
             $this->timeChange = $timeChange;
    }
    
    
}