<?php

class Courses {
    private $id;
    private $name;
    private $description;
    private $dateNew;
    private $dateFinish;
    private $information;
    private $instructor;
    private $password;
    private $certifiedPercentage;
    private $minimumTime;
    private $files;
    private $foruns;
    private $tasks;
    private $students;
    private $studentsRegistered;
    private $classes;
    private $news;
    private $exercises;
    
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
    
    public function getDescription() {
             return $this->description;
    }
    
    public function setDescription($description) {
             $this->description = $description;
    }
    
    public function getDateNew() {
             return $this->dateNew;
    }
    
    public function setDateNew(DateTime $dateNew) {
             $this->dateNew = $dateNew;
    }
    
    public function getDateFinish() {
             return $this->dateFinish;
    }
    
    public function setDateFinish(DateTime $dateFinish) {
             $this->dateFinish = $dateFinish;
    }
    
    public function getInformation() {
             return $this->information;
    }
    
    public function setInformation($information) {
             $this->information = $information;
    }
    
    public function getInstructor() {
             return $this->instructor;
    }
    
    public function setInstructor(Users $instructor) {
             $this->instructor = $instructor;
    }
    
    public function getPassword() {
             return $this->password;
    }
    
    public function setPassword($password) {
             $this->password = $password;
    }
    
    public function getCertifiedPercentage() {
             return $this->certifiedPercentage;
    }
    
    public function setCertifiedPercentage($certifiedPercentage) {
             $this->certifiedPercentage = $certifiedPercentage;
    }
    
    public function getMinimumTime() {
             return $this->minimumTime;
    }
    
    public function setMinimumTime(DateTime $minimumTime) {
             $this->minimumTime = $minimumTime;
    }
    
    public function getFiles() {
             return $this->files;
    }
    
    public function setFiles(ArrayObject $files) {
             $this->files = $files;
    }
    
    public function getForuns() {
             return $this->foruns;
    }
    
    public function setForuns(ArrayObject $foruns) {
             $this->foruns = $foruns;
    }
    
    public function getTasks() {
             return $this->tasks;
    }
    
    public function setTasks(ArrayObject $tasks) {
             $this->tasks = $tasks;
    }
    
    public function getStudents() {
             return $this->students;
    }
    
    public function setStudents(ArrayObject $students) {
             $this->students = $students;
    }
    
    public function getStudentsRegistered() {
             return $this->studentsRegistered;
    }
    
    public function setStudentsRegistered(ArrayObject $studentsRegistered) {
             $this->studentsRegistered = $studentsRegistered;
    }
    
    public function getClasses() {
             return $this->classes;
    }
    
    public function setClasses(ArrayObject $classes) {
             $this->classes = $classes;
    }
    
    public function getNews() {
             return $this->news;
    }
    
    public function setNews(ArrayObject $news) {
             $this->news = $news;
    }
    
    public function getExercises() {
        return $this->exercises;
    }
    
    public function setExercises(ArrayObject $exercises) {
        $this->exercises = $exercises;
    }
    
    
    
    
    
}