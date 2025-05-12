<?php
    $errored = false;

    if (!isset($_FILES['file'])) {
        http_response_code(400);
        die();
    }

    $files = $_FILES['file']['tmp_name'];
    $path = explode("/", $_FILES['file']['full_path'][0])[0];

    //File count check

    if (count($files) > 1000) {
        http_response_code(400);
        $errored = true;
    }

    // Total file size check

    if (array_sum($_FILES['file']['size']) > 10737418240) {
        $errored = true;
        http_response_code(413);
    }

    // Media type check

    $supported_media_types = [
        "video/x-matroska",
        "video/x-msvideo",
        "video/matroska",
        "video/mp4",
        "video/mpeg",
        "video/ogg",
        "video/mp2t",
        "video/webm",
        "video/3gpp",
        "video/3gpp2"
    ];

    $media_type_check_ok = false;
    foreach ($_FILES['file']['type'] as $media_type) {
        if (in_array($media_type, $supported_media_types)) {
            $media_type_check_ok = true;
        }
    }

    if (!$media_type_check_ok) {
        $errored = true;
        http_response_code(415);
    }
    
    // If no checks failed, upload to server

    if (!$errored) {
        foreach ($files as $i => $file) {
            $dir = "uploads/".str_replace($_FILES['file']['name'][$i], "", $_FILES['file']['full_path'][$i]);
            
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            if (!move_uploaded_file($file, 'uploads/'.$_FILES['file']['full_path'][$i])) {
                $errored = true;
            };
        }
    }
?>

    <?php if ($errored) { ?>
        Parece que el servidor no ha podido subir tus archivos. <br /> 
        Asegurate de que:
        <ul>
            <li>El formato es correcto</li>    
            <li>No has subido mas de 1000 archivos a la vez (o menos de 1)</li>
            <li>Todos tus archivos no superan los 10 GB</li>
        </ul>
        Actualiza la pagina para continuar.
    <?php } else { ?>
        <div class="success">
            <p>
                Tus archivos se han subido correctamente.
            </p>
            <p>
                La carpeta "<strong><?= $path ?></strong>" se ha creado correctamente en el servidor y debería aparecer en Jellyfin dentro de poco. <br />
            </p>
            <p>
                Para subir mas, refresca la pagina y selecciona otra carpeta.
            </p>
        </div>
    <?php } ?>
