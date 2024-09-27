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
            $sqlQuant = "INSERT INTO nop(quantidade)
                        VALUE (:quant)";
            $parametros = [
                "quant" => $quantidade
            ];

            $stmt = $connection->prepare($sqlQuant);
            $stmt->execute($parametros);
        ?>
    </div>
</body>
</html>