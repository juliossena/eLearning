<?php

$requires = "";
$requires[] = 'app/view/View.php';
$requires[] = 'app/config/Commands.php';
$requires[] = 'app/models/users/Users.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class VCourses implements View {
    
    private $content;
    private $user;
    
    public function __construct(Users $user) {
        $this->user = $user;
    }
    
    public function getView() {
        return $this->getCorpo();
    }
    
    private function getCorpo() {
        return $this->content;
    }
    
    public function setInsertSuccess () {
        $this->content = "Inserido con éxito";
    }
    
    public function setInsertFail () {
        $this->content = "Error al insertar";
    }
    
    public function setViewOpenExercises (Courses $course) {
        $return = '';
        
        
        $this->content = $return;
    }
    
    public function setViewCreateExercises (Courses $course) {
        $return = '';
        
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="createExercise">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$CREATE_NEW_EXERCISES.'" name="rota">
                        <input type="hidden" value="'.$course->getId().'" name="idCourse">
                        <table class="form">
                            <tr>
                                <td class="left">Título Ejercicio*
                                <td class="right"><input name="nameExercise">
                            <tr>
                                <td class="left">Peso Ejercicio*
                                <td class="right"><input name="weightExercise">
                            <tr>
                                <td class="left">Fecha Limite*
                                <td class="right"><input name="dateLimit">
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
                        </table>
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewAllExercises (ArrayObject $exercises, Courses $course) {
        $return = '';
        $return .= '
        <button onclick="carregarPaginaAtivarCheck('."'#dadosNovaPagina', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_CREATE_EXERCISES."&idCourse=".$course->getId()."'".')">Crear Nuevo Ejercicio</button>
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Curso" />
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Data</th>
                        <th colspan="3" class="actions"></th>
                    </tr>
                </thead>
        ';
        
        for ($i = 0 ; $i < $exercises->count() ; $i++) {
            $exercise = $exercises->offsetGet($i);
            if ($exercise instanceof Exercises) {
                $return .= '
                    <tr id="tr_'.$exercise->getIdExercise().'">
                        <td align="center">'.$exercise->getName().'</td>
                        <td align="center">'.$exercise->getDateLimit()->format("d/m/Y").'</td>
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_COURSE."&idCourse=".$exercise->getIdExercise()."')".'" src="imagens/editar.png">
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_COURSE."&idCourse=".$exercise->getIdExercise()."')".'" src="imagens/view.png">
                        <td><img class="imgButton" onclick="carregarPagina('."'#informacoes', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$OPEN_COURSE."&idCourse=".$exercise->getIdExercise()."'".')" src="imagens/enter.png">
                    </tr>
                ';
            }
        }
        
        
        $return .= '</tbody>
            </table>';
        
        
        $this->content = $return;
    }
    
    public function viewClassesSelect (Classes $class, ArrayObject $classesSelect) {
        for ($i = 0 ; $i < $classesSelect->count() ; $i++) {
            $newClass = $classesSelect->offsetGet($i);
            if ($newClass instanceof Classes) {
                if ($newClass->getId() == $class->getId()) {
                    return '<script>selectList('.$class->getId().');</script>';
                    
                }
            }
        }
    }
    
    public function viewNews () {
        
    }
    
    public function viewStudentsSelect (Users $student, ArrayObject $studentsSelect) {
        for ($i = 0 ; $i < $studentsSelect->count() ; $i++) {
            $newStudent = $studentsSelect->offsetGet($i);
            if ($newStudent instanceof Users) {
                if ($newStudent->getEmail() == $student->getEmail()) {
                    return '<script>selectList('.$student->getId().');</script>';
                    
                }
            }
        }
    }
    
    public function setViewCourse (Courses $course, ArrayObject $instructors, ArrayObject $students, ArrayObject $classes) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="editCourse">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES.'&subSite='.Rotas::$EDIT_COURSE.'" name="rota">
                        <input type="hidden" value="'.$course->getId().'" name="idCourse">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre Course*
                                <td class="right"><input name="nameClass" value="'.$course->getName().'" disabled>
                            <tr>
                                <td class="left">Instructor Responsable*
                                <td class="right"><input name="instructor" value="'.$course->getInstructor()->getEmail().'" disabled>
                            <tr>
                                <td class="left">Data Final
                                <td class="right"><input name="dateFinish" value="'.$course->getDateFinish()->format("d/m/Y").'" disabled>
                            <tr>
                                <td class="left">Contraseña para Matricularse
                                <td class="right"><input name="password" value="'.$course->getPassword().'" disabled>
                            <tr>
                                <td class="left">Mínimo para Completar
                                <td class="right"><input name="certifiedPercentage" value="'.$course->getCertifiedPercentage().'" disabled>
                            <tr>
                                <td class="left">Fecha de destaque
                                <td class="right"><input name="dateNew" value="'.$course->getDateNew()->format("d/m/Y").'" disabled>
                            <tr>
                                <td class="left">Tiempo Mínimo
                                <td class="right"><input name="minimumTime" value="'.Commands::passDateTimeForMinutes($course->getMinimumTime()).'" disabled>
                                    
                            <tr>
                                <td colspan="2"><br>Estudiantes del Clase:<br><br>
                    <textarea id="selectActiveClass" name="selectActiveClass" class="selectActive"></textarea>
                    <script type="text/javascript" src="js/jquery.quick.search.js"></script>
                    <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
                    <div class="frameSelect"><table id="formSelect" class="lista-clientes">
                ';
        
        for ($i = 0 ; $i < $classes->count() ; $i++) {
            $class = $classes->offsetGet($i);
            if ($class instanceof Classes) {
                $return .= $this->viewClassesSelect($class, $course->getClasses());
                $return .= '
                                <tr>
                                    <input class="check" type="checkbox" id="td'.$class->getId().'" name="td'.$class->getId().'" value="'.$class->getId().'">
                                    <td class="tdSelect" id="label'.$class->getId().'" >
                                            		'.$class->getName().'
                                            		    
                                    ';
            }
        }
        
        $return .='
                    </table></div>';
        
        $return .= '<tr>
        <td colspan="2"><br>Estudiantes del Clase:<br><br>
        <textarea id="selectActive" name="selectActive" class="selectActive" disabled></textarea>
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
        <div class="frameSelect"><table id="formSelect" class="lista-clientes">
        ';
        
        for ($i = 0 ; $i < $students->count() ; $i++) {
            $student = $students->offsetGet($i);
            if ($student instanceof Users) {
                $return .= $this->viewStudentsSelect($student, $course->getStudents());
                $return .= '
                <tr>
                <input class="check" type="checkbox" id="td'.$student->getId().'" name="td'.$student->getId().'" value="'.$student->getEmail().'">
                <td class="tdSelect" id="label'.$student->getId().'">
                '.$student->getName().'
                    
                                        ';
            }
        }
        
        $return .='
                    </table></div>
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
            
                        </table>
            
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewEditCourse (Courses $course, ArrayObject $instructors, ArrayObject $students, ArrayObject $classes) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="editCourse">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES.'&subSite='.Rotas::$EDIT_COURSE.'" name="rota">
                        <input type="hidden" value="'.$course->getId().'" name="idCourse">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre Course*
                                <td class="right"><input name="nameClass" value="'.$course->getName().'">
                            <tr>
                                <td class="left">Instructor Responsable*
                                <td class="right">'.$this->viewSelectInstructor($instructors, $course).'
                            <tr>
                                <td class="left">Data Final
                                <td class="right"><input name="dateFinish" value="'.$course->getDateFinish()->format("d/m/Y").'">
                            <tr>
                                <td class="left">Contraseña para Matricularse
                                <td class="right"><input name="password" value="'.$course->getPassword().'">
                            <tr>
                                <td class="left">Mínimo para Completar
                                <td class="right"><input name="certifiedPercentage" value="'.$course->getCertifiedPercentage().'">
                            <tr>
                                <td class="left">Fecha de destaque
                                <td class="right"><input name="dateNew" value="'.$course->getDateNew()->format("d/m/Y").'">
                            <tr>
                                <td class="left">Tiempo Mínimo
                                <td class="right"><input name="minimumTime" value="'.Commands::passDateTimeForMinutes($course->getMinimumTime()).'">
                                    
                            <tr>
                                <td colspan="2"><br>Estudiantes del Clase:<br><br>
                    <textarea id="selectActiveClass" name="selectActiveClass" class="selectActive"></textarea>
                    <script type="text/javascript" src="js/jquery.quick.search.js"></script>
                    <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
                    <div class="frameSelect"><table id="formSelect" class="lista-clientes">
                ';
        
        for ($i = 0 ; $i < $classes->count() ; $i++) {
            $class = $classes->offsetGet($i);
            if ($class instanceof Classes) {
                $return .= $this->viewClassesSelect($class, $course->getClasses());
                $return .= '
                                <tr>
                                    <input class="check" type="checkbox" id="td'.$class->getId().'" name="td'.$class->getId().'" value="'.$class->getId().'">
                                    <td class="tdSelect" id="label'.$class->getId().'" onclick="selectListClass('.$class->getId().')">
                                            		'.$class->getName().'
                                            		    
                                    ';
            }
        }
        
        $return .='
                    </table></div>';
        
        $return .= '<tr>
        <td colspan="2"><br>Estudiantes del Clase:<br><br>
        <textarea id="selectActive" name="selectActive" class="selectActive"></textarea>
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
        <div class="frameSelect"><table id="formSelect" class="lista-clientes">
        ';
        
        for ($i = 0 ; $i < $students->count() ; $i++) {
            $student = $students->offsetGet($i);
            if ($student instanceof Users) {
                $return .= $this->viewStudentsSelect($student, $course->getStudents());
                $return .= '
                <tr>
                <input class="check" type="checkbox" id="td'.$student->getId().'" name="td'.$student->getId().'" value="'.$student->getEmail().'">
                <td class="tdSelect" id="label'.$student->getId().'" onclick="selectList('.$student->getId().')">
                '.$student->getName().'
                    
                                        ';
            }
        }
        
        $return .='
                    </table></div>
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
            
                        </table>
            
                    </form>';
        
        $this->content = $return;
    }
    
    public function viewSelectInstructor (ArrayObject $instructors, Courses $course = null) {
        $return = '';
        $return .= '<select name="instructors">
                        <option value=""></options>';
                        
        for ($i = 0 ; $i < $instructors->count() ; $i++) {
            $instructor = $instructors->offsetGet($i);
            if ($instructor instanceof Users) {
                if ($course != null && $instructor->getEmail() == $course->getInstructor()->getEmail()) {
                    $return .= '<option value="'.$instructor->getEmail().'" selected>'.$instructor->getName().'</option>';
                } else {
                    $return .= '<option value="'.$instructor->getEmail().'">'.$instructor->getName().'</option>';
                }
                
            }
        }
        
        $return .= '</select>';
        return $return;        
    }
    
    public function setNewsCourse (ArrayObject $newsCourse) {
        $return = '';
        $return .= '
            <script type="text/javascript" src="js/pageTable.js"></script>
            <input type="hidden" id="limitLines" value="10">
            <table id="pageTable" class="tableNews">
                <thead>
                    <tr class="nameTable">
                        <td class="nameTable">Cambio
                        <td class="nameTable">Usuario
                        <td class="nameTable">Data Cambio
                </thead>
                <tbody>
            ';
        for ($i = 0 ; $i < $newsCourse->count() ; $i++) {
            $new = $newsCourse->offsetGet($i);
            if ($new instanceof NewsCourse) {
                $return .= '
                    <tr>
                        <td>'.$new->getChange().'
                        <td>'.$new->getUser()->getName().'
                        <td>'.$new->getTimeChange()->format("d/m/Y H:i:s").'
                    ';
                    
            }
        }
        $return .= '
                </tbody>
                    </table><div id="pagination"></div>';
        $this->content = $return;
    }
    
    public function setNewCourse (ArrayObject $instructors, ArrayObject $students, ArrayObject $classes) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="createCourse">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES.'&subSite='.Rotas::$CREATE_NEW_COURSE.'" name="rota">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre Course*
                                <td class="right"><input name="nameClass">
                            <tr>
                                <td class="left">Instructor Responsable*
                                <td class="right">'.$this->viewSelectInstructor($instructors).'
                            <tr>
                                <td class="left">Data Final
                                <td class="right"><input name="dateFinish">
                            <tr>
                                <td class="left">Contraseña para Matricularse
                                <td class="right"><input name="password">
                            <tr>
                                <td class="left">Mínimo para Completar
                                <td class="right"><input name="certifiedPercentage">
                            <tr>
                                <td class="left">Fecha de destaque
                                <td class="right"><input name="dateNew">
                            <tr>
                                <td class="left">Tiempo Mínimo
                                <td class="right"><input name="minimumTime">

                            <tr>
                                <td colspan="2"><br>Estudiantes del Clase:<br><br>
                    <textarea id="selectActiveClass" name="selectActiveClass" class="selectActive"></textarea>
                    <script type="text/javascript" src="js/jquery.quick.search.js"></script>
                    <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
                    <div class="frameSelect"><table id="formSelect" class="lista-clientes">
                ';
        
        for ($i = 0 ; $i < $classes->count() ; $i++) {
            $class = $classes->offsetGet($i);
            if ($class instanceof Classes) {
                $return .= '
                                <tr>
                                    <input class="check" type="checkbox" id="td'.$class->getId().'" name="td'.$class->getId().'" value="'.$class->getId().'">
                                    <td class="tdSelect" id="label'.$class->getId().'" onclick="selectListClass('.$class->getId().')">
                                            		'.$class->getName().'
                                            		    
                                    ';
            }
        }
        
        $return .='
                    </table></div>';
        
        $return .= '<tr>
        <td colspan="2"><br>Estudiantes del Clase:<br><br>
        <textarea id="selectActive" name="selectActive" class="selectActive"></textarea>
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
        <div class="frameSelect"><table id="formSelect" class="lista-clientes">
        ';
            
        for ($i = 0 ; $i < $students->count() ; $i++) {
            $student = $students->offsetGet($i);
            if ($student instanceof Users) {
                $return .= '
            <tr>
            <input class="check" type="checkbox" id="td'.$student->getId().'" name="td'.$student->getId().'" value="'.$student->getEmail().'">
            <td class="tdSelect" id="label'.$student->getId().'" onclick="selectList('.$student->getId().')">
            '.$student->getName().'
                
                                    ';
            }
        }
        
        $return .='
                    </table></div>
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
            
                        </table>
            
                    </form>';
        
        $this->content = $return;
    }
    
    public function insertImgBlocked (Courses $course) {
        if ($course->getPassword() != null) {
            return '<img class="imgButton" src="imagens/blocked.png">';
        }
    }
    
    public function setViewFilesInstructor (ArrayObject $files, Courses $course) {
        $return = '';
        $_SESSION['idCourse'] = $course->getId();
        include('../app/view/fileUpload/index.html');
        /*$return .= '<div class="downloadFiles">';
        for ($i = 0 ; $i < $files->count() ; $i++) {
            $file = $files->offsetGet($i);
            if ($file instanceof Files) {
                $return .= '<a target="_blank" href="?site='.Rotas::$COURSES_STUDENTS.'&subSite='.Rotas::$DOWNLOAD_FILE_COURSE.'&idCourse='.$course->getId().'&idFile='.$file->getName().'"><div class="file"><img src="'.$file->getImgIcone().'"><p>'.$file->getName().'</p></div></a>';
            }
        }
        
        $return .= '</div>';*/
        
        $this->content = $return;
    }
    
    public function setViewFiles (ArrayObject $files, Courses $course) {
        $return = '';
        $return .= '<div class="downloadFiles">';
        for ($i = 0 ; $i < $files->count() ; $i++) {
            $file = $files->offsetGet($i);
            if ($file instanceof Files) {
                $return .= '<a target="_blank" href="?site='.Rotas::$COURSES_STUDENTS.'&subSite='.Rotas::$DOWNLOAD_FILE_COURSE.'&idCourse='.$course->getId().'&idFile='.$file->getId().'"><div class="file"><img src="'.$file->getImgIcone().'"><p>'.$file->getName().'</p></div></a>';
            }
        }
        
        $return .= '</div>';
        
        $this->content = $return;
    }
    
    public function setViewAllCoursesInstructor (ArrayObject $arrayCourses) {
        $return = '';
        $return .= '
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Curso" />
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Data</th>
                        <th>Descripción</th>
                        <th colspan="3" class="actions"></th>
                    </tr>
                </thead>
        ';
        
        for ($i = 0 ; $i < $arrayCourses->count() ; $i++) {
            $course = $arrayCourses->offsetGet($i);
            if ($course instanceof Courses) {
                $return .= '
                    <tr id="tr_'.$course->getId().'">
                        <td align="center">'.$course->getName().'</td>
                        <td align="center">'.$course->getDescription().'</td>
                        <td align="center">'.$course->getDateFinish()->format("d/m/Y").'</td>
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$VIEW_COURSE."&idCourse=".$course->getId()."')".'" src="imagens/editar.png">
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$VIEW_COURSE."&idCourse=".$course->getId()."')".'" src="imagens/view.png">
                        <td><img class="imgButton" onclick="carregarPagina('."'#informacoes', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$OPEN_COURSE."&idCourse=".$course->getId()."'".')" src="imagens/enter.png">
                    </tr>
                ';
            }
        }
        
        
        $return .= '</tbody>
            </table>';
        
        
        $this->content = $return;
    }
    
    public function setViewAllCoursesStudent (ArrayObject $arrayAvailable, ArrayObject $arrayRegistered) {
        $return = '';
        $return .= '
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Curso" />
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Data</th>
                        <th>Descripción</th>
                        <th colspan="3" class="actions"></th>
                    </tr>
                </thead>
        ';
        
        for ($i = 0 ; $i < $arrayAvailable->count() ; $i++) {
            $course = $arrayAvailable->offsetGet($i);
            if ($course instanceof Courses) {
                $return .= '
                    <tr id="tr_'.$course->getId().'">
                        <td align="center">'.$course->getName().'</td>
                        <td align="center">'.$course->getDescription().'</td>
                        <td align="center">'.$course->getDateFinish()->format("d/m/Y").'</td>
                        <td>'.$this->insertImgBlocked($course).'
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$VIEW_COURSE."&idCourse=".$course->getId()."')".'" src="imagens/view.png">
                        <td><img class="imgButton" onclick="registeredCourse('."'".$course->getId()."', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$REGISTERED_COURSE."', '?site=".Rotas::$COURSES_STUDENTS."'".')" src="imagens/registered.png">
                    </tr>
                ';
            }
        }
        
        
        $return .= '</tbody>
            </table>';
        
        $return .= '
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Data</th>
                        <th>Completo</th>
                        <th colspan="3" class="actions"></th>
                    </tr>
                </thead>
        ';
        
        for ($i = 0 ; $i < $arrayRegistered->count() ; $i++) {
            $course = $arrayRegistered->offsetGet($i);
            if ($course instanceof Courses) {
                $return .= '
                    <tr id="tr_'.$course->getId().'">
                        <td align="center">'.$course->getName().'</td>
                        <td align="center">'.$course->getDateFinish()->format("d/m/Y").'</td>
                        <td align="center">'.$course->getDateFinish()->format("d/m/Y").'</td>
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$VIEW_COURSE."&idCourse=".$course->getId()."')".'" src="imagens/certificate.png">
                        <td><img class="imgButton"  onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$VIEW_EDIT_COURSE."&idCourse=".$course->getId()."')".'" src="imagens/view.png">
                        <td><img class="imgButton" onclick="carregarPagina('."'#informacoes', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$OPEN_COURSE."&idCourse=".$course->getId()."'".')" src="imagens/enter.png">
                    </tr>
                ';
            }
        }
        
        
        $return .= '</tbody>
            </table>';
        
        $this->content = $return;
        
        return $return;
    }
    
    public function viewTimeElapse (Users $user) {
        $return = '';
        $return .= '
            <div class="reloj" id="Horas">'.$user->getTimeElapseCourse()->format("H").'</div>
    		<div class="reloj" id="Minutos">:'.$user->getTimeElapseCourse()->format("i").'</div>
    		<div  style="display:none;" class="reloj" id="Segundos">:'.$user->getTimeElapseCourse()->format("s").'</div>
    		<div style="display:none;" class="reloj" id="Centesimas">:00</div>
    
        ';
        
        return $return;
    }
    
    public function setViewNewForum (Courses $course) {
        $return = '';
        
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="createForum">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$CREATE_NEW_FORUM.'" name="rota">
                        <input type="hidden" value="'.$course->getId().'" name="idCourse">
                        <table>
                            <tr>
                                <td class="left">Título Forum*
                                <td class="right"><input name="nameForum">
                            <tr>
                                <td class="left" colspan="2"><textarea name="textArea" id="markItUp" cols="80" rows="20"></textarea>
                ';
        include ('../app/view/textArea/textArea.html');
        $return .='
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
            
                        </table>
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewNewForumStudents (Courses $course) {
        $return = '';
        
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="createForum">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES_STUDENTS.'&subSite='.Rotas::$CREATE_NEW_FORUM.'" name="rota">
                        <input type="hidden" value="'.$course->getId().'" name="idCourse">
                        <table>
                            <tr>
                                <td class="left">Título Forum*
                                <td class="right"><input name="nameForum">
                            <tr>
                                <td class="left" colspan="2"><textarea name="textArea" id="markItUp" cols="80" rows="20"></textarea>
                ';
        include ('../app/view/textArea/textArea.html');
        $return .='
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
            
                        </table>
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewAnswer (Answer $answer) {
        $return = '';
        $return .= '<div class="answer">
                                        <div class="imgUsuario">
                                            <img src="?site='.Rotas::$OPEN_IMG_PERFIL.'&emailUser='.$answer->getUserCreate()->getEmail().'">
                                            <p>'.$answer->getUserCreate()->getName().'</p>
                                        </div>
                                        <div class="dataPost">
                                            <p class="userLastPost">'.$answer->getAnswer().' </p>
                                        </div>
                                    </div>';
        
        $this->content = $return;
        
    }
    
    public function setViewForum (Forum $forum) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                <script type="text/javascript" src="js/pageTable.js"></script>
                <input type="hidden" id="limitLines" value="10">
                <table id="pageTable" class="forum">
                ';
        for ($i = 0 ; $i < $forum->getAnswers()->count() ; $i++) {
            $answer = $forum->getAnswers()->offsetGet($i);
            if ($answer instanceof Answer) {
                $return .= '<tr>
                                <td>
                                    <div class="answer">
                                        <div class="imgUsuario">
                                            <img src="?site='.Rotas::$OPEN_IMG_PERFIL.'&emailUser='.$answer->getUserCreate()->getEmail().'">
                                            <p>'.$answer->getUserCreate()->getName().'</p>
                                        </div>
                                        <div class="dataPost">
                                            <p class="userLastPost">'.$answer->getAnswer().' </p>
                                        </div>
                                    </div>';
            }
        }
        include ('../app/view/textArea/textArea.html');
        $return .='<tr>
                      <td>
                           <div id=result></div>
                             </table><div id="pagination"></div>
                <form id="answerForum">
                    <input value="'.$forum->getId().'" type="hidden" name="idForum">
                    <input value="?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$ANSWER_FORUM.'"  type="hidden" name="rota">
                    <textarea name="textArea" id="markItUp" cols="80" rows="20"></textarea>
                        <br><button type="submit">Respuesta</button>
                </form>';
        $return .= '

            </table>';
        $this->content = $return;
    }
    
    public function setViewForumStudents (Forum $forum) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                <script type="text/javascript" src="js/pageTable.js"></script>
                <input type="hidden" id="limitLines" value="10">
                <table id="pageTable" class="forum">
                ';
        for ($i = 0 ; $i < $forum->getAnswers()->count() ; $i++) {
            $answer = $forum->getAnswers()->offsetGet($i);
            if ($answer instanceof Answer) {
                $return .= '<tr>
                                <td>
                                    <div class="answer">
                                        <div class="imgUsuario">
                                            <img src="?site='.Rotas::$OPEN_IMG_PERFIL.'&emailUser='.$answer->getUserCreate()->getEmail().'">
                                            <p>'.$answer->getUserCreate()->getName().'</p>
                                        </div>
                                        <div class="dataPost">
                                            <p class="userLastPost">'.$answer->getAnswer().' </p>
                                        </div>
                                    </div>';
            }
        }
        include ('../app/view/textArea/textArea.html');
        $return .='<tr>
                      <td>
                           <div id=result></div>
                             </table><div id="pagination"></div>
                <form id="answerForum">
                    <input value="'.$forum->getId().'" type="hidden" name="idForum">
                    <input value="?site='.Rotas::$COURSES_STUDENTS.'&subSite='.Rotas::$ANSWER_FORUM.'"  type="hidden" name="rota">
                    <textarea name="textArea" id="markItUp" cols="80" rows="20"></textarea>
                        <br><button type="submit">Respuesta</button>
                </form>';
        $return .= '
            
            </table>';
        $this->content = $return;
    }
    
    public function setViewForunsStudents (Courses $course) {
        $return = '';
        $return .= '<button onclick="carregarPaginaAtivarCheck('."'#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_CREATE_FORUM."&idCourse=".$course->getId()."'".')">Crear Nuevo Forum</button>';
        $return .= '
                <script type="text/javascript" src="js/pageTable.js"></script>
                <input type="hidden" id="limitLines" value="10">
                <table id="pageTable" class="forum">
                        ';
        for ($i = 0 ; $i < $course->getForuns()->count() ; $i++) {
            $forum = $course->getForuns()->offsetGet($i);
            if ($forum instanceof Forum) {
                $return .= '<tr>
                                <td>
                                    <div class="forum" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$OPEN_FORUM."&idForum=".$forum->getId()."'".')"">
                                        <div class="imgUsuario">
                                            <img src="?site='.Rotas::$OPEN_IMG_PERFIL.'&emailUser='.$forum->getUserCreate()->getEmail().'">
                                            <p>'.$forum->getUserCreate()->getName().'</p>
                                        </div>
                                        <div class="dataPost">
                                            <p class="h1Post">'.Commands::limitCharacters($forum->getTitle(), 36).'</p>
                                            <p class="userLastPost">'.Commands::limitCharacters($forum->getAnswers()->offsetGet($forum->getAnswers()->count() - 1)->getAnswer()).' </p>
                                        </div>
                                        <div class="qtdPost">
                                            <p class="h1Post">'.$forum->getAnswers()->count().'</p>
                                            <p class="userLastPost">Posts </p>
                                        </div>
                                        <div class="lastPost">
                                            <p class="h1Post">Last Post</p>
                                            <p class="userLastPost">'.$forum->getAnswers()->offsetGet(0)->getUserCreate()->getName().'</p>
                                            <p class="userLastPost">'.$forum->getAnswers()->offsetGet(0)->getDateCreate()->format("d/m/Y H:i:s").'</p>
                                        </div>
                                    </div>';
            }
        }
        
        $return .= '</table></table><div id="pagination"></div>';
        $this->content = $return;
    }
    
    public function setViewForuns (Courses $course) {
        $return = '';
        $return .= '<button onclick="carregarPaginaAtivarCheck('."'#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_CREATE_FORUM."&idCourse=".$course->getId()."'".')">Crear Nuevo Forum</button>';
        $return .= '
                <script type="text/javascript" src="js/pageTable.js"></script>
                <input type="hidden" id="limitLines" value="10">
                <table id="pageTable" class="forum">
                        ';
        for ($i = 0 ; $i < $course->getForuns()->count() ; $i++) {
            $forum = $course->getForuns()->offsetGet($i);
            if ($forum instanceof Forum) {
                $return .= '<tr>
                                <td>
                                    <div class="forum" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$OPEN_FORUM."&idForum=".$forum->getId()."'".')"">
                                        <div class="imgUsuario">
                                            <img src="?site='.Rotas::$OPEN_IMG_PERFIL.'&emailUser='.$forum->getUserCreate()->getEmail().'">
                                            <p>'.$forum->getUserCreate()->getName().'</p>
                                        </div>
                                        <div class="dataPost">
                                            <p class="h1Post">'.Commands::limitCharacters($forum->getTitle(), 36).'</p>
                                            <p class="userLastPost">'.Commands::limitCharacters($forum->getAnswers()->offsetGet($forum->getAnswers()->count() - 1)->getAnswer()).' </p>
                                        </div>
                                        <div class="qtdPost">
                                            <p class="h1Post">'.$forum->getAnswers()->count().'</p>
                                            <p class="userLastPost">Posts </p>
                                        </div>
                                        <div class="lastPost">
                                            <p class="h1Post">Last Post</p>
                                            <p class="userLastPost">'.$forum->getAnswers()->offsetGet(0)->getUserCreate()->getName().'</p>
                                            <p class="userLastPost">'.$forum->getAnswers()->offsetGet(0)->getDateCreate()->format("d/m/Y H:i:s").'</p>
                                        </div>
                                    </div>';
            }
        }
        
        $return .= '</table></table><div id="pagination"></div>';
        $this->content = $return;
    }
    
    public function setViewOpenCourseInstructor (Courses $course) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
            
            <div class="content">
                <div class="tabs-content">
                    <div class="tabs-menu clearfix">
                        <ul>
                            <li><a class="active-tab-menu" href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_NEWS_COURSE."&idCourse=".$course->getId()."'".')">Novedades</a></li>
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_FILES_COURSE."&idCourse=".$course->getId()."'".')">Archivos</a></li>
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_FORUNS_COURSE."&idCourse=".$course->getId()."'".')">Foros</a></li>
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_ALL_EXERCISES."&idCourse=".$course->getId()."'".')">Rareas</a></li>
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_CLASSES_COURSE."&idCourse=".$course->getId()."'".')">Clases</a></li>
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_LIVE_CLASSES_COURSE."&idCourse=".$course->getId()."'".')">Clases en Vivo</a></li>
                        </ul>
                    </div>
                                
                    <div id="dataTab">
                        <script>
                            clearInterval(control);
                            carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_NEWS_COURSE."&idCourse=".$course->getId()."'".');
                            startCronometro ('."'".$course->getStudentsRegistered()->offsetGet(0)->getTimeElapseCourse()->format('H')."', '".$course->getStudentsRegistered()->offsetGet(0)->getTimeElapseCourse()->format('i')."', '".$course->getStudentsRegistered()->offsetGet(0)->getTimeElapseCourse()->format('s')."'".');
                            $idCourse = '.$course->getId().';control = setInterval(cronometro,10);
                        </script>
                    </div>
                                
                </div>
            </div>';
        
        $this->content = $return;
    }
    
    public function setViewOpenCourse (Courses $course) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>

