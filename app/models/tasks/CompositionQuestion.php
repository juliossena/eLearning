<?php

class CompositionQuestion {
    private $sequence;
    private $type;
    private $text;
    private $link;
    private $answer;
    
    /*
    Type = 1 -> questão tipo text
    Type = 2 -> questao tipo link
    Type = 3 -> alternativa tipo text
    Type = 4 -> alternativa tipo link
    */
    public function getSequence() {
        return $this->sequence;
    }
    
    public function setSequence($sequence) {
        $this->sequence = $sequence;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function setText($text) {
        $this->text = $text;
    }
    
    public function getLink() {
        return $this->link;
    }
    
    public function setLink($link) {
        $this->link = $link;
    }
    
    public function getAnswer() {
        return $this->answer;
    }
    
    public function setAnswer($answer) {
        $this->answer = $answer;
    }
    
    
    
}