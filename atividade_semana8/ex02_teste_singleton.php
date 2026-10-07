<?php

declare(strict_types=1);

require_once 'ConexaoBanco.php';

const ARQUIVO_CONFIG = 'config/database.ini';

// Compara duas conexões do Singleton.
function testarSingleton(): void
{
    try {
        $conexao1 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
        $conexao2 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

        $mesmaConexao = $conexao1 === $conexao2;

        echo "ID da conexão 1: " . spl_object_id($conexao1) . "\n";
        echo "ID da conexão 2: " . spl_object_id($conexao2) . "\n";

        if ($mesmaConexao) {
            echo "As duas variáveis usam a mesma conexão.\n";
        }
    } catch (PDOException $e) {
        echo "Erro ao testar o Singleton.\n";
    }
}

testarSingleton();