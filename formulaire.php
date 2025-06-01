
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
        width: 80px;
        height: 50px;
        border-radius: 10px;
        margin-left: 680px;
    }



    body{
        font-size: 18px;
    }


    .carousel-container {
    position: relative;
    width: 100%;
    max-width: 400px;
    margin: 1rem auto;
    overflow: hidden;
    }


    .carousel {
        display: flex;
        transition: transform 0.5s ease;
        height: 400px;
    }


    .carousel img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        flex-shrink: 0;
    }


    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0,0,0,0.5);
        color: white;
        border: none;
        padding: 1rem;
        cursor: pointer;
        font-size: 1.5rem;
        z-index: 10;
    }


    #prevBtn {
        left: 10px;
    }


    #nextBtn {
        right: 10px;
    }


    .carousel-btn:hover {
        background-color: rgba(0,0,0,0.8);
    }


   
    .welcome {
        text-align: center;
        padding: 2rem;
        background-color: #f8f9fa;
    }



    .event-section {
        padding: 2rem;
        margin: 0 auto;
        max-width: 1000px;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }


    .event-card {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        text-align: center;
    }


    .event-card:hover {
        transform: scale(1.02);
    }


    .event-card h2 {
        color: #1c66af;
        margin-bottom: 1rem;
    }


    footer {
        background-color: #1c66af;
        color: white;
        padding: 2rem 4rem;
        margin-top: 2rem;
        display: flex;
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
        gap: 2rem;
        align-items: flex-start;
        text-align: left;
    }


    footer .contact-info {
        max-width: 300px;
        flex: 1;
        min-width: 250px;
    }

    footer .map {
        height: 200px;
        flex: 1;
        min-width: 300px;
        max-width: 500px;
    }

    .map {
        height: 200px;
        margin: 1rem auto;
        max-width: 800px;
    }




    .categories-container,
    .event-section {
        padding: 1rem;
    }

    .category-card,
    .event-card {
        padding: 1rem;
    }

    footer {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    footer .map {
        width: 100%;
        max-width: 100%;
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
                <div class = "ligne">
                <select id="activite" name="activite" required>
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                    
                </select>
                 </div>
            </div>

            <div class = "ligne"> 
                <label for="frequence">Si oui, combien de fois par semaine ?</label>
                <div class = "ligne"> 
                 <input type="number" id="frequence" name="frequence">
                </div>
            </div>

            <div class = "ligne"> 
                <label for="meilleur_coach">quel coach vous semble le plus qualifié ?</label>
                <div class = "ligne">
                <select id="meilleur_coach" name="meilleur_coach" required>
                    <option value="Brice">Brice Contentin</option>
                    
                </select>
                 </div>
            </div>
              <div class="ligne">
                    <label for="horaire_prefere">Horaire préféré pour les séances :</label>
                    <select id="horaire_prefere" name="horaire_prefere">
                        <option value="">-- Indifférent --</option>
                        <option value="matin">Matin (6h-10h)</option>
                        <option value="midi">Midi (11h-14h)</option>
                        <option value="aprem">Après-midi (14h-18h)</option>
                        <option value="soir">Soir (18h-22h)</option>
                    </select>
                </div>


                 <div class="ligne">
                    <label for="lieu_prefere">Lieu préféré pour les séances :</label>
                    <select id="lieu_prefere" name="lieu_prefere">
                        <option value="">-- Indifférent --</option>
                        <option value="domicile">À domicile</option>
                        <option value="salle">En salle de sport</option>
                        <option value="exterieur">En extérieur</option>
                        <option value="online">En ligne</option>
                    </select>
                </div>
                

                <div class="ligne">
                    <label for="commentaires">Commentaires ou demandes particulières :</label>
                    <textarea id="commentaires" name="commentaires" rows="4"></textarea>
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