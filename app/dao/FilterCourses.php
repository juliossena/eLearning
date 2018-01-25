<?php

$requires = "";
$requires[] = 'app/dao/FilterSearch.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class FilterCourses extends FilterSearch {
    private $courses;
    private $order;
    private $administrator = false;
    
    public function __construct(Courses $courses) {
        $this->courses = $courses;
        $this->order = "";
    }
    
    public function setWhereAdm() {
        $this->administrator = true;
    }
    
    public function getWhere() {
        $pesquisa = null;
        
        if ($this->courses->getId() != null || 
            $this->courses->getName() != null || 
            $this->courses->getStudents() != null || 
            $this->courses->getStudentsRegistered() != null ||
            $this->courses->getInstructor() != null ||
            $this->courses->getForuns() != null) {
            
                
            if ($this->courses->getForuns() != null && $this->courses->getForuns()->count() > 0) {
                $forum = $this->courses->getForuns()->offsetGet(0);
                if ($forum instanceof Forum) {
                    $pesquisa = $this->getCampo($pesquisa) . sprintf(
                        "F.Id LIKE '%s'",
                        $forum->getId());
                }
            } else if ($this->courses->getInstructor() != null && $this->courses->getInstructor()->getEmail() != null && $this->courses->getId() != null) {
                $pesquisa = $this->getCampo($pesquisa) . sprintf(
                    "C.Instructor LIKE '%s' AND C.Id LIKE '%s'",
                    $this->courses->getInstructor()->getEmail(),
                    $this->courses->getId());
            } else  if ($this->courses->getInstructor() != null && $this->courses->getInstructor()->getEmail() != null) {
                $pesquisa = $this->getCampo($pesquisa) . sprintf(
                    "C.Instructor LIKE '%s'",
                    $this->courses->getInstructor()->getEmail());
            } else if ($this->courses->getStudentsRegistered() != null && $this->courses->getStudentsRegistered()->count() > 0 && $this->courses->getId() != null) {
                $student = $this->courses->getStudentsRegistered()->offsetGet(0);
                if ($student instanceof Users) {
                    $pesquisa = $this->getCampo($pesquisa) . sprintf(
                        "CRU.EmailUser LIKE '%s' AND C.Id LIKE '%s'",
                        $student->getEmail(),
                        $this->courses->getId());
                }
            }else if ($this->courses->getStudentsRegistered() != null && $this->courses->getStudentsRegistered()->count() > 0) {
                $student = $this->courses->getStudentsRegistered()->offsetGet(0);
                if ($student instanceof Users) {
                    $pesquisa = $this->getCampo($pesquisa) . sprintf(
                        "CRU.EmailUser LIKE '%s'",
                        $student->getEmail());
                }
            }else if ($this->courses->getStudents() != null && $this->courses->getStudents()->count() > 0) {
                $student = $this->courses->getStudents()->offsetGet(0);
                if ($student instanceof Users) {
                    $pesquisa = $this->getCampo($pesquisa) . sprintf(
                        "(CAU.EmailUser LIKE '%s' OR UC.EmailUsers LIKE '%s') AND CRU.EmailUser IS NULL",
                        $student->getEmail(),
                        $student->getEmail());
                }
            }else if ($this->courses->getId() != null) {
                $pesquisa = $this->getCampo($pesquisa) . sprintf(
                    "C.Id LIKE '%s'",
                    $this->courses->getId());
            }
            
        } else {
            $pesquisa = '1';
        }
        
        return $pesquisa;
    }
    
    public function setOrder($order) {
        $this->order = $order;
    }
    
    public function getOrder() {
        return $this->order;
    }
}