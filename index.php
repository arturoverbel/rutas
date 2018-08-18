<?php

    $nombre = '';
    if( !empty($_GET) ){
        $nombre = $_GET['estacion'];
    }else if ( !empty($_POST) ){
        $nombre = $_POST['estacion'];
    }
    
    
    $servername = "localhost";
    $username = "admin";
    $password = "admin";

    $conn = new mysqli($servername, $username, $password, 'rutasestaciones');
    header('Content-Type: application/json');
    $return = [
        'error' => 0,
        'data' => []
    ];
    
    // Check connection
    if ($conn->connect_error) { 
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        $return['error'] = '2';
    }
    
    $sql = "SELECT estaciones.Nombre, rutas.nombre, estaciones_has_rutas.vagon FROM estaciones_has_rutas "
            . "INNER JOIN estaciones ON estaciones_has_rutas.Estaciones_idEstaciones=estaciones.idEstaciones "
            . "INNER JOIN rutas ON estaciones_has_rutas.Rutas_idRutas=rutas.idRutas ";
    
    if( !empty($nombre)){
        $sql .= "WHERE estaciones.nombre='" . $nombre . "'";
    }
    
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $return['data'][] = $row;
        }
    }
    
    $conn->close();
    
    
    echo json_encode($return);