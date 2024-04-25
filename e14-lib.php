<?php
define('FICHERO_DATOS', __DIR__."\\e14.json");

/**
 * Devuelve los usuarios en el fichero como un array de datos hash
 */
function user_get_all() 
{
    if( !file_exists(FICHERO_DATOS) ) {
        user_save([]);
    }
    $users = json_decode(file_get_contents(FICHERO_DATOS), false);
    // Post processsing
    return $users;
}

/**
 * Obtiene un usuario concreto a partir de su email
 * 
 * @param email     Correo
 * 
 * @return mixed|null
 */
function user_get($email) 
{
    $users = user_get_all();
    foreach($users as $u) {
        if( $u->email==$email ) {
            return $u;
        }
    }
    return null;
}

function user_edit($email, $data) 
{
    $success = false;
    $users = user_get_all();
    foreach($users as &$u) {
        if( $u->email==$email ) {
            $u->dni = $data['dni'];
            $u->nombre = $data['nombre'];
            $u->apellidos = $data['apellidos'];
            $u->email = $data['email'];
            if( $data['password']!='' ) {
                $u->password = md5($data['password']);
            }
            $success = true;
        }
    }
    // Guardar los datos
    user_save($users);
    return $success;
}

function user_delete($email) 
{
    $success = false;
    $users = user_get_all();
    foreach($users as $key => &$u) {
        if( $u->email==$email ) {
            unset($users[$key]);
            // ...
            $success = true;
        }
    }
    // Guardar los datos
    user_save($users);
    return $success;
}

function user_add($data) 
{
    // Posible validacion de datos
    $users = user_get_all();
    $users[] = $data;    
    // Guardar los datos
    user_save($users);
    return true;
}

function user_save($users)
{
    file_put_contents(FICHERO_DATOS, json_encode($users, JSON_PRETTY_PRINT));
}
?>