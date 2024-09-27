<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONEXÃO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php // CONEXAO COM O BANCO DE DADOS
        $serverName = "localhost";
        $user = "root";
        $password = "";
        $dataBase = "banco_tcc_apont";
        $connection = null;
        
        try {
            $connection = new PDO("mysql:host=$serverName; dbname=$dataBase; charset=utf8", $user, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            $errorMsg = "Erro ao tentar realizar conexão. ERRO: " . $ex->getMessage();
        }
    ?>
</body>
</html>

