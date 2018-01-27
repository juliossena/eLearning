<?php

class CompositionQuestion {
    private $sequence;
    private $type;
    private $text;
    private $link;
    
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
    
}