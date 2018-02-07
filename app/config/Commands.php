<?php
class Commands {
    
    
    public static function limitCharacters ($string, $lenght = 128) {
        if (strlen($string) > $lenght) {
            return substr($string, 0, $lenght) . ' [...]';
        } else {
            return $string;
        }
    }
    public static function passMinutesForDateTime ($minutes) {
        $hour = 0;
        $days = 0;
        if ($minutes >= 60) {
            $hour = $minutes / 60;
            $minutes = $minutes % 60;
            if ($hour > 24) {
                $days = $hour / 24;
                $hour = $hour % 24;
            }
        }
        $hour = (int)$hour;
        $days = (int)$days;
        $minutes = (int)$minutes;
        if (strlen($hour) == 1) {
            $hour = '0' . $hour;
        }
        if (strlen($days) == 1) {
            $days = '0' . $days;
        }
        if (strlen($minutes) == 1) {
            $minutes = '0' . $minutes;
        }
        return DateTime::createFromFormat("d:H:i", $days . ':' . $hour . ':' . $minutes);
    }
    public static function passDateTimeForMinutes (DateTime $dateTime) {
        $hour = $dateTime->format("H");
        $minutes = $dateTime->format("i");
        return ($hour * 60) + $minutes;
    }
    public static function allCountrys ($nameSelect){
        return '<select name='.$nameSelect.'>
            <option value="�frica do Sul">�frica do Sul</option>
            <option value="Alb�nia">Alb�nia</option>
            <option value="Alemanha">Alemanha</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antigua">Antigua</option>
            <option value="Ar�bia Saudita">Ar�bia Saudita</option>
            <option value="Argentina">Argentina</option>
            <option value="Arm�nia">Arm�nia</option>
            <option value="Aruba">Aruba</option>
            <option value="Austr�lia">Austr�lia</option>
            <option value="�ustria">�ustria</option>
            <option value="Azerbaij�o">Azerbaij�o</option>
            <option value="Bahamas">Bahamas</option>
            <option value="Bahrein">Bahrein</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Barbados">Barbados</option>
            <option value="B�lgica">B�lgica</option>
            <option value="Benin">Benin</option>
            <option value="Bermudas">Bermudas</option>
            <option value="Botsuana">Botsuana</option>
            <option value="Brasil">Brasil</option>
            <option value="Brunei">Brunei</option>
            <option value="Bulg�ria">Bulg�ria</option>
            <option value="Burkina Fasso">Burkina Fasso</option>
            <option value="bot�o">bot�o</option>
            <option value="Cabo Verde">Cabo Verde</option>
            <option value="Camar�es">Camar�es</option>
            <option value="Camboja">Camboja</option>
            <option value="Canad�">Canad�</option>
            <option value="Cazaquist�o">Cazaquist�o</option>
            <option value="Chade">Chade</option>
            <option value="Chile">Chile</option>
            <option value="China">China</option>
            <option value="Cidade do Vaticano">Cidade do Vaticano</option>
            <option value="Col�mbia">Col�mbia</option>
            <option value="Congo">Congo</option>
            <option value="Cor�ia do Sul">Cor�ia do Sul</option>
            <option value="Costa do Marfim">Costa do Marfim</option>
            <option value="Costa Rica">Costa Rica</option>
            <option value="Cro�cia">Cro�cia</option>
            <option value="Dinamarca">Dinamarca</option>
            <option value="Djibuti">Djibuti</option>
            <option value="Dominica">Dominica</option>
            <option value="EUA">EUA</option>
            <option value="Egito">Egito</option>
            <option value="El Salvador">El Salvador</option>
            <option value="Emirados �rabes">Emirados �rabes</option>
            <option value="Equador">Equador</option>
            <option value="Eritr�ia">Eritr�ia</option>
            <option value="Esc�cia">Esc�cia</option>
            <option value="Eslov�quia">Eslov�quia</option>
            <option value="Eslov�nia">Eslov�nia</option>
            <option value="Espanha">Espanha</option>
            <option value="Est�nia">Est�nia</option>
            <option value="Eti�pia">Eti�pia</option>
            <option value="Fiji">Fiji</option>
            <option value="Filipinas">Filipinas</option>
            <option value="Finl�ndia">Finl�ndia</option>
            <option value="Fran�a">Fran�a</option>
            <option value="Gab�o">Gab�o</option>
            <option value="G�mbia">G�mbia</option>
            <option value="Gana">Gana</option>
            <option value="Ge�rgia">Ge�rgia</option>
            <option value="Gibraltar">Gibraltar</option>
            <option value="Granada">Granada</option>
            <option value="Gr�cia">Gr�cia</option>
            <option value="Guadalupe">Guadalupe</option>
            <option value="Guam">Guam</option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guiana">Guiana</option>
            <option value="Guiana Francesa">Guiana Francesa</option>
            <option value="Guin�-bissau">Guin�-bissau</option>
            <option value="Haiti">Haiti</option>
            <option value="Holanda">Holanda</option>
            <option value="Honduras">Honduras</option>
            <option value="Hong Kong">Hong Kong</option>
            <option value="Hungria">Hungria</option>
            <option value="I�men">I�men</option>
            <option value="Ilhas Cayman">Ilhas Cayman</option>
            <option value="Ilhas Cook">Ilhas Cook</option>
            <option value="Ilhas Cura�ao">Ilhas Cura�ao</option>
            <option value="Ilhas Marshall">Ilhas Marshall</option>
            <option value="Ilhas Turks & Caicos">Ilhas Turks & Caicos</option>
            <option value="Ilhas Virgens (brit.)">Ilhas Virgens (brit.)</option>
            <option value="Ilhas Virgens(amer.)">Ilhas Virgens(amer.)</option>
            <option value="Ilhas Wallis e Futuna">Ilhas Wallis e Futuna</option>
            <option value="�ndia">�ndia</option>
            <option value="Indon�sia">Indon�sia</option>
            <option value="Inglaterra">Inglaterra</option>
            <option value="Irlanda">Irlanda</option>
            <option value="Isl�ndia">Isl�ndia</option>
            <option value="Israel">Israel</option>
            <option value="It�lia">It�lia</option>
            <option value="Jamaica">Jamaica</option>
            <option value="Jap�o">Jap�o</option>
            <option value="Jord�nia">Jord�nia</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Latvia">Latvia</option>
            <option value="L�bano">L�bano</option>
            <option value="Liechtenstein">Liechtenstein</option>
            <option value="Litu�nia">Litu�nia</option>
            <option value="Luxemburgo">Luxemburgo</option>
            <option value="Macau">Macau</option>
            <option value="Maced�nia">Maced�nia</option>
            <option value="Madagascar">Madagascar</option>
            <option value="Mal�sia">Mal�sia</option>
            <option value="Malaui">Malaui</option>
            <option value="Mali">Mali</option>
            <option value="Malta">Malta</option>
            <option value="Marrocos">Marrocos</option>
            <option value="Martinica">Martinica</option>
            <option value="Maurit�nia">Maurit�nia</option>
            <option value="Mauritius">Mauritius</option>
            <option value="M�xico">M�xico</option>
            <option value="Moldova">Moldova</option>
            <option value="M�naco">M�naco</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Nepal">Nepal</option>
            <option value="Nicar�gua">Nicar�gua</option>
            <option value="Niger">Niger</option>
            <option value="Nig�ria">Nig�ria</option>
            <option value="Noruega">Noruega</option>
            <option value="Nova Caled�nia">Nova Caled�nia</option>
            <option value="Nova Zel�ndia">Nova Zel�ndia</option>
            <option value="Om�">Om�</option>
            <option value="Palau">Palau</option>
            <option value="Panam�">Panam�</option>
            <option value="Papua-nova Guin�">Papua-nova Guin�</option>
            <option value="Paquist�o">Paquist�o</option>
            <option value="Peru" selected>Peru</option>
            <option value="Polin�sia Francesa">Polin�sia Francesa</option>
            <option value="Pol�nia">Pol�nia</option>
            <option value="Porto Rico">Porto Rico</option>
            <option value="Portugal">Portugal</option>
            <option value="Qatar">Qatar</option>
            <option value="Qu�nia">Qu�nia</option>
            <option value="Rep. Dominicana">Rep. Dominicana</option>
            <option value="Rep. Tcheca">Rep. Tcheca</option>
            <option value="Reunion">Reunion</option>
            <option value="Rom�nia">Rom�nia</option>
            <option value="Ruanda">Ruanda</option>
            <option value="R�ssia">R�ssia</option>
            <option value="Saipan">Saipan</option>
            <option value="Samoa Americana">Samoa Americana</option>
            <option value="Senegal">Senegal</option>
            <option value="Serra Leone">Serra Leone</option>
            <option value="Seychelles">Seychelles</option>
            <option value="Singapura">Singapura</option>
            <option value="S�ria">S�ria</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="St. Kitts & Nevis">St. Kitts & Nevis</option>
            <option value="St. L�cia">St. L�cia</option>
            <option value="St. Vincent">St. Vincent</option>
            <option value="Sud�o">Sud�o</option>
            <option value="Su�cia">Su�cia</option>
            <option value="Sui�a">Sui�a</option>
            <option value="Suriname">Suriname</option>
            <option value="Tail�ndia">Tail�ndia</option>
            <option value="Taiwan">Taiwan</option>
            <option value="Tanz�nia">Tanz�nia</option>
            <option value="Togo">Togo</option>
            <option value="Trinidad & Tobago">Trinidad & Tobago</option>
            <option value="Tun�sia">Tun�sia</option>
            <option value="Turquia">Turquia</option>
            <option value="Ucr�nia">Ucr�nia</option>
            <option value="Uganda">Uganda</option>
            <option value="Uruguai">Uruguai</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Vietn�">Vietn�</option>
            <option value="Zaire">Zaire</option>
            <option value="Z�mbia">Z�mbia</option>
            <option value="Zimb�bue">Zimb�bue</option>
            </select>';
    }
    
    
    public static function javaScriptForISO($string) {
        $string = str_replace('í', '�', $string);
        $string = str_replace('–', '-', $string);
        $string = str_replace('Î', '�', $string); 
        $string = str_replace('Þ', '�', $string);
        $string = str_replace('ß', '�', $string);
        $string = str_replace('Ù', '�', $string);
        $string = str_replace('Ê', '�', $string);
        $string = str_replace('Ú', '�', $string);
        $string = str_replace('Ì', '�', $string);
        $string = str_replace('Ü', '�', $string);
        $string = str_replace('ú', '�', $string);
        $string = str_replace('Ã', '�', $string);
        $string = str_replace('ê', '�', $string);
        $string = str_replace('ó', '�', $string);
        $string = str_replace('ò', '�', $string);
        $string = str_replace('ù', '�', $string);
        $string = str_replace('þ', '�', $string);
        $string = str_replace('ý', '�', $string);
        $string = str_replace('ü', '�', $string);
        $string = str_replace('É', '�', $string);
        $string = str_replace('Õ', '�', $string);
        $string = str_replace('Ç', '�', $string);
        $string = str_replace('Æ', '�', $string);
        $string = str_replace('Å', '�', $string);
        $string = str_replace('÷', '�', $string);
        $string = str_replace('õ', '�', $string);
        $string = str_replace('ð', '�', $string);
        $string = str_replace('î', '�', $string);
        $string = str_replace('é', '�', $string);
        $string = str_replace('ç', '�', $string);
        $string = str_replace('û', '�', $string);
        $string = str_replace('ë', '�', $string);
        $string = str_replace('ñ', '�', $string);
        $string = str_replace('À', '�', $string);
        $string = str_replace('å', '�', $string);
        $string = str_replace('ä', '�', $string);
        $string = str_replace('ã', '�', $string);
        $string = str_replace('â', '�', $string);
        $string = str_replace('Û', '�', $string);
        $string = str_replace('Ë', '�', $string);
        $string = str_replace('Ä', '�', $string);
        $string = str_replace('Ô', '�', $string);
        $string = str_replace('Ó', '�', $string);
        $string = str_replace('Â', '�', $string);
        $string = str_replace('Ò', '�', $string);
        $string = str_replace('Ñ', '�', $string);
        $string = str_replace('Ø', '�', $string);
        $string = str_replace('ÿ', '�', $string);
        $string = str_replace('ø', '�', $string);
        $string = str_replace('ô', '�', $string);
        $string = str_replace('ï', '�', $string);
        $string = str_replace('è', '�', $string);
        $string = str_replace('æ', '�', $string);
        $string = str_replace('á', '�', $string);
        $string = str_replace('È', '�', $string);
        $string = str_replace('×', '�', $string);
        $string = str_replace('Ö', '�', $string);
        $string = str_replace('�', '�', $string);
        $string = str_replace('�', '�', $string);
        
        return $string;
    }
    
