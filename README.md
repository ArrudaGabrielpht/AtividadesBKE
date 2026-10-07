# Lista de Exercícios: Processamento HTTP e Formulários

## Parte A: Exercícios Teóricos de Fixação

### 1. Diferença Estrutural

**Pergunta:** Explique a diferença física entre onde os dados são anexados em uma requisição GET e em uma requisição POST.

**Resposta:**
No GET, os dados ficam na própria URL, depois do `?`, então ficam visíveis no navegador. Já no POST, os dados são enviados dentro do corpo da requisição e não aparecem na URL.

---

### 2. Segurança e Privacidade

**Pergunta:** Por que senhas de usuário nunca devem ser enviadas via método GET? Cite pelo menos dois locais onde essa senha ficaria gravada de forma insegura.

**Resposta:**
Porque no GET a senha fica aparecendo na URL. Ela poderia ficar salva no histórico do navegador e também nos logs do servidor. Por isso, senhas devem ser enviadas usando POST.

---

### 3. Coalescência Nula

**Pergunta:** Por que a instrução `$nome = $_POST['nome'];` dispara um Warning na primeira vez que a página é carregada no navegador? Como o operador `??` resolve isso?

**Resposta:**
Isso acontece porque quando a página é aberta pela primeira vez, o formulário ainda não foi enviado. Então `$_POST['nome']` não existe e o PHP mostra um Warning.

O `??` permite colocar um valor padrão caso a informação não exista:

```php
$nome = $_POST['nome'] ?? '';
```

Assim, se `nome` não existir, ele recebe uma string vazia.

---

### 4. Idempotência

**Pergunta:** O que significa dizer que uma requisição GET é idempotente? Por que atualizar ou deletar dados no banco usando links GET é uma má prática de segurança?

**Resposta:**
Significa que fazer a mesma requisição GET várias vezes não deveria ficar alterando os dados do sistema.

Usar GET para atualizar ou deletar dados é ruim porque uma pessoa poderia clicar em um link sem querer e acabar alterando ou apagando alguma informação do banco.

---

### 5. Validação Client vs Server

**Pergunta:** Um desenvolvedor júnior afirma que o formulário dele é 100% seguro porque colocou `required` e `type="email"` em todas as tags HTML. Explique por que essa afirmação é falsa.

**Resposta:**
Essa afirmação é falsa porque essas validações são feitas pelo navegador. O usuário pode desativar as validações do HTML ou enviar os dados diretamente para o servidor.

Por isso, o PHP também precisa validar os dados antes de aceitar qualquer informação.

---

### 6. XSS e Sanitização

**Pergunta:** Qual é o risco de exibir dados vindos de um `$_POST` diretamente na tela sem utilizar `htmlspecialchars()`?

**Resposta:**
O usuário poderia enviar um código HTML ou JavaScript malicioso no formulário. Quando esse conteúdo fosse mostrado na página, o navegador poderia executar o código.

Isso pode causar um ataque de **XSS**. O `htmlspecialchars()` ajuda a evitar esse problema transformando os caracteres especiais em texto.

---

### 7. Sticky Forms

**Pergunta:** O que é a técnica de Sticky Forms e qual é o seu impacto na experiência do usuário (UX)?

**Resposta:**
Sticky Forms é quando os dados que o usuário digitou continuam preenchidos no formulário depois que ele é enviado.

Isso ajuda bastante quando existe algum erro, porque o usuário não precisa digitar tudo novamente. Assim, a experiência de uso fica melhor.

---

### 8. DevTools

**Pergunta:** Como você utilizaria a aba Network do navegador para comprovar que um formulário foi enviado via POST e não via GET?

**Resposta:**
Eu abriria o DevTools do navegador e entraria na aba **Network**. Depois enviaria o formulário e procuraria pela requisição feita.

Ao abrir a requisição, eu verificaria o campo **Request Method**. Se aparecer:

```text
Request Method: POST
```

significa que o formulário foi enviado usando POST.
