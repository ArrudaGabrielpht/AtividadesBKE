?php

declare(strict_types=1);

require_once 'ConexaoBanco.php';

const ARQUIVO_CONFIG = 'config/database.ini';

// Carrega os dados do ambiente escolhido.
function carregarAmbiente(string $ambiente): array
{
    $config = parse_ini_file(ARQUIVO_CONFIG, true);

    if (!isset($config[$ambiente])) {
        throw new Exception('Ambiente não encontrado.');
    }

    return $config[$ambiente];
}

// Cria uma conexão usando o ambiente escolhido.
function conectarAmbiente(array $dados): PDO
{
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

try {
    $dados = carregarAmbiente('testing');
    conectarAmbiente($dados);

    echo "Ambiente testing conectado com sucesso!";
} catch (PDOException $e) {
    echo "Não foi possível conectar ao ambiente.";
} catch (Exception $e) {
    echo "Ambiente inválido.";
}