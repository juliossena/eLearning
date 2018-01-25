<?php

$requires = "";
$requires[] = 'app/view/View.php';

for ($i = 0 ; $i < count($requires) ; $i ++) {
    $cont = 0;
    while (!file_exists($requires[$i])) {
        $requires[$i] = '../' . $requires[$i];
        $cont++;
    }
    require_once $requires[$i];
}

class VInstructors implements View {
    
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
    
    public function setEditInstructor (Users $user) {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="editAdministrator">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre*
                                <td class="right"><input name="nameUser" value="'.$user->getName().'">
                            <tr>
                                <td class="left">Correo Electrónico*
                                <td class="right"><input name="emailUser" value="'.$user->getEmail().'" disabled>
                            <tr>
                                <td class="left">Fecha de Nacimiento
                                <td class="right"><input name="dateBirth" value="'.$user->getDateBirth()->format('d/m/Y').'" style="width:130px;" maxlength="10">
                            <tr>
                                <td class="left">Contraseña*
                                <td class="right"><input name="passUser" type="password" value="'.$user->getPassword().'" style="width:180px;">
                            <tr>
                                <td class="left">Repetir Contraseña*
                                <td class="right"><input name="passUser2" type="password"  value="'.$user->getPassword().'" style="width:180px;">
                            <tr>
                                <td class="left">Ciudad
                                <td class="right"><input name="city" value="'.$user->getCity().'" style="width:150px;">
                            <tr>
                                <td class="left">País
                                <td class="right">'.Commands::allCountrys('country').'
                            <tr>
                                <td colspan="2"><button type="submit">Save</button>
                                    
                        </table>
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewInstructor (Users $user) {
        $return = '';
        $return .= '
            <table class="form">
                            <tr>
                                <td class="left">Nombre*
                                <td class="right"><input name="nameUser" value="'.$user->getName().'" disabled>
                            <tr>
                                <td class="left">Correo Electrónico*
                                <td class="right"><input name="emailUser" value="'.$user->getEmail().'" disabled>
                            <tr>
                                <td class="left">Fecha de Nacimiento
                                <td class="right"><input name="dateBirth" value="'.$user->getDateBirth()->format('d/m/Y').'" style="width:130px;"  disabled>
                            <tr>
                                <td class="left">Contraseña*
                                <td class="right"><input name="passUser" type="password" value="'.$user->getPassword().'" style="width:180px;"  disabled>
                            <tr>
                                <td class="left">Repetir Contraseña*
                                <td class="right"><input name="passUser2" type="password"  value="'.$user->getPassword().'" style="width:180px;"  disabled>
                            <tr>
                                <td class="left">Ciudad
                                <td class="right"><input name="city" value="'.$user->getCity().'" style="width:150px;"  disabled>
                            <tr>
                                <td class="left">País
                                <td class="right"><input name="city" value="'.$user->getCountry().'" style="width:150px;"  disabled>
                            <tr>
                                <td colspan="2"><button type="button" onclick="carregarPagina ('."'#dadosNovaPagina', 'index.php?site=".Rotas::$INSTRUCTORS."&subSite=".Rotas::$VIEW_EDIT_INSTRUCTOR."&emailUser=".$user->getEmail()."'".')">Editar</button>
                                    
                        </table>
        ';
        
        $this->content = $return;
    }
    
    public function setNewInstructor () {
        $return = '';
        $return .= '<script type="text/javascript" src="js/script.js"></script>
                    <div id="result"></div>
                    <form id="createInstructor">
                        <table class="form">
                            <tr>
                                <td class="left">Nombre*
                                <td class="right"><input name="nameUser">
                            <tr>
                                <td class="left">Correo Electrónico*
                                <td class="right"><input name="emailUser">
                            <tr>
                                <td class="left">Fecha de Nacimiento*
                                <td class="right"><input name="dateBirth" style="width:130px;" maxlength="10">
                            <tr>
                                <td class="left">Contraseña*
                                <td class="right"><input name="passUser" type="password" style="width:180px;">
                            <tr>
                                <td class="left">Repetir Contraseña*
                                <td class="right"><input name="passUser2" type="password" style="width:180px;">
                            <tr>
                                <td class="left">Ciudad
                                <td class="right"><input name="city" style="width:150px;">
                            <tr>
                                <td class="left">País
                                <td class="right">'.Commands::allCountrys('country').'
                            <tr>
                                <td colspan="2"><input type="checkbox" name="sendPassword" id="sendPassword" value="sendPassword"><label for="sendPassword">Enviar contraseña al correo electrónico</label>
                            <tr>
                                <td colspan="2"><button type="submit">Save</button>
                                    
                        </table>
                                    
                    </form>';
        
        $this->content = $return;
    }
    
    public function setViewAllInstructors () {
        $return = '';
        $return .= '
        <script type="text/javascript" src="js/jquery.quick.search.js"></script>
        <button onclick="carregarPaginaAtivarCheck('."'#dadosNovaPagina', 'index.php?site=".Rotas::$INSTRUCTORS."&subSite=".Rotas::$NEW_INSTRUCTOR."'".')">Crear Nuevo Instructor</button>
        <input type="text" class="input-search" alt="lista-clientes" placeholder="Buscar Administrador" />
            <table class="lista-clientes" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th colspan="3" class="actions"></th>
                    </tr>
                </thead>
        ';
        
        $users = new Users();
        $users->setType(2);
        $filter = new FilterUsers($users);
        $userDAO = new UsersDAO();
        
        $users = $userDAO->getObjects($filter);
        
        for ($i = 0 ; $i < $users->count() ; $i++) {
            $user = $users->offsetGet($i);
            if ($user instanceof Users) {
                $return .= '
                    <tr id="tr_'.$user->getId().'">
                        <td align="center">'.$user->getName().'</td>
                        <td align="center">'.$user->getEmail().'</td>
                        <td><img class="imgButton" onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$INSTRUCTORS."&subSite=".Rotas::$VIEW_INSTRUCTOR."&emailUser=".$user->getEmail()."')".'" src="imagens/view.png">
                        <td><img class="imgButton"  onclick="'."carregarPaginaAtivarCheck('#dadosNovaPagina', 'index.php?site=".Rotas::$INSTRUCTORS."&subSite=".Rotas::$VIEW_EDIT_INSTRUCTOR."&emailUser=".$user->getEmail()."')".'" src="imagens/editar.png">
                        <td><img class="imgButton" onclick="deleteUser('."'".$user->getEmail()."', 'index.php?site=".Rotas::$INSTRUCTORS."&subSite=".Rotas::$DELETE_INSTRUCTOR."', '".$user->getId()."'".')" src="imagens/excluir.png">
                    </tr>
                ';
            }
        }
        
        
        $return .= '</tbody>
            </table>';
        
        $this->content = $return;
    }
    
}