<?php

$requiresUD[] = 'app/dao/DAO.php';
$requiresUD[] = 'app/models/exceptions/ObjectException.php';
$requiresUD[] = 'app/models/users/Permission.php';
$requiresUD[] = 'app/models/users/Users.php';
$requiresUD[] = 'app/models/classes/Classes.php';
$requiresUD[] = 'app/models/courses/Courses.php';
$requiresUD[] = 'app/models/courses/Files.php';

for ($i = 0 ; $i < count($requiresUD) ; $i ++) {
    while (!file_exists($requiresUD[$i])) {
        $requiresUD[$i] = '../' . $requiresUD[$i];
    }
    require_once $requiresUD[$i];
}


class UsersDAO extends DAO{
    private $insertUser = "INSERT INTO Users (Email, Name, Password, DateBirth, City, Country, Type) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    private $insertPermission = "INSERT INTO UsersPermission (IdPermission, EmailUsers) VALUES %s";
    private $select = "SELECT U.Id, U.Email, U.Name, U.Password, U.DateBirth, U.City, U.Country, U.Type, UC.IdClass, UP.IdPermission, P.IsMenu, P.Menu, P.Link FROM Users as U left join UsersClass as UC ON U.Email = UC.EmailUsers left join UsersPermission as UP ON U.Email = UP.EmailUsers left join Permission as P ON P.id = UP.IdPermission WHERE %s %s";
    private $update = "UPDATE Users SET Name = '%s', Password = '%s', DateBirth = '%s', City = '%s', Country = '%s' WHERE Email = '%s'";
    private $dropUser = "DELETE FROM Users WHERE Email LIKE '%s'";
    private $dropPermission = "DELETE FROM UsersPermission WHERE EmailUsers LIKE '%s'";
    
    public function insert($object) {
        if ($object instanceof Users) { 
            $sql = sprintf($this->insertUser, $object->getEmail(), $object->getName(), $object->getPassword(), $object->getDateBirth()->format('Y-m-d'), $object->getCity(), $object->getCountry(), $object->getType());
            if ($this->runQuery($sql)) {
                if ($object->getPermissions() != null) {
                    $sql = sprintf($this->insertPermission, $this->multiplesInsertsPermission($object->getPermissions(), $object));
                    return $this->runQuery($sql);
                } else {
                    return true;
                }
            } else {
                return $this->runQuery($sql);
            }
        } else {
            throw new ObjectException("it is necessary that the object be of type user");
        }
    }
    
    protected function multiplesInsertsPermission (ArrayObject $ojects, Users $user) {
        $object = new ArrayObject();
        for ($i = 0 ; $i < $ojects->count() ; $i++) {
            $newArray = $ojects->offsetGet($i);
            if ($newArray instanceof Permission) {
                $newObject[0] = $newArray->getId();
                $newObject[1] = $user->getEmail();
                
                $object->append($newObject);
            }
        }
        return $this->multiplesInserts($object);
    }
    
    public function insertObjet($object) {
        return $this->insert($object);
    }
    
    public function update($object) {
        if ($object instanceof Users) {
            $sql = sprintf($this->update, $object->getName(), $object->getPassword(), $object->getDateBirth()->format('Y-m-d'), $object->getCity(), $object->getCountry(), $object->getEmail());
            return $this->runQuery($sql);
        } else {
            throw new ObjectException("it is necessary that the object be of type user");
        }
    }
    
    public function drop($object) {
        if ($object instanceof Users) {
            $sql = sprintf($this->dropPermission, $object->getEmail());
            if ($this->runQuery($sql)) {
                $sql = sprintf($this->dropUser, $object->getEmail());
                return $this->runQuery($sql);
            } else {
                return $this->runQuery($sql);
            }
        }
    }
    
    protected function getSelect() {
        return $this->select;
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
    
    protected function insertPermission (ArrayObject $array, Permission $permission) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newPermission = $array->offsetGet($i);
            if ($newPermission instanceof Permission) {
                if ($newPermission->getId() == $permission->getId()) {
                    return $array;
                }
            }
        }
        
        $array->append($permission);
        return $array;
    }
    
    protected function InsertObject (ArrayObject $array, Users $users) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newUser = $array->offsetGet($i);
            if ($newUser instanceof Users) {
                if ($newUser->getEmail() == $users->getEmail()) {
                    $newUser->setPermissions($this->insertPermission($newUser->getPermissions(), $users->getPermissions()->offsetGet(0)));
                    $newUser->setClasses($this->insertClasses($newUser->getClasses(), $users->getClasses()->offsetGet(0)));
                    $array->offsetSet($i, $newUser);
                    return $array;
                }
            }
        }
        $array->append($users);
        return $array;
    }
    
    
    public function getObjects($filter) {
        $objects = new ArrayObject();
        if ($filter instanceof FilterUsers) {
            $rs = $this->select($filter->getWhere(), $filter->getOrder());
            
            for ($i = 0 ; $i < count($rs) ; $i++){
                $user = new Users();
                $classe = new Classes();
                $permission = new Permission();
                
                $classe->setId($rs[$i]['IdClass']);
                $classes = new ArrayObject();
                $classes->append($classe);
                
                $permission->setId($rs[$i]['IdPermission']);
                $permission->setIsMenu($rs[$i]['IsMenu']);
                $permission->setMenu($rs[$i]['Menu']);
                $permission->setLink($rs[$i]['Link']);
                $permissions = new ArrayObject();
                $permissions->append($permission);
                
                $user->setClasses($classes);
                $user->setId($rs[$i]['Id']);
                $user->setEmail($rs[$i]['Email']);
                $user->setName($rs[$i]['Name']);
                $user->setPassword($rs[$i]['Password']);
                $user->setDateBirth(new DateTime($rs[$i]['DateBirth']));
                $user->setCity($rs[$i]['City']);
                $user->setCountry($rs[$i]['Country']);
                $user->setPermissions($permissions);
                $user->setType($rs[$i]['Type']);
                
                $objects = $this->InsertObject($objects, $user);
            }
        }
        return $objects;
    }
    
    public function instance($array) {
        
    }
}