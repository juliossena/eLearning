<?php

class Permission {
    private $id;
    private $name;
    private $description;
    private $isMenu;
    private $menu;
    private $link;
    
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
    
    public function getIsMenu() {
             return $this->isMenu;
    }
    
    public function setIsMenu($isMenu) {
             $this->isMenu = $isMenu;
    }
    
    public function getMenu() {
             return $this->menu;
    }
    
    public function setMenu($menu) {
             $this->menu = $menu;
    }
    
    public function getLink() {
             return $this->link;
    }
    
    public function setLink($link) {
             $this->link = $link;
    }
    
    
    
}