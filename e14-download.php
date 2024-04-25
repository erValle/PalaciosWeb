<?php
    $id = $_GET['id'];

    $file_data = json_decode(file_get_contents('e14-files.json'), true);
    foreach($file_data as $f) {
        if( $f['id']==$id ) {
            // descarga
            header('Content-Type: application/octet-stream');
            // header('Content-Type: '.$f['mimetype']);
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"" . $f['name'] . "\""); 
            header('Content-Length: '.$f['size']);
            readfile($f['path']); 
        }
    }
    // Error