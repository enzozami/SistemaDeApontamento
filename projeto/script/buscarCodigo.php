<?php
include_once "../script/conexao.php";

if (isset($_POST['nop'])) {
    $nop = filter_input(INPUT_POST, "nop", FILTER_DEFAULT);

    $sqlNumOrdem = "SELECT codigo FROM nop WHERE numero_ordem = :numOrdem";
    $stmt = $connection->prepare($sqlNumOrdem);
    $stmt->bindParam(':numOrdem', $nop, PDO::PARAM_STR);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode(['codigo' => $row['codigo']]);
    } else {
        echo json_encode(['codigo' => null]);
    } 
}
?>