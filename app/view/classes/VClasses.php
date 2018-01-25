<?php

$requires = "";
$requires[] = 'app/view/View.php';
$requires[] = 'app/config/Commands.php';
$requires[] = 'app/models/classes/Classes.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class VClasses implements View {
    
    private $content;
    private $user;
    
    public function __construct(Users $user) {
        $this->user = $user;
    }
    
    public function getView() {
        return $this->getCorpo();
    }
    
    private function getCorpo(){
        return $this->content;
    }
    
    public function setInsertSuccess () {
        $this->content = "Inserido con éxito";
    }
    
    public function setInsertFail () {
        $this->content = "Error al insertar";
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
    
    public function viewEmailsStudentsSelect (ArrayObject $students) {
        $return = '';
        for ($i = 0 ; $i < $students->count() ; $i++) {
            $student = $students->offsetGet($i);
            if ($student instanceof Users) {
                $return .= $student->getEmail() . ', ';
            }
        }
        return $return;
    }
    
    public function setViewClasses (Classes $class, ArrayObject $arrayStudents) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                        <input name="rota" type="hidden" value = "index.php?site='.Rotas::$CLASSES.'&subSite='.Rotas::$EDIT_CLASS.'">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre Clase*
                                <td class="right"><input type="hidden" name="idClass" value="'.$class->getId().'"><input name="nameClass" value="'.$class->getName().'" disabled>
                            <tr>
                                <td class="left">Descripción
                                <td class="right"><input name="description" value="'.$class->getDescription().'" disabled>
                                    
                            <tr>
                                <td colspan="2"><br>Estudiantes del Clase:<br><br>
                    <textarea id="selectActive" class="selectActive" disabled>'.$this->viewEmailsStudentsSelect($class->getStudents()).'</textarea>
                    <script type="text/javascript" src="js/jquery.quick.search.js"></script>
                    <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
                    <div class="frameSelect"><table id="formSelect" class="lista-clientes">
                ';
        
        for ($i = 0 ; $i < $arrayStudents->count() ; $i++) {
            $student = $arrayStudents->offsetGet($i);
            if ($student instanceof Users) {
                $return .= $this->viewStudentsSelect($student, $class->getStudents());
                $return .= '<tr>
                        <input class="check" checked type="checkbox" id="td'.$student->getId().'" name="td'.$student->getId().'" value="'.$student->getEmail().'">
                        <td class="tdSelect" id="label'.$student->getId().'">
                        '.$student->getName().'
                                            ';
            }
        }
        
        
        $return .='
                    </table></div>
                    </tr>
                            <tr>
                                <td colspan="2"><button type="button" onclick="carregarPagina ('."'#dadosNovaPagina', 'index.php?site=".Rotas::$CLASSES."&subSite=".Rotas::$VIEW_EDIT_CLASS."&idClass=".$class->getId()."'".')">Editar</button>
            
                        </table>
            ';
        
        
        $this->content = $return;
    }
    
    public function setViewEditClasses (Classes $class, ArrayObject $arrayStudents) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="editClass">
                        <input name="rota" type="hidden" value = "index.php?site='.Rotas::$CLASSES.'&subSite='.Rotas::$EDIT_CLASS.'">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre Clase*
                                <td class="right"><input type="hidden" name="idClass" value="'.$class->getId().'"><input name="nameClass" value="'.$class->getName().'">
                            <tr>
                                <td class="left">Descripción
                                <td class="right"><input name="description" value="'.$class->getDescription().'">
            
                            <tr>
                                <td colspan="2"><br>Estudiantes del Clase:<br><br>
                    <textarea id="selectActive" class="selectActive">'.$this->viewEmailsStudentsSelect($class->getStudents()).'</textarea>
                    <script type="text/javascript" src="js/jquery.quick.search.js"></script>
                    <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
                    <div class="frameSelect"><table id="formSelect" class="lista-clientes">
                ';
        
        for ($i = 0 ; $i < $arrayStudents->count() ; $i++) {
            $student = $arrayStudents->offsetGet($i);
            if ($student instanceof Users) {
                $return .= $this->viewStudentsSelect($student, $class->getStudents());
                $return .= '<tr>
                        <input class="check" checked type="checkbox" id="td'.$student->getId().'" name="td'.$student->getId().'" value="'.$student->getEmail().'">
                        <td class="tdSelect" id="label'.$student->getId().'" onclick="selectList('.$student->getId().')">
                        '.$student->getName().'
                                            ';
            }
        }
        
        
        $return .='
                    </table></div>
                    </tr>
                            <tr>
                                <td colspan="2"><button type="submit">Guardar</button>
            
                        </table>
            
                    </form>';
        
        
        $this->content = $return;
    }
    
    public function setNewClasses (ArrayObject $arrayStudents) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="createClass">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre Clase*
                                <td class="right"><input name="nameClass">
                            <tr>
                                <td class="left">Descripción
                                <td class="right"><input name="description">

                            <tr>
                                <td colspan="2"><br>Estudiantes del Clase:<br><br>
                    <textarea id="selectActive" class="selectActive"></textarea>
                    <script type="text/javascript" src="js/jquery.quick.search.js"></script>
                    <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Estudiante" />
                    <div class="frameSelect"><table id="formSelect" class="lista-clientes">
                ';
                    
        for ($i = 0 ; $i < $arrayStudents->count() ; $i++) {
            $student = $arrayStudents->offsetGet($i);
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
                    </tr>
                            <tr>
                                <td colspan="2"><button type="submit">Create</button>
                                    
                        </table>
                                    
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewAllClasses (ArrayObject $array) {
        $return = '';
        $return .= '
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <button onclick="carregarPaginaAtivarCheck('."'#dadosNovaPagina', 'index.php?site=".Rotas::$CLASSES."&subSite=".Rotas::$NEW_CLASS."'".')">Crear Nueva Clase</button>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Clase" />
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Qtd Students</th>
                        <th colspan="3" class="actions"></th>
                    </tr>
                </thead>
        ';
        
        for ($i = 0 ; $i < $array->count() ; $i++) {
            $class = $array->offsetGet($i);
            if ($class instanceof Classes) {
                $return .= '
                    <tr id="tr_'.$class->getId().'">
                        <td align="center">'.$class->getName().'</td>
                        <td align="center">'.$class->getDescription().'</td>
                        <td align="center">'.$class->getStudents()->count().'</td>
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$CLASSES."&subSite=".Rotas::$VIEW_CLASS."&idClass=".$class->getId()."')".'" src="imagens/view.png">
                        <td><img class="imgButton"  onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$CLASSES."&subSite=".Rotas::$VIEW_EDIT_CLASS."&idClass=".$class->getId()."')".'" src="imagens/editar.png">
                        <td><img class="imgButton" onclick="deleteClass('."'".$class->getId()."', 'index.php?site=".Rotas::$CLASSES."&subSite=".Rotas::$DELETE_CLASS."', '".$class->getId()."'".')" src="imagens/excluir.png">
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