<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apontamento - O-LINKe Medical LTDA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../style.css">
</head>
<body style="background-color: #b5b5b5; width: 100%; height: 100%;" class=" flex-column min-vh-100">

<!-- Template e conexão com banco de dados -->
<?php 
    include_once "../template/template.php";
    include_once "../script/conexao.php";

    if (is_null($connection)) {
        echo "<div class='alert alert-danger fw-bold text-center'>$errorMsg</div>";
        exit();
    }

    $nop = filter_input(INPUT_POST, "nop", FILTER_DEFAULT);

    if ($nop) {
        $sqlNumOrdem = "SELECT * FROM nop WHERE numero_ordem = :numOrdem OR codigo = :cod";
        $parametroNumOrdem = [
            "numOrdem" => $nop, 
            "cod" => $nop];
        $stmt = $connection->prepare($sqlNumOrdem);
        $stmt->execute($parametroNumOrdem);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>
    
<!-- TÍTULO DA PÁGINA -->
<h5 class="text-center mx-auto py-3" style="background-color: rgb(63, 0, 113); color: #fff;">APONTAMENTO</h5>

<div class="container">
    <form action="../script/insertQuantidade.php" method="post">
        <div class="mt-0">
            <!-- PRIMEIRA PARTE: NÚMERO DA ORDEM, CÓDIGO, QUANTIDADE -->
            <div class="row mt-5 text-center">
                <!-- NÚMERO DA ORDEM -->
                <div class="col">
                    <label for="nop" class="form-label fw-bold">Número Ordem</label>
                    <input type="text" id="nop" name="nop" class="form-control" title="Número Ordem" required>
                    <div id="error-message-nop" style="color: red; display: none">Entrada Inválida.</div>
                </div>
                <!-- CÓDIGO -->
                <div class="col">
                    <label for="codigo" class="form-label fw-bold">Código</label>
                    <input type="number" id="codigo" name="codigo" class="form-control" readonly>
                </div>
                <!-- QUANTIDADE -->
                <div class="col">
                    <label for="quantidade" class="form-label fw-bold">Quantidade</label>
                    <input type="number" step="any" id="quantidade" name="quantidade" class="form-control" required>
                </div>
            </div>

            <!-- SEGUNDA PARTE: OPERADOR, OPERAÇÃO, MÁQUINA -->
            <div class="row mt-5 text-center">
                <!-- OPERADOR -->
                <div class="col">
                    <label for="operador" class="form-label fw-bold">Operador</label>
                    <input type="number" id="operador" name="operador" class="form-control" required>
                </div>
                <!-- OPERAÇÃO -->
                <div class="col">
                    <label for="operacao" class="form-label fw-bold">Operação</label>
                    <select name="operacao" id="operacao" class="form-control rounded-pill" required>
                        <option value="">Selecione uma operação</option>
                        <option value="1">Produção</option>
                        <option value="2">Rebarbar</option>
                        <option value="3">Polimento</option>
                        <!--<option value="poli">Polimento</option>
                        <option value="in">Inspeção</option>
                        <option value="est">Esterilização</option>
                        <option value="estoque">Estoque</option>-->
                    </select>
                </div>
                <!-- MÁQUINA (exibido somente para algumas operações) -->
                <div class="col";">
                    <label for="maquina" class="form-label fw-bold">Máquina</label>
                    <select name="maquina" id="maquina" class="form-control rounded-pill">
                        <option value="">Selecione uma máquina</option>
                        <option value="1">L20</option>
                        <option value="2">C16</option>
                        <option value="3">C15</option>
                        <!--<option value="torno_C16_2">M-14</option>
                        <option value="torno_C16_3">M-15</option>
                        <option value="centro_torneamento_star">M-05</option>
                        <option value="centro_usinagem_760">M-19</option>
                        <option value="centro_usinagem_660">M-22</option>
                        <option value="brother">M-18</option>-->
                    </select>
                </div>
            </div>
        </div>

        <!-- BOTÕES DE AÇÃO -->
        <div class="d-flex justify-content-center align-items-center mt-5" > <!-- style="background-color: rgb(63, 0, 113);" -->
            <div class="text-center py-2 px-2">
                <div class="d-flex justify-content-between align-items-center my-3">
                    <!-- Botão SALVAR -->
                    <button type="submit" class="btn btn-outline-success my-2 d-block mx-auto" style="width: 200px;">Registrar</button>
                    <!-- Botão LIMPAR -->
                    <a href="apontamento.php" class="btn btn-outline-danger" style="width: 200px;">Limpar</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="../index.js"></script>
<script>

// Função para validar os campos antes de enviar o formulário
function validateForm() {
    // Verifica se o campo N° Ordem está preenchido
    var nop = document.getElementById('nop').value;
    var quantidade = document.getElementById('quantidade').value;
    var operador = document.getElementById('operador').value;
    var operacao = document.getElementById('operacao').value;
    
    // Verifica se todos os campos obrigatórios estão preenchidos
    if (nop == "" || quantidade == "" || operador == "" || operacao == "") {
        alert("Por favor, preencha todos os campos obrigatórios.");
        return false; // Impede o envio do formulário
    }
    return true;
}
/*
// Exibe ou oculta o campo 'Máquina' dependendo da operação
document.getElementById('operacao').addEventListener('change', function() {
    var operacao = this.value;
    var maquinaDiv = document.getElementById('maquina-div');
    if (operacao == "pro" || operacao == "reb" || operacao == "lav" || operacao == "poli") {
        maquinaDiv.style.display = 'block'; // Exibe o campo máquina
    } else {
        maquinaDiv.style.display = 'none'; // Oculta o campo máquina
        document.getElementById('maquina').value = ""; // Limpa o campo máquina
    }
});
*/
// Preenche automaticamente o campo "Código" com base no "N° Ordem"
document.getElementById('nop').addEventListener('blur', function() {
    var nop = this.value;
    
    if (nop) {
        fetch('../script/buscarCodigo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'nop=' + encodeURIComponent(nop)
        })
        .then(response => response.json())
        .then(data => {
            if (data.codigo) {
                document.getElementById('codigo').value = data.codigo;
            } else {
                document.getElementById('codigo').value = '';
                alert("Código não encontrado para essa ordem.");
            }
        })
        .catch(error => {
            console.error('Erro ao buscar o código:', error);
        });
    }
});
</script>
<?php 
    include_once "../template/footer.php"
?>
</body>
</html>