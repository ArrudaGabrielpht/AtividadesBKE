<?php

declare(strict_types=1);

// Classe responsável por criar e reutilizar a conexão.
class ConexaoBanco
{
    private static ?PDO $conexao = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception('Não é permitido desserializar.');
    }

    public static function obterConexao(string $arquivo): PDO
    {
        if (self::$conexao === null) {
            self::$conexao = self::criarConexao($arquivo);
        }

        return self::$conexao;
    }

    private static function criarConexao(string $arquivo): PDO
    {
        $config = parse_ini_file($arquivo, true);
        $dados = $config['development'];

        $dsn = "pgsql:host={$dados['db_host']};";
        $dsn .= "port={$dados['db_port']};";
        $dsn .= "dbname={$dados['db_name']}";

        return new PDO($dsn, $dados['db_user'], $dados['db_password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }
}