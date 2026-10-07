<?php

declare(strict_types=1);

// Registra mensagens importantes no arquivo de log.
function registrarLog(string $nivel, string $mensagem): void
{
    $niveis = ['INFO', 'WARNING', 'ERROR'];

    if (!in_array($nivel, $niveis, true)) {
        return;
    }

    $data = date('Y-m-d H:i:s');
    $linha = "[$data] [$nivel] $mensagem" . PHP_EOL;

    file_put_contents('logs/sistema.log', $linha, FILE_APPEND);
}

// Simula uma conexão com erro.
function testarErro(): void
{
    try {
        $pdo = new PDO(
            'pgsql:host=127.0.0.1;port=5432;dbname=banco_inexistente',
            'usuario',
            'senha_errada',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        registrarLog('INFO', 'Conexão realizada com sucesso.');
    } catch (PDOException $e) {
        registrarLog('ERROR', $e->getMessage());
        echo "Erro na conexão. Consulte o log.\n";
    }
}

registrarLog('INFO', 'Sistema iniciado.');
registrarLog('WARNING', 'Teste de aviso.');
testarErro();