<?php

    $estaciones = [
        'calle_39' => [
            'rutas' => 2,
        ],
        'calle_45' => [
            'rutas' => 1,
        ]
        
    ];
    
    header('Content-Type: application/json');
    $return = [];
    
    foreach ($estaciones as $estacion => $datos) {
        
        $url = "http://127.0.0.1:8085/rutas/index.php?estacion=" . $estacion;
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
//        var_dump($output);
//        echo "<br>";
        $result = json_decode($output, true);
        
        if( empty($result) ){
            echo "Está vacio<br>";
            continue;
        }
        
        if( count($result['data']) == $datos['rutas'] ){
            $return[$estacion][] = "Coinciden numero de rutas. ";
        }else{
            $return[$estacion][] = "No coinciden numero de rutas. ";
        }
        
        curl_close($ch);
    }
    
    echo json_encode($return);
    
