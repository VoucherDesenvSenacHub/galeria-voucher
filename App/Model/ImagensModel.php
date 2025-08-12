<?php

require_once __DIR__ . "/BaseModel.php";

class ImagensModel extends BaseModel {

    private $nameImage;
    private $originalName;
    private $router;


    public function __construct() {
        parent::__construct();
        $this->tableName = "imagem";
    }

    public function getEstatisticas() {



        
    }



    }