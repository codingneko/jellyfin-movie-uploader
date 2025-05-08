<?php
    $errored = false;

    if (!isset($_FILES['file'])) {
        http_response_code(400);
        die();
    }

    $files = $_FILES['file']['tmp_name'];
    $path = explode("/", $_FILES['file']['full_path'][0])[0];

    if (count($files) > 10) {
        http_response_code(400);
        $errored = true;
    }

    if (array_sum($_FILES['file']['size']) > 10737418240) {
        $errored = 1;
        http_response_code(413);
    }

    if (!(
        in_array("video/x-msvideo", $_FILES['file']['type']) ||
        in_array("video/mp4", $_FILES['file']['type']) ||
        in_array("video/mpeg", $_FILES['file']['type']) ||
        in_array("video/ogg", $_FILES['file']['type']) ||
        in_array("video/mp2t", $_FILES['file']['type']) ||
        in_array("video/webm", $_FILES['file']['type']) ||
        in_array("video/3gpp", $_FILES['file']['type']) ||
        in_array("video/3gpp2", $_FILES['file']['type'])
        )) {
        $errored = 1;
        http_response_code(415);
    }


    if (!$errored) {
        foreach ($files as $i => $file) {
            $dir = "uploads/".str_replace($_FILES['file']['name'][$i], "", $_FILES['file']['full_path'][$i]);
            
            if (!is_dir($dir)) {
                mkdir($dir);
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
            <li>No has subido mas de 10 archivos a la vez (o menos de 1)</li>
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
