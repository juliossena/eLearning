<?php

require_once '../app/models/tasks/Tasks.php';

class Exercises extends Tasks{
    private $idExercise;
    private $questions;
    private $name;
    private $dateLimit;
    private $released;
    
    public function getIdExercise() {
        return $this->idExercise;
    }
    
    public function setIdExercise($idExercise) {
        $this->idExercise = $idExercise;
    }
    
    public function getQuestions() {
        return $this->questions;
    }
    
    public function setQuestions(ArrayObject $questions) {
        $this->questions = $questions;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    
    
    public function getDateLimit() {
        return $this->dateLimit;
    }
    
    public function setDateLimit(DateTime $dateLimit) {
        $this->dateLimit = $dateLimit;
    }
    
    public function getReleased() {
        return $this->released;
    }
    
    public function setReleased($released) {
        $this->released = $released;
    }
    
    
}