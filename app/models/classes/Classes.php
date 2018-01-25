<?php

class Classes {
    private $id;
    private $name;
    private $description;
    private $students;
    
    public function getId() {
             return $this->id;
    }
    
    public function setId($id) {
             $this->id = $id;
    }
    
    public function getName() {
             return $this->name;
    }
    
    public function setName($name) {
             $this->name = $name;
    }
    
    public function getStudents() {
             return $this->students;
    }
    
    public function setStudents(ArrayObject $students) {
             $this->students = $students;
    }
    
    public function getDescription() {
             return $this->description;
    }
    
    public function setDescription($description) {
             $this->description = $description;
    }
    
    
    
}