<?php
    require("e14.inc.php"):

    define('UPLOAD_DIR', '\\xampp7433\\appdata');

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['archivo']['error']) ||
        is_array($_FILES['archivo']['error'])
    ) {
        header("Location: $SITE/e14-panel.php?error=uploadparams");
        exit;
    }

    // Check $_FILES['archivo']['error'] value.
    switch ($_FILES['archivo']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            header("Location:  $SITE/e14-panel.php?error=nofile");
            exit;
            case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            header("Location:  $SITE/e14-panel.php?error=filesize");
            exit;
        default:
            header("Location:  $SITE/e14-panel.php?error=uploaderror");
            exit;
    }

    // You should also check filesize here. 
    if ($_FILES['archivo']['size'] > 1024000) {
        header("Location:  $SITE/e14-panel.php?error=filesize");
        exit;
    }

    // DO NOT TRUST $_FILES['archivo']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($_FILES['archivo']['tmp_name']);
    if (false === $ext = array_search(
        $mime_type,
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        header("Location:  $SITE/e14-panel.php?error=fileformat");
        exit;
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['archivo']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $path = sprintf(UPLOAD_DIR.'\\%s', sha1_file($_FILES['archivo']['tmp_name']));
    if (!move_uploaded_file(
        $_FILES['archivo']['tmp_name'],
        $path
    )) {
        header("Location:  $SITE/e14-panel.php?error=uploaderror");
        exit;
    }

    $file_data = json_decode(file_get_contents('e14-files.json'), true);
    $file_data[] = [
        // 'id' => str_replace(".","",number_format(microtime(true),6,".","")),
        // 'id' => md5("127.0.0.1-1710238720"),
        'id' => uniqid('',true),
        'path' => $path,
        'name' => $_FILES['archivo']['name'],
        'mimetype' => $mime_type,
        'size' => filesize($path)
    ];
    file_put_contents('e14-files.json', json_encode($file_data, JSON_PRETTY_PRINT));

    header("Location:  $SITE/e14-panel.php");
    exit;
?>



