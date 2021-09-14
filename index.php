<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extractor</title>
</head>
<body>
    <h1>Exporta EXCEL y PO</h1>
    <form action="excel.php" method="post" enctype="multipart/form-data">
        <input type="file" name="excel" id="excel">
        <input type="submit" name="submit" value="Exportar Excel">
    </form>
    
    <form action="po.php" method="post" enctype="multipart/form-data">
        <input type="file" name="po" id="po">
        <input type="submit" name="submit" value="Exportar PO">
    </form>

    <?php echo exec('whoami'); ?>
</body>
</html>