	//Converter Caracteres especiais para linguagem lida no JAVAScript 
	public static function caracteresEspeciaisParaJAVAScript($string){
		$string = str_replace('�', '&Agrave;', $string);
		$string = str_replace('�', '&Aacute;', $string);
		$string = str_replace('�', '&Acirc;', $string);
		$string = str_replace('�', '&Atilde;', $string);
		$string = str_replace('�', '&Auml;', $string);
		$string = str_replace('�', '&Aring;', $string);
		$string = str_replace('�', '&AElig;', $string);
		$string = str_replace('�', '&Ccedil;', $string);
		$string = str_replace('�', '&Egrave;', $string);
		$string = str_replace('�', '&Eacute;', $string);
		$string = str_replace('�', '&Ecirc;', $string);
		$string = str_replace('�', '&Euml;', $string);
		$string = str_replace('�', '&Igrave;', $string);
		$string = str_replace('�', '&Iacute;', $string);
		$string = str_replace('�', '&Icirc;', $string);
		$string = str_replace('�', '&Iuml;', $string);
		$string = str_replace('�', '&ETH;', $string);
		$string = str_replace('�', '&Ntilde;', $string);
		$string = str_replace('�', '&Ograve;', $string);
		$string = str_replace('�', '&Oacute;', $string);
		$string = str_replace('�', '&Ocirc;', $string);
		$string = str_replace('�', '&Otilde;', $string);
		$string = str_replace('�', '&Ouml;', $string);
		$string = str_replace('�', '&Oslash;', $string);
		$string = str_replace('�', '&Ugrave;', $string);
		$string = str_replace('�', '&Uacute;', $string);
		$string = str_replace('�', '&Ucirc;', $string);
		$string = str_replace('�', '&Uuml;', $string);
		$string = str_replace('�', '&Yacute;', $string);
		$string = str_replace('�', '&THORN;', $string);
		$string = str_replace('�', '&szlig;', $string);
		$string = str_replace('�', '&agrave;', $string);
		$string = str_replace('�', '&aacute;', $string);
		$string = str_replace('�', '&acirc;', $string);
		$string = str_replace('�', '&atilde;', $string);
		$string = str_replace('�', '&auml;', $string);
		$string = str_replace('�', '&aring;', $string);
		$string = str_replace('�', '&aelig;', $string);
		$string = str_replace('�', '&ccedil;', $string);
		$string = str_replace('�', '&egrave;', $string);
		$string = str_replace('�', '&eacute;', $string);
		$string = str_replace('�', '&ecirc;', $string);
		$string = str_replace('�', '&euml;', $string);
		$string = str_replace('�', '&igrave;', $string);
		$string = str_replace('�', '&iacute;', $string);
		$string = str_replace('�', '&icirc;', $string);
		$string = str_replace('�', '&iuml;', $string);
		$string = str_replace('�', '&eth;', $string);
		$string = str_replace('�', '&ntilde;', $string);
		$string = str_replace('�', '&ograve;', $string);
		$string = str_replace('�', '&oacute;', $string);
		$string = str_replace('�', '&ocirc;', $string);
		$string = str_replace('�', '&otilde;', $string);
		$string = str_replace('�', '&ouml;', $string);
		$string = str_replace('�', '&oslash;', $string);
		$string = str_replace('�', '&ugrave;', $string);
		$string = str_replace('�', '&uacute;', $string);
		$string = str_replace('�', '&ucirc;', $string);
		$string = str_replace('�', '&uuml;', $string);
		$string = str_replace('�', '&yacute;', $string);
		$string = str_replace('�', '&thorn;', $string);
		$string = str_replace('�', '&yuml;', $string);
		$string = str_replace('�', '&OElig;', $string);
		$string = str_replace('�', '&oelig;', $string);
		$string = str_replace('�', '&Scaron;', $string);
		$string = str_replace('�', '&scaron;', $string);
		$string = str_replace('�', '&Yuml;', $string);
		$string = str_replace('�', '&fnof;', $string);
		$string = str_replace('�', '&deg;', $string);
		$string = str_replace('�', '&deg;', $string);
	
		return $string;
	}
	//Subtrair Hora
	public static function subtrairHora($horaAtual, $horaSubtrair = '00:00:00'){
		list($horas_acesso,$minutos_acesso,$segundos_acesso) = explode(":", $horaSubtrair);
		$horas_acesso1 = $horas_acesso * 3600;
		$minutos_acesso1 = $minutos_acesso * 60;
		$total_acesso = $horas_acesso1 + $minutos_acesso1 + $segundos_acesso;
		list($horas_saida,$minutos_saida,$segundos_saida) = explode(":", $horaAtual);
		$horas_saida1 = $horas_saida * 3600;
		$minutos_saida1 = $minutos_saida * 60;
		$total_saida = $horas_saida1 + $minutos_saida1 + $segundos_saida;
		$total = ($total_saida - $total_acesso);
		$time = ($total/3600);
		list($horas) = explode(".", $time);
		$resto_segundos = ($total % 3600);// resto da divisao por 3600
		$c = ($resto_segundos/60);
		list($minutos) = explode(".", $c);
		$segundos = ($total % 60);
		$permanencia = $horas.":".$minutos.":".$segundos;
		$date = new DateTime($permanencia);
		return $date->format('H:i:s');
	}
	
