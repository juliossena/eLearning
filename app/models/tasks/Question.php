<?php

$requiresQU[] = 'app/models/tasks/CompositionQuestion.php';

for ($i = 0 ; $i < count($requiresQU) ; $i ++) {
    while (!file_exists($requiresQU[$i])) {
        $requiresQU[$i] = '../' . $requiresQU[$i];
    }
    require_once $requiresQU[$i];
}

class Question {
    private $id;
    private $difficulty;
    private $sequence;
    private $compositionQuestion;
    
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getDifficulty() {
        return $this->difficulty;
    }
    
    public function setDifficulty($difficulty) {
        $this->difficulty = $difficulty;
    }
    
    public function getSequence() {
        return $this->sequence;
    }
    
    public function setSequence($sequence) {
        $this->sequence = $sequence;
    }
    
    
    
    public function getCompositionQuestion() {
        return $this->compositionQuestion;
    }
    
    public function setCompositionQuestion(ArrayObject $compositionQuestion) {
        $this->compositionQuestion = $compositionQuestion;
    }
    
}