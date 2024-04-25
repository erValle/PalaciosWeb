<?php
    require_once('e14.inc.php');
    require_once('e14-lib.php');
    require_once('User.class.php');
    require_once('Administrador.class.php');

    $PATH = $_SERVER['PATH_INFO'];
    
    if( $PATH=='/login' ) {
        // Procesar datos
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Validación
        if( $email=='' || $password=='' ) {
            header("Location: $SITE/e14-login.php?error=void");
            exit;
        }
        // Control logic
        $user = user_get($email);        
        if( $user==null ) {
            // Usuario no existe. Reenviamos al formulario de login
            header("Location: $SITE/e14-login.php?error=user");
            exit;
        }
        else {
            if( $user->password!=md5($password) ) {
                // Contraseña incorrecta. Reenviamos al formulario de login
                header("Location: $SITE/e14-login.php?error=password");
                exit;
            }
            else {
                session_start();
                $_SESSION['auth'] = true;
                // unset($user->password);
                if( $user->email == 'admin@localhost.local' ) {
                    $_SESSION['user'] = new Administrador($user);
                }
                else {
                    $_SESSION['user'] = new User($user);
                }
                // Exito de login. Redirigimos a una pagina interna de la aplicacion
                header("Location: $SITE/e14-panel.php");
                exit;
            }
        }
    }
    else if( $PATH=='/register' ) {
        // Procesar datos
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password1 = $_POST['password1'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        // Validación
        if( $email=='' || $password=='' ) {
            header("Location: $SITE/e14-register.php?error=void");
            exit;
        }
        if( $password!=$password1 ) {
            header("Location: $SITE/e14-register.php?error=password");
            exit;
        }                

        // Control logic
        $res = user_add([
            'email' => $email,
            'password' => md5($password),
            'nombre' => $nombre,
            'apellidos' => $apellidos
        ]);
        if( $res!==true ) {
            // Usuario no existe. Reenviamos al formulario de login
            header("Location: $SITE/e14-register.php?error=register");
            exit;
        }
        else {
            header("Location: $SITE/e14-login.php");
            exit;
        }
    }    

    //===================================================
    //  OPERACIONES QUE REQUIEREN SESION
    //===================================================
    
    session_start();
    if( !isset($_SESSION['auth']) ) {
        // No autentificado
        header('Location: e14-login.php');
        exit;
    }

    if( $PATH=='/profile' ) {
        
    }   
    else if( $PATH=='/edit' ) {
        // Procesar datos
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password1 = $_POST['password1'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        // Validación
        if( $email=='' ) {
            header('Location: e14-edit.php?id='.$email.'error=void');
            exit;
        }
        if( $password!='' && ($password!=$password1) ) {
            header('Location: e14-edit.php?id='.$email.'error=password');
            exit;
        }                

        // Control logic
        $res = user_edit($email, [
            'email' => $email,
            'password' => $password,
            'nombre' => $nombre,
            'apellidos' => $apellidos
        ]);
        if( $res!==true ) {
            // Usuario no existe. Reenviamos al formulario de login
            header('Location: e14-panel.php');
            exit;
        }
        else {
            header('Location: e14-panel.php?error=edit');
            exit;
        }
    }
    else if( $PATH=='/delete' ) {
        $user = user_get($_GET['id']);
        if( !$user ) {
            header("Location: e14-panel.php?error=delete");
            exit;
        }

        user_delete($_GET['id']);
        header("Location: e14-panel.php");
        exit;
    }
    else {
        echo "Action not allowed";
        exit;
    } 

