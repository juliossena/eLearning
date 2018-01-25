<?php

$requiresCDAO[] = 'app/dao/DAO.php';
$requiresCDAO[] = 'app/models/exceptions/ObjectException.php';
$requiresCDAO[] = 'app/models/users/Permission.php';
$requiresCDAO[] = 'app/models/users/Users.php';
$requiresCDAO[] = 'app/models/classes/Classes.php';
$requiresCDAO[] = 'app/models/courses/Courses.php';
$requiresCDAO[] = 'app/models/courses/Files.php';

for ($i = 0 ; $i < count($requiresCDAO) ; $i ++) {
    while (!file_exists($requiresCDAO[$i])) {
        $requiresCDAO[$i] = '../' . $requiresCDAO[$i];
    }
    require_once $requiresCDAO[$i];
}


class ClassesDAO extends DAO{
    private $nextAutoIncrement = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'Class'"; 
    private $insertClass = "INSERT INTO Class (Id, Name, Description) VALUES ('%s', '%s', '%s')";
    private $insertClassUsers = "INSERT INTO UsersClass (IdClass, EmailUsers) VALUES %s";
    private $selectClasses = "SELECT C.Id as IdClass, C.Name as NameClass, C.Description, U.Id, U.Email, U.Name, U.Type FROM Class as C left join UsersClass as UC ON C.Id = UC.IdClass left join Users as U ON U.Email = UC.EmailUsers WHERE %s %s";
    private $update = "UPDATE Class SET Description = '%s', Name = '%s' WHERE Id LIKE '%s'";
    private $dropClass = "DELETE FROM Class WHERE Id LIKE '%s'";
    private $dropUserClass = "DELETE FROM UsersClass WHERE IdClass LIKE '%s'";
    
    public function insert($object) {
        if ($object instanceof Classes) { 
            $sql = sprintf($this->insertClass, $object->getId(), $object->getName(), $object->getDescription());
            if ($this->runQuery($sql)) {
                if ($object->getStudents() != null) {
                    $sql = sprintf($this->insertClassUsers, $this->multiplesInsertsClasses($object->getStudents(), $object));
                    return $this->runQuery($sql);
                } else {
                    return true;
                }
            } else {
                return $this->runQuery($sql);
            }
        } else {
            throw new ObjectException("it is necessary that the object be of type Classes");
        }
    }
    
    protected function multiplesInsertsClasses (ArrayObject $ojects, Classes $class) {
        $object = new ArrayObject();
        for ($i = 0 ; $i < $ojects->count() ; $i++) {
            $newArray = $ojects->offsetGet($i);
            if ($newArray instanceof Users) {
                $newObject[0] = $class->getId();
                $newObject[1] = $newArray->getEmail();
                
                $object->append($newObject);
            }
        }
        return $this->multiplesInserts($object);
    }
    
    public function update($object) {
        if ($object instanceof Classes) {
            if ($this->dropUserClass($object)) {
                $sql = sprintf($this->insertClassUsers, $this->multiplesInsertsClasses($object->getStudents(), $object));
                if ($this->runQuery($sql)) {
                    $sql = sprintf($this->update, $object->getDescription(), $object->getName(), $object->getId());
                    return $this->runQuery($sql);
                } 
            }
        } else {
            throw new ObjectException("it is necessary that the object be of type classes");
        }
        return false;
    }
    
    public function dropUserClass (Classes $class) {
        $sql = sprintf($this->dropUserClass, $class->getId());
        return $this->runQuery($sql);
    }
    
    public function drop($object) {
        if ($object instanceof Classes) {
            if ($this->dropUserClass($object)) {
                $sql = sprintf($this->dropClass, $object->getId());
                return $this->runQuery($sql);
            } else {
                return $this->runQuery($sql);
            }
        }
    }
    
    public function getNextAutoIncrement() {
        $vetor = $this->runSelect($this->nextAutoIncrement);
        return $vetor[0]['AUTO_INCREMENT'];
    }
    
    protected function getSelect() {
        return $this->selectClasses;
    }
    
    protected function insertClasses (ArrayObject $array, Classes $class) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newClass = $array->offsetGet($i);
            if ($newClass instanceof Classes) {
                if ($newClass->getId() == $class->getId()) {
                    return $array;
                }
            }
        }
        $array->append($class);
        return $array;
    }
    
    protected function insertStudent (ArrayObject $array, Users $user) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newUser = $array->offsetGet($i);
            if ($newUser instanceof Users) {
                if ($newUser->getEmail() == $user->getEmail()) {
                    return $array;
                }
            }
        }
        
        $array->append($user);
        return $array;
    }
    
    protected function InsertObject (ArrayObject $array, Classes $class) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newClass = $array->offsetGet($i);
            if ($newClass instanceof Classes) {
                if ($newClass->getId() == $class->getId()) {
                    $newClass->setStudents($this->insertStudent($newClass->getStudents(), $class->getStudents()->offsetGet(0)));
                    return $array;
                }
            }
        }
        $array->append($class);
        return $array;
    }
    
    
    public function getObjects($filter) {
        $objects = new ArrayObject();
        if ($filter instanceof FilterClasses) {
            $rs = $this->select($filter->getWhere(), $filter->getOrder());
            
            for ($i = 0 ; $i < count($rs) ; $i++) {
                $class = new Classes();
                $class->setId($rs[$i]['IdClass']);
                $class->setName($rs[$i]['NameClass']);
                $class->setDescription($rs[$i]['Description']);
                
                $students = new ArrayObject();
                $student = new Users();
                $student->setName($rs[$i]['Name']);
                $student->setId($rs[$i]['Id']);
                $student->setEmail($rs[$i]['Email']);
                $student->setType($rs[$i]['Type']);
                
                $students->append($student);
                
                $class->setStudents($students);
                
                $objects = $this->InsertObject($objects, $class);
            }
        }
        return $objects;
    }
    
    public function instance($array) {
        
    }
}