<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/flatly-bootstrap.min.css">
    <link rel="shortcut icon" href="./img/pokeball.png" type="image/x-icon">
</head>
<body>
    
    <?php require_once('./partials/menu.php'); ?>

    <div class="container mt-2">
        <table class="table table-hover table-striped">
            <tr>
                <th>Imagen</th>
                <th>Número</th>
                <th>Nombre</th>
                <th>Región</th>
                <th>Tipo</th>
                <th>Altura</th>
                <th>Peso</th>
                <th>Evolución</th>
            </tr>
            <tr>
                <td>
                    <?php
                        // get details of the uploaded file
                        $fileTmpPath = $_FILES['fileLangHTML']['tmp_name'];
                        $fileName = $_FILES['fileLangHTML']['name'];
                        $fileSize = $_FILES['fileLangHTML']['size'];
                        $fileType = $_FILES['fileLangHTML']['type'];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));
                        $name = './img/'.$_POST['inputNumero'].'.'.$fileExtension;
                        move_uploaded_file($fileTmpPath, $name);
                        // echo $_FILES['fileLangHTML']['tmp_name'].'<br>';
                        // echo $_FILES['fileLangHTML']['name'].'<br>';

                    ?>
                    <img src="<?php echo $name ?>" alt="" height="100" width="100">
                </td>
                <td><?php echo $_POST['inputNumero']; ?></td>
                <td><?php echo $_POST['inputNombre']; ?></td>
                <td><?php echo $_POST['selectRegion']; ?></td>
                <td>
                    <?php
                        if (isset($_POST['checkTipo'])) {
                            foreach ($_POST['checkTipo'] as $tipo) {
                                echo $tipo . '<br>';
                            }
                        }
                        else {
                            echo 'No hay tipo';
                        }
                    ?>
                </td>
                <td><?php echo $_POST['inputAltura'].' cm' ?></td>
                <td><?php echo $_POST['inputPeso'].' Kg' ?></td>
                <td>
                    <?php
                        echo $_POST['radioEvolucion'];
                    ?>
                </td>
                
            </tr>

        </table>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


</html>