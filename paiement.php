<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 40px;
            padding: 20px;
        }
        form {
            width: 90%;
            max-width: 500px;
            margin: 30px auto;
        }
        .ligne {
            margin-top: 10px;
            text-align: center;
        }
        button {
            margin-top: 20px;
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
            width: 80px;
            height: 50px;
            border-radius: 10px;
        }
        body {
            font-size: 18px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <header>
        <img src="Images/Logo-sportify.png" alt="Sportify Logo">
    </header>

    <nav>
        <a href="Accueil.php">Accueil</a>
        <a href="Tout_parcourir.php">Tout parcourir</a>
        <a href="recherche.php">Recherche</a>
        <a href="rendez-vous.php">Rendez-vous</a>
        <a href="Votre_compte.php">Votre compte</a>
     
    </nav>

    <div class="container">
        <h1>Paiement</h1>
        <form action="paiement_stockage.php" method="POST">

            <div class="ligne">
                <label for="client_username">Nom d'utilisateur :</label>
                <input type="text" id="client_username" name="client_username" required>
            </div>

            <div class="ligne">
                <label for="nom_complet">Nom complet :</label>
                <input type="text" id="nom_complet" name="nom_complet" required>
            </div>

            <div class="ligne">
                <label for="adresse1">Adresse ligne 1 :</label>
                <input type="text" id="adresse1" name="adresse1" required>
            </div>

            <div class="ligne">
                <label for="adresse2">Adresse ligne 2 (optionnel) :</label>
                <input type="text" id="adresse2" name="adresse2">
            </div>

            <div class="ligne">
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" required>
            </div>

            <div class="ligne">
                <label for="code_postal">Code postal :</label>
                <input type="text" id="code_postal" name="code_postal" required>
            </div>

            <div class="ligne">
                <label for="pays">Pays :</label>
                <input type="text" id="pays" name="pays" required>
            </div>

            <div class="ligne">
                <label for="telephone">Téléphone :</label>
                <input type="tel" id="telephone" name="telephone">
            </div>

            <div class="ligne">
                <label for="carte_etudiant">Numéro de carte étudiante (optionnel) :</label>
                <input type="text" id="carte_etudiant" name="carte_etudiant">
            </div>


            <div class="ligne">
                <label for="type_carte">Type de carte :</label>
                <select id="type_carte" name="type_carte" required>
                    <option value="Visa">Visa</option>
                    <option value="MasterCard">MasterCard</option>
                    <option value="American Express">American Express</option>
                    <option value="PayPal">PayPal</option>
                </select>
            </div>

            <div class="ligne">
                <label for="numero_carte">Numéro de carte :</label>
                <input type="text" id="numero_carte" name="numero_carte" required>
            </div>

            <div class="ligne">
                <label for="nom_carte">Nom sur la carte :</label>
                <input type="text" id="nom_carte" name="nom_carte" required>
            </div>

            <div class="ligne">
                <label for="date_expiration">Date d'expiration :</label>
                <input type="date" id="date_expiration" name="date_expiration" required>
            </div>

            <div class="ligne">
                <label for="code_securite">Code de sécurité :</label>
                <input type="text" id="code_securite" name="code_securite" maxlength="4" required>
            </div>

            <button type="submit">Payer</button>
        </form>
    </div>

    <footer>
        <div class="contact-info">
            <h3>Contactez-nous</h3>
            <p>33 Rue des sportifs de l'ECE<br>
                team.sportify@onnes.com<br>
                06 33 16 22 31</p>
        </div>
    </footer>
</body>
</html>