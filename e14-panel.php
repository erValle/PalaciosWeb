<?php
    require_once('e14.inc.php');
    require_once('e14-lib.php');
    require_once('User.class.php');
    require_once('Administrador.class.php');
    
    session_start();
    if( !isset($_SESSION['auth']) ) {
        // No autentificado
        header("Location: $CFG/e14-login.php");
        exit;
    }

    $users = user_get_all();    
?>
<!DOCTYPE html>
<head>
    <title>Ejemplo PHP</title>
    <meta charset="utf-8">
</head>
<body>
    <p>
        <a href="e14-logout.php">Desconectar</a>
    </p>
    <table>
        <thead>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
            <tr>
                <td><?php echo $u->email?></td>
                <td><?php echo $u->nombre?></td>
                <td><?php echo $u->apellidos?></td>
                <td>
                    <?php if($_SESSION['user']->isAdmin()): ?>
                        <a href="e14-controller.php/edit?id=<?php echo $u->email;?>">Editar</a>
                        <a href="e14-controller.php/delete?id=<?php echo $u->email;?>">Eliminar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form method="post" enctype="multipart/form-data" action="e14-uploadfile.php">
        Fichero <input type="file" name="archivo" />
        <button>Subir</button>
    </form>
</body>
</html>