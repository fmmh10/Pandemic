<?php


class API {
    
    
    public function run(){
        
        $metodo = key_exists('metodo', $_POST);
        
        if(!$metodo){
            throw new Exception('Necessario especificar o metodo');
        }
        
        switch($metodo){
            case 'getJogadaActual' : 
                $this->getJogadaActual();
                break;
            default: 
                throw new Exception('Metodo invalido');
        }
        
    }
    
    /**
     * 
     */
    public function getJogadaActual(){
        $jogo = $_POST['jogo'];
        
        global $conn;

        echo json_encode(array('jogada' => verificaNumeroJogadasFeitas($jogo, $conn)));
        
        
    }
}



$api = new API;
$api->run();