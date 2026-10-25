<?php
// Ci dessous, je déclare la session ouverte
session_start();

// Les chemins vers mes "tables"
const FICHIER_VINYLES = __DIR__ . "/data/vinyles.php";
const FICHIER_UTILISATEURS = __DIR__ . "/data/utilisateurs.php";

// J'importe le fichier AltoRouter.php
require __DIR__ . "/AltoRouter.php";

$router = new AltoRouter();

$router->map('GET', '/', 'accueil');

// TODO : toutes les autres routes (voir l'énoncé)
$router->map('GET', '/catalogue', 'catalogue');
$router->map('GET', '/connexion', 'login');
$router->map('GET', '/inscription', 'register');
$router->map('GET','/panier','panier');
$router->map('GET','/admin','admin');


$router->map('GET', '/deconnexion', 'deconnexion');

// C'est ici que je vais gérer l'authentification
$router->map('POST', '/auth', 'authentification');

// C'est ici que je vais gérer l'authentification
$router->map('POST', '/register', 'register_user');

// ICi on va specifier l'id du produit qu'on veut afficher
$router->map('GET', '/vinyle/[i:id]', 'vinyle');
// Fonctions d'ajout et suppression
$router->map('POST', '/panier/ajouter', 'panier_ajouter');
$router->map('POST', '/panier/vider', 'panier_vider');
$router->map('POST', '/admin/ajouter', 'admin_ajouter');
$router->map('POST', '/panier/retirer/[i:index]', 'panier_retirer');
$router->map('POST', '/admin/supprimer/[i:id]', 'admin_supprimer');

$match = $router->match();
if ($match !== false && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    http_response_code(404);
    erreur();
}
function deconnexion() {
    session_unset();
    header('Location: /');
    return;
}
// =====================================================================
//  PAGES
// =====================================================================
// Chaque fonction ci-dessous correspond à une page de mon site
// Accueil ; catalogue ; vinyle ; panier ; admin ; connexion ; inscription ; 404
function accueil() {
    $vinyles = require_once(FICHIER_VINYLES);
    $totalStock = 0;
        foreach ($vinyles as $vinyle) {
        $totalStock += $vinyle['stock'];        
        }
    require_once(__DIR__ . "/views/accueil.php");
}
// catalogue() est la fonction qui va s'exécuter quand on va aller dans /catalogue
function catalogue() {
    // print_r($_SESSION);
    $vinyles = require_once(__DIR__."/data/vinyles.php");
    $genre = isset($_GET['genre']) ? $_GET['genre'] : "";
    $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : "";
    $resultats =[];
        foreach ($vinyles as $vinyle) {
        $okGenre = ($genre == "" || $vinyle["genre"] == $genre);
        $okRecherche = ($recherche == "" || stripos($vinyle["titre"] . " " . $vinyle["artiste"], $recherche) !== false);

        if ($okGenre && $okRecherche) {
            $resultats[] = $vinyle;
        }
    }
    $vinyles = $resultats;
    // var_dump($vinyles);  
    require_once(__DIR__ . "/views/catalogue.php");
}
// vinyle() est la fonction qui va s'exécuter quand on va aller dans /vinyle/1 ou /vinyle/2 ou /vinyle/3 etc...
function vinyle($id) {
    $vinyles = require_once(__DIR__."/data/vinyles.php");
    // 2. Chercher le vinyle dont l'id correspond
    $vinyle = null;
    foreach ($vinyles as $v) {
        if ($v["id"] == $id) {
            $vinyle = $v;
            break; // inutile de continuer une fois trouvé
        }
    }
    if ($vinyle == null) {
        http_response_code(404);
        erreur();
        return;
    }
// var_dump($vinyle);
    require_once(__DIR__ . "/views/vinyle.php");
}
function login() {
    require_once(__DIR__ . "/views/connexion.php");
}

function register() {
    require_once(__DIR__ . "/views/inscription.php");
}

