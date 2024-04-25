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

    <form method="post" action="e14-controler.php/register">  
        <p>
            EMAIL <input type="text" name="email">
        </p>
        <p>
            PASSWORD <input type="password" name="password">
        </p>
        <p>
            PASSWORD (repetir) <input type="password" name="password1">
        </p>
        <p>
            NOMBRE <input type="text" name="nombre">
        </p>        
        <p>
            APELLIDOS <input type="text" name="apellidos">
        </p>        
        <p>
            <button>Registrar</button>
        </p>
    </form>
</body>
</html>
