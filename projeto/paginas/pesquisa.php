<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa - O-LINKe Medical LTDA </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../style.css">
</head>
<body style="background-color: #b5b5b5; width: 100%; height: 100%;">
    <!-- TEMPLATE + BANCO DE DADOS -->
     <?php 
        include_once "../template/template.php";

        include_once "../script/conexao.php";

        if(is_null($connection)){
            echo"<div class='alert alert-danger fw-bold text-center'>$errorMsg</div>";
            exit();
        }

        $pesquisar = filter_input(INPUT_POST, "pesquisar", FILTER_DEFAULT);

        $sql = "SELECT * FROM nop 
                INNER JOIN operadores ON nop.operador_id = operadores.id_operador
                WHERE numero_ordem = :numeroOrdem OR codigo LIKE :cod OR lote LIKE :lot";
        $parametro = [
            "numeroOrdem" => $pesquisar,
            "cod" => "%$pesquisar%",
            "lot" => "%$pesquisar%"
        ];

        $stmt = $connection->prepare($sql);
        $stmt->execute($parametro);
        $nop = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
     ?>

     <!--TÍTULO DA PÁGINA-->
    <h5 class="text-center mx-auto py-3" style="background-color: rgb(63, 0, 113); color: #fff; ">PESQUISA</h5>

    <div class="container">
        <form action="" method="post">
            <div class="row text-center">
                <div class="col">
                    <label for="" class="form-label fw-bold">Pesquisa:</label>
                    <div class="input-group mb-2">
                        <input name="pesquisar" type="text" class="form-control rounded-end" placeholder="Insira o Número da Ordem ou o Código ou o Lote ">
                        <button type="submit" class="btn btn-outline-success">Pesquisar</button>
                        <a href="pesquisa.php" class="btn btn-outline-danger">Limpar</a>
                    </div>
                </div>
            </div>
        </form>

    <!-- AQUI COMEÇA A ORGANIZAÇÃO DA TABELA PARA APRESENTAR AS OPS -->
        <?php
            if(count($nop) > 0){ ?>

            <!-- HTML -->
                <table class="table table-striped table-hover table-border mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Numero Ordem: </th>
                            <th class="text-center">Código: </th>
                            <th class="text-center">Quantidade: </th>
                            <th class="text-center">Lote: </th>
                            <th class="text-center">Operador: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($nop as $ordem){ ?>
                            <tr>
                                <td class="text-center"><?= $ordem['numero_ordem'] ?></td>
                                <td class="text-center"><?= $ordem['codigo'] ?></td>
                                <td class="text-center"><?= $ordem['quantidade'] ?></td>
                                <td class="text-center"><?= $ordem['lote'] ?></td>
                                <td class="text-center"><?= $ordem['nome_operador'] ?></td>
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
</body>
</html>