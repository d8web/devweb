<?php

namespace core\helpers;

use PDO;
use PDOException;

class Database
{
    private $connect;

    private function connectDatabase(): void
    {
        // Conectar ao banco de dados
        $this->connect = new PDO(
            "mysql:" .
                "host=" . MYSQL_SERVER . ";" .
                "dbname=" . MYSQL_DATABASE . ";" .
                "charset=" . MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );

        // Debug
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    private function disconectDatabase(): void
    {
        // Desconectar do banco de dados
        $this->connect = null;
    }

    // Método para selecionar dados do banco
    public function select(string $sql, $params = null)
    {
        // Limpar espaços da query sql
        $sql = trim($sql);

        // Verificar se é uma instrução SELECT
        if (!preg_match("/^SELECT/i", $sql)) {
            // throw new Exception("Base de dados - Não é uma instrução SELECT.");
            die("Base de dados - Não é uma instrução SELECT.");
        }

        // Conectando ao banco de dados.
        $this->connectDatabase();

        $results = null;

        try {

            if (!empty($params)) {
                $executar = $this->connect->prepare($sql);
                $executar->execute($params);
                $results = $executar->fetchAll(PDO::FETCH_CLASS);
            } else {
                $executar = $this->connect->prepare($sql);
                $executar->execute();
                $results = $executar->fetchAll(PDO::FETCH_CLASS);
            }
        } catch (PDOException $e) {
            // Caso exista um erro retorna falso.
            return false;
        }

        // Desconectando do banco de dados.
        $this->disconectDatabase();

        // Retornar o resultado
        return $results;
    }

    // Método para inserir dados do banco
    public function insert(string $sql, $params = null)
    {
        // Limpar espaços da query sql
        $sql = trim($sql);

        // Verificar se é uma instrução INSERT
        if (!preg_match("/^INSERT/i", $sql)) {
            // throw new Exception("Base de dados - Não é uma instrução INSERT.");
            die("Base de dados - Não é uma instrução INSERT.");
        }

        // Conectando ao banco de dados.
        $this->connectDatabase();

        try {

            if (!empty($params)) {
                $executar =  $this->connect->prepare($sql);
                $executar->execute($params);
            } else {
                $executar = $this->connect->prepare($sql);
                $executar->execute();
            }

            return $this->connect->lastInsertId();

        } catch (PDOException $e) {
            // Caso exista um erro retorna falso.
            return false;
        }

        // Desconectando do banco de dados.
        $this->disconectDatabase();
    }

    // Método para atualizar dados do banco
    public function update(string $sql, $params = null)
    {
        // Limpar espaços da query sql
        $sql = trim($sql);

        // Verificar se é uma instrução UPDATE
        if (!preg_match("/^UPDATE/i", $sql)) {
            // throw new Exception("Base de dados - Não é uma instrução UPDATE.");
            die("Base de dados - Não é uma instrução UPDATE.");
        }

        // Conectando ao banco de dados.
        $this->connectDatabase();

        try {

            if (!empty($params)) {
                $executar = $this->connect->prepare($sql);
                $executar->execute($params);
            } else {
                $executar = $this->connect->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) {
            // Caso exista um erro retorna falso.
            return false;
        }

        // Desconectando do banco de dados.
        $this->disconectDatabase();
    }

    // Método para deletar dados do banco
    public function delete(string $sql, $params = null)
    {
        // Limpar espaços da query sql
        $sql = trim($sql);

        // Verificar se é uma instrução DELETE
        if (!preg_match("/^DELETE/i", $sql)) {
            // throw new Exception("Base de dados - Não é uma instrução DELETE.");
            die("Base de dados - Não é uma instrução DELETE.");
        }

        // Conectando ao banco de dados.
        $this->connectDatabase();

        try {

            if (!empty($params)) {
                $executar = $this->connect->prepare($sql);
                $executar->execute($params);
            } else {
                $executar = $this->connect->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) {
            // Caso exista um erro retorna falso.
            return false;
        }

        // Desconectando do banco de dados.
        $this->disconectDatabase();
    }
}