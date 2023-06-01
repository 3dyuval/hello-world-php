<html>
<head>
    <title>id: <?php echo $_GET['id'] ?></title>
</head>
<body>
    <?php 
    require_once 'config/database.php';
    $id = $_GET['id']; 
    $sql = "SELECT first_name, last_name from names where id = $id";
    $data = $conn->query($sql);
    $result = $data->fetch_assoc();

    $firstName = $data->firstName ?? '';
    $lastName = $data->lastName ?? '';

    $output = implode(' ', $result)
    ?>

    <?php if(isset($output)): ?>
    <strong><?php echo $output ?> </strong>
    <?php else: ?>
    <p>Not found</p>
    <?php endif; ?>

</body>
</html>