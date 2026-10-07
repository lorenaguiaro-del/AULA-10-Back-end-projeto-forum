<?php 
// Alteração: usa caminhos absolutos e as rotinas comuns de XML. 
session_start(); 
require_once __DIR__ . '/funcoes.php'; 
 
if (!isset($_SESSION['usuario'])) { 
    encerrarComErro('Você precisa estar logado para criar um tópico.', 403); 
} 
 
$titulo = ''; 
$mensagem = ''; 
$erro = ''; 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // Alteração: valida o token e os campos antes de acessar o XML. 
    if (!csrfValido($_POST['csrf_token'] ?? null)) { 
        encerrarComErro('Formulário expirado. Tente novamente.', 403); 
    } 

    $titulo = trim((string) ($_POST['titulo'] ?? '')); 
    $mensagem = trim((string) ($_POST['mensagem'] ?? '')); 

    if ($titulo === '' || $mensagem === '') { 
        $erro = 'Informe o título e a mensagem.'; 
    } else { 
        try { 
            $topicos = carregarXml(ARQUIVO_TOPICOS, 'topicos'); 
            $novo = $topicos->addChild('topico'); 
            adicionarTextoXml($novo, 'autor', (string) $_SESSION['usuario']); 
            adicionarTextoXml($novo, 'titulo', $titulo); 
            adicionarTextoXml($novo, 'mensagem', $mensagem); 
            $novo->addChild('comentarios'); 
            salvarXml($topicos, ARQUIVO_TOPICOS); 

            // Alteração: evita a criação duplicada ao atualizar a página. 
            $_SESSION['mensagem_sucesso'] = 'Tópico criado com sucesso!'; 
            header('Location: listar.php'); 
            exit; 

        } catch (RuntimeException $excecao) { 
            $erro = $excecao->getMessage(); 
        } 
    } 
} 
?> 

<!doctype html> 
<html lang="pt-BR"> 

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Criar Tópico</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family: Arial, sans-serif;

            background: linear-gradient(135deg, #fff3e0, #056d82);

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 500px;

            background: white;

            padding: 35px;

            border-radius: 16px;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        h1 {
            margin: 0 0 8px;

            text-align: center;

            color: #056d82;

            font-size: 28px;
        }

        .subtitulo {
            text-align: center;

            color: #777;

            margin-bottom: 25px;

            font-size: 14px;
        }

        .erro {
            background: #ffebee;

            color: #056d82;

            padding: 10px;

            border-radius: 7px;

            margin-bottom: 15px;

            text-align: center;
        }

        label {
            display: block;

            color: #555;

            font-weight: bold;

            margin-bottom: 7px;
        }

        input,
        textarea {
            width: 100%;

            padding: 12px;

            margin-bottom: 18px;

            border: 1px solid #056d82;

            border-radius: 8px;

            outline: none;

            font-size: 15px;

            font-family: Arial, sans-serif;
        }

        input:focus,
        textarea:focus {
            border-color: #056d82;

            box-shadow: 0 0 5px rgba(245, 124, 0, 0.25);
        }

        textarea {
            height: 150px;

            resize: vertical;
        }

        button {
            width: 100%;

            padding: 13px;

            background: #056d82;

            color: white;

            border: none;

            border-radius: 8px;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        button:hover {
            background: #056d82;

            transform: translateY(-1px);
        }

        .voltar {
            display: block;

            text-align: center;

            margin-top: 18px;

            color: #056d82;

            text-decoration: none;

            font-size: 14px;
        }

        .voltar:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

    <div class="container">

        <h1>Criar Tópico</h1>

        <p class="subtitulo">
            Compartilhe uma nova ideia ou assunto com a comunidade
        </p>

        <?php if ($erro !== ''): ?>
            <div class="erro">
                <?= escapar($erro) ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <input 
                type="hidden" 
                name="csrf_token" 
                value="<?= escapar(tokenCsrf()) ?>"
            >

            <label for="titulo">Título</label>

            <input 
                type="text" 
                id="titulo"
                name="titulo" 
                value="<?= escapar($titulo) ?>" 
                placeholder="Digite o título do tópico"
                required
            >

            <label for="mensagem">Mensagem</label>

            <textarea 
                id="mensagem"
                name="mensagem" 
                placeholder="Escreva sua mensagem..."
                required
            ><?= escapar($mensagem) ?></textarea>

            <button type="submit">
                Criar Tópico
            </button>

        </form>

        <a class="voltar" href="listar.php">
            Voltar aos tópicos
        </a>

    </div>

</body>

</html>