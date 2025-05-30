
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
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
      .ligne{
        margin-top: 10px;
        align: center;
      }
      button {
        margin-top: 20px;
        background-color: blue;
        color: white;
        border: none;
        cursor: pointer;
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
    <a href="logout.php" style="color: #d33;">Déconnexion</a>
</nav>

    <div class="container">
        <h1>Formulaire Pour les Nouveaux utilisateurs</h1>
        <form action="#" method="POST">
            <div class = "ligne">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
             </div>

              <div class = "ligne">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
              </div>

             <div class = "ligne"> 
                <label for="age">Âge :</label>
                <input type="number" id="age" name="age" required>
            </div>

            <div class = "ligne"> 
                <label for="poids">Poids (kg) :</label>
                <input type="number" id="poids" name="poids" step="0.1">
            </div>

            <div class = "ligne"> 
                <label for="taille">Taille (cm) :</label>
                <input type="number" id="taille" name="taille" step="0.1">
            </div>


            
            <div class = "ligne"> 
            <label for="objectif">Quel est votre objectif :</label>
            <select id="objectif" name="objectif" required>
                <option value="perte">Perte de poids</option>
                <option value="musculation">Prise de masse musculaire</option>
                <option value="forme">Remise en forme</option>
                <option value="autre">Autre</option>
            </select>
            </div>

            <div class = "ligne"> 
                <label for="problemes">Avez vous un quelconque probleme de sante ?</label>
                <div class = "ligne"> 
                <textarea id="problemes" name="problemes" rows="4" ></textarea>
                </div>
            </div>
            
            <div class = "ligne"> 
                <label for="activite">Pratiquezvous deja une activité physique?</label>
                <select id="activite" name="activite" required>
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
            </select>
            </div>

            <div class = "ligne"> 
                <label for="frequence">Si oui, combien de fois par semaine ?</label>
                <div class = "ligne"> 
                 <input type="number" id="frequence" name="frequence">
                </div>
            </div>

            <button type="submit">Envoyer</button>
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