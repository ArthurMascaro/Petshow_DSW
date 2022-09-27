<?php

require_once 'BancoDados.php';

class Cuidador
{
    public static function cadastrar($nome, $email)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("INSERT INTO cuidador (nome, email, dataCadastro) VALUES ( ?, ?, now())");
            $sql->execute([$nome, $email]);
            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function listar()
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT c.id, c.nome, c.email, c.dataCadastro FROM cuidador c ORDER BY c.id");
            $sql->execute();
            return $sql->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existeEmail($email)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT count(*) FROM cuidador WHERE email = ?");
            $sql->execute([$email]);
            $quantidade = $sql->fetchColumn();
            if ($quantidade <= 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getCuidador($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("Select * from cuidador where id = ?");
            $sql->execute([$id]);
            return $sql->fetchAll()[0];
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getPets($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("Select idPet from Cuida ci inner join Pet p on p.id = ci.idPet where idCuidador = ? order by p.nome asc");
            $sql->execute([$id]);
            $idPets =  $sql->fetchAll();
            $pets = [];
            foreach ($idPets as $idPet) {
                $sql = $conexao->prepare("Select * from Pet where id = ? order by nome asc");
                $sql->execute([$idPet['idPet']]);
                $pet = $sql->fetchAll();
                array_push($pets, $pet);
            }
            return $pets;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existe($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT count(*) FROM cuidador WHERE id = ?");
            $sql->execute([$id]);
            $quantidade = $sql->fetchColumn();
            if ($quantidade > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function editar($id, $nome, $email)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("UPDATE cuidador SET nome = ?, email = ?, dataCadastro = now() WHERE id = ?");
            $sql->execute([$nome, $email, $id]);
            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existeEmailAlterar($email, $id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT count(*) FROM cuidador WHERE email = ? and id != ?");
            $sql->execute([$email, $id]);
            $quantidade = $sql->fetchColumn();
            if ($quantidade <= 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function excluir($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $assoc = Cuida::listarCuidador($id);
            foreach ($assoc as $tupla) {
                $sql = $conexao->prepare("DELETE FROM cuida WHERE idCuidador = ? and idPet = ?");
                $sql->execute([$tupla['idCuidador'], $tupla['idPet']]);
            }
            $sql = $conexao->prepare("DELETE FROM cuidador WHERE id = ?");
            $sql->execute([$id]);
            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}