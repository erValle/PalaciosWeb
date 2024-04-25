<?php
    require_once('e14.inc.php');
    require_once('e14-lib.php');

    session_start();
    if( !isset($_SESSION['auth']) ) {
        // No autentificado
        header("Location: $SITE/e14-login.php");
        exit;
    }
        
    $user = user_get($_GET['id']);
    if( !$user ) {
        header("Location $SITE/e14-panel.php");
        exit;
    }
?>
<!DOCTYPE html>
<head>
    <title>Ejemplo PHP</title>
    <meta charset="utf-8">
</head>
<body>

    <?php if( isset($_GET['error']) ) :?>
    <p style="color: red">
        <?php if( $_GET['error']=='void' ) { echo "Campos vacios"; }?>
        <?php if( $_GET['error']=='password' ) { echo "Contraseñas no coinciden"; }?>
    </p>
    <?php endif; ?>

    <form method="post" action="e14-controller.php/edit?id=<?php echo $_GET['id']?>"> 
        <p>
            EMAIL <input type="text" name="email" value="<?php echo $user['email'];?>">
        </p>
        <p>
            PASSWORD <input type="password" name="password">
        </p>
        <p>
            PASSWORD (repetir) <input type="password" name="password1">
        </p>
        <p>
            NOMBRE <input type="text" name="nombre" value="<?php echo $user['nombre'];?>">
        </p>        
        <p>
            APELLIDOS <input type="text" name="apellidos" value="<?php echo $user['apellidos'];?>">
        </p>        
        <p>
            <button>Modificar</button>
        </p>
    </form>
</body>
</html>