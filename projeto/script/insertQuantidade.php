<?php
include_once "conexao.php"; // Inclui o arquivo de conexão com o banco de dados

// Captura os dados do formulário usando 
$nop = filter_input(INPUT_POST, "nop", FILTER_SANITIZE_STRING);
$quantidade = filter_input(INPUT_POST, "quantidade", FILTER_SANITIZE_NUMBER_INT);
$operador = filter_input(INPUT_POST, "operador", FILTER_SANITIZE_NUMBER_INT);
$operacao = filter_input(INPUT_POST, "operacao", FILTER_SANITIZE_NUMBER_INT);
$maquina = filter_input(INPUT_POST, "maquina", FILTER_SANITIZE_NUMBER_INT); // Não obrigatório

$converter = (int)$quantidade;
//var_dump($converter);

// Validação dos campos
if (empty($nop) || empty($quantidade) || empty($operador) || empty($operacao)) {
    // Se faltar algum campo obrigatório
   die("Por favor, preencha todos os campos obrigatórios.");
}

// Verificar se a operação exige máquina e se foi preenchida
if (($operacao == 'pro') && empty($maquina)) {
    die("Por favor, selecione uma máquina para a operação.");
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

//var_dump($resultado);
//var_dump($quantidade);

if($resultado >= $converter){
    // Preparar a consulta para inserir os dados no banco CASO SEJA AUTOMATICO
    $sql = "UPDATE nop SET quantidade = :quantidade, operador_id = :operador, operacao_id = :operacao, maquina_id = :maquina  
            WHERE numero_ordem = :nop AND quantidadeMaxima >= :quantidade";
            //ARRUMAR INSERT
        /*$sql = "INSERT INTO nop(quantidade, operador_id, operacao_id, maquina_id)
                VALUES (:quant, operador, operacao, maquina)
                WHERE numero_ordem = :nop";*/
    // Preparar os parâmetros
    $params = [
        "nop" => $nop,
        "quantidade" => $quantidade,
        "operador" => $operador,
        "operacao" => $operacao,
        "maquina" => $maquina ? $maquina : NULL // Se não houver máquina, passa NULL
    ];
// Executar a consulta
$stmt = $connection->prepare($sql);
$stmt->execute($params);
} else {
    echo"nao existe";
}
//Verificar se a inserção foi bem-sucedida
if ($stmt->rowCount() > 0) {
    // Sucesso
    echo "Apontamento registrado com sucesso!";
} else {
    // Erro
    echo "Erro ao registrar apontamento. Tente novamente.";
}
?>
