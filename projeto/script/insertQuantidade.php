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
<body style="background-color: #b5b5b5; width: 100%; height: 100%;" class=" flex-column min-vh-100">
    <?php
        include_once "conexao.php"; // Inclui o arquivo de conexão com o banco de dados
    ?>
    <div class="container">
        <h2 class="text-center my-2">APONTAMENTO</h2>
        <?php
            // Captura os dados do formulário usando 
            $nop = filter_input(INPUT_POST, "nop", FILTER_SANITIZE_STRING);
            $quantidade = filter_input(INPUT_POST, "quantidade", FILTER_SANITIZE_NUMBER_INT);
            $operador = filter_input(INPUT_POST, "operador", FILTER_SANITIZE_NUMBER_INT);
            $operacao = filter_input(INPUT_POST, "operacao", FILTER_SANITIZE_NUMBER_INT);
            $maquina = filter_input(INPUT_POST, "maquina", FILTER_SANITIZE_NUMBER_INT); // Não obrigatório
            $data_inicial = filter_input(INPUT_POST, "data_inicial", FILTER_DEFAULT);
            $perda = filter_input(INPUT_POST, "perda", FILTER_SANITIZE_NUMBER_INT);

            $perd = (int)$perda;
            $quant = (int)$quantidade;
            //var_dump($converter);

            // Validação dos campos
            if (empty($nop) || empty($quantidade) || empty($operador) || empty($operacao)) {
                // Se faltar algum campo obrigatório
               $mensagem = "Por favor, preencha todos os campos obrigatórios.";
            }

            // Verificar se a operação exige máquina e se foi preenchida
            if (($operacao == "1") && empty($maquina)) {
                $mensagem = "Por favor, selecione uma máquina para a operação.";
            }

            $sql = "SELECT quantidadeMaxima FROM nop 
                    WHERE numero_ordem = :nop";
            $params = [
                "nop" => $nop
            ];
            // Executar a consulta
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // var_dump($resultado);
            //var_dump($quantidade);
            $pecas = $quant + $perd;
            // var_dump($pecas);
            try {            
                if($pecas <= $resultado['quantidadeMaxima']){
                    // Preparar a consulta para inserir os dados no banco CASO SEJA AUTOMATICO
                    $sql = "UPDATE nop SET quantidade = :quantidade, operador_id = :operador, operacao_id = :operacao, maquina_id = :maquina, data_inicial = :dataInicial, data_final = NOW(), perda = :perd
                            WHERE numero_ordem = :nop AND quantidadeMaxima >= :quantidade";
                    $params = [
                        "nop" => $nop,
                        "quantidade" => $quantidade,
                        "operador" => $operador,
                        "operacao" => $operacao,
                        "maquina" => $maquina ? $maquina : NULL, // Se não houver máquina, passa NULL
                        "dataInicial" => $data_inicial,
                        "perd" => $perda
                    ];
                    //INSERT TABELA HISTORICO
                    $sqlHist = "INSERT INTO historico(ordem, quantidade, operacao_id, maquina_id, operador_id, data_inicial, data_final, perda) 
                                VALUES (:nop, :quant, :operacao, :maquina, :operador, :dataInicial, NOW(), :perd)"; // data_inicial, 
                    $paramsHist = [
                        "nop" => $nop,
                        "quant" => $quantidade,
                        "operador" => $operador,
                        "operacao" => $operacao,
                        "maquina" => $maquina ? $maquina : NULL, // Se não houver máquina, passa NULL
                        "dataInicial" => $data_inicial,
                        "perd" => $perda
                    ];
                } else {
                    $mensagem = "Quantidade acima do permitido!";
                }

                    $stmt = $connection->prepare($sql);
                    $stmt->execute($params);
                    $produtoAtualizado = $stmt->rowCount();

                // Executar a consulta
                    $stmt = $connection->prepare($sqlHist);
                    $stmt->execute($paramsHist);
                    $produtoInserido = $stmt->rowCount();
            
            } catch (PDOException $ex){
                $mensagem = "Erro pois esta operação já foi apontada. Erro: " . $ex->getMessage();
                $alertColor = "danger";
            }
            //Verificar se a inserção foi bem-sucedida
            if ($produtoInserido > 0) {
                // Sucesso
                $mensagem =  "Apontamento registrado com sucesso!";
                $alertColor = "success";
            } else {
                // Erro
                $mensagem =  "Erro ao registrar apontamento. Tente novamente.";
                $alertColor = "danger";
            }
        ?>

        <div class="alert alert-<?=$alertColor?> my-3 text-center">
            <?=$mensagem?>
        </div>
    
        <div class="text-center my-3">
            <div class="btn-group">
                <a href="../paginas/apontamento.php" class="btn btn-info" style="width: 200px;">Apontamento</a>
                <a href="../paginas/pesquisa.php" class="btn btn-success" style="width: 200px;" >Pesquisa</a>
            </div>
        </div>
    </div>
    <?php 
        include_once "../template/footer.php";
    ?>
</body>
</html>
