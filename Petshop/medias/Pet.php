<?php

class Pet
{

    public static function cadastrar($nome, $descricao, $telTutor)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("INSERT INTO pet (nome, descricao, telTutor, dataCadastro) VALUES (?, ?, ?, now())");
            $sql->execute([$nome, $descricao, $telTutor]);
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
            $sql = $conexao->prepare("SELECT p.id, p.nome, p.descricao, p.telTutor, p.dataCadastro FROM pet p ORDER BY p.id");
            $sql->execute();
            return $sql->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function listarTel()
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT distinct p.telTutor FROM pet p ORDER BY p.id");
            $sql->execute();
            return $sql->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getPet($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("Select * from pet where id = ?");
            $sql->execute([$id]);
            return $sql->fetchAll()[0];
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getCuidadores($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("Select idCuidador from Cuida ci inner join Cuidador c on c.id = ci.idCuidador where idPet = ? order by c.nome asc");
            $sql->execute([$id]);
            $idCuidadores =  $sql->fetchAll();
            $cuidadores = [];
            foreach ($idCuidadores as $idCuidador) {
                $sql = $conexao->prepare("Select * from Cuidador where id = ? order by nome asc");
                $sql->execute([$idCuidador['idCuidador']]);
                $cuidador = $sql->fetchAll();
                array_push($cuidadores, $cuidador);
            }
            return $cuidadores;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getPetsTutor($telTutor)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("Select * from pet where telTutor = ? order by nome asc");
            $sql->execute([$telTutor]);
            return $sql->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existe($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT count(*) FROM pet WHERE id = ?");
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

    public static function Editar($id, $nome, $descricao, $telTutor)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("UPDATE pet SET nome = ?, descricao = ?, telTutor = ?, dataCadastro = now() WHERE id = ?");
            $sql->execute([$nome, $descricao, $telTutor, $id]);
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

    public static function remover($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $assoc = Cuida::listarPets($id);
            foreach ($assoc as $tupla) {
                $sql = $conexao->prepare("DELETE FROM cuida WHERE idCuidador = ? and idPet = ?");
                $sql->execute([$tupla['idCuidador'], $tupla['idPet']]);
            }
            $sql = $conexao->prepare("DELETE FROM pet WHERE id = ?");
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