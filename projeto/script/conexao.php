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