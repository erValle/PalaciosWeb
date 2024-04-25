<!DOCTYPE html>
<head>
    <title>Ejemplo PHP</title>
    <meta charset="utf-8">
</head>
<body>

    <?php if( isset($_GET['error']) ) :?>
    <p style="color: red">
        <?php if( $_GET['error']=='void' ) { echo "Campos vacios"; }?>
        <?php if( $_GET['error']=='user' ) { echo "No existe el usuario" ;}?>
        <?php if( $_GET['error']=='password' ) { echo "Contraseña incorrecta"; }?>
    </p>
    <?php endif; ?>

    <!-- <form method="post" action="e14-controller.php?action=login">  -->
    <form method="post" action="e14-controller.php/login">
        <p>
            EMAIL <input type="text" name="email">
        </p>
        <p>
            PASSWORD <input type="password" name="password">
        </p>
        <p>
            <button>Acceder</button>
        </p>
    </form>
</body>
</html>