function panier() {
    $vinyles = require_once(FICHIER_VINYLES);
    $panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];

    $lignes = [];
    $total = 0;

        foreach ($panier as $index => $ligne) {
            foreach ($vinyles as $vinyle) {
                if ($vinyle['id'] == $ligne['id']) {
                    $sousTotal = $vinyle['prix'] * $ligne['quantite'];
                    $lignes[] = [
                        'index' => $index,
                        'titre' => $vinyle['titre'],
                        'artiste' => $vinyle['artiste'],
                        'prix' => $vinyle['prix'],
                        'quantite' => $ligne['quantite'],
                        'sousTotal' => $sousTotal,
                    ];
                    $total += $sousTotal;
                    break;
                }
            }
        }
    $totalFinal = ($total >= 60 || count($lignes) == 0) ? $total : $total + 5;

    require_once(__DIR__ . "/views/panier.php");
}
function panier_ajouter() {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $quantite = isset($_POST['quantite']) ? (int) $_POST['quantite'] : 1;

    $vinyles = require FICHIER_VINYLES;

    // Chercher le vinyle
    $vinyle = null;
    foreach ($vinyles as $v) {
        if ($v['id'] == $id) {
            $vinyle = $v;
            break;
        }
    }

    // Vinyle inconnu ou quantité invalide
    if ($vinyle == null || $quantite < 1) {
        header('Location: /panier');
        return;
    }

    // Quantité déjà dans le panier pour ce vinyle
    $dejaDansPanier = 0;
    if (isset($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $ligne) {
            if ($ligne['id'] == $id) {
                $dejaDansPanier += $ligne['quantite'];
            }
        }
    }

    // Refus si on dépasse le stock
    if ($dejaDansPanier + $quantite > $vinyle['stock']) {
        header('Location: /vinyle/' . $id . '?erreur=stock');
        return;
    }

    $_SESSION['panier'][] = ['id' => $id, 'quantite' => $quantite];
    header('Location: /panier');
    return;
}

function panier_retirer($index) {
    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        // Réindexer pour garder des index 0, 1, 2...
        $_SESSION['panier'] = array_values($_SESSION['panier']);
    }
    header('Location: /panier');
    return;
}

function panier_vider() {
    unset($_SESSION['panier']);
    header('Location: /panier');
    return;
}
// Mission 9 et 10 pour le role Admin
function admin() {
    if (!isset($_SESSION['is_authenticated']) || $_SESSION['user_role'] != 'admin') {
        header('Location: /connexion');
        return;
    }

    $vinyles = require_once(FICHIER_VINYLES);
    $users = require_once(FICHIER_UTILISATEURS);

    require_once(__DIR__ . "/views/admin.php");
}

function admin_ajouter() {
    if (!isset($_SESSION['is_authenticated']) || $_SESSION['user_role'] != 'admin') {
        header('Location: /connexion');
        return;
    }

    $titre = isset($_POST['titre']) ? trim($_POST['titre']) : "";
    $artiste = isset($_POST['artiste']) ? trim($_POST['artiste']) : "";
    $annee = isset($_POST['annee']) ? (int) $_POST['annee'] : 0;
    $genre = isset($_POST['genre']) ? $_POST['genre'] : "";
    $prix = isset($_POST['prix']) ? (float) $_POST['prix'] : 0;
    $stock = isset($_POST['stock']) ? (int) $_POST['stock'] : 0;
    $couleur = isset($_POST['couleur']) ? $_POST['couleur'] : "#1f1a14";
    $description = isset($_POST['description']) ? trim($_POST['description']) : "";

    if ($titre == "" || $artiste == "" || $prix <= 0) {
        header('Location: /admin?erreur=1');
        return;
    }

    $vinyles = require FICHIER_VINYLES;

    // Plus grand id existant + 1 (évite les doublons après une suppression)
    $maxId = 0;
    foreach ($vinyles as $v) {
        if ($v['id'] > $maxId) {
            $maxId = $v['id'];
        }
    }

    $vinyles[] = [
        'id' => $maxId + 1,
        'titre' => $titre,
        'artiste' => $artiste,
        'annee' => $annee,
        'genre' => $genre,
        'prix' => $prix,
        'stock' => $stock,
        'couleur' => $couleur,
        'description' => $description,
    ];

    ecrireTable(FICHIER_VINYLES, $vinyles);
    header('Location: /admin?ajout=1');
    return;
}
function admin_supprimer($id) {
    if (!isset($_SESSION['is_authenticated']) || $_SESSION['user_role'] != 'admin') {
        header('Location: /connexion');
        return;
    }

    $vinyles = require FICHIER_VINYLES;

    // On reconstruit le tableau sans le vinyle à supprimer
    $restants = [];
    foreach ($vinyles as $vinyle) {
        if ($vinyle['id'] != $id) {
            $restants[] = $vinyle;
        }
    }

    ecrireTable(FICHIER_VINYLES, $restants);
    header('Location: /admin');
    return;
}
// Fonction erreur 404
function erreur() {
    require_once(__DIR__ . "/views/404.php");
}

