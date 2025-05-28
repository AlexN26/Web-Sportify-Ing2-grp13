<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'client':
            header("Location: client.php");
            break;
        case 'coach':
            header("Location: coach.php");
            break;
        case 'admin':
            header("Location: admin.php");
            break;
        default:
            // Si le rôle est inconnu, déconnexion par sécurité
            session_destroy();
            header("Location: register.php?error=session_error");
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Sportify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #1c66af;
            box-shadow: 0 0 5px rgba(28, 102, 175, 0.3);
        }
        
        .login-btn {
            background-color: #1c66af;
            color: white;
            border: none;
            padding: 0.8rem;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        
        .login-btn:hover {
            background-color: #15527a;
        }
        
        .login-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        
        .error-banner {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 1rem;
            display: none;
        }
        
        .success-banner {
            background-color: #d4edda;
            color: #155724;
            padding: 0.75rem;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 1rem;
            display: none;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }
        
        .register-link a {
            color: #1c66af;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .loading {
            display: none;
            text-align: center;
            margin-top: 1rem;
        }
        
        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #1c66af;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .hidden {
            display: none;
        }
        
       
        
        
        
        
        main {
            min-height: 60vh;
            padding: 2rem 1rem;
        }
    </style>
</head>
<body>
    <header>
        <img src="Images/Logo-sportify.png" alt="Sportify Logo" height="150">
    </header>
    
    <nav>
        <a href="Accueil.php">Accueil</a>
        <a href="Tout_parcourir.php">Tout parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendez-vous.php">Rendez-vous</a>
        <a href="Votre_compte.php" class="active">Votre compte</a>
    </nav>
    
    <main>
        <!-- Formulaire de connexion -->
        <div id="login-form" class="login-container">
            <h2>Connexion à votre compte</h2>
            
            <!-- Bandeau d'erreur -->
            <div id="error-banner" class="error-banner">
                <strong>Erreur :</strong> <span id="error-message">Nom d'utilisateur ou mot de passe incorrect</span>
            </div>
            
            <!-- Bandeau de succès -->
            <div id="success-banner" class="success-banner">
                <strong>Succès :</strong> <span id="success-message">Connexion réussie, redirection en cours...</span>
            </div>
            
            <form id="loginForm" action="authenticate.php" method="POST">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur *</label>
                    <input type="text" id="username" name="username" required autocomplete="username">
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="login-btn" id="loginBtn">Se connecter</button>
                
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    Connexion en cours...
                </div>
            </form>
            
            <div class="register-link">
                <p>Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
            </div>
        </div>
        
        <!-- Interface Client (masquée par défaut) -->
        <div id="client-interface" class="hidden">
            <h2>Espace Client</h2>
            <!-- Contenu spécifique au client -->
        </div>
        
        <!-- Interface Coach (masquée par défaut) -->
        <div id="coach-interface" class="hidden">
            <h2>Espace Coach</h2>
            <!-- Contenu spécifique au coach -->
        </div>
        
        <!-- Interface Admin (masquée par défaut) -->
        <div id="admin-interface" class="hidden">
            <h2>Espace Administrateur</h2>
            <!-- Contenu spécifique à l'admin -->
        </div>
    </main>
    
    <footer>
        <div class="contact-info">
            <h3>Contactez-nous</h3>
            <p>33 Rue des sportifs de l'ECE<br>
            team.sportify@onnes.com<br>
            06 33 16 22 31</p>
        </div>

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46125.16715836869!2d3.6489429259873885!3d43.735004800892554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12b3fe268b01f953%3A0x4078821166ab9b0!2s34380%20Viols-le-Fort!5e0!3m2!1sfr!2sfr!4v1748268041768!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vérifier s'il y a des paramètres d'erreur dans l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const errorBanner = document.getElementById('error-banner');
            const errorMessage = document.getElementById('error-message');
            
            if (urlParams.has('error')) {
                const errorType = urlParams.get('error');
                let message = 'Une erreur est survenue';
                
                switch(errorType) {
                    case 'invalid_credentials':
                        message = 'Nom d\'utilisateur ou mot de passe incorrect';
                        break;
                    case 'empty_fields':
                        message = 'Veuillez remplir tous les champs';
                        break;
                    case 'db_error':
                        message = 'Erreur de connexion à la base de données';
                        break;
                    case 'session_error':
                        message = 'Erreur de session, veuillez réessayer';
                        break;
                    default:
                        message = 'Erreur inconnue, veuillez réessayer';
                }
                
                errorMessage.textContent = message;
                errorBanner.style.display = 'block';
            }
            
            // Gestion du formulaire
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const loading = document.getElementById('loading');
            
            loginForm.addEventListener('submit', function(e) {
                // Validation côté client
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;
                
                if (!username || !password) {
                    e.preventDefault();
                    showError('Veuillez remplir tous les champs');
                    return;
                }
                
                if (username.length < 3) {
                    e.preventDefault();
                    showError('Le nom d\'utilisateur doit contenir au moins 3 caractères');
                    return;
                }
                
                if (password.length < 6) {
                    e.preventDefault();
                    showError('Le mot de passe doit contenir au moins 6 caractères');
                    return;
                }
                
                // Afficher le loading
                loginBtn.disabled = true;
                loginBtn.style.display = 'none';
                loading.style.display = 'block';
                hideMessages();
            });
            
            function showError(message) {
                errorMessage.textContent = message;
                errorBanner.style.display = 'block';
                document.getElementById('success-banner').style.display = 'none';
            }
            
            function hideMessages() {
                errorBanner.style.display = 'none';
                document.getElementById('success-banner').style.display = 'none';
            }
            
            // Masquer les messages d'erreur quand l'utilisateur commence à taper
            document.getElementById('username').addEventListener('input', hideMessages);
            document.getElementById('password').addEventListener('input', hideMessages);
        });
    </script>
</body>
</html>