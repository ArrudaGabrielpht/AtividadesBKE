<?php

declare(strict_types=1);

require_once 'ConexaoBanco.php';

const ARQUIVO_CONFIG = 'config/database.ini';

// Testa a conexão com o PostgreSQL.
function testarConexao(string $arquivo): void
{
    try {
        $pdo = ConexaoBanco::obterConexao($arquivo);
        $versao = $pdo->query('SELECT version()')->fetchColumn();

        echo "Conexão realizada com sucesso!\n";
        echo "PostgreSQL: {$versao}\n";
    } catch (PDOException $e) {
        echo "Não foi possível conectar ao banco.\n";
        echo "Verifique a porta 5432 e as configurações.\n";
    }
}

testarConexao(ARQUIVO_CONFIG);