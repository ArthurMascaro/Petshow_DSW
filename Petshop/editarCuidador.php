<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cuidador</title>
</head>

<body>

    <?php

    require_once "./medias/Cuidador.php";
    require_once "./medias/BancoDados.php";

    if (isset($_POST['nome']) && !empty($_POST['nome'])) {
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $id = $_POST['id'];
                if (Cuidador::existeEmailAlterar($email, $id)) {
                    $resultado = Cuidador::editar($id, $nome, $email);
                    if ($resultado) {
                        echo "<Script> window.alert('$nome editado com sucesso') </Script>";
                        echo '<a href="index.php">Voltar</a>';
                    } else {
                        echo "<Script> window.alert('Erro ao editar') </Script>";
                        echo '<a href="index.php">Voltar</a>';
                    }
                } else {
                    echo "<Script> window.alert('Email novo já cadastrado') </Script>";
                }

                exit;
            }
        }
    }

    if (isset($_GET['id']) and !empty($_GET['id'])) {
        if (Cuidador::existe($_GET['id'])) {
            $cuidador = Cuidador::getCuidador($_GET['id']);
        } else {
            echo "<Script> window.alert('Cuidador não encontrado') </Script>";
            echo "<a href='index.php'>Voltar</a>";
            exit;
        }
    } else {
        echo "<Script> window.alert('Cuidador não encontrado') </Script>";
        echo "<a href='index.php'>Voltar</a>";
        exit;
    }

    ?>

    <h1>Editar <?= $cuidador['nome'] ?></h1>

    <form method="post">
        <p>Nome:</p>
        <input type="text" name="nome" required value="<?= $cuidador['nome'] ?>">
        <p>Email:</p>
        <input type="text" name="email" required value="<?= $cuidador['email'] ?>">
        <input type="hidden" name="id" value="<?= $cuidador['id'] ?>">
        <br>
        <br>
        <button>Editar</button>
    </form>

</body>

</html>