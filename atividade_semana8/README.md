# Parte A: Exercícios Teóricos de Fixação

## 1. Abstração de Dados: O que é o PDO no PHP e por que ele é preferível em relação a extensões especializadas procedurais como o antigo pgsql em projetos corporativos?

> **Resposta:** PDO é uma ferramenta do PHP que serve para conectar o sistema com o banco de dados. Ele é melhor em muitos casos porque consegue trabalhar com vários bancos, como PostgreSQL, MySQL e SQLite. Já o pgsql é usado somente para PostgreSQL.

---

## 2. Ciclo do DSN: Explique o que é a string DSN e detalhe a finalidade de cada um dos parâmetros configurados para o PostgreSQL (host, port, dbname).

> **Resposta:** A string DSN serve para passar as informações do banco que o PHP vai acessar. Um exemplo seria `"pgsql:host=localhost;port=5432;dbname=empresa"`. O `host` mostra onde o banco está, o `port` indica a porta usada e o `dbname` mostra o nome do banco que será acessado.

---

## 3. Padrão de Portas: Qual é a porta padrão de escuta do SGBD PostgreSQL (5432) e como ela é referenciada dentro da string de conexão?

> **Resposta:** A porta padrão do PostgreSQL é a 5432. Na string de conexão ela aparece como `port=5432`. Essa informação serve para indicar ao PHP qual porta ele deve usar para se conectar ao PostgreSQL.

---

## 4. Flags de Integridade: O que acontece quando definimos o atributo PDO::ATTR_ERRMODE com o valor PDO::ERRMODE_EXCEPTION? Qual seria o comportamento padrão caso essa flag não fosse definida?

> **Resposta:** Quando colocamos `PDO::ERRMODE_EXCEPTION`, o PHP gera uma exceção quando acontece algum erro na conexão ou em alguma operação com o banco. Assim podemos usar `try` e `catch` para tratar o erro. Se não colocarmos essa configuração, o PDO usa o modo `PDO::ERRMODE_SILENT`, que não mostra a exceção automaticamente.

---

## 5. Fetch Mode: Qual é a vantagem de utilizar PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC para o consumo de memória RAM do servidor?

> **Resposta:** O `PDO::FETCH_ASSOC` faz os resultados da consulta aparecerem usando o nome das colunas. Ele não cria também os índices numéricos para os mesmos dados. Com isso, pode diminuir um pouco o uso de memória, principalmente quando a consulta retorna muitos registros.

---

## 6. Padrão Singleton: Por que abrir uma nova conexão com new PDO() a cada consulta executada no PostgreSQL pode esgotar o limite de max_connections do servidor?

> **Resposta:** Se o programa usar `new PDO()` toda hora, ele pode criar várias conexões com o banco. O PostgreSQL tem um limite de conexões chamado `max_connections`. Se muitas forem abertas ao mesmo tempo, esse limite pode ser atingido e o banco pode começar a recusar novas conexões. O Singleton ajuda a reutilizar uma única conexão.

---

## 7. Encapsulamento do Singleton: Por que o construtor da classe ConexaoBanco precisa ser declarado como private e quais métodos mágicos devem ser bloqueados para garantir a unicidade da instância?

> **Resposta:** O construtor fica como `private` para impedir que outras partes do código criem uma nova conexão usando `new`. O `__clone()` também deve ser bloqueado para não poder copiar a conexão. O `__wakeup()` é bloqueado para evitar que outra instância seja criada por desserialização. Assim, fica mais fácil garantir que só exista uma instância.

---

## 8. Segurança de Credenciais: Por que nunca devemos deixar o usuário e senha do banco de dados salvos de forma estática (hardcoded) dentro dos scripts PHP do projeto?

> **Resposta:** Não é uma boa ideia colocar o usuário e a senha diretamente no código porque outras pessoas podem acabar vendo essas informações. Isso pode acontecer se o projeto for enviado para o GitHub ou compartilhado com alguém. O melhor é deixar essas informações em variáveis de ambiente ou em algum lugar mais seguro.

---

## 9. Tratamento de Exceções & LGPD: Por que a exibição direta de $e->getMessage() de uma PDOException na tela do navegador é considerada uma falha grave de segurança (Information Disclosure)?

> **Resposta:** Mostrar `$e->getMessage()` direto na tela pode revelar informações do sistema que não deveriam aparecer para o usuário. Por exemplo, pode mostrar nomes de tabelas, comandos SQL ou informações sobre o banco. Por isso, o ideal é guardar o erro nos logs e mostrar somente uma mensagem simples para o usuário.
