<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
    body { 
        font-family: Arial, sans-serif; 
        display: grid; 
        place-items: center; 
        min-height: 100vh; 
        background: #f4f4f4; 
        margin: 0;
    }
    form { 
        background: white; 
        height: auto;
        width: 95%; 
        max-width: 400px;
        border-radius: 8px; 
        padding: 25px; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        box-sizing: border-box;
    }
    input { 
        display: block; 
        margin-bottom: 15px; 
        padding: 12px;    
        width: 100%; 
        box-sizing: border-box; 
    }
    button { 
        background: #0f172a; 
        color: white; 
        padding: 12px 15px;
        border: none; 
        border-radius: 5px; 
        cursor: pointer;
        width: 100%;
    }
    </style>
</head>
<body>
    <form action="processar_login.php" method="POST">
        <h2>Login Administrativo</h2>
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>