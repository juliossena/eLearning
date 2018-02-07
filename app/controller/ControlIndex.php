<?php

require_once '../app/models/Rotas.php';
require_once '../app/controller/ControlAccess.php';
require_once '../app/controller/view/CTelaLogin.php';
require_once '../app/controller/view/CTelaHome.php';
require_once '../app/controller/view/CTelaAdministrator.php';
require_once '../app/controller/view/CTelaInstructor.php';
require_once '../app/controller/view/CTelaStudent.php';
require_once '../app/controller/view/CTelaClasses.php';
require_once '../app/controller/view/CTelaCourse.php';
require_once '../app/controller/view/CTelaCourseStudent.php';
require_once '../app/controller/view/CTelaCourseInstructor.php';


class ControlIndex {
	private $tela;
	
	public function defineRota() {
		
	    $controlAccess = new ControlAccess();
		
		$site = null;
		if (isset($_REQUEST['site'])) {
		    $site = $_REQUEST['site'];
		}
		
		try {
		    
		    $user = $controlAccess->startSession();
			switch ($site) {
			    
			    case Rotas::$CLASSES:
			        if ($user->possuiPermissao(Rotas::$COD_CLASSES)) {
			            $controle = new CTelaClasses($user);
			            $tela = $controle->getScreen();
			            echo $tela->getView();
			        }
			        break;
			    case Rotas::$INSTRUCTORS:
			        if ($user->possuiPermissao(Rotas::$COD_INSTRUCTORS)) {
			            $controle = new CTelaInstructor($user);
			            $tela = $controle->getScreen();
			            echo $tela->getView();
			        }
			        break;
			    case Rotas::$STUDENTS:
			        if ($user->possuiPermissao(Rotas::$COD_STUDENTS)) {
			            $controle = new CTelaStudent($user);
			            $tela = $controle->getScreen();
			            echo $tela->getView();
			        }
			        break;
			    case Rotas::$ADMINISTRATORS:
			        if ($user->possuiPermissao(Rotas::$COD_ADMINISTRATORS)) {
			            $controle = new CTelaAdministrator($user);
			            $tela = $controle->getScreen();
			            echo $tela->getView();
			        }
			        break;
			    case Rotas::$COURSES:
			        if ($user->possuiPermissao(Rotas::$COD_COURSES)) {
			            $controle = new CTelaCourse($user);
			            $tela = $controle->getScreen();
			            echo $tela->getView();
			        }
			        break;
			    case Rotas::$COURSES_STUDENTS:
			        if ($user->possuiPermissao(Rotas::$COD_COURSES_STUDENTS)) {
			            $controle = new CTelaCourseStudent($user);
			            $tela = $controle->getScreen();
			            echo $tela->getView();
			        }
			        break;
			    case Rotas::$COURSES_INSTRUCTOR:
			        if ($user->possuiPermissao(Rotas::$COD_COURSES_INSTRUCTOR)) {
			            $controle = new CTelaCourseInstructor($user);
			            $tela = $controle->getScreen();
			            echo $tela->getView();
			        }
			        break;
			    case Rotas::$OPEN_IMG_PERFIL:
    		        $email = $_REQUEST['emailUser'];
    		        if (file_exists('../dados/perfis/' . $email . '.jpg')) {
		              echo Commands::downloadArquivo('dados/perfis/', $email . '.jpg', 'image/jpeg');
    		        } else {
    		            echo Commands::downloadArquivo('dados/perfis/', 'usuario.jpg', 'image/jpeg');
    		        }
    		        break;
			    case Rotas::$OPEN_IMG:
			        $nameImg = $_REQUEST['nameImg'];
			        echo Commands::downloadArquivo('dados/imgs/', $nameImg, 'image/jpeg');
			        break;
				case Rotas::$LOGOFF:
				    session_destroy();
				    header("Location: index.php");
				    break;
				default:
				    $controle = new CTelaHome($user);
				    $tela = $controle->getScreen();
				    echo $tela->getView();
				    break;
			}
			
		} catch (LoginException $ex) {
			$controle = new CTelaLogin();
			$tela = $controle->getScreen();
			$tela->setMsgUsuarioInvalido($ex->getMessage());
			
			echo $tela->getView();
		} catch (FirstAccessException $ex) {
		    //Caso o aluno esteja clicando em esqueci senha
		    /*if (isset($_REQUEST['site']) && $site == 'esqueciSenha') {
		        $controle = new CTelaEsqueciSenha();
		        $tela = $controle->getTela();
		    } else {*/
		        $controle = new CTelaLogin();
		        $tela = $controle->getTela();
		    //}
			echo $tela->getView(); 
		}
		
	}
}