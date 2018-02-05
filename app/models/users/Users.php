<?php

class Users {
    private $id;
    private $email;
    private $name;
    private $password;
    private $dateBirth;
    private $city;
    private $country;
    private $type;
    private $permissions;
    private $classes;
    private $courses;
    private $timeElapseCourse;
    private $exercises;
    
    public function getId() {
             return $this->id;
    }
    
    public function setId($id) {
             $this->id = $id;
    }
    
    
    
    public function getEmail() {
             return $this->email;
    }
    
    public function setEmail($email) {
             $this->email = $email;
    }
    
    public function getName() {
             return $this->name;
    }
    
    public function setName($name) {
             $this->name = $name;
    }
    
    public function getPassword() {
             return $this->password;
    }
    
    public function setPassword($password) {
             $this->password = $password;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function insertPermission(Permission $permission) {
        $this->permissions->append($permission);
    }
    
    public function getPermissions() {
             return $this->permissions;
    }
    
    public function setPermissions(ArrayObject $permissions) {
             $this->permissions = $permissions;
    }
    
    public function insertClass(Classes $classes) {
        $this->classes->append($classes);
    }
    
    public function getClasses() {
             return $this->classes;
    }
    
    public function setClasses(ArrayObject $classes) {
             $this->classes = $classes;
    }
    
    public function insertCourse (Courses $course) {
        $this->courses->append($course);
    }
    
    public function getCourses() {
             return $this->courses;
    }
    
    public function setCourses(ArrayObject $courses) {
             $this->courses = $courses;
    }
    
    public function getDateBirth() {
             return $this->dateBirth;
    }
    
    public function setDateBirth(DateTime $dateBirth) {
             $this->dateBirth = $dateBirth;
    }
    
    public function getCity() {
             return $this->city;
    }
    
    public function setCity($city) {
             $this->city = $city;
    }
    
    public function getCountry() {
             return $this->country;
    }
    
    public function setCountry($country) {
             $this->country = $country;
    }
    
    public function getTimeElapseCourse() {
             return $this->timeElapseCourse;
    }
    
    public function setTimeElapseCourse(DateTime $timeElapseCourse) {
             $this->timeElapseCourse = $timeElapseCourse;
    }
    
    public function getExercises() {
        return $this->exercises;
    }
    
    public function setExercises(ArrayObject $exercises) {
        $this->exercises = $exercises;
    }
    
    
    
    
    
    
    public function possuiPermissao($codPermissao) {
        for ($i = 0 ; $i < $this->permissions->count() ; $i++) {
            $permission = $this->permissions->offsetGet($i);
            if ($permission instanceof Permission) {
                if ($codPermissao == $permission->getId()) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function setPermissionsAdministrator() {
        $permissions = new ArrayObject();
        $permission = new Permission();
        $permission->setId(1);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(2);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(3);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(4);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(5);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(6);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(7);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(8);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(9);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(10);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(11);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(12);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(13);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(14);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(15);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(16);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(17);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(18);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(19);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(20);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(21);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(22);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(23);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(24);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(25);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(26);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(27);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(28);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(29);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(30);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(31);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(32);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(33);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(34);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(35);
        $permissions->append($permission);
        
        $this->permissions = $permissions;
    }
    
    public function setPermissionsStudent() {
        $permissions = new ArrayObject();
        $permission = new Permission();
        $permission->setId(36);
        $permissions->append($permission);
        
        $this->permissions = $permissions;
    }
    
    public function setPermissionsInstructor() {
        $permissions = new ArrayObject();
        
        $permission = new Permission();
        $permission->setId(37);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(38);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(39);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(40);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(41);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(42);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(43);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(44);
        $permissions->append($permission);
        
        $permission = new Permission();
        $permission->setId(45);
        $permissions->append($permission);
        
        
        $this->permissions = $permissions;
    }
}