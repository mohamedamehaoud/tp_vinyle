
<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$isHomePage = $currentPath === '/';
$estConnecte = isset($_SESSION['is_authenticated']);
?>

<div class="bandeau">Livraison offerte dès 60 € d'achat · Disques neufs et rééditions</div>
<header class="entete">
    <a class="logo" href="/">Le Bac<span>à</span>Vinyles</a>
    <nav class="nav">
        <a href="/" class="<?= $isHomePage ? 'active' : '' ?>">Accueil</a>
        <a href="/catalogue" class="<?= $currentPath === '/catalogue' ? 'active' : '' ?>">Catalogue</a>
        <a href="/panier" class="<?= $currentPath === '/panier' ? 'active' : '' ?>">Panier <span class="pastille"><?= isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0 ?></span></a>

        <?php if ($estConnecte) : ?>
            <?php if ($_SESSION['user_role'] == 'admin') : ?>
                <a href="/admin" class="<?= $currentPath === '/admin' ? 'active' : '' ?>">Admin</a>
            <?php endif; ?>
            <span class="bonjour">Bonjour <?= htmlspecialchars($_SESSION['user_nom']) ?></span>
            <a href="/deconnexion">Déconnexion</a>
        <?php else : ?>
            <a href="/connexion" class="<?= $currentPath === '/connexion' ? 'active' : '' ?>">Connexion</a>
            <a class="nav-cta <?= $currentPath === '/inscription' ? 'active' : '' ?>" href="/inscription">Créer un compte</a>
        <?php endif; ?>
    </nav>
</header>