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
    private $insertComposition = "INSERT INTO UserComposition (EmailUser, IdQuestion, IdExercises, SequenceComposition) VALUES ('%s', '%s', '%s', '%s')";
    private $select = "SELECT U.Id, U.Email, U.Name, U.Password, U.DateBirth, U.City, U.Country, U.Type, 
                        UC.IdClass, UP.IdPermission, P.IsMenu, P.Menu, P.Link,
                        UCO.IdQuestion as IdQuestionUser, UCO.IdExercises as IdExercisesUser, UCO.SequenceComposition as SequenceCompositionUser
                        FROM Users as U left join UsersClass as UC ON U.Email = UC.EmailUsers 
                        left join UsersPermission as UP ON U.Email = UP.EmailUsers 
                        left join UserComposition as UCO ON U.Email = U.Email
                        left join Permission as P ON P.id = UP.IdPermission WHERE %s %s";
    private $update = "UPDATE Users SET Name = '%s', Password = '%s', DateBirth = '%s', City = '%s', Country = '%s' WHERE Email = '%s'";
    private $updateCompostion = "UPDATE UserComposition SET SequenceComposition = '%s' WHERE EmailUser LIKE '%s' AND IdQuestion LIKE '%s' AND IdExercises LIKE '%s'";
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
    
    public function InsertCompositionUser (Exercises $exercise, Users $user) {
        for ($i = 0 ; $i < $exercise->getQuestions()->count() ; $i++) {
            $question = $exercise->getQuestions()->offsetGet($i);
            if ($question instanceof Question) {
                for ($k = 0 ; $k < $question->getCompositionQuestion()->count() ; $k++) {
                    $composition = $question->getCompositionQuestion()->offsetGet($k);
                    if ($composition instanceof CompositionQuestion) {
                        $sql = sprintf($this->insertComposition, $user->getEmail(), $question->getId(), $exercise->getIdExercise(), $composition->getSequence());
                        if (! $this->runQuery($sql)) {
                            $sql = sprintf($this->updateCompostion, $composition->getSequence(), $user->getEmail(), $question->getId(), $exercise->getIdExercise());
                            return $this->runQuery($sql);
                        }
                    }
                }
            }
        }
        return false;
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
    
    protected function insertExercises (ArrayObject $array, Exercises $exercise) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newExercise = $array->offsetGet($i);
            if ($newExercise instanceof Exercises) {
                if ($newExercise->getIdExercise() == $exercise->getIdExercise()) {
                    if ($exercise->getQuestions()->count() > 0) {
                        $newExercise->setQuestions($this->insertQuestion($newExercise->getQuestions(), $exercise->getQuestions()->offsetGet(0)));
                    }
                    
                    $array->offsetSet($i, $newExercise);
                    return $array;
                }
            }
        }
        $array->append($exercise);
        return $array;
    }
    
    protected function insertQuestion (ArrayObject $array, Question $question) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newQuestion = $array->offsetGet($i);
            if ($newQuestion instanceof Question) {
                if ($newQuestion->getId() == $question->getId()) {
                    if ($question->getCompositionQuestion()->count() > 0) {
                        $newQuestion->setCompositionQuestion($this->insertComposition($newQuestion->getCompositionQuestion(), $question->getCompositionQuestion()->offsetGet(0)));
                    }
                    
                    $array->offsetSet($i, $newQuestion);
                    return $array;
                }
            }
        }
        $array->append($question);
        return $array;
    }
    
    protected function insertComposition (ArrayObject $array, CompositionQuestion $composition) {
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $newComposition = $array->offsetGet($i);
            if ($newComposition instanceof CompositionQuestion) {
                if ($newComposition->getSequence() == $composition->getSequence()) {
                    return $array;
                }
            }
        }
        $array->append($composition);
        return $array;
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
                    
                    if ($users->getExercises() != null && $users->getExercises()->count() > 0) {
                        $newUser->setExercises($this->insertExercises($newUser->getExercises(), $users->getExercises()->offsetGet(0)));
                    }
                    
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
                $exercises = new ArrayObject();
                
                $classe->setId($rs[$i]['IdClass']);
                $classes = new ArrayObject();
                $classes->append($classe);
                
                $permission->setId($rs[$i]['IdPermission']);
                $permission->setIsMenu($rs[$i]['IsMenu']);
                $permission->setMenu($rs[$i]['Menu']);
                $permission->setLink($rs[$i]['Link']);
                $permissions = new ArrayObject();
                $permissions->append($permission);
                
                if ($rs[$i]['IdExercisesUser'] != null) {
                    $exercise = new Exercises();
                    $exercise->setIdExercise($rs[$i]['IdExercisesUser']);
                    
                    $questions = new ArrayObject();
                    if ($rs[$i]['IdQuestionUser'] != null) {
                        $question = new Question();
                        $question->setId($rs[$i]['IdQuestionUser']);
                        
                        $compositions = new ArrayObject();
                        
                        if ($rs[$i]['SequenceCompositionUser'] != null) {
                            $composition = new CompositionQuestion();
                            $composition->setSequence($rs[$i]['SequenceCompositionUser']);
                            
                            $compositions->append($composition);
                        }
                        
                        $question->setCompositionQuestion($compositions);
                        
                        $questions->append($question);
                    }
                    $exercise->setQuestions($questions);
                    
                    $exercises->append($exercise);
                }
                $user->setExercises($exercises);
                
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