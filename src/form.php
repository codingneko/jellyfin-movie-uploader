<form hx-post="upload.php" hx-encoding="multipart/form-data" class="form" id="form">
    <div>
        Sube los archivos de la pelicula aqui
    </div>
    <div>
        <input type="file" name="file[]" webkitdirectory multiple />
    </div>
    <div class="warning">
        <p>
            Debes subir la carpeta completa. <br />
            Si la pelicula que has descargado es un solo archivo, 
            metelo dentro de una carpeta llamada como la pelicula, 
            y el año en que salió entre parentesis, por ejemplo: <br />
            <strong>Conclave (2024)</strong>
        </p>
    </div>
    <progress id='progress' value='0' max='100'></progress>
    <div>
        <button>Subir</button>
    </div>
</form>

<script>
    htmx.on('#form', 'htmx:xhr:progress', function(evt) {
        htmx.find('#progress').setAttribute('value', evt.detail.loaded/evt.detail.total * 100)
    });

    document.body.addEventListener('htmx:beforeSwap', function(evt) {
        switch (evt.detail.xhr.status) {
            case 413:
                evt.detail.shouldSwap = true;
                break;
            case 400:
                evt.detail.shouldSwap = true;
                break;
            case 500:
                alert("Algo ha fallado en el servidor, intentalo de nuevo");
                break;
        
            default:
                break;
        }
    });
</script>