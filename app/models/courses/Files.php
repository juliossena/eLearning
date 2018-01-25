<?php

class Files {
    private $id;
    private $name;
    private $location;
    private $extensao;
    private $type;
    private $thumbnail;
    
    public function getId() {
             return $this->id;
    }
    
    public function setId($id) {
             $this->id = $id;
    }
    
    public function getName() {
             return $this->name;
    }
    
    public function setName($name) {
             $this->name = $name;
    }
    
    public function getLocation() {
             return $this->location;
    }
    
    public function setLocation($location) {
             $this->location = $location;
             $extensao = explode(".", $location);
             $this->extensao = $extensao[count($extensao) - 1];
             
             if ($this->extensao == "jpg" || $this->extensao == "jpeg") {
                 $this->type = "image/jpeg";
             } else if ($this->extensao == "gif") {
                 $this->type = "image/gif";
             } else if ($this->extensao == "png") {
                 $this->type = "image/png";
             } else {
                 $this->type = "";
             }
    }
    
    public function getThumbnail() {
        return $this->thumbnail;
    }
    
    public function setThumbnail ($thumbnail) {
        $this->thumbnail = $thumbnail;
    }
    
    
    public function getType() {
        return $this->type;
    }
    
    
    public function getImgIcone() {
        if ($this->extensao == "doc") {
            return 'imagens/icones/iconePdf.png';
        } else if ($this->extensao == "docx") {
            return 'imagens/icones/iconeDocx.png';
        } else if ($this->extensao == "xls") {
            return 'imagens/icones/iconeXls.png';
        } else if ($this->extensao == "xlsx") {
            return 'imagens/icones/iconeXlsx.png';
        } else if ($this->extensao == "gif") {
            return 'imagens/icones/iconeGif.png';
        } else if ($this->extensao == "jpg") {
            return 'imagens/icones/iconeJpg.png';
        } else if ($this->extensao == "jpeg") {
            return 'imagens/icones/iconeJpg.png';
        } else if ($this->extensao == "png") {
            return 'imagens/icones/iconePng.png';
        } else if ($this->extensao == "ppt") {
            return 'imagens/icones/iconePpt.png';
        } else if ($this->extensao == "pptx") {
            return 'imagens/icones/iconePptx.png';
        } else if ($this->extensao == "rar") {
            return 'imagens/icones/iconeRar.png';
        } else if ($this->extensao == "txt") {
            return 'imagens/icones/iconeTxt.png';
        } else if ($this->extensao == "zip") {
            return 'imagens/icones/iconeZip.png';
        }
        
        return 'imagens/icones/iconePdf.png';
    }
    
}