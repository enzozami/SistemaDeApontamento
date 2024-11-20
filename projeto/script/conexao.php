    <?php // CONEXAO COM O BANCO DE DADOS
        $serverName = "localhost";
        $user = "root";
        $password = "";
        $dataBase = "teste";
        $connection = null;
        
        try {
            $connection = new PDO("mysql:host=$serverName; dbname=$dataBase; charset=utf8", $user, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            $errorMsg = "Erro ao tentar realizar conexão. ERRO: " . $ex->getMessage();
        }
    ?>