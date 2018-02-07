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
            <option value="África do Sul">África do Sul</option>
            <option value="Albânia">Albânia</option>
            <option value="Alemanha">Alemanha</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antigua">Antigua</option>
            <option value="Arábia Saudita">Arábia Saudita</option>
            <option value="Argentina">Argentina</option>
            <option value="Armênia">Armênia</option>
            <option value="Aruba">Aruba</option>
            <option value="Austrália">Austrália</option>
            <option value="Áustria">Áustria</option>
            <option value="Azerbaijão">Azerbaijão</option>
            <option value="Bahamas">Bahamas</option>
            <option value="Bahrein">Bahrein</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Barbados">Barbados</option>
            <option value="Bélgica">Bélgica</option>
            <option value="Benin">Benin</option>
            <option value="Bermudas">Bermudas</option>
            <option value="Botsuana">Botsuana</option>
            <option value="Brasil">Brasil</option>
            <option value="Brunei">Brunei</option>
            <option value="Bulgária">Bulgária</option>
            <option value="Burkina Fasso">Burkina Fasso</option>
            <option value="botão">botão</option>
            <option value="Cabo Verde">Cabo Verde</option>
            <option value="Camarões">Camarões</option>
            <option value="Camboja">Camboja</option>
            <option value="Canadá">Canadá</option>
            <option value="Cazaquistão">Cazaquistão</option>
            <option value="Chade">Chade</option>
            <option value="Chile">Chile</option>
            <option value="China">China</option>
            <option value="Cidade do Vaticano">Cidade do Vaticano</option>
            <option value="Colômbia">Colômbia</option>
            <option value="Congo">Congo</option>
            <option value="Coréia do Sul">Coréia do Sul</option>
            <option value="Costa do Marfim">Costa do Marfim</option>
            <option value="Costa Rica">Costa Rica</option>
            <option value="Croácia">Croácia</option>
            <option value="Dinamarca">Dinamarca</option>
            <option value="Djibuti">Djibuti</option>
            <option value="Dominica">Dominica</option>
            <option value="EUA">EUA</option>
            <option value="Egito">Egito</option>
            <option value="El Salvador">El Salvador</option>
            <option value="Emirados Árabes">Emirados Árabes</option>
            <option value="Equador">Equador</option>
            <option value="Eritréia">Eritréia</option>
            <option value="Escócia">Escócia</option>
            <option value="Eslováquia">Eslováquia</option>
            <option value="Eslovênia">Eslovênia</option>
            <option value="Espanha">Espanha</option>
            <option value="Estônia">Estônia</option>
            <option value="Etiópia">Etiópia</option>
            <option value="Fiji">Fiji</option>
            <option value="Filipinas">Filipinas</option>
            <option value="Finlândia">Finlândia</option>
            <option value="França">França</option>
            <option value="Gabão">Gabão</option>
            <option value="Gâmbia">Gâmbia</option>
            <option value="Gana">Gana</option>
            <option value="Geórgia">Geórgia</option>
            <option value="Gibraltar">Gibraltar</option>
            <option value="Granada">Granada</option>
            <option value="Grécia">Grécia</option>
            <option value="Guadalupe">Guadalupe</option>
            <option value="Guam">Guam</option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guiana">Guiana</option>
            <option value="Guiana Francesa">Guiana Francesa</option>
            <option value="Guiné-bissau">Guiné-bissau</option>
            <option value="Haiti">Haiti</option>
            <option value="Holanda">Holanda</option>
            <option value="Honduras">Honduras</option>
            <option value="Hong Kong">Hong Kong</option>
            <option value="Hungria">Hungria</option>
            <option value="Iêmen">Iêmen</option>
            <option value="Ilhas Cayman">Ilhas Cayman</option>
            <option value="Ilhas Cook">Ilhas Cook</option>
            <option value="Ilhas Curaçao">Ilhas Curaçao</option>
            <option value="Ilhas Marshall">Ilhas Marshall</option>
            <option value="Ilhas Turks & Caicos">Ilhas Turks & Caicos</option>
            <option value="Ilhas Virgens (brit.)">Ilhas Virgens (brit.)</option>
            <option value="Ilhas Virgens(amer.)">Ilhas Virgens(amer.)</option>
            <option value="Ilhas Wallis e Futuna">Ilhas Wallis e Futuna</option>
            <option value="Índia">Índia</option>
            <option value="Indonésia">Indonésia</option>
            <option value="Inglaterra">Inglaterra</option>
            <option value="Irlanda">Irlanda</option>
            <option value="Islândia">Islândia</option>
            <option value="Israel">Israel</option>
            <option value="Itália">Itália</option>
            <option value="Jamaica">Jamaica</option>
            <option value="Japão">Japão</option>
            <option value="Jordânia">Jordânia</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Latvia">Latvia</option>
            <option value="Líbano">Líbano</option>
            <option value="Liechtenstein">Liechtenstein</option>
            <option value="Lituânia">Lituânia</option>
            <option value="Luxemburgo">Luxemburgo</option>
            <option value="Macau">Macau</option>
            <option value="Macedônia">Macedônia</option>
            <option value="Madagascar">Madagascar</option>
            <option value="Malásia">Malásia</option>
            <option value="Malaui">Malaui</option>
            <option value="Mali">Mali</option>
            <option value="Malta">Malta</option>
            <option value="Marrocos">Marrocos</option>
            <option value="Martinica">Martinica</option>
            <option value="Mauritânia">Mauritânia</option>
            <option value="Mauritius">Mauritius</option>
            <option value="México">México</option>
            <option value="Moldova">Moldova</option>
            <option value="Mônaco">Mônaco</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Nepal">Nepal</option>
            <option value="Nicarágua">Nicarágua</option>
            <option value="Niger">Niger</option>
            <option value="Nigéria">Nigéria</option>
            <option value="Noruega">Noruega</option>
            <option value="Nova Caledônia">Nova Caledônia</option>
            <option value="Nova Zelândia">Nova Zelândia</option>
            <option value="Omã">Omã</option>
            <option value="Palau">Palau</option>
            <option value="Panamá">Panamá</option>
            <option value="Papua-nova Guiné">Papua-nova Guiné</option>
            <option value="Paquistão">Paquistão</option>
            <option value="Peru" selected>Peru</option>
            <option value="Polinésia Francesa">Polinésia Francesa</option>
            <option value="Polônia">Polônia</option>
            <option value="Porto Rico">Porto Rico</option>
            <option value="Portugal">Portugal</option>
            <option value="Qatar">Qatar</option>
            <option value="Quênia">Quênia</option>
            <option value="Rep. Dominicana">Rep. Dominicana</option>
            <option value="Rep. Tcheca">Rep. Tcheca</option>
            <option value="Reunion">Reunion</option>
            <option value="Romênia">Romênia</option>
            <option value="Ruanda">Ruanda</option>
            <option value="Rússia">Rússia</option>
            <option value="Saipan">Saipan</option>
            <option value="Samoa Americana">Samoa Americana</option>
            <option value="Senegal">Senegal</option>
            <option value="Serra Leone">Serra Leone</option>
            <option value="Seychelles">Seychelles</option>
            <option value="Singapura">Singapura</option>
            <option value="Síria">Síria</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="St. Kitts & Nevis">St. Kitts & Nevis</option>
            <option value="St. Lúcia">St. Lúcia</option>
            <option value="St. Vincent">St. Vincent</option>
            <option value="Sudão">Sudão</option>
            <option value="Suécia">Suécia</option>
            <option value="Suiça">Suiça</option>
            <option value="Suriname">Suriname</option>
            <option value="Tailândia">Tailândia</option>
            <option value="Taiwan">Taiwan</option>
            <option value="Tanzânia">Tanzânia</option>
            <option value="Togo">Togo</option>
            <option value="Trinidad & Tobago">Trinidad & Tobago</option>
            <option value="Tunísia">Tunísia</option>
            <option value="Turquia">Turquia</option>
            <option value="Ucrânia">Ucrânia</option>
            <option value="Uganda">Uganda</option>
            <option value="Uruguai">Uruguai</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Vietnã">Vietnã</option>
            <option value="Zaire">Zaire</option>
            <option value="Zâmbia">Zâmbia</option>
            <option value="Zimbábue">Zimbábue</option>
            </select>';
    }
    
    
    public static function javaScriptForISO($string) {
        $string = str_replace('Ã­', 'í', $string);
        $string = str_replace('â€“', '-', $string);
        $string = str_replace('ÃŽ', 'Î', $string); 
        $string = str_replace('Ãž', 'Þ', $string);
        $string = str_replace('ÃŸ', 'ß', $string);
        $string = str_replace('Ã™', 'Ù', $string);
        $string = str_replace('ÃŠ', 'Ê', $string);
        $string = str_replace('Ãš', 'Ú', $string);
        $string = str_replace('ÃŒ', 'Ì', $string);
        $string = str_replace('Ãœ', 'Ü', $string);
        $string = str_replace('Ãº', 'ú', $string);
        $string = str_replace('Ãƒ', 'Ã', $string);
        $string = str_replace('Ãª', 'ê', $string);
        $string = str_replace('Ã³', 'ó', $string);
        $string = str_replace('Ã²', 'ò', $string);
        $string = str_replace('Ã¹', 'ù', $string);
        $string = str_replace('Ã¾', 'þ', $string);
        $string = str_replace('Ã½', 'ý', $string);
        $string = str_replace('Ã¼', 'ü', $string);
        $string = str_replace('Ã‰', 'É', $string);
        $string = str_replace('Ã•', 'Õ', $string);
        $string = str_replace('Ã‡', 'Ç', $string);
        $string = str_replace('Ã†', 'Æ', $string);
        $string = str_replace('Ã…', 'Å', $string);
        $string = str_replace('Ã·', '÷', $string);
        $string = str_replace('Ãµ', 'õ', $string);
        $string = str_replace('Ã°', 'ð', $string);
        $string = str_replace('Ã®', 'î', $string);
        $string = str_replace('Ã©', 'é', $string);
        $string = str_replace('Ã§', 'ç', $string);
        $string = str_replace('Ã»', 'û', $string);
        $string = str_replace('Ã«', 'ë', $string);
        $string = str_replace('Ã±', 'ñ', $string);
        $string = str_replace('Ã€', 'À', $string);
        $string = str_replace('Ã¥', 'å', $string);
        $string = str_replace('Ã¤', 'ä', $string);
        $string = str_replace('Ã£', 'ã', $string);
        $string = str_replace('Ã¢', 'â', $string);
        $string = str_replace('Ã›', 'Û', $string);
        $string = str_replace('Ã‹', 'Ë', $string);
        $string = str_replace('Ã„', 'Ä', $string);
        $string = str_replace('Ã”', 'Ô', $string);
        $string = str_replace('Ã“', 'Ó', $string);
        $string = str_replace('Ã‚', 'Â', $string);
        $string = str_replace('Ã’', 'Ò', $string);
        $string = str_replace('Ã‘', 'Ñ', $string);
        $string = str_replace('Ã˜', 'Ø', $string);
        $string = str_replace('Ã¿', 'ÿ', $string);
        $string = str_replace('Ã¸', 'ø', $string);
        $string = str_replace('Ã´', 'ô', $string);
        $string = str_replace('Ã¯', 'ï', $string);
        $string = str_replace('Ã¨', 'è', $string);
        $string = str_replace('Ã¦', 'æ', $string);
        $string = str_replace('Ã¡', 'á', $string);
        $string = str_replace('Ãˆ', 'È', $string);
        $string = str_replace('Ã—', '×', $string);
        $string = str_replace('Ã–', 'Ö', $string);
        $string = str_replace('Ã', 'ì', $string);
        $string = str_replace('Ã', 'à', $string);
        
        return $string;
    }
    
	//Converter Caracteres especiais para linguagem lida no JAVAScript 
	public static function caracteresEspeciaisParaJAVAScript($string){
		$string = str_replace('ï¿½', '&Agrave;', $string);
		$string = str_replace('ï¿½', '&Aacute;', $string);
		$string = str_replace('ï¿½', '&Acirc;', $string);
		$string = str_replace('ï¿½', '&Atilde;', $string);
		$string = str_replace('ï¿½', '&Auml;', $string);
		$string = str_replace('ï¿½', '&Aring;', $string);
		$string = str_replace('ï¿½', '&AElig;', $string);
		$string = str_replace('ï¿½', '&Ccedil;', $string);
		$string = str_replace('ï¿½', '&Egrave;', $string);
		$string = str_replace('ï¿½', '&Eacute;', $string);
		$string = str_replace('ï¿½', '&Ecirc;', $string);
		$string = str_replace('ï¿½', '&Euml;', $string);
		$string = str_replace('ï¿½', '&Igrave;', $string);
		$string = str_replace('ï¿½', '&Iacute;', $string);
		$string = str_replace('ï¿½', '&Icirc;', $string);
		$string = str_replace('ï¿½', '&Iuml;', $string);
		$string = str_replace('ï¿½', '&ETH;', $string);
		$string = str_replace('ï¿½', '&Ntilde;', $string);
		$string = str_replace('ï¿½', '&Ograve;', $string);
		$string = str_replace('ï¿½', '&Oacute;', $string);
		$string = str_replace('ï¿½', '&Ocirc;', $string);
		$string = str_replace('ï¿½', '&Otilde;', $string);
		$string = str_replace('ï¿½', '&Ouml;', $string);
		$string = str_replace('ï¿½', '&Oslash;', $string);
		$string = str_replace('ï¿½', '&Ugrave;', $string);
		$string = str_replace('ï¿½', '&Uacute;', $string);
		$string = str_replace('ï¿½', '&Ucirc;', $string);
		$string = str_replace('ï¿½', '&Uuml;', $string);
		$string = str_replace('ï¿½', '&Yacute;', $string);
		$string = str_replace('ï¿½', '&THORN;', $string);
		$string = str_replace('ï¿½', '&szlig;', $string);
		$string = str_replace('ï¿½', '&agrave;', $string);
		$string = str_replace('ï¿½', '&aacute;', $string);
		$string = str_replace('ï¿½', '&acirc;', $string);
		$string = str_replace('ï¿½', '&atilde;', $string);
		$string = str_replace('ï¿½', '&auml;', $string);
		$string = str_replace('ï¿½', '&aring;', $string);
		$string = str_replace('ï¿½', '&aelig;', $string);
		$string = str_replace('ï¿½', '&ccedil;', $string);
		$string = str_replace('ï¿½', '&egrave;', $string);
		$string = str_replace('ï¿½', '&eacute;', $string);
		$string = str_replace('ï¿½', '&ecirc;', $string);
		$string = str_replace('ï¿½', '&euml;', $string);
		$string = str_replace('ï¿½', '&igrave;', $string);
		$string = str_replace('ï¿½', '&iacute;', $string);
		$string = str_replace('ï¿½', '&icirc;', $string);
		$string = str_replace('ï¿½', '&iuml;', $string);
		$string = str_replace('ï¿½', '&eth;', $string);
		$string = str_replace('ï¿½', '&ntilde;', $string);
		$string = str_replace('ï¿½', '&ograve;', $string);
		$string = str_replace('ï¿½', '&oacute;', $string);
		$string = str_replace('ï¿½', '&ocirc;', $string);
		$string = str_replace('ï¿½', '&otilde;', $string);
		$string = str_replace('ï¿½', '&ouml;', $string);
		$string = str_replace('ï¿½', '&oslash;', $string);
		$string = str_replace('ï¿½', '&ugrave;', $string);
		$string = str_replace('ï¿½', '&uacute;', $string);
		$string = str_replace('ï¿½', '&ucirc;', $string);
		$string = str_replace('ï¿½', '&uuml;', $string);
		$string = str_replace('ï¿½', '&yacute;', $string);
		$string = str_replace('ï¿½', '&thorn;', $string);
		$string = str_replace('ï¿½', '&yuml;', $string);
		$string = str_replace('ï¿½', '&OElig;', $string);
		$string = str_replace('ï¿½', '&oelig;', $string);
		$string = str_replace('ï¿½', '&Scaron;', $string);
		$string = str_replace('ï¿½', '&scaron;', $string);
		$string = str_replace('ï¿½', '&Yuml;', $string);
		$string = str_replace('ï¿½', '&fnof;', $string);
		$string = str_replace('ï¿½', '&deg;', $string);
		$string = str_replace('ï¿½', '&deg;', $string);
	
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
	
	//Criar um calendï¿½rio selecionï¿½vel com data e hora em um input
	public static function datetimepicker($nome) {
		return "
					<script>
					$(function() {
					    $( '#".$nome."' ).datetimepicker({
					    	dateFormat: 'dd/mm/yy',
					    	showOtherMonths: true,
					        selectOtherMonths: true,
					        dayNames: ['Domingo','Segunda','Terï¿½a','Quarta','Quinta','Sexta','Sï¿½bado','Domingo'],
					        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sï¿½b','Dom'],
					        monthNames: ['Janeiro','Fevereiro','Marï¿½o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
					    });
					});
					</script>";
	}
	//Criar um calendï¿½rio selecionï¿½vel com data
	public static function datepicker($nome) {
		return "
					<script>
					$(function() {
					    $( '#".$nome."' ).datepicker({
					    	dateFormat: 'dd/mm/yy',
					    	showOtherMonths: true,
					        selectOtherMonths: true,
					        dayNames: ['Domingo','Segunda','Terï¿½a','Quarta','Quinta','Sexta','Sï¿½bado','Domingo'],
					        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sï¿½b','Dom'],
					        monthNames: ['Janeiro','Fevereiro','Marï¿½o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
					    });
					});
					</script>
	
	
					";
	}
	//Verifica se a data, ï¿½ uma data brasileira vï¿½lida
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
		$string = str_replace("ï¿½","A", $string);
		$string = str_replace("ï¿½","A", $string);
		$string = str_replace("ï¿½","A", $string);
		$string = str_replace("ï¿½","A", $string);
		$string = str_replace("ï¿½","E", $string);
		$string = str_replace("ï¿½","E", $string);
		$string = str_replace("ï¿½","E", $string);
		$string = str_replace("ï¿½","I", $string);
		$string = str_replace("ï¿½","O", $string);
		$string = str_replace("ï¿½","O", $string);
		$string = str_replace("ï¿½","O", $string);
		$string = str_replace("ï¿½","O", $string);
		$string = str_replace("ï¿½","U", $string);
		$string = str_replace("ï¿½","C", $string);
	
		$string = str_replace("ï¿½","a", $string);
		$string = str_replace("ï¿½","a", $string);
		$string = str_replace("ï¿½","a", $string);
		$string = str_replace("ï¿½","a", $string);
		$string = str_replace("ï¿½","e", $string);
		$string = str_replace("ï¿½","e", $string);
		$string = str_replace("ï¿½","e", $string);
		$string = str_replace("ï¿½","i", $string);
		$string = str_replace("ï¿½","o", $string);
		$string = str_replace("ï¿½","o", $string);
		$string = str_replace("ï¿½","o", $string);
		$string = str_replace("ï¿½","o", $string);
		$string = str_replace("ï¿½","u", $string);
		$string = str_replace("ï¿½","c", $string);
	
		$string = str_replace("ï¿½","", $string);
		$string = str_replace("ï¿½","", $string);
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
	//Gerar senha aleatï¿½rio
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
