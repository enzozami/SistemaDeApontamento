<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operadores - O-LINKe Medical LTDA</title>
</head>
<body style="background-color: #b5b5b5; width: 100%; height: 100%;">
    <?php 
        include_once "../template/template.php";

        include_once "../script/conexao.php";

        if(is_null($connection)){
            echo"<div class='alert alert-danger fw-bold text-center'>$errorMsg</div>";
            exit();
        }

        $turnos = filter_input(INPUT_POST, "turnos", FILTER_DEFAULT);

        // continuar logica amanha! Mexer no banco!!!!
        $sql = "SELECT * FROM operadores"
    ?>

    <h5 class="text-center mx-auto py-3" style="background-color: rgb(63, 0, 113); color: #fff;">OPERADORES</h5>

    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <select name="turnos" id="turnos" class="text-center d-block w-25 h-100 my-1 mx-auto rounded-pill" onchange="this.form.submit()"> <!-- onchange -->
                        <option value="">Selecione um Turno</option>
                        <option value="primeiro_turno" <?= (isset($_POST['turnos']) && ($_POST['turnos']) == 'primeiro_turno') ? 'selected' : null ?>>1° Turno</option>
                        <option value="segundo_turno" <?= (isset($_POST['turnos']) && ($_POST['turnos']) == 'segundo_turno') ? 'selected' : null ?>>2° Turno</option>
                    </select>
                </div>
                <div id="error-message-turno" style="color: red; display: none">Turno inválido.</div>
            </div>
            <div class="row">
                <div id="primeiro_turno" class="col text-center my-3" style="display: none;">
                    <label for="turno1" class="label-control">Primeiro Turno:</label>
                    <select name="turno1" id="turno1" class="form-control rounded-pill" >
                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div id="segundo_turno" class="col text-center my-3" style="display: none;">
                    <label for="turno2" class="label-control">Segundo Turno:</label>
                    <select name="turno2" id="turno2" class="form-control rounded-pill">

                    </select>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('turnos').addEventListener('change', function(){
            
            var turnos = this.value;
            var primeiro_turnoDiv = document.getElementById('primeiro_turno');
            var segundo_turnoDiv = document.getElementById('segundo_turno');

            if(turnos == "primeiro_turno"){
                primeiro_turnoDiv.style.display = 'block';
                segundo_turnoDiv.style.display = 'none';
            } else if(turnos == "segundo_turno"){
                primeiro_turnoDiv.style.display = 'none';
                segundo_turnoDiv.style.display = 'block';
            } else {
                primeiro_turnoDiv.style.display = 'none';
                segundo_turnoDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html>