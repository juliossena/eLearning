<?php

class Forum {
    private $id;
    private $userCreate;
    private $dateCreate;
    private $answers;
    private $title;
    
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
    
    public function getDateCreate() {
             return $this->dateCreate;
    }
    
    public function setDateCreate(DateTime $dateCreate) {
             $this->dateCreate = $dateCreate;
    }
    
    public function getAnswers() {
        return $this->answers;
    }
    
    public function setAnswers(ArrayObject $answers) {
        $this->answers = $answers;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    
}