// TODO : les autres fonctions (une par route)

// =====================================================================
//  AUTHENTIFICATION / INSCRIPTION
// =====================================================================
function authentification() {
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $users = require FICHIER_UTILISATEURS;

    foreach ($users as $user) {
        if (strtolower($user['email']) == strtolower($email)
            && password_verify($password, $user['mot_de_passe'])) {

            session_regenerate_id(true);
            $_SESSION['is_authenticated'] = true;
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header('Location: /admin');
            } else {
                header('Location: /catalogue');
            }
            return;
        }
    }
        header('Location: /connexion?erreur=1');
    return;
}

// C'est la fonction qui va s'exécuter lorsque une requete POST sera faite sur la route /register
function register_user() {
    $nom = isset($_POST['name']) ? trim($_POST['name']) : "";
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $confirmation = isset($_POST['confirmation']) ? $_POST['confirmation'] : "";

    // 1. Champs vides
    if ($nom == "" || $email == "" || $password == "") {
        header('Location: /inscription?erreur=champs');
        return;
    }
    // 2. Mot de passe trop court
    if (strlen($password) < 8) {
        header('Location: /inscription?erreur=mdp');
        return;
    }
    // 3. Confirmation différente
    if ($password != $confirmation) {
        header('Location: /inscription?erreur=confirmation');
        return;
    }
    // 4. E-mail déjà utilisé
    $users = require __DIR__ . "/data/utilisateurs.php";
    foreach ($users as $user) {
        if (strtolower($user['email']) == strtolower($email)) {
            header('Location: /inscription?erreur=email');
            return;
        }
    }
    // 5. Tout est bon : on ajoute l'utilisateur
    $maxId = 0;
    foreach ($users as $user) {
        if ($user['id'] > $maxId) {
            $maxId = $user['id'];
        }
    }
    $users[] = [
        'id' => $maxId + 1,
        'nom' => $nom,
        'email' => $email,
        'mot_de_passe' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'user',
        'date_inscription' => date('Y-m-d H:i:s'),
    ];

    ecrireTable(FICHIER_UTILISATEURS, $users);
    header('Location: /connexion?inscrit=1');
    return;
}

// C'est ma fonction qui check si les acces d'un utilisateurs existent bien en bdd
// @params $client : ce que le client a posté
// @params $bdd : Le tableau avec tous les utilisateurs en bdd
// function isAuthable($client, $bdd) {
//     for ($i = 0; $i < count($bdd); $i++) {
//         // Ci dessous, je check si l'email renseigné par le client est egal a l'une des adresses mails dans la base de données 'utilisateurs.php'
//         if ($client["email"] == $bdd[$i]["email"] && $client["password"] == $bdd[$i]["mot_de_passe"]) {
//             echo "Les adresse emails ont bien matchés";
//             return true;
//         }
//     }
//     return false;
// }

// =====================================================================
//  OUTILS (fourni)
// =====================================================================

// Réécrit entièrement un fichier de data/ avec le tableau $lignes
// Exemple : ecrireTable(FICHIER_UTILISATEURS, $users);
function ecrireTable(string $fichier, array $lignes): void
{
    $contenu = "<?php\n\nreturn " . var_export(array_values($lignes), true) . ";\n";
    file_put_contents($fichier, $contenu, LOCK_EX);

    // PHP garde les fichiers en cache (OPcache) : on lui dit que celui-ci a changé,
    // sinon le prochain require_once pourrait relire l'ANCIENNE version pendant 2 secondes.
    if (function_exists('opcache_invalidate')) {
        opcache_invalidate($fichier, true);
    }
}