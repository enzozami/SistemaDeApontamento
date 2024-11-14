<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operadores - O-LINKe Medical LTDA</title>
</head>
<body style="background-color: #b5b5b5; width: 100%; height: 100%;" class="d-flex flex-column min-vh-100">
    <?php 
        include_once "../template/template.php";
        include_once "../script/conexao.php";

        if(is_null($connection)){
            echo"<div class='alert alert-danger fw-bold text-center'>$errorMsg</div>";
            exit();
        }

        $turnos = filter_input(INPUT_POST, "turnos", FILTER_DEFAULT);

        $sql = "SELECT * FROM operadores
                WHERE id_operador = :numeroOperador";
        $parametro = [
            "numeroOperador" => $turnos
        ];

        $stmt = $connection->prepare($sql);
        $stmt->execute($parametro);
        $nop = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <h5 class="text-center mx-auto py-3" style="background-color: rgb(63, 0, 113); color: #fff;">OPERADORES</h5>

    <div class="container">
    <form action="" method="post">
            <div class="row text-center">
                <div class="col">
                    <label for="" class="form-label fw-bold">TURNOS:</label>
                    <div class="input-group mb-2">
                        <input name="turnos" type="text" class="form-control rounded-end" placeholder="Insira o Turno" value="<?= $_POST['termo'] ?? null ?>">
                        <button type="submit" class="btn btn-outline-success">Pesquisar</button>
                        <a href="operadores.php" class="btn btn-outline-danger">Limpar</a>
                    </div>
                </div>
            </div>
        </form>
        <?php
            if(count($nop) > 0){ ?>

            <!-- HTML -->
                <table class="table table-striped table-hover table-border mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID: </th>
                            <th class="text-center">Nome: </th>
                            <th class="text-center">Turno: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($nop as $operadores){ ?>
                            <tr>
                                <td class="text-center"><?= $operadores['id_operador'] ?></td>
                                <td class="text-center"><?= $operadores['nome_operador'] ?></td>
                                <td class="text-center"><?= $operadores['nome_turno'] ?></td>
                            </tr>
                    <?php
                        }
                        ?>
                    </tbody>
                </table>

        <?php
            } else {
                echo"<div class='alert alert-warning my-3 text-center fw-bold'> Nenhum registro foi encontrado... </div>";
            }
        ?>
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
<?php 
    include_once "../template/footer.php"
?>
</body>
</html>