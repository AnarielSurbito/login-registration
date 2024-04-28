<?php
require_once __DIR__ . '/src/helpers.php';


checkAuth();

?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
<?php include_once __DIR__ . '/components/head.php'?>
<body>

<div class="card home">
    <h1>Hello <?php echo $_SESSION['user']['name']?>!</h1>
    <form action="src/actions/logout.php" method="post">
        <button role="button">Выйти</button>
    </form>
</div>

<?php include_once __DIR__ . '/components/scripts.php' ?>
</body>
</html>