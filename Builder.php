<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres - Nom de votre entreprise</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <header>
        <h1>Nom de votre entreprise</h1>
        <nav>
            <ul>
                <li><a href="#about">À propos</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#projects">Projets</a></li>
                <li><a href="#offers">Offres</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="offers">
            <h2>Offres de Services</h2>
            <p>
                Une offre est une proposition formelle faite par un entrepreneur ou un fournisseur à un client dans le secteur de la construction. C'est une étape importante du processus d'approvisionnement, où l'entrepreneur présente ses prix et la portée de son travail pour un projet spécifique.
            </p>

            <h3>Exemples d'Offres</h3>
            <div class="offer">
                <h4>Offre de Construction Résidentielle</h4>
                <p>
                    **Description**: Construction d'une maison de 150 m² avec 3 chambres, 2 salles de bain, et un garage. 
                </p>
                <p><strong>Prix Estimé:</strong> 250 000 €</p>
                <p><strong>Délai de Réalisation:</strong> 6 mois</p>
            </div>
            
            <div class="offer">
                <h4>Offre de Rénovation Commerciale</h4>
                <p>
                    **Description**: Rénovation d'un espace de bureau de 200 m², y compris des travaux d'électricité, de plomberie, et de design intérieur.
                </p>
                <p><strong>Prix Estimé:</strong> 100 000 €</p>
                <p><strong>Délai de Réalisation:</strong> 3 mois</p>
            </div>

            <h3>Demandez une Offre</h3>
            <form method="post" action="submit_offer.php"> <!-- Lien vers le script de traitement -->
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="project_type">Type de Projet:</label>
                <select id="project_type" name="project_type" required>
                    <option value="residential">Résidentiel</option>
                    <option value="commercial">Commercial</option>
                    <option value="industrial">Industriel</option>
                </select><br>

                <label for="description">Description du Projet:</label>
                <textarea id="description" name="description" required></textarea><br>

                <label for="budget">Budget Estimé (€):</label>
                <input type="number" id="budget" name="budget" required><br>

                <input type="submit" value="Demander une Offre">
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Nom de votre entreprise. Tous droits réservés.</p>
    </footer>
</body>
</html>
