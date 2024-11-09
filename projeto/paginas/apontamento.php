<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apontamento - O-LINKe Medical LTDA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../style.css">
</head>
<body style="background-color: #b5b5b5; width: 100%; height: 100%;">
    
<!--TEMPLATE + CONEXÃO COM BANCO DE DADOS-->
    <?php 
        // incluindo template
        include_once "../template/template.php";
        // incluindo banco de dados
        include_once "../script/conexao.php";

        if (is_null($connection)) {
            echo"<div class='alert alert-danger fw-bold text-center'>$errorMsg</div>";
            exit();
        }

        $nop = filter_input(INPUT_POST, "nop", FILTER_DEFAULT);

        if($nop){
            $sqlNumOrdem = "SELECT * FROM nop
                    WHERE numero_ordem = :numOrdem, codigo = :cod";
            $parametroNumOrdem = [
                "numOrdem" => $nop,
                "cod" => $nop
            ];
            $stmt = $connection->prepare($sqlNumOrdem);
            $stmt->execute($parametroNumOrdem);
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    ?>
    <!--TÍTULO DA PÁGINA-->
    <h5 class="text-center mx-auto py-3" style="background-color: rgb(63, 0, 113); color: #fff; ">APONTAMENTO</h5>
    
    <div class="container">
        <form action="../script/insertQuantidade.php" method="post">
            <div id="apontamentoForm" class="mt-0">
                <!--PRIMEIRA PARTE-->
                <div class="row mt-5 text-center">  
                    <!--ABA PARA INSERIR NUMERO DA ORDEM-->
                        <div class="col">
                            <label for="nop" class="form-label fw-bold">Número Ordem:</label>
                	        <input type="text" id="nop" name="nop" class="form-control" pattern="^[0-9]{6}[A-Z]{2}[0-9]{3}$" title="Número Ordem" required value="<?=$_POST['nop'] ?? null ?>">
                            <div id="error-message-nop" style="color: red; display: none">Entrada Inválida.</div>
                        </div>
                        <!--ABA QUE O CÓDIGO É INSERIDO (É PARA ELE IR AUTOMATICAMENTE)-->
                        <div class="col">
                            <label for="codigo" class="form-label fw-bold">Código: </label> 
                            <input type="number" step="any" id="codigo" name="codigo" class="form-control" value="<?= htmlspecialchars($codigo) ?>">
                        </div>
                        <!--ABA PARA INSERIR A QUANTIDADE PRODUZIDA-->
                        <div class="col">
                            <label for="quantidade" class="form-label fw-bold">Quantidade: </label>
                            <input type="number" step="any" id="quantidade" class="form-control" pattern="^[0-9]{4}$" title="Quantidade" required value="<?=$_POST['quantidade'] ?? null ?>">
                            <div id="" style="color: red; display: none;"></div>
                        </div>
                </div>
                <!--SEGUNDA PARTE-->
                <div class="row mt-5 text-center">
                    <!--ABA PARA INSERIR O OPERADOR-->
                    <div class="col">
                        <label for="operador" class="form-label fw-bold">Operador: </label>
                        <input type="number" step="any" id="operador" class="form-control" pattern="^[0-9]{2}$" title="Operador" required value="<?=$_POST['operador'] ?? null ?>">
                        <div id="error-message-operador" style="color: red; display: none"></div>
                    </div>
                    <!--ABA PARA INSERIR A OPERAÇÃO-->
                    <div class="col">
                        <label for="operacao" class="form-label fw-bold">Operação: </label>
                        <select name="operacao" id="operacao" class="form-control rounded-pill" onchange="teste()" required>
                            <option value="">Selecione uma operação:</option>
                            <option value="pro">Produção</option>
                            <option value="reb">Rebarbar</option>
                            <option value="lav">Lavagem</option>
                            <option value="poli">Polimento</option>
                            <option value="in">Inspeção</option>
                            <option value="est">Esterialização</option>
                            <option value="estoque">Estoque</option>
                        </select>
                        <div id="error-message-operacao" style="color: red; display: none">Operação inválida.</div>
                    </div>
                    <!--ABA PARA INSERIR MAQUINA (SE FOR TIPO USINAGEM)-->
                    <div id="maquina-div" class="col" style="display: none">
                        <label for="maquina" class="form-label fw-bold">Máquina: </label>
                        <select name="maquina" id="maquina" class="form-control rounded-pill">
                            <option value="">Selecione uma máquina</option>
                            <option value="torno_l20">M-21</option>
                            <option value="torno_l20_2">M-31</option>
                            <option value="torno_C16">M-13</option>
                            <option value="torno_C16_2">M-14</option>
                            <option value="torno_C16_3">M-15</option>
                            <option value="centro_torneamento_star">M-05</option>
                            <option value="centro_usinagem_760">M-19</option>
                            <option value="centro_usinagem_660">M-22</option>
                            <option value="brother">M-18</option>
                        </select>
                        <div class="error-message-maquina" style="color: red; display: none">Máquina inválida.</div>
                    </div>
                </div>   
            </div>
            <div class="d-flex justify-content-center align-items-center mt-5" style="background-color: rgb(63, 0, 113);">    
                <div class="text-center py-2 px-2" style="background-color: rgb(63, 0, 113);">                    
                    <button type="submit" name="iniciar_op" id="iniciar_op" class="btn btn-outline-info" >Iniciar</button>
                    <a href="apontamento.php" class="btn btn-outline-danger">Limpar</a>
                    <button type="submit" name="finalizar_op" id="finalizar_op" class="btn btn-outline-success" >Finalizar</button>
                </div>    
            </div>
        </form>
    </div>
    <script src="../index.js"></script>
    <script>
    
    document.getElementById('operacao').addEventListener('change', function() {
            
        var operacao = this.value;
        var maquinaDiv = document.getElementById('maquina-div');
        
        if(operacao == "pro"){
            maquinaDiv.style.display = 'block';
            isValid = false;
        } else {
            maquinaDiv.style.display = 'none';
            document.getElementById('maquina').selectedIndex = 0; // reinicia para o padrao se o campo 'usi' for desselecionado
        }
    }); 

    document.getElementById('iniciar_op').addEventListener('click', function(){
        this.disabled = true;
        document.getElementById('finalizar_op').disabled = false;        
    });

    
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
</body>
</html>