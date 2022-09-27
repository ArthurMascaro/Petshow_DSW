<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pet</title>
</head>

<body>

    <?php

    require_once "./medias/Pet.php";
    require_once "./medias/BancoDados.php";

    if (isset($_POST['nome']) && !empty($_POST['nome'])) {
        if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
            if (isset($_POST['telTutor']) && !empty($_POST['telTutor'])) {
                if (isset($_POST['id']) && !empty($_POST['id'])) {
                    $nome = $_POST['nome'];
                    $descricao = $_POST['descricao'];
                    $telTutor = $_POST['telTutor'];
                    $id = $_POST['id'];
                    $resultado = Pet::editar($id, $nome, $descricao, $telTutor);
                    if ($resultado) {
                        echo "<Script> window.alert('$nome editado com sucesso') </Script>";
                        echo '<a href="index.php">Voltar</a>';
                    } else {
                        echo "<Script> window.alert('Erro ao editar $nome') </Script>";
                        echo '<a href="index.php">Voltar</a>';
                    }
                    exit;
                }
            }
        }
    }

    if (isset($_GET['id']) and !empty($_GET['id'])) {
        if (Pet::existe($_GET['id'])) {
            $pet = Pet::getPet($_GET['id']);
        } else {
            echo "<Script> window.alert('Pet não encontrado') </Script>";
            echo "<a href='index.php'>Voltar</a>";
            exit;
        }
    } else {
        echo "<Script> window.alert('Pet não encontrado') </Script>";
        echo "<a href='index.php'>Voltar</a>";
        exit;
    }

    ?>

    <h1>Editar <?= $pet['nome'] ?></h1>

    <form method="post">
        <p>Nome:</p>
        <input type="text" name="nome" required value="<?= $pet['nome'] ?>">
        <p>Descrição:</p>
        <input type="text" name="descricao" required value="<?= $pet['descricao'] ?>">
        <p>TelTutor:</p>
        <input type="text" name="telTutor" required value="<?= $pet['telTutor'] ?>">
        <input type="hidden" name="id" value="<?= $pet['id'] ?>">
        <br>
        <br>
        <button>Editar</button>
    </form>

</body>

</html>