	//Criar um calend�rio selecion�vel com data e hora em um input
	public static function datetimepicker($nome) {
		return "
					<script>
					$(function() {
					    $( '#".$nome."' ).datetimepicker({
					    	dateFormat: 'dd/mm/yy',
					    	showOtherMonths: true,
					        selectOtherMonths: true,
					        dayNames: ['Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'],
					        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'],
					        monthNames: ['Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
					    });
					});
					</script>";
	}
	//Criar um calend�rio selecion�vel com data
	public static function datepicker($nome) {
		return "
					<script>
					$(function() {
					    $( '#".$nome."' ).datepicker({
					    	dateFormat: 'dd/mm/yy',
					    	showOtherMonths: true,
					        selectOtherMonths: true,
					        dayNames: ['Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'],
					        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'],
					        monthNames: ['Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
					    });
					});
					</script>
	
	
					";
	}
	//Verifica se a data, � uma data brasileira v�lida
	public static function dataValida($data) {
		$data = explode("/", $data);
		if ($data[0]>31 || $data[0] < 1 || $data[1]>12 || $data[1] < 1 || $data[2] < 1){
			return false;
		}else{
			return true;
		}
	}
	//Remover acentos
	public static function removerAcentos($string) {
		$string = str_replace("�","A", $string);
		$string = str_replace("�","A", $string);
		$string = str_replace("�","A", $string);
		$string = str_replace("�","A", $string);
		$string = str_replace("�","E", $string);
		$string = str_replace("�","E", $string);
		$string = str_replace("�","E", $string);
		$string = str_replace("�","I", $string);
		$string = str_replace("�","O", $string);
		$string = str_replace("�","O", $string);
		$string = str_replace("�","O", $string);
		$string = str_replace("�","O", $string);
		$string = str_replace("�","U", $string);
		$string = str_replace("�","C", $string);
	
		$string = str_replace("�","a", $string);
		$string = str_replace("�","a", $string);
		$string = str_replace("�","a", $string);
		$string = str_replace("�","a", $string);
		$string = str_replace("�","e", $string);
		$string = str_replace("�","e", $string);
		$string = str_replace("�","e", $string);
		$string = str_replace("�","i", $string);
		$string = str_replace("�","o", $string);
		$string = str_replace("�","o", $string);
		$string = str_replace("�","o", $string);
		$string = str_replace("�","o", $string);
		$string = str_replace("�","u", $string);
		$string = str_replace("�","c", $string);
	
		$string = str_replace("�","", $string);
		$string = str_replace("�","", $string);
		return $string;
	}
	//Converte Data e Hora Brasileira para americana
	public static function timeStampBraParaUSA ($timeStamp){
		$timeStamp = explode(" ", $timeStamp);
		$resultado = explode("/", $timeStamp[0]);
		return $resultado[2]."-".$resultado[1]."-".$resultado[0]." ".$timeStamp[1];
	}
	//Converte Data e Hora Americana para brasileira
	public static function timeStampUSAParaBRA ($timeStamp){
		$timeStamp = explode(" ", $timeStamp);
		$resultado = explode("-", $timeStamp[0]);
		return $resultado[2]."/".$resultado[1]."/".$resultado[0]." ".$timeStamp[1];
	}
	//Converte da Americana para Brasileira
	public static function dataUSAparaBRA ($data){
		$resultado = explode("-", $data);
		return $resultado[2]."/".$resultado[1]."/".$resultado[0];
	}
	//Converte data Brasileira para Americana
	public static function dataBRAparaUSA($data) {
		$resultado = explode("/", $data);
		return $resultado[2]."-".$resultado[1]."-".$resultado[0];
	}
	//Gerar senha aleat�rio
	public static function gerarSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$retorno = '';
		$caracteres = '';
		$caracteres .= $lmin;
		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;
		$len = strlen($caracteres);
		for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}
	
	//Download de arquivo
	public static function downloadArquivo($localArquivo, $nomeArquivo, $type) {
	    
	    $path = '../' . $localArquivo . $nomeArquivo.'';
		$fp = fopen($path, 'r');
		$buffer = fread($fp, filesize($path));
		fclose($fp);
		header('Content-type: '.$type);
		header('Content-Disposition: attachment; filename="'.$nomeArquivo.'"');
		return print $buffer;
	}
	
// 	public static function downloadArquivoGeral($localArquivo, $nomeArquivo) {
// 		header('Content-Description: File Transfer');
// 		header('Content-Dispositions: attachment; filename="' . $nomeArquivo . '"');
// 		header('Content-Type: application/octet-stream');
// 		header('Content-Transferr')
// 	}
}
