<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>petshop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php

    require_once './medias/Cuidador.php';
    require_once './medias/Cuida.php';
    require_once './medias/Pet.php';

    if (isset($_POST['nome']) && !empty($_POST['nome'])) {
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            if (Cuidador::existeEmail($email)) {
                $resultado = Cuidador::cadastrar($nome, $email);
                if ($resultado == false) {
                    echo "<Script> window.alert('Erro ao cadastrar') </Script>";
                }
            } else {
                echo "<Script> window.alert('já existe uma pessoa com este Email') </Script>";
            }
        }
    }

    if (isset($_POST['nomePet']) && !empty($_POST['nomePet'])) {
        if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
            if (isset($_POST['telTutor']) && !empty($_POST['telTutor'])) {
                $nomePet = $_POST['nomePet'];
                $descricao = $_POST['descricao'];
                $telTutor = $_POST['telTutor'];
                $resultado = Pet::cadastrar($nomePet, $descricao, $telTutor);
                if ($resultado == false) {
                    echo "<Script> window.alert('Erro ao cadastrar') </Script>";
                }
            }
        }
    }

    if (isset($_POST['idCuidador']) && !empty($_POST['idCuidador'])) {
        if (isset($_POST['idPet']) && !empty($_POST['idPet'])) {
            $idCuidador = $_POST['idCuidador'];
            $idPet = $_POST['idPet'];
            $resultado = Cuida::cadastrar($idCuidador, $idPet);
            if ($resultado == false) {
                echo "<Script> window.alert('Erro ao Associar') </Script>";
            }
        }
    }

    if (isset($_GET['removerPet']) && !empty($_GET['removerPet'])) {
        $idPet = $_GET['removerPet'];
        if (Pet::existe($idPet)) {
            $resultado = Pet::remover($idPet);
            if ($resultado == false) {
                echo "<Script> window.alert('Erro ao Remover') </Script>";
            }
        } else {
            echo "<Script> window.alert('Não existe pet com este id') </Script>";
        }
    }

    if (isset($_GET['removerCuidador']) && !empty($_GET['removerCuidador'])) {
        $idCuidador = $_GET['removerCuidador'];
        if (Cuidador::existe($idCuidador)) {
            $resultado = Cuidador::excluir($idCuidador);
            if ($resultado == false) {
                echo "<Script> window.alert('Erro ao Remover') </Script>";
            }
        } else {
            echo "<Script> window.alert('Não existe Cuidador com este id') </Script>";
        }
    }
    ?>

    <nav>
        <h1 class="title"> Petshop </h1>
    </nav>

    <div class="container">

        <div class="container-Cuidador">



            <div class="form-Cuidador">
                <h2>Cadastre um Cuidador</h2>
                <form method="post">
                    <label for="nome">Digite o nome:</label>
                    <br>
                    <input type="text" name="nome" required placeholder="Nome">
                    <br>
                    <label for="email">Digite o email</label>
                    <br>
                    <input type="email" name="email" required placeholder="Email">
                    <br>
                    <button>Enviar</button>

                </form>

            </div>

            <div class="table-Cuidador">
                <table>
                    <caption>Tabela Cuidadores</caption>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data Cadastro</th>
                            <th>Editar</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        require_once "./medias/Cuidador.php";
                        $cuidadores = Cuidador::listar();
                        foreach ($cuidadores as $cuidador) {
                            echo "<tr>";
                            echo "<td>"  . $cuidador["id"] . "</td>";
                            echo "<td>" . $cuidador["nome"] . "</td>";
                            echo "<td>" . $cuidador["email"] . "</td>";
                            echo "<td>" . $cuidador["dataCadastro"] . "</td>";
                            echo "<td>" . "<a href='editarCuidador.php?id=" . $cuidador["id"] . "'>Editar</a>" . "</td>";
                            echo "<td>" . "<a href='index.php?removerCuidador=" . $cuidador["id"] . "'>Remover</a>" . "</td>";
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>

            </div>
        </div>




        <div class="container-Pet">



            <div class="form-Pet">
                <h2>Cadastre um Pet</h2>
                <form method="post">
                    <label for="nome">Digite o nome:</label>
                    <br>
                    <input type="text" name="nomePet" id="nome" required placeholder="Nome">
                    <br>
                    <label for="descricao">Digite uma Descrição:</label>
                    <br>
                    <input type="text" name="descricao" required placeholder="Descrição">
                    <br>
                    <label for="telTutor">Digite o telefone do tutor:</label>
                    <br>
                    <input type="text" name="telTutor" required placeholder="Telefone">
                    <br>
                    <button>Enviar</button>
                </form>
            </div>

            <div class="table-Pet">
                <table>
                    <caption>Tabela Pets</caption>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Descricao</th>
                            <th>Telefone Tutor</th>
                            <th>Data Cadastro</th>
                            <th>Editar</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        require_once "./medias/Pet.php";
                        $pets = Pet::listar();
                        foreach ($pets as $pet) {
                            echo "<tr>";
                            echo "<td>"  . $pet['id'] . "</td>";
                            echo "<td>" . $pet['nome'] . "</td>";
                            echo "<td>" . $pet['descricao'] . "</td>";
                            echo "<td>" . $pet['telTutor'] . "</td>";
                            echo "<td>" . $pet['dataCadastro'] . "</td>";
                            echo "<td>" . "<a href='editarPet.php?id=" . $pet["id"] . "'>Editar</a>" . "</td>";
                            echo "<td>" . "<a href='index.php?removerPet=" . $pet["id"] . "'>Remover</a>" . "</td>";
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container-associa">



            <div class="form-Associa">
                <h2>Associe um Pet & Cuidador</h2>
                <form method="post">
                    <label>Pet:</label>
                    <select name="idPet">
                        <?php
                        $pets = Pet::listar();
                        $cuidadores = Cuidador::listar();
                        foreach ($pets as $pet) {
                            echo "<option value=" . $pet['id'] . ">" . $pet['nome'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <label>Cuidador:</label>
                    <select name="idCuidador">
                        <?php
                        foreach ($cuidadores as $cuidador) {
                            echo "<option value=" . $cuidador['id'] . ">" . $cuidador['nome'] . "</option>";
                        }
                        ?>
                    </select>
                    <?php
                    ?>
                    <br>
                    <button>Cadastrar</button>
                </form>

            </div>

            <div class="table-Associa">
                <table>
                    <caption>Tabela Associações</caption>
                    <thead>
                        <tr>
                            <th>Cuidador</th>
                            <th>Cuidador Email</th>
                            <th>Pet</th>
                            <th>Telefone Tutor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        require_once "./medias/Pet.php";
                        $associacoes = Cuida::listar();
                        foreach ($associacoes as $assoc) {
                            $cuidador = Cuidador::getCuidador($assoc['idCuidador']);
                            $pet = Pet::getPet($assoc['idPet']);
                            echo "<tr>";
                            echo "<td>"  . $cuidador['nome'] . "</td>";
                            echo "<td>"  . $cuidador['email'] . "</td>";
                            echo "<td>" . $pet['nome'] . "</td>";
                            echo "<td>" . $pet['telTutor'] . "</td>";
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <h1>Procurar</h1>

    <div class="container-search">



        <div class="container-search-Cuidador">
            <div class="form-search-Cuidador">

                <h2>Procurar Cuidador do Pet</h2>
                <form method="post">
                    <select name="idPetProcura">
                        <?php
                        $pets = Pet::listar();
                        foreach ($pets as $pet) {
                            echo "<option value=" . $pet['id'] . ">" . $pet['nome'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <button>Procurar</button>
                </form>
            </div>

            <div class="table-search-Cuidador">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['idPetProcura']) && !empty($_POST['idPetProcura'])) {
                            $idPet = $_POST['idPetProcura'];
                            $cuidadores = Pet::getCuidadores($idPet);
                            foreach ($cuidadores as $cuidadorMenor) {
                                foreach ($cuidadorMenor as $cuidador) {
                                    echo "<tr>";
                                    echo "<td>"  . $cuidador["id"] . "</td>";
                                    echo "<td>" . $cuidador["nome"] . "</td>";
                                    echo "<td>" . $cuidador["email"] . "</td>";
                                    echo "<td>" . $cuidador["dataCadastro"] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>



        <div class="container-search-Pet">

            <div class="form-search-Pet">

                <h2>Procurar Pet do Cuidador</h2>
                <form method="post">
                    <select name="idCuidadorProcura">
                        <?php
                        $cuidadores = Cuidador::listar();
                        foreach ($cuidadores as $cuidador) {
                            echo "<option value=" . $cuidador['id'] . ">" . $cuidador['nome'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <button>Procurar</button>
                </form>

            </div>

            <div class="table-search-Pet">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Telefone Tutor</th>
                            <th>Data Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['idCuidadorProcura']) && !empty($_POST['idCuidadorProcura'])) {
                            $idCuidador = $_POST['idCuidadorProcura'];
                            $pets = Cuidador::getPets($idCuidador);
                            foreach ($pets as $petsMenor) {
                                foreach ($petsMenor as $pet) {
                                    echo "<tr>";
                                    echo "<td>"  . $pet["id"] . "</td>";
                                    echo "<td>" . $pet["nome"] . "</td>";
                                    echo "<td>" . $pet["descricao"] . "</td>";
                                    echo "<td>" . $pet["telTutor"] . "</td>";
                                    echo "<td>" . $cuidador["dataCadastro"] . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>



        <div class="container-search-Tutor">
            <div class="form-search-Tutor">
                <h2>Procura Pet do Tutor</h2>
                <form method="post">
                    <select name="idPetTutor">
                        <?php
                        $pets = Pet::listarTel();
                        foreach ($pets as $pet) {
                            echo "<option value=" . $pet['telTutor'] . ">" . $pet['telTutor'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <button>Procurar</button>
                </form>
            </div>

            <div class="table-search-Tutor">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Data Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (isset($_POST['idPetTutor']) && !empty($_POST['idPetTutor'])) {
                            $telTutor = $_POST['idPetTutor'];
                            $pets = Pet::getPetsTutor($telTutor);
                            foreach ($pets as $pet) {
                                echo "<tr>";
                                echo "<td>"  . $pet["id"] . "</td>";
                                echo "<td>" . $pet["nome"] . "</td>";
                                echo "<td>" . $pet["descricao"] . "</td>";
                                echo "<td>" . $cuidador["dataCadastro"] . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>