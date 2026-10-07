<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuarios = simplexml_load_file("usuarios.xml");

    $novo = $usuarios->addChild("usuario");

    $novo->addChild("nome", $_POST['nome']);
    $novo->addChild("celular", $_POST['celular']);
    $novo->addChild("email", $_POST['email']);
    $novo->addChild("senha", md5($_POST['senha']));

    $usuarios->asXML("usuarios.xml");


    echo "<div style='text-align: center; margin: 80px auto; width: 350px; padding: 25px; background: white; border: 2px solid #056d82; border-radius: 12px; box-shadow: 0 4px 12px #ccc; color: #056d82; font-family: Arial; font-weight: bold;'>Usuário cadastrado com sucesso!<br><br><a href='login.php' style='color: white; background: #056d82; padding: 10px 20px; border-radius: 6px; text-decoration: none;'>Fazer login</a></div>";
} else {
?>

    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #fff3e0, #056d82);
            font-family: Arial, sans-serif;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            background-color: white;
            width: 320px;

            padding: 30px;

            border-radius: 15px;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #056d82;
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #555;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;

            margin-bottom: 16px;

            border: 1px solid #056d82;
            border-radius: 7px;

            outline: none;

            box-sizing: border-box;
        }

        input:focus {
            border-color: #056d82;
            box-shadow: 0 0 5px rgba(5, 109, 130, 0.3);
        }

        button {
            width: 100%;

            background-color: #056d82;
            color: white;

            border: none;

            padding: 12px;

            border-radius: 7px;

            cursor: pointer;

            font-size: 15px;
            font-weight: bold;

            transition: 0.3s;
        }

        button:hover {
            background-color: #056d82;
        }
    </style>

    <form method="post">

        <h2>Cadastro</h2>

        <label>Nome</label>
        <input type="text" name="nome" required>

        <label>Celular</label>
        <input type="text" name="celular" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <button type="submit">Cadastrar</button>

    </form>

<?php } ?>