<div class="content">
    <div class="tabs-content">
        <div class="tabs-menu clearfix">
            <ul>
                <li><a class="active-tab-menu" href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_NEWS_COURSE."&idCourse=".$course->getId()."'".')">Novedades</a></li>
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_FILES_COURSE."&idCourse=".$course->getId()."'".')">Archivos</a></li>
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_FORUNS_COURSE."&idCourse=".$course->getId()."'".')">Foros</a></li>
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_TASKS_COURSE."&idCourse=".$course->getId()."'".')">Rareas</a></li>
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_CLASSES_COURSE."&idCourse=".$course->getId()."'".')">Clases</a></li>
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_LIVE_CLASSES_COURSE."&idCourse=".$course->getId()."'".')">Clases en Vivo</a></li>
                <li class="elapseTime">Tiempo de carrera: '.$this->viewTimeElapse($course->getStudentsRegistered()->offsetGet(0)).'</li>
            </ul>
        </div>

        <div id="dataTab">
            <script>
                clearInterval(control);
                carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_NEWS_COURSE."&idCourse=".$course->getId()."'".');
                startCronometro ('."'".$course->getStudentsRegistered()->offsetGet(0)->getTimeElapseCourse()->format('H')."', '".$course->getStudentsRegistered()->offsetGet(0)->getTimeElapseCourse()->format('i')."', '".$course->getStudentsRegistered()->offsetGet(0)->getTimeElapseCourse()->format('s')."'".');
                $idCourse = '.$course->getId().';control = setInterval(cronometro,10);
            </script>
        </div> 

    </div>
