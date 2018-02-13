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
    
    public function setNewQuestion () {
        $this->content = $this->newQuestion();
    }
    
    public function setViewResultsCourse () {
        $return = '';
        
        
        $this->content = $return;
    }
    
    public function setViewAllGradesIntructor (ArrayObject $users) {
        $return = '';
        $return .= '<input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Nota" />
                    <table class="lista-clientes" style="width:100%;">
                         <thead>
                            <tr>
                                <th>Nombre
                                <th>Valor
                                <th>Nota
                         </thead>';
        
        for ($k = 0 ; $k < $users->count() ; $k++) {
            $user = $users->offsetGet($k);
            if ($user instanceof Users) {
                $total = 0;
                $grade = 0;
                for ($i = 0 ; $i < $user->getExercises()->count() ; $i++) {
                    $exercise = $user->getExercises()->offsetGet($i);
                    if ($exercise instanceof Exercises) {
                        $total += $exercise->getWeightTask();
                        $grade += $exercise->getPointes();
                    }
                }
                for ($i = 0 ; $i < $user->getUploadTasks()->count() ; $i++) {
                    $uploadTasks = $user->getUploadTasks()->offsetGet($i);
                    if ($uploadTasks instanceof UploadTasks){
                        $total += $uploadTasks->getWeightTask();
                        $grade += $uploadTasks->getPointes();
                    }
                }
                $return .= '
                    <tr>
                        <td>' . $user->getName() . '
                        <td>'.$total.'
                        <td>'.$grade.'
                ';
            }
        }
        
        
        $return .= '
                </table>';
        $this->content = $return;
    }
    
    public function setViewAllGradesStudent (Users $user) {
        $return = '';
        $return .= '<input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Nota" />
                    <table class="lista-clientes" style="width:100%;">
                         <thead>
                            <tr>
                                <th>Nombre
                                <th>Valor
                                <th>Nota
                         </thead>';
        $total = 0;
        $grade = 0;
        for ($i = 0 ; $i < $user->getExercises()->count() ; $i++) {
            $exercise = $user->getExercises()->offsetGet($i);
            if ($exercise instanceof Exercises) {
                $total += $exercise->getWeightTask();
                $grade += $exercise->getPointes();
                $return .= '<tr>
                                <td>'.$exercise->getName().'
                                <td>'.$exercise->getWeightTask().'
                                <td>'.$exercise->getPointes();
            }
        }
        for ($i = 0 ; $i < $user->getUploadTasks()->count() ; $i++) {
            $uploadTasks = $user->getUploadTasks()->offsetGet($i);
            if ($uploadTasks instanceof UploadTasks){
                $total += $uploadTasks->getWeightTask();
                $grade += $uploadTasks->getPointes();
                $return .= '<tr>
                                <td>'.$uploadTasks->getName().'
                                <td>'.$uploadTasks->getWeightTask().'
                                <td>'.$uploadTasks->getPointes();
            }
        }
        
        $return .= '
                    <tr>
                        <td>
                        <th style="text-align:center;">'.$total.'
                        <th style="text-align:center;">'.$grade.'
                </table>';
        $this->content = $return;
    }
    
    public function setViewInfoTasksUpload (ArrayObject $users) {
        $return = '';
        $return .= '<h1 class="line">Resultados</h1>
                    <table class="lista-clientes"  width="100%">
                <thead>
                    <tr>
                        <th>Nombre
                        <th>Nota
                </thead>
        ';
        
        for ($i = 0 ; $i < $users->count() ; $i++) {
            $user = $users->offsetGet($i);
            if ($user instanceof Users) {
                $uploadTasks = $user->getUploadTasks()->offsetGet(0);
                if ($uploadTasks instanceof UploadTasks) {
                    $return .= '<tr>
                                    <td>'.$user->getName().'
                                    <td>'. number_format(($uploadTasks->getPercentagem() * 100), 2, ',', ' ') .'%
                    ';
                }
            }
            
        }
        
        $return .= '</table>';
        
        $this->content = $return;
    }
    
    public function setOpenUploadTasksInstructor (ArrayObject $arrayUsers) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiente" />
                    <table class="lista-clientes" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Nombre
                                <th>Arquivo
                                <th>Fecha de entrega
                                <th>Nota
                        </thead>
                    ';
        for ($i = 0 ; $i < $arrayUsers->count() ; $i++) {
            $user = $arrayUsers->offsetGet($i);
            if ($user instanceof Users) {
                $uploadTasks = $user->getUploadTasks()->offsetGet(0);
                if ($uploadTasks instanceof UploadTasks) {
                    $return .= '<tr>
                                    <td>' . $user->getName() . '
                                    <td><div class="downloadFiles">
                                            <a target="_blank" href="?site=' . Rotas::$COURSES_INSTRUCTOR . '&subSite=' . Rotas::$DOWNLOAD_FILE_UPLOAD_TASKS . '&idUploadTasks=' . $uploadTasks->getIdUploadTasks() . '"><div class="file"><img src="'.$uploadTasks->getFile()->getImgIcone().'"><p style="width: 100%;">'.$uploadTasks->getFile()->getName().'</p></div></a>
                                        </div>
                                    <td>' . $uploadTasks->getDateSend()->format("d/m/Y H:i:s") . '
                                    <td><form id="changeNotaUploadTasks">
                                            <input type="hidden" name="idTasks" value="' . $uploadTasks->getIdTask() . '">
                                            <input type="hidden" name="idUploadTasks" value="' . $uploadTasks->getIdUploadTasks() . '">
                                            <input type="hidden" name="emailUser" value="' . $user->getEmail() . '">
                                            <input type="hidden" name="rota" value="?site=' . Rotas::$COURSES_INSTRUCTOR . '&subSite=' . Rotas::$CHANGE_NOTA_UPLOAD_TASTKS . '">
                                            <input name="notaUploadTasks" maxlength="4" value="' . ($uploadTasks->getPercentagem() * 100) . '" style="width: 60px; text-align: center;">%
                                        </form>
                        ';
                }
            }
        }
        
        $return .= '</table>';
        
        $this->content = $return;
    }
    
    public function statusSend (UploadTasks $uploadTasks) {
        if ($uploadTasks->getDateSend() != null) {
            return 'Enviado para la evaluación';
        } else {
            return 'Ningún intento';
        }
    }
    
    public function evaluationStatus (UploadTasks $uploadTasks) {
        if ($uploadTasks->getPercentagem() != null) {
            return number_format(($uploadTasks->getPercentagem() * 100), 2, ',', ' ') . '%';
        } else {
            return 'No hay notas';
        }
    }
    
    public function fileDownload (UploadTasks $uploadTasks) {
        if ($uploadTasks->getFile() != null) {
            return '
            <div class="downloadFiles">
                <a target="_blank" href="?site=' . Rotas::$COURSES_STUDENTS . '&subSite=' . Rotas::$DOWNLOAD_FILE_UPLOAD_TASKS . '&idUploadTasks=' . $uploadTasks->getIdUploadTasks() . '"><div class="file"><img src="'.$uploadTasks->getFile()->getImgIcone().'"><p style="width: 100%;">'.$uploadTasks->getFile()->getName().'</p></div></a>
            </div>';
        } else {
            return '-';
        }
    }
    
    public function timeElapse(UploadTasks $uploadTasks) {
        $timeNow = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        if ($timeNow > $uploadTasks->getDateFinish()) {
            return 'La tarea está retrasada hace: ' . Commands::subtractTime($timeNow, $uploadTasks->getDateFinish());
        } else {
            return Commands::subtractTime($uploadTasks->getDateFinish(), $timeNow);
        }
    }
    
    public function setOpenUploadTasks (Courses $course, UploadTasks $uploadTasks) {
        $return = '';
        if ($uploadTasks instanceof UploadTasks) {
            $return .= '
            <script type="text/javascript" src="js/script.js"></script>
            <form class="formImg" id="sendUploadTask" enctype="multipart/form-data">
                <input type="hidden" name="rota" value="?site='.Rotas::$COURSES_STUDENTS.'&subSite='.Rotas::$UPLOAD_FILE_UPLOAD_TASKS.'">
                <input name="fileUploadTasks" type="file" id="fileUploadTasks">
                <input name="idUploadTasks" type="hidden" value="' . $uploadTasks->getIdUploadTasks() . '">
                <input name="idTasks" type="hidden" value="' . $uploadTasks->getIdTask() . '">

                <input type="hidden" name="rotaActual" value="?site='.Rotas::$COURSES_STUDENTS.'&subSite='.Rotas::$OPEN_UPLOAD_TASKS_STUDENT.'&idUploadTasks='.$uploadTasks->getIdUploadTasks().'">
            </form>
            <table class="uploadTasks">
                <tr>
                    <td>Estado de envío
                    <td>'.$this->statusSend($uploadTasks).'
                <tr>
                    <td>Estado de la evaluación
                    <td>'.$this->evaluationStatus($uploadTasks).'
                <tr>
                    <td>Fecha de la entrega
                    <td>' . $uploadTasks->getDateFinish()->format("d/m/Y H:i:s") . '
                <tr>
                    <td>Tiempo restante
                    <td>' . $this->timeElapse($uploadTasks) . '
                <tr>
                    <td>Envío de archivos
                    <td>' . $this->fileDownload($uploadTasks) . '
                <div id="result"></div>
            </table>
            
            ';
            $timeNow = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            if ($timeNow < ($uploadTasks->getDateFinish()->add(new DateInterval('P' . $uploadTasks->getDaysDelay() . 'D')))) {
                $return .= '<label for="fileUploadTasks" class="btnFile">Añadir Archivo</label>';
            }
            
            
        }
        $this->content = $return;
    }
    
    public function setViewEditTarea (Courses $course) {
        $return = '';
        $uploadTasks = $course->getUploadTasks()->offsetGet(0);
        if ($uploadTasks instanceof UploadTasks) {
            $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="editUploadTasks">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$EDIT_TAREA_INSTRUCTOR.'" name="rota">
                        <input type="hidden" value="'.$uploadTasks->getIdUploadTasks().'" name="idUploadTasks">
                        <input type="hidden" value="'.$uploadTasks->getIdTask().'" name="idTask">
                        <table class="form">
                            <tr>
                                <td class="left">Título Tarea*
                                <td class="right"><input name="nameUploadTasks" value="'.$uploadTasks->getName().'">
                            <tr>
                                <td class="left">Peso Ejercicio*
                                <td class="right"><input name="weightUploadTasks" value="'.$uploadTasks->getWeightTask().'">
                            <tr>
                                <td class="left">Fecha Limite*
                                <td class="right"><input name="dateLimit" value="'.$uploadTasks->getDateFinish()->format("d/m/Y H:i:s").'">
                            <tr>
                                <td class="left">Días de retraso*
                                <td class="right"><input name="daysDelay" value="'.$uploadTasks->getDaysDelay().'">
                            <tr>
                                <td colspan="2"><button type="submit">Guardar</button>
                        </table>
                    </form>';
        }
        
        $this->content = $return;
    }
    
    public function setViewCreateTarea (Courses $course) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="createUploadTask">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$CREATE_TAREA.'" name="rota">
                        <input type="hidden" value="'.$course->getId().'" name="idCourse">
                        <table class="form">
                            <tr>
                                <td class="left">Título Tarea*
                                <td class="right"><input name="nameUploadTasks">
                            <tr>
                                <td class="left">Peso Ejercicio*
                                <td class="right"><input name="weightUploadTasks">
                            <tr>
                                <td class="left">Fecha Limite*
                                <td class="right"><input name="dateLimit">
                            <tr>
                                <td class="left">Días de retraso*
                                <td class="right"><input name="daysDelay" value="0">
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
                        </table>
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewAllUploadTasksStudent (Courses $course) {
        $return = '';
        $return .= '
            <script type="text/javascript" src="js/jquery.quick.search.js"></script>
            <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Tarea" />
                <table class="lista-clientes" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre
                            <th>Fecha Data
                            <th colspan="2" class="actions">
                        </tr>
                    </thead>
        ';
        
        for ($i = 0 ; $i < $course->getUploadTasks()->count() ; $i++) {
            $uploadTask = $course->getUploadTasks()->offsetGet($i);
            if ($uploadTask instanceof UploadTasks) {
                $return .= '
                    <tr>
                        <td>'.$uploadTask->getName().'
                        <td>'.$uploadTask->getDateFinish()->format("d/m/Y H:i:s").'
                        <td><img class="imgButton" onclick="carregarPagina('."'#dataTab', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$OPEN_UPLOAD_TASKS_STUDENT."&idUploadTasks=".$uploadTask->getIdUploadTasks()."&idTasks=".$uploadTask->getIdTask()."'".')" src="imagens/enter.png">
                    ';
            }
        }
        
        
        $return .= '</table>';
        
        $this->content = $return;
    }
    
    public function setViewAllUploadTasks (Courses $course) {
        $return = '';
        $return .= '
            <button onclick="carregarPaginaAtivarCheck('."'#dadosNovaPagina', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_CREATE_TAREA."&idCourse=".$course->getId()."'".')">Crear Nueva Tarea</button>
            <script type="text/javascript" src="js/jquery.quick.search.js"></script>
            <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Tarea" />
                <table class="lista-clientes" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre
                            <th>Fecha Data
                            <th colspan="3" class="actions">
                        </tr>
                    </thead>
        ';
        
        for ($i = 0 ; $i < $course->getUploadTasks()->count() ; $i++) {
            $uploadTask = $course->getUploadTasks()->offsetGet($i);
            if ($uploadTask instanceof UploadTasks) {
                $return .= '
                    <tr>
                        <td>'.$uploadTask->getName().'
                        <td>'.$uploadTask->getDateFinish()->format("d/m/Y H:i:s").'
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_EDIT_TAREA_INSTRUCTOR."&idUploadTasks=".$uploadTask->getIdUploadTasks()."')".'" src="imagens/editar.png">
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_INFO_TAREA_INSTRUCTOR."&idUploadTasks=".$uploadTask->getIdUploadTasks()."&idTasks=".$uploadTask->getIdTask()."')".'" src="imagens/view.png">
                        <td><img class="imgButton" onclick="carregarPagina('."'#dataTab', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$OPEN_TAREA_INSTRUCTOR."&idUploadTasks=".$uploadTask->getIdUploadTasks()."&idTasks=".$uploadTask->getIdTask()."'".')" src="imagens/enter.png">
                    
                ';
            }
        }
        
        
        $return .= '</table>';
        
        $this->content = $return;
    }
    
    public function setViewInfoExrcise (ArrayObject $users, Exercises $exercise) {
        $return = '';
        $return .= '<h1 class="line">Información</h1>
                    <p style="text-align: justify;">Quantidade de questões: '.$exercise->getQuestions()->count().'</p>
                    <p style="text-align: justify;">Peso do exercicio: '.$exercise->getWeightTask().'</p>';
        $return .= '<h1 class="line">Resultados</h1>
                    <table class="lista-clientes"  width="100%">
                <thead>
                    <tr>
                        <th>Nombre
                        <th>Nota
                </thead>
        ';
        
        for ($i = 0 ; $i < $users->count() ; $i++) {
            $user = $users->offsetGet($i);
            if ($user instanceof Users) {
                $exercise = $user->getExercises()->offsetGet(0);
                if ($exercise instanceof Exercises) {
                    $return .= '<tr>
                                    <td>'.$user->getName().'
                                    <td>'. number_format(($exercise->getPercentagem() * 100), 2, ',', ' ') .'%
                    ';
                }
            }
            
        }
        
        $return .= '</table>';
        
        $this->content = $return;
    }
    
    public function setViewExerciseInstructor (Exercises $exercise) {
        $return = '';
        $return .= '<h1 class="line">Información</h1>
                    <p style="text-align: justify;">Quantidade de questões: '.$exercise->getQuestions()->count().'</p>
                    <p style="text-align: justify;">Peso do exercicio: '.$exercise->getWeightTask().'</p>';
        $return .= '<h1 class="line">Resultados</h1>';
        if ($exercise->getPercentagem() != null) {
            $this->setViewResultTask($exercise);
            $return .= $this->content;
        } else {
            $return .= 'Exercicio não foi finalizado';
        }
        
        
        $this->content = $return;
    }
    
    public function setViewExercise (Exercises $exercise, Users $user) {
        $return = '';
        $return .= '<h1 class="line">Información</h1>
                    <p style="text-align: justify;">Quantidade de questões: '.$exercise->getQuestions()->count().'</p>
                    <p style="text-align: justify;">Peso do exercicio: '.$exercise->getWeightTask().'</p>';
        $return .= '<h1 class="line">Resultado</h1>';
        $contentExercise = false;
        for ($i = 0 ; $i < $user->getExercises()->count() ; $i++) {
            $exerciseUser = $user->getExercises()->offsetGet($i);
            if ($exerciseUser instanceof Exercises && $exerciseUser->getIdExercise() == $exercise->getIdExercise()) {
                $contentExercise = true;
                break;
            }
        }
        
        if ($contentExercise) {
            $this->setViewResultTask($exerciseUser);
            $return .= $this->content;
        } else {
            $return .= 'Exercicio não foi finalizado';
        }
        
        
        $this->content = $return;
    }
    
    public function setViewResultTask (Exercises $exercise) {
        $return = '';
        $return .= '<div class="resultTask">' . number_format(($exercise->getPercentagem() * 100), 2, ',', ' ') . '%</div>';
        
        
        $this->content = $return;
    }
    
    public function setViewFinishExercises (Courses $course) {
        $exercise = $course->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            $return = '';
            $return .= '<h1 style="color: #800000;">¡Atención! Al finalizar el ejercicio no será posible modificarlo después.</h1>
                    <button onclick="carregarPagina('."'#dataTab', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$OPEN_EXERCISE_STUDENT."&idExercise=".$exercise->getIdExercise()."'".')">Cancelar</button>
                    <button onclick="carregarPagina('."'#dataTab', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$FINISH_EXERCISES."&idExercise=".$exercise->getIdExercise()."'".')">Finalizar Tarea</button>
                ';
        }
        
        $this->content = $return;
    }
    
    public function newQuestion ($numberBody = 1) {
        if (isset($_REQUEST['numberBody'])) {
            $numberBody = $_REQUEST['numberBody'];
        }
        $return = '<script type="text/javascript" src="js/sendQuestion.js"></script>
                    <script type="text/javascript" src="js/lateralMenu.js"></script>
                    <script>
                        setNumberQuestion('. ($numberBody) .');
                        setNumberQuestions('. ($numberBody) .');
                        setIdSelected('. ($numberBody) .');
                        setAceptNewQuestion (false);
                    </script>
                    <form id="sendQuestion" class="formQuestion" accept-charset="ISO-8859-1">
            			<div id="body_'.($numberBody).'">
                            <h1>Pregunta '. $numberBody .'</h1>
                            <button type="submit" style="float: right; margin: 10px;">Guardar</button>
                            <input type="hidden" name="numberQuestion" value="' .$numberBody. '">
                            <input type="hidden" name="nameBody" value="body_'.($numberBody).'">
                            <input type="hidden" name="idExercise" value="' . $_REQUEST['idExercise'] . '">
                            <input class="radioHidden" type="radio" name="levelQuestion" id="label1" value="1"><label for="label1" class="labelRadio"><span class="labelRadio">Fácil</span></label>
                			<input class="radioHidden" type="radio" name="levelQuestion" id="label2" value="2" checked><label for="label2" class="labelRadio"><span class="labelRadio">Médio</span></label>
                			<input class="radioHidden" type="radio" name="levelQuestion" id="label3" value="3"><label for="label3" class="labelRadio"><span class="labelRadio">Difícil</span></label>
                            

                                <input name="rotaQuestion" type="hidden" value="?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$INSERT_QUESTION.'">
                                <div class="divQuestion"><div id="contentQuestion"></div>
                            
                                <img onclick="insertTextArea('."'contentQuestion'".')" class="icon" src="imagens/textArea.png">
                                <label for="imgQuestion" class="insertImg"></label>
                                
                                
                                </div>
                            <div onclick="insertNewAlternative(' . "'0'" . ', '.($numberBody).')" class="divNewAlternatives" id="alt_0">Nueva Alternativa</div>
                        </div>
                    </form>';
        return $return;
    }
    
    public function setCompositionQuestion (Question $question) {
        $return = '';
        $return .= '<h1>Pregunta '.$question->getSequence().'</h1>';
        for ($i = 0 ; $i < $question->getCompositionQuestion()->count() ; $i++) {
            $compostion = $question->getCompositionQuestion()->offsetGet($i);
            if ($compostion instanceof CompositionQuestion) {
                if ($compostion->getType() == 1 || $compostion->getType() == 2) {
                    if ($compostion->getLink() != '') {
                        $return .= '<p class="pImg"><img src="'.$compostion->getLink().'"></p>';
                    } else {
                        $return .= '<p>'.$compostion->getText().'</p>';
                    }
                } else {
                    if ($compostion->getAnswer()) {
                        if ($compostion->getLink() != '') {
                            $return .= '<p class="pImgTrue"><img src="'.$compostion->getLink().'"></p>';
                        } else {
                            $return .= '<p class="pTrue">'.$compostion->getText().'</p>';
                        }
                    } else {
                        if ($compostion->getLink() != '') {
                            $return .= '<p class="pImgFalse"><img src="'.$compostion->getLink().'"></p>';
                        } else {
                            $return .= '<p class="pFalse">'.$compostion->getText().'</p>';
                        }
                    }
                }
            }
        }
        $this->content = $return;
    }
    
    public function setViewOpenExercisesStudentsFinish (Courses $course, Exercises $exercisesUser) {
        $return = '';
        $idExercise = $_REQUEST['idExercise'];
        $exercise = $course->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            $return .= '<script type="text/javascript" src="js/lateralMenu.js"></script>
                        <script type="text/javascript" src="js/script.js"></script>
                        <div id="bodyLateral" class="bodyLateralMenuSelected">
            ';
            for ($k = 0 ; $k < $exercise->getQuestions()->count() ; $k++) {
                $question = $exercise->getQuestions()->offsetGet($k);
                if ($question instanceof Question) {
                    if ($k == 0) {
                        $return .= '<div id="body_'. ($k + 1) .'">';
                    } else {
                        $return .= '<div style="display: none;" id="body_'. ($k + 1) .'">';
                    }
                    $return .= '<h1>Pregunta '.$question->getSequence().'</h1>';
                    for ($i = 0 ; $i < $question->getCompositionQuestion()->count() ; $i++) {
                        $compostion = $question->getCompositionQuestion()->offsetGet($i);
                        if ($compostion instanceof CompositionQuestion) {
                            if ($compostion->getType() == 1 || $compostion->getType() == 2) {
                                if ($compostion->getLink() != '') {
                                    $return .= '<p class="pImg"><img src="'.$compostion->getLink().'"></p>';
                                } else {
                                    $return .= '<p>'.$compostion->getText().'</p>';
                                }
                            } else {
                                $compositionSelected = false;
                                for ($j = 0 ; $j < $exercisesUser->getQuestions()->count() ; $j++) {
                                    $questionUser = $exercisesUser->getQuestions()->offsetGet($j);
                                    if ($questionUser instanceof Question) {
                                        for ($l = 0 ; $l < $questionUser->getCompositionQuestion()->count() ; $l++) {
                                            $compostionUser = $questionUser->getCompositionQuestion()->offsetGet($l);
                                            if ($compostionUser instanceof CompositionQuestion) {
                                                if ($compostionUser->getSequence() == $compostion->getSequence() && $questionUser->getId() == $question->getId() && $exercisesUser->getIdExercise() == $exercise->getIdExercise()) {
                                                    $compositionSelected = true;
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                if ($compostion->getLink() != '') {
                                    if ($compositionSelected && $compostion->getAnswer()) {
                                        $return .= '<div class="questionCompositionTrueTrue"><img src="'.$compostion->getLink().'"></div>';
                                    } else if($compositionSelected) {
                                        $return .= '<div class="questionCompositionFalse"><img src="'.$compostion->getLink().'"></div>';
                                    } else  if($compostion->getAnswer()) {
                                        $return .= '<div class="questionCompositionTrue"><img src="'.$compostion->getLink().'"></div>';
                                    } else {
                                        $return .= '<div class="questionComposition"><img src="'.$compostion->getLink().'"></div>';
                                    }
                                } else {
                                    if ($compositionSelected && $compostion->getAnswer()) {
                                        $return .= '<div class="questionCompositionTrueTrue">'.$compostion->getText().'</div>';
                                    } else if($compositionSelected) {
                                        $return .= '<div class="questionCompositionFalse">'.$compostion->getText().'</div>';
                                    } else if($compostion->getAnswer()) {
                                        $return .= '<div class="questionCompositionTrue">'.$compostion->getText().'</div>';
                                    } else {
                                        $return .= '<div class="questionComposition">'.$compostion->getText().'</div>';
                                    }
                                }
                            }
                            
                        }
                    }
                    $return .= '
                        </div>';
                }
                
            }
            $return .= '
                
        		</div>
        		<div class="lateralMenu">
        			<ul id="ulLateralMenu">';
            for ($k = 0 ; $k < $exercise->getQuestions()->count() ; $k++) {
                $question = $exercise->getQuestions()->offsetGet($k);
                if ($question instanceof Question) {
                    if ($k == 0) {
                        $return .= '<li id="'. ($k + 1) .'" class="selected" onclick="insertNewQuestion('. ($k + 1) .', ' . $idExercise . ')">Pregunta '. ($k + 1) .'</li>';
                    } else {
                        $return .= '<li id="'. ($k + 1) .'" onclick="insertNewQuestion('. ($k + 1) .', ' . $idExercise . ')">Pregunta '. ($k + 1) .'</li>';
                    }
                }
            }
            $return .= '<script>
                            setNumberQuestion('. ($exercise->getQuestions()->count() + 1) .');
                        </script>
        			</ul>
        		</div>';
        }
        $this->content = $return;
    }
    
    public function setViewOpenExercisesStudents (Courses $course, Exercises $exercisesUser) {
        $return = '';
        $idExercise = $_REQUEST['idExercise'];
        $exercise = $course->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            $return .= '<script type="text/javascript" src="js/lateralMenu.js"></script>
                        <script type="text/javascript" src="js/script.js"></script>
                        <div id="bodyLateral" class="bodyLateralMenuSelected">
                            <button onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$CONFIRM_FINISH_EXERCISES."&idExercise=".$exercise->getIdExercise()."'".')" style="float: right;">Finalizar Tarea</button>
            ';
            for ($k = 0 ; $k < $exercise->getQuestions()->count() ; $k++) {
                $question = $exercise->getQuestions()->offsetGet($k);
                if ($question instanceof Question) {
                    $return .= '<form id="sendQuestionStudent">
                    <input type="hidden" name="rota" value="?site='.Rotas::$COURSES_STUDENTS.'&subSite='.Rotas::$UPDATE_COMPOSITION_QUESTION.'">
                    <input type="hidden" name="idExercise" value="'.$exercise->getIdExercise().'">';
                    if ($k == 0) {
                        $return .= '<div id="body_'. ($k + 1) .'">';
                    } else {
                        $return .= '<div style="display: none;" id="body_'. ($k + 1) .'">';
                    }
                    $return .= '<h1>Pregunta '.$question->getSequence().'</h1>';
                    for ($i = 0 ; $i < $question->getCompositionQuestion()->count() ; $i++) {
                        $compostion = $question->getCompositionQuestion()->offsetGet($i);
                        if ($compostion instanceof CompositionQuestion) {
                            if ($compostion->getType() == 1 || $compostion->getType() == 2) {
                                if ($compostion->getLink() != '') {
                                    $return .= '<p class="pImg"><img src="'.$compostion->getLink().'"></p>';
                                } else {
                                    $return .= '<p>'.$compostion->getText().'</p>';
                                }
                            } else {
                                $compositionSelected = false;
                                if ($exercisesUser->getQuestions() != null) {
                                    for ($j = 0 ; $j < $exercisesUser->getQuestions()->count() ; $j++) {
                                        $questionUser = $exercisesUser->getQuestions()->offsetGet($j);
                                        if ($questionUser instanceof Question) {
                                            for ($l = 0 ; $l < $questionUser->getCompositionQuestion()->count() ; $l++) {
                                                $compostionUser = $questionUser->getCompositionQuestion()->offsetGet($l);
                                                if ($compostionUser instanceof CompositionQuestion) {
                                                    if ($compostionUser->getSequence() == $compostion->getSequence() && $questionUser->getId() == $question->getId() && $exercisesUser->getIdExercise() == $exercise->getIdExercise()) {
                                                        $compositionSelected = true;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                if ($compostion->getLink() != '') {
                                    if ($compositionSelected) {
                                        $return .= '<div class="radioQuestion"><input type="radio" checked value="'.$compostion->getSequence().'" name="que_'.$question->getId().'" id="'.$question->getId().'op_'.$compostion->getSequence().'"><label for="'.$question->getId().'op_'.$compostion->getSequence().'"><span><img src="'.$compostion->getLink().'"></span></label></div>';
                                    } else {
                                        $return .= '<div class="radioQuestion"><input type="radio" value="'.$compostion->getSequence().'" name="que_'.$question->getId().'" id="'.$question->getId().'op_'.$compostion->getSequence().'"><label for="'.$question->getId().'op_'.$compostion->getSequence().'"><span><img src="'.$compostion->getLink().'"></span></label></div>';
                                    }
                                } else {
                                    if ($compositionSelected) {
                                        $return .= '<div class="radioQuestion"><input type="radio" checked value="'.$compostion->getSequence().'" name="que_'.$question->getId().'" id="'.$question->getId().'op_'.$compostion->getSequence().'"><label for="'.$question->getId().'op_'.$compostion->getSequence().'"><span>'.$compostion->getText().'</span></label></div>';
                                    } else {
                                        $return .= '<div class="radioQuestion"><input type="radio" value="'.$compostion->getSequence().'" name="que_'.$question->getId().'" id="'.$question->getId().'op_'.$compostion->getSequence().'"><label for="'.$question->getId().'op_'.$compostion->getSequence().'"><span>'.$compostion->getText().'</span></label></div>';
                                    }
                                }
                            }
                            
                        }
                    }
                    $return .= '
                        </div></form>';
                }
                
            }
            $return .= '
                
        		</div>
        		<div class="lateralMenu">
        			<ul id="ulLateralMenu">';
            for ($k = 0 ; $k < $exercise->getQuestions()->count() ; $k++) {
                $question = $exercise->getQuestions()->offsetGet($k);
                if ($question instanceof Question) {
                    if ($k == 0) {
                        $return .= '<li id="'. ($k + 1) .'" class="selected" onclick="insertNewQuestion('. ($k + 1) .', ' . $idExercise . ')">Pregunta '. ($k + 1) .'</li>';
                    } else {
                        $return .= '<li id="'. ($k + 1) .'" onclick="insertNewQuestion('. ($k + 1) .', ' . $idExercise . ')">Pregunta '. ($k + 1) .'</li>';
                    }
                }
            }
            $return .= '<script>
                            setNumberQuestion('. ($exercise->getQuestions()->count() + 1) .');
                        </script>
        			</ul>
        		</div>';
        }
        $this->content = $return;
    }
    
    public function setViewOpenExercises (Courses $course) {
        $return = '';
        $idExercise = $_REQUEST['idExercise'];
        $exercise = $course->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            if ($exercise->getQuestions()->count() == 0) {
                $return .= '<script type="text/javascript" src="js/lateralMenu.js"></script>
                            <script type="text/javascript" src="js/script.js"></script>
                <form class="formImg" id="enviarC" enctype="multipart/form-data">
                    <input type="hidden" name="rota" value="?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$INSERT_IMAGE.'">
                    
                    <input name="imgQuestion" type="file" id="imgQuestion">
                </form>
                <form class="formImg" id="enviarAlt" enctype="multipart/form-data">
                    <input type="hidden" name="rota" value="?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$INSERT_IMAGE.'">
                    <input name="imgQuestion" type="file" id="imgAlternative">
                </form>
                <div id="bodyLateral" class="bodyLateralMenuSelected">
        		</div>
        		<div class="lateralMenu">
        			<ul id="ulLateralMenu">
        				<li id="1" onclick="insertNewQuestion(1, ' . $idExercise . ')">+ Nueva Pregunta</li>
        			</ul>
        		</div>';
            } else {
                $return .= '<script type="text/javascript" src="js/lateralMenu.js"></script>
                            <script type="text/javascript" src="js/script.js"></script>
                            <form class="formImg" id="enviarC" enctype="multipart/form-data">
                                <input type="hidden" name="rota" value="?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$INSERT_IMAGE.'">
                                <input name="imgQuestion" type="file" id="imgQuestion">
                            </form>
                            <form class="formImg" id="enviarAlt" enctype="multipart/form-data">
                                <input type="hidden" name="rota" value="?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$INSERT_IMAGE.'">
                                <input name="imgQuestion" type="file" id="imgAlternative">
                            </form>
                            <div id="bodyLateral" class="bodyLateralMenuSelected">';
                for ($k = 0 ; $k < $exercise->getQuestions()->count() ; $k++) {
                    $question = $exercise->getQuestions()->offsetGet($k);
                    if ($question instanceof Question) {
                        if ($k == 0) {
                            $return .= '<div id="body_'. ($k + 1) .'">';
                        } else {
                            $return .= '<div style="display: none;" id="body_'. ($k + 1) .'">';
                        }
                        $return .= '<h1>Pregunta '.$question->getSequence().'</h1>';
                        for ($i = 0 ; $i < $question->getCompositionQuestion()->count() ; $i++) {
                            $compostion = $question->getCompositionQuestion()->offsetGet($i);
                            if ($compostion instanceof CompositionQuestion) {
                                if ($compostion->getType() == 1 || $compostion->getType() == 2) {
                                    if ($compostion->getLink() != '') {
                                        $return .= '<p class="pImg"><img src="'.$compostion->getLink().'"></p>';
                                    } else {
                                        $return .= '<p>'.$compostion->getText().'</p>';
                                    }
                                } else {
                                    if ($compostion->getAnswer()) {
                                        if ($compostion->getLink() != '') {
                                            $return .= '<p class="pImgTrue"><img src="'.$compostion->getLink().'"></p>';
                                        } else {
                                            $return .= '<p class="pTrue">'.$compostion->getText().'</p>';
                                        }
                                    } else {
                                        if ($compostion->getLink() != '') {
                                            $return .= '<p class="pImgFalse"><img src="'.$compostion->getLink().'"></p>';
                                        } else {
                                            $return .= '<p class="pFalse">'.$compostion->getText().'</p>';
                                        }
                                    }
                                }
                                
                            }
                        }
                        $return .= '
                            </div>';
                    }
                    
                }
                $return .= '
                        
            		</div>
            		<div class="lateralMenu">
            			<ul id="ulLateralMenu">';
                for ($k = 0 ; $k < $exercise->getQuestions()->count() ; $k++) {
                    $question = $exercise->getQuestions()->offsetGet($k);
                    if ($question instanceof Question) {
                        if ($k == 0) {
                            $return .= '<li id="'. ($k + 1) .'" class="selected" onclick="insertNewQuestion('. ($k + 1) .', ' . $idExercise . ')">Pregunta '. ($k + 1) .'</li>';
                        } else {
                            $return .= '<li id="'. ($k + 1) .'" onclick="insertNewQuestion('. ($k + 1) .', ' . $idExercise . ')">Pregunta '. ($k + 1) .'</li>';
                        }
                    }
                }
                $return .= '<script>
                                setNumberQuestion('. ($exercise->getQuestions()->count() + 1) .');
                            </script>
            				<li id="'. ($exercise->getQuestions()->count() + 1) .'" onclick="insertNewQuestion('. ($exercise->getQuestions()->count() + 1) .', ' . $idExercise . ')">+ Nueva Pregunta</li>
            			</ul>
            		</div>';
            }
        }
        
        
        
        $this->content = $return;
    }
    
    public function viewExercisesReleased (Exercises $exercise) {
        if ($exercise->getReleased()) {
            return '<input type="checkbox" name="released" value="1" checked>';
        } else {
            return '<input type="checkbox" name="released" value="1">';
        }
    }
    
    public function setViewEditExercises (Courses $course) {
        $return = '';
        $exercise = $course->getExercises()->offsetGet(0);
        if ($exercise instanceof Exercises) {
            $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="editExercise">
                        <input type="hidden" value="index.php?site='.Rotas::$COURSES_INSTRUCTOR.'&subSite='.Rotas::$EDIT_EXERCISES.'" name="rota">
                        <input type="hidden" value="'.$exercise->getIdExercise().'" name="idExercise">
                        <input type="hidden" value="'.$exercise->getIdTask().'" name="idTask">
                        <table class="form">
                            <tr>
                                <td class="left">Título Ejercicio*
                                <td class="right"><input name="nameExercise" value="'.$exercise->getName().'">
                            <tr>
                                <td class="left">Peso Ejercicio*
                                <td class="right"><input name="weightExercise" value="'.$exercise->getWeightTask().'">
                            <tr>
                                <td class="left">Fecha Limite*
                                <td class="right"><input name="dateLimit" value="'.$exercise->getDateLimit()->format("d/m/Y H:i:s").'">
                            <tr>
                                <td class="left">Liberado para los estudiantes
                                <td class="right">'.$this->viewExercisesReleased($exercise).'
                            <tr>
                                <td colspan="2"><button type="submit">Guardar</button>
                        </table>
                    </form>';
        }
        
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
    
    public function setViewAllExercisesStudent (ArrayObject $exercises, Courses $course) {
        $return = '';
        $return .= '
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Curso" />
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Data</th>
                        <th colspan="2" class="actions"></th>
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
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_DATA_EXERCISES."&idExercise=".$exercise->getIdExercise()."')".'" src="imagens/view.png">
                        <td><img class="imgButton" onclick="carregarPagina('."'#dataTab', 'index.php?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$OPEN_EXERCISE_STUDENT."&idExercise=".$exercise->getIdExercise()."'".')" src="imagens/enter.png">
                    </tr>
                ';
            }
        }
        
        
        $return .= '</tbody>
            </table>';
        
        
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
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_EDIT_EXERCISES."&idExercise=".$exercise->getIdExercise()."')".'" src="imagens/editar.png">
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_INFO_EXERCISE."&idExercise=".$exercise->getIdExercise()."')".'" src="imagens/view.png">
                        <td><img class="imgButton" onclick="carregarPagina('."'#dataTab', 'index.php?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$OPEN_EXERCISE_INSTRUCTOR."&idExercise=".$exercise->getIdExercise()."'".')" src="imagens/enter.png">
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
        <h1 class="line">Cursos Disponibles</h1>
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
            $repeated = false;
            for ($j = 0 ; $j < $arrayRegistered->count() ; $j++) {
                $couseR = $arrayRegistered->offsetGet($j);
                if ($course instanceof Courses) {
                    if ($couseR->getId() == $course->getId()) {
                        $repeated = true;
                    }
                }
                
            }
            if (!$repeated) {
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
        <h1 class="line">Cursos Matriculados</h1>
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
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_ALL_EXERCISES."&idCourse=".$course->getId()."'".')">Ejercicios</a></li>
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_ALL_TAREAS."&idCourse=".$course->getId()."'".')">Tareas</a></li>
                            <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_GRADES_INSTRUCTOR."&idCourse=".$course->getId()."'".')">Resultados</a></li>
                        </ul>
                    </div>
                                
                    <div id="dataTab">
                        <script>
                            carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_INSTRUCTOR."&subSite=".Rotas::$VIEW_NEWS_COURSE."&idCourse=".$course->getId()."'".');
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
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_ALL_EXERCISES_STUDENTS."&idCourse=".$course->getId()."'".')">Ejercicios</a></li>
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_ALL_UPLOAD_TASKS_STUDENT."&idCourse=".$course->getId()."'".')">Tareas</a></li>
                <li><a href="#" onclick="carregarPagina('."'#dataTab', '?site=".Rotas::$COURSES_STUDENTS."&subSite=".Rotas::$VIEW_GRADES_STUDENT."&idCourse=".$course->getId()."'".')">Notas</a></li>
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