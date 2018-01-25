<?php

class Answer {
    private $id;
    private $userCreate;
    private $answer;
    private $dateCreate;
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getUserCreate() {
        return $this->userCreate;
    }
    
    public function setUserCreate(Users $userCreate) {
        $this->userCreate = $userCreate;
    }
    
    public function getAnswer() {
        return $this->answer;
    }
    
    public function setAnswer($answer) {
        $this->answer = $answer;
    }
    
    public function getDateCreate() {
        return $this->dateCreate;
    }
    
    public function setDateCreate(DateTime $dateCreate) {
        $this->dateCreate = $dateCreate;
    }
    
    
}