<html>
<head>
    <title>get all</title>
</head>
<body>
    <?php 

    ob_start();

    include './controller/index.php';

    $response = ob_get_clean();

    ?>
        
    <?php if(isset($response)): ?>
    <strong>found:</strong><br>
    <pre><?php echo var_dump($response); ?></pre>
    <?php else: ?>
    <p>Not found</p>
    <?php endif; ?>

</body>
</html>