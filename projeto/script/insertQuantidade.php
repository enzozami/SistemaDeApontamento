<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>    
</head>
<body>
    <div class="container">
        <?php
            include_once "../script/conexao.php";

            $nop = filter_input(INPUT_POST, "nop", FILTER_SANITIZE_STRING);
            $quantidade = filter_input(INPUT_POST, "quantidade", FILTER_SANITIZE_NUMBER_INT);
            $operadorID = filter_input(INPUT_POST, "operador", FILTER_SANITIZE_NUMBER_INT);

            if($nop && $operadorID){
                $sqlQuantMaxBD = "SELECT quantidade FROM nop
                                WHERE numero_ordem = :numOrd";
                $parametro = [
                    "numOrd" => $nop
                ];
                $stmt = $connection->prepare($sqlQuantMaxBD);
                $stmt->execute($parametro);
                $valorQuantMax = $stmt->featch(PDO::FETCH_ASSOC);

                if($valorQuantMax){
                    $quantidade_maxima = $valorQuantMax;

                    if($quantidade <= $quantidade_maxima){
                        $sqlOperador = "SELECT id_operador FROM operadores
                                WHERE id_operador = :numeroOperador";
                        $parametroOperador = [
                        "numeroOperador" => $operadorID
                        ];
                        $stmt = $connection->prepare($sqlOperador);
                        $stmt->execute($parametroOperador);
                        $resultadoOperador = $stmt->fetch(PDO::FETCH_ASSOC);

                        if($resultadoOperador){
                            $operadorID = $resultadorOperador;

                            $sqlBD = "INSERT INTO nop(quantidade, operador_id) 
                                VALUES (:quant, :operaId)";
                            $parametroBD = [
                                "quant" => $quantidade,
                                "operaId" => $operadorId
                            ];
                            $stmt = $connection->prepare($sqlBD);
                            $stmt->execute($parametroBD);
                            $quantidadeInserida = $stmt->rowCount();

                            if($quantidadeInserida < 0){
                                $mensagem = "Quantidade fornecida incorreta! Tente novamente";
                                $alertColor = "danger";
                            } else {
                                $mensagem = "Foram inseridas: $quantidadeInserida peças";
                                $alertColor = "success";
                            }
                        } else {
                            $mensagem = "Número de operador inválido.";
                        }
                    } else {
                        // Mensagem de erro se a quantidade exceder o limite
                        $mensagem = "A quantidade excede o limite máximo permitido de $quantidadeMaxima. Tente novamente.";
                    }
                } else {
                    $mensagem = "Ordem de produção não encontrada ou quantidade máxima não definida.";
                }
            } else {
                $mensagem = "Número da ordem inválido.";
            }            
        ?>

        <!-- Exibe a mensagem para o usuário -->
        <div class="alert alert-<?= $alertColor; ?> text-center">
            <?= $mensagem; ?>
        </div>

        <div class="text-center my-3">
            <div class="btn-group">
                <a href="../paginas/apontamento.php" class="btn btn-success" style="width: 200px;">Salvar</a>
            </div>
        </div>
        <div class="text-center my-3">
            <div class="btn-group">
                <a href="../paginas/apontamento.php" class="btn btn-success" style="width: 200px;">Limpar</a>
            </div>
        </div>
    </div>
</body>
</html>