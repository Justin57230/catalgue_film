<!-- header.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Page</title>
    <link rel="stylesheet" href="./style/header.css">
    <style>
        /* Ajoutez le lien vers votre feuille de style CSS */

        /* Styles pour le menu déroulant d'administration */
        .admin-dropdown {
            position: relative;
            display: inline-block;
        }

        .admin-btn {
            padding: 10px;
            display: block;
        }

        .admin-dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .admin-dropdown:hover .admin-dropdown-content {
            display: block;
        }

        .admin-dropdown-content a {
            display: block;
            width: 100%;
            padding: 10px;
            text-decoration: none;
            color: #333;
            background-color: #fff;
            text-align: left;
            cursor: pointer;
        }

        .admin-dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Aligner le lien "Déconnexion" à droite */
        nav {
            display: flex;
            justify-content: space-between;
        }

        .logout-link {
            margin-left: auto;
        }

        /* Style pour le bouton "Modifier mon profil" */
        .profile-btn {
            padding: 10px;
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>

<body>
    <header>
        <h1>Matte en stream</h1>
    </header>

    <nav>
        <?php
        // Vérifie si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            echo '<a href="catalogue.php">Catalogue</a>';
            
            // Affiche le bouton "Modifier mon profil"
            echo '<a class="profile-btn" href="profil.php">Mon profil</a>';

            // Vérifie si l'utilisateur a le rôle d'administrateur
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                // Affiche le bouton Admin avec le menu déroulant
                echo '<div class="admin-dropdown">';
                echo '<a class="admin-btn" href="#">Admin</a>';
                echo '<div class="admin-dropdown-content">';
                echo '<a href="ajt.php">Ajouter un film ou une série</a>';
                echo '<a href="suppression_serie.php">Supprimer un film ou une série</a>';
                echo '<a href="admin/users.php">Administration des Utilisateurs</a>';
                echo '</div>';
                echo '</div>';
            }

            // Affiche le lien "Déconnexion" aligné à droite
            echo '<a class="logout-link" href="logout.php">Déconnexion</a>';
        } else {
            // Si non, affiche les liens vers la page de connexion et d'inscription
            echo '<a href="register.php">Inscription</a>';
            echo '<a href="login.php">Connexion</a>';
        }
        ?>
    </nav>

    <!-- Votre contenu HTML ici -->

</body>

</html>
