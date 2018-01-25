<?php


class SendEmail {
    private $emails;
    private $assunto = "Sem Assunto";
    private $mensagem;
    private $headers;
    
    public function __construct() {
        $this->headers  = 'MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    }
    
    public function inserirEmails($email) {
        $this->emails[] = $email;
    }
    
    public function getAssunto () {
        return $this->assunto;
    }
    
    public function setAssunto ($assunto) {
        $this->assunto = $assunto;
    }
    
    public function getMensagem () {
        return $this->mensagem;
    }
    
    public function setMensagem ($mensagem) {
        $this->mensagem = $mensagem;
    }
    
    public function enviar() {
        $todosEnviados = true;
        for ($i = 0 ; $i < count($this->emails) ; $i++) {
            if (!mail($this->emails[$i], $this->assunto, $this->mensagem, $this->headers)) {
                $todosEnviados = false;
            }
        }
        
        return $todosEnviados;
    }
    
}