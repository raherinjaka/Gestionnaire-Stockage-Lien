<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, mot_de_passe) VALUES (?, ?)");
    $stmt->execute([$_POST['nom'], $hash]);
    header('Location: login.php?success=Compte créé avec succès !');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Nouveau Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: rgba(50, 50, 70, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 50px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
        }

        .login-title {
            color: #ffffff;
            text-align: center;
            font-size: 1.8rem;
            font-weight: 300;
            letter-spacing: 4px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-control {
            background: rgba(60, 60, 80, 0.6);
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 0;
            color: #ffffff;
            padding: 12px 15px 12px 45px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(60, 60, 80, 0.8);
            border-bottom: 2px solid rgba(255, 255, 255, 0.5);
            box-shadow: none;
            color: #ffffff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.2rem;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            background: rgba(100, 100, 130, 0.7);
            border: none;
            color: #ffffff;
            padding: 15px;
            font-size: 1.1rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            border-radius: 10px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: rgba(120, 120, 150, 0.9);
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
        }

        .register-link a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95rem;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
        }

        .register-link a {
            color: rgba(255, 255, 255, 0.6); 
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .register-link a:hover {
            color: #00f2fe; 
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.5); 
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Inscription</h2>

        <form method="POST">
            <div class="form-group">
                <i class="bi bi-person input-icon"></i>
                <input type="text" name="nom" class="form-control" placeholder="Enter votre nom" required>
            </div>

            <div class="form-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                </button>
            </div>

            <button type="submit" class="btn btn-login">Créer mon compte</button>

            <div class="register-link">
                <a href="login.php">Déjà inscrit ? Se connecter</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
</body>
<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, mot_de_passe) VALUES (?, ?)");
    $stmt->execute([$_POST['nom'], $hash]);
    header('Location: login.php?success=Compte créé avec succès !');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Nouveau Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: rgba(50, 50, 70, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 50px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
        }

        .login-title {
            color: #ffffff;
            text-align: center;
            font-size: 1.8rem;
            font-weight: 300;
            letter-spacing: 4px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-control {
            background: rgba(60, 60, 80, 0.6);
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 0;
            color: #ffffff;
            padding: 12px 15px 12px 45px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(60, 60, 80, 0.8);
            border-bottom: 2px solid rgba(255, 255, 255, 0.5);
            box-shadow: none;
            color: #ffffff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.2rem;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            background: rgba(100, 100, 130, 0.7);
            border: none;
            color: #ffffff;
            padding: 15px;
            font-size: 1.1rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            border-radius: 10px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: rgba(120, 120, 150, 0.9);
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
        }

        .register-link a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95rem;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
        }

        .register-link a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .register-link a:hover {
            color: #00f2fe; 
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.5); 
            transform: translateY(-2px); 
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title">Inscription</h2>

        <form method="POST">
            <div class="form-group">
                <i class="bi bi-person input-icon"></i>
                <input type="text" name="nom" class="form-control" placeholder="Enter votre nom" required>
            </div>

            <div class="form-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                </button>
            </div>

            <button type="submit" class="btn btn-login">Créer mon compte</button>

            <div class="register-link">
                <a href="login.php">Déjà inscrit ? Se connecter</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
</body>
</html>