</div>';
        
        $this->content = $return;
    }
    
    public function setViewAllCourses (ArrayObject $array) {
        $return = '';
        $return .= '
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <button onclick="carregarPaginaAtivarCheck('."'#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$NEW_COURSE."'".')">Crear Nuevo Curso</button>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Curso" />
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th colspan="3" class="actions"></th>
                    </tr>
                </thead>
        ';
        
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $course = $array->offsetGet($i);
            if ($course instanceof Courses) {
                $return .= '
                    <tr id="tr_'.$course->getId().'">
                        <td align="center">'.$course->getName().'</td>
                        <td align="center">'.$course->getDescription().'</td>
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$VIEW_COURSE."&idCourse=".$course->getId()."')".'" src="imagens/view.png">
                        <td><img class="imgButton"  onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$VIEW_EDIT_COURSE."&idCourse=".$course->getId()."')".'" src="imagens/editar.png">
                        <td><img class="imgButton" onclick="deleteCourse('."'".$course->getId()."', 'index.php?site=".Rotas::$COURSES."&subSite=".Rotas::$DELETE_COURSE."', '".$course->getId()."'".')" src="imagens/excluir.png">
                    </tr>
                ';
            }
        }
        
        
        $return .= '</tbody>
            </table>';
        
        $this->content = $return;
        
        return $return;
    }
    
}