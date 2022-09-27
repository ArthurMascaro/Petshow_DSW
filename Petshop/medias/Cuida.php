<?php

class Cuida
{

    public static function cadastrar($idCuidador, $idPet)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("INSERT INTO cuida (idCuidador, idPet) VALUES (?, ?)");
            $sql->execute([$idCuidador, $idPet]);
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
            $sql = $conexao->prepare("SELECT c.idCuidador, c.idPet FROM cuida c");
            $sql->execute();
            return $sql->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function listarPets($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT c.idCuidador, c.idPet FROM cuida c where c.idPet = ?");
            $sql->execute([$id]);
            return $sql->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function listarCuidador($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("SELECT c.idCuidador, c.idPet FROM cuida c where c.idCuidador = ?");
            $sql->execute([$id]);
            return $sql->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}