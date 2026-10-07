<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Você precisa estar logado.";
    exit;
}
$topicos = simplexml_load_file("topicos.xml");
$id = intval($_GET['id']);
$comentario_id = intval($_GET['comentario']);
if ($_SESSION['usuario'] == $topicos->topico[$id]->autor) {
    unset($topicos->topico[$id]->comentarios->comentario[$comentario_id]);
    $topicos->asXML("topicos.xml");
}
header("Location: listar.php");

?>

<style>
        body {
            background: #fff3e0;
            text-align: center;
        }

        form {
            background: white;
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
        }

        input {
            padding: 8px;
            margin: 5px;
            width: 90%;
        }

        button {
            background: #056d82;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #056d82;
        }
    </style>

    <form method="post">

        <h2>Login</h2>

        Email:
        <input type="email" name="email" required><br>

        Senha:
        <input type="password" name="senha" required><br>

        <button type="submit">Entrar</button>

    </form>
