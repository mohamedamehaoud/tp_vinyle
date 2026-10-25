<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogue — Le Bac à Vinyles</title>
    <style>
        :root { --encre: #1f1a14; --encre-douce: #6f655a; --papier: #f4eee3; --carton: #e9dfcf; --blanc: #fffdf8; --accent: #e4572e; --accent-fonce: #b83d1a; --vert: #2f7d4f; --ambre: #c98a12; --rouge: #b42318; --ligne: #dccfbb; --rayon: 14px; --titre: "Georgia", "Times New Roman", serif; --texte: "Segoe UI", system-ui, -apple-system, Roboto, Arial, sans-serif; }
        * { box-sizing: border-box; }
        body { display: flex; flex-direction: column; min-height: 100vh; margin: 0; background: var(--papier); color: var(--encre); font-family: var(--texte); line-height: 1.5; }
        a { color: inherit; }
        img { max-width: 100%; }
        h1, h2, h3 { font-family: var(--titre); font-weight: 700; line-height: 1.1; letter-spacing: -0.01em; }
        h1 { margin: 0 0 12px; font-size: clamp(34px, 5vw, 52px); }
        h2 { margin: 48px 0 18px; font-size: 28px; }
        h3 { margin: 0 0 6px; font-size: 18px; }
        .cache { display: none !important; }
        .bandeau { padding: 8px 16px; background: var(--encre); color: var(--carton); text-align: center; font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase; }
        .entete { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; width: min(1200px, 100% - 32px); margin: 0 auto; padding: 20px 0; border-bottom: 2px solid var(--encre); }
        .logo { font-family: var(--titre); font-size: 26px; font-weight: 700; text-decoration: none; }
        .logo span { margin: 0 4px; color: var(--accent); font-style: italic; }
        .logo--petit { font-size: 18px; }
        .nav { display: flex; flex-wrap: wrap; align-items: center; gap: 18px; font-size: 14px; font-weight: 600; }
        .nav a { text-decoration: none; }
        .nav a:hover { color: var(--accent); }
        .nav-cta { padding: 8px 14px; border-radius: 99px; background: var(--encre); color: var(--blanc); }
        .nav-cta:hover { background: var(--accent); color: var(--blanc) !important; }
        .pastille { display: inline-block; min-width: 22px; padding: 1px 7px; border-radius: 99px; background: var(--accent); color: var(--blanc); font-size: 12px; text-align: center; }
        .form-inline { display: inline; margin: 0; }
        .lien-bouton { padding: 0; border: none; background: none; color: inherit; font: inherit; font-weight: 600; text-decoration: underline; cursor: pointer; }
        .lien-bouton:hover { color: var(--accent); }
        .lien-bouton--danger { color: var(--rouge); }
        .contenu { flex: 1; width: min(1200px, 100% - 32px); margin: 0 auto; padding: 40px 0 64px; }
        .pied { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; width: min(1200px, 100% - 32px); margin: 0 auto; padding: 24px 0; border-top: 2px solid var(--encre); color: var(--encre-douce); font-size: 13px; }
        .surtitre { margin: 0 0 8px; color: var(--accent-fonce); font-size: 12px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; }
        .titre-page { margin-bottom: 28px; }
        .titre-page--ligne { display: flex; flex-wrap: wrap; align-items: end; justify-content: space-between; gap: 16px; }
        .titre-section { display: flex; align-items: baseline; justify-content: space-between; gap: 16px; }
        .titre-section a { font-weight: 600; }
        .bouton { display: inline-block; padding: 13px 22px; border: 2px solid var(--encre); border-radius: 99px; background: var(--encre); color: var(--blanc); font: inherit; font-weight: 700; text-decoration: none; cursor: pointer; transition: background 0.15s, border-color 0.15s; }
        .bouton:hover { border-color: var(--accent); background: var(--accent); }
        .bouton:disabled { opacity: 0.6; cursor: wait; }
        .bouton--plein { width: 100%; text-align: center; }
        .lien-retour, .lien-discret { display: inline-block; margin-bottom: 20px; color: var(--encre-douce); font-weight: 600; }
        .flash { width: min(1200px, 100% - 32px); margin: 20px auto 0; padding: 14px 18px; border-radius: var(--rayon); font-weight: 600; }
        .flash--succes { background: #dcefdf; color: #1d5233; }
        .flash--erreur { background: #f8dcd6; color: #8a2412; }
        .contenu .flash, .carte-form .flash, .panneau .flash { width: auto; margin: 0 0 16px; }
        .info { color: var(--encre-douce); font-size: 14px; }
        .vide { padding: 32px; border: 2px dashed var(--ligne); border-radius: var(--rayon); text-align: center; color: var(--encre-douce); }
        .hero { display: grid; grid-template-columns: 1.3fr 1fr; align-items: center; gap: 40px; padding: 24px 0 40px; }
        .hero h1 { font-size: clamp(40px, 6vw, 68px); }
        .hero h1 em { color: var(--accent); }
        .hero-texte { max-width: 520px; margin: 0 0 28px; color: var(--encre-douce); font-size: 18px; }
        .platine { display: grid; place-items: center; width: 100%; aspect-ratio: 1; max-width: 380px; margin-left: auto; border-radius: 24px; background: var(--carton); box-shadow: inset 0 0 0 2px var(--ligne); }
        .disque { width: 82%; aspect-ratio: 1; border-radius: 50%; background: radial-gradient(circle, var(--accent) 0 15%, var(--encre) 15.5% 17%, transparent 17.5%), repeating-radial-gradient(circle, #1a1612 0 2px, #2a241d 2px 4px); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25); animation: tourne 6s linear infinite; }
        @keyframes tourne { to { transform: rotate(360deg); } }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin: 8px 0 16px; }
        .stat { padding: 20px; border: 2px solid var(--encre); border-radius: var(--rayon); background: var(--blanc); }
        .stat strong { display: block; font-family: var(--titre); font-size: 32px; }
        .stat span { color: var(--encre-douce); font-size: 13px; }
        .grille { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 22px; }
        .carte { overflow: hidden; border: 2px solid var(--encre); border-radius: var(--rayon); background: var(--blanc); transition: transform 0.15s; }
        .carte:hover { transform: translateY(-4px); }
        .pochette { position: relative; display: flex; align-items: flex-end; aspect-ratio: 1; padding: 14px; overflow: hidden; background: var(--couleur, var(--encre)); color: #fff; text-decoration: none; }
        .pochette::after { content: ""; position: absolute; top: 12%; right: -38%; width: 76%; aspect-ratio: 1; border-radius: 50%; background: radial-gradient(circle, var(--papier) 0 3%, var(--accent) 3.5% 16%, transparent 16.5%), repeating-radial-gradient(circle, #1a1612 0 2px, #2a241d 2px 4px); transition: right 0.3s; }
        .carte:hover .pochette::after { right: -28%; }
        .pochette-titre { position: relative; z-index: 1; max-width: 70%; font-family: var(--titre); font-size: 20px; font-weight: 700; line-height: 1.1; text-shadow: 0 1px 6px rgba(0, 0, 0, 0.35); }
        .pochette--grande { border: 2px solid var(--encre); border-radius: var(--rayon); padding: 28px; }
        .pochette--grande .pochette-titre { font-size: 36px; }
        .carte-infos { padding: 14px 16px 16px; }
        .carte-haut, .carte-bas { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .carte h3 a { text-decoration: none; }
        .genre { color: var(--encre-douce); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }
        .artiste { margin: 0 0 12px; color: var(--encre-douce); font-size: 14px; }
        .prix { font-size: 17px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 12px; font-weight: 700; white-space: nowrap; }
        .badge--ok { background: #dcefdf; color: var(--vert); }
        .badge--bientot { background: #f8ebc9; color: #8a5d05; }
        .badge--epuise { background: #f8dcd6; color: var(--rouge); }
        .panneau { padding: 24px; border: 2px solid var(--encre); border-radius: var(--rayon); background: var(--blanc); }
        .panneau p { color: var(--encre-douce); }
        .mini-carte { display: grid; grid-template-columns: 56px 1fr auto; align-items: center; gap: 14px; padding: 12px; border-radius: var(--rayon); background: var(--carton); text-decoration: none; }
        .mini-pochette { width: 56px; height: 56px; border-radius: 8px; }
        .filtres { display: flex; flex-wrap: wrap; align-items: end; gap: 14px; padding: 20px; border: 2px solid var(--encre); border-radius: var(--rayon); background: var(--blanc); }
        .filtres label { display: flex; flex-direction: column; gap: 6px; font-size: 13px; font-weight: 700; }
        .filtres .lien-discret { margin: 0 0 12px; }
        input, select, textarea { padding: 10px 12px; border: 2px solid var(--ligne); border-radius: 10px; background: var(--blanc); color: var(--encre); font: inherit; font-weight: 400; }
        input:focus, select:focus, textarea:focus { border-color: var(--encre); outline: none; }
        input[type="color"] { height: 46px; padding: 4px; }
        .resultats { margin: 20px 0 10px; font-weight: 600; }
        .fiche { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start; }
        .fiche-artiste { margin: 0 0 16px; color: var(--encre-douce); font-size: 22px; }
        .fiche-prix { margin: 0 0 10px; font-family: var(--titre); font-size: 34px; font-weight: 700; }
        .fiche-description { margin: 24px 0; font-size: 17px; }
        .ajout-panier { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; }
        .quantite { display: flex; align-items: center; border: 2px solid var(--encre); border-radius: 99px; overflow: hidden; }
        .quantite button { width: 44px; height: 44px; border: none; background: var(--blanc); font-size: 20px; cursor: pointer; }
        .quantite button:hover { background: var(--carton); }
        .quantite input { width: 56px; border: none; border-radius: 0; text-align: center; }
        .total-live { flex-basis: 100%; margin: 0; color: var(--encre-douce); }
        .panier { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }
        .tableau { overflow-x: auto; border: 2px solid var(--encre); border-radius: var(--rayon); background: var(--blanc); }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 12px 16px; border-bottom: 1px solid var(--ligne); text-align: left; vertical-align: middle; }
        th { color: var(--encre-douce); font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; }
        tr:last-child td { border-bottom: none; }
        small { color: var(--encre-douce); }
        .ligne-epuisee { background: #fbf0ec; }
        .recap { display: flex; flex-direction: column; gap: 12px; padding: 22px; border: 2px solid var(--encre); border-radius: var(--rayon); background: var(--blanc); }
        .recap form { margin: 0; }
        .recap-ligne { display: flex; justify-content: space-between; gap: 12px; padding: 8px 0; border-bottom: 1px solid var(--ligne); }
        .recap-total { border-bottom: none; font-size: 20px; font-weight: 800; }
        .carte-form { max-width: 480px; margin: 0 auto; padding: 32px; border: 2px solid var(--encre); border-radius: var(--rayon); background: var(--blanc); }
        .carte-form--large { max-width: 760px; margin: 0; }
        .carte-form form { display: flex; flex-direction: column; gap: 16px; }
        .carte-form label { display: flex; flex-direction: column; gap: 6px; font-size: 14px; font-weight: 700; }
        .form-grille { display: grid !important; grid-template-columns: 1fr 1fr; }
        .pleine-largeur { grid-column: 1 / -1; }
        .page-404 { display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 40px 0; text-align: center; }
        .page-404 h1 { font-size: 96px; margin: 0; }
        @media (max-width: 800px) { .hero, .fiche, .panier, .fouille-grille, .form-grille { grid-template-columns: 1fr; } .platine { display: none; } .stats { grid-template-columns: repeat(2, 1fr); } }
        .carte { display: block; color: inherit; text-decoration: none; }
        .bonjour { color: var(--encre-douce); }
        .pied-liens { display: flex; gap: 18px; }
        .barre-resultats { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin: 20px 0; }
        .barre-resultats .resultats { margin: 0; }
        .hasard { display: grid; grid-template-columns: 1fr 1fr; align-items: center; gap: 24px; margin-top: 48px; }
        .hasard h2 { margin-top: 0; }
        .mdp { position: relative; display: block; }
        .mdp input { width: 100%; padding-right: 90px; }
        .mdp-toggle { position: absolute; top: 50%; right: 10px; transform: translateY(-50%); border: 0; background: none; color: var(--encre-douce); font: inherit; font-size: 13px; font-weight: 700; cursor: pointer; }
        .quantite span { min-width: 44px; text-align: center; font-weight: 700; }
        #btn-description { display: block; margin-top: 20px; }
        .form-grille { gap: 16px; }
        .carte-form textarea { resize: vertical; }
        .page-404 .disque { width: 180px; animation-duration: 1.5s; }
        @media (max-width: 800px) { .hasard { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <?php require __DIR__ . '/navbar.php'; ?>
    <main class="contenu">
        <div class="titre-page">
            <p class="surtitre">Tout le bac</p>
            <h1>Catalogue</h1>
        </div>

        <!-- Filtres : formulaire en GET, les choix apparaissent dans l'URL -->
        <form class="filtres" action="/catalogue" method="get">
            <label>Recherche
                <input type="text" name="recherche" value="<?= htmlspecialchars($recherche) ?>" placeholder="Titre ou artiste">
            </label>
            <label>Genre
                <select name="genre">
                    <option value="">Tous les genres</option>
                    <option value="rock" <?= $genre == 'rock' ? 'selected' : '' ?>>Rock</option>
                    <option value="jazz" <?= $genre == 'jazz' ? 'selected' : '' ?>>Jazz</option>
                    <option value="soul" <?= $genre == 'soul' ? 'selected' : '' ?>>Soul</option>
                    <option value="hip-hop" <?= $genre == 'hip-hop' ? 'selected' : '' ?>>Hip-hop</option>
                    <option value="electro" <?= $genre == 'electro' ? 'selected' : '' ?>>Électro</option>
                </select>
            </label>
            <button type="submit" class="bouton">Filtrer</button>
            <a href="/catalogue" class="lien-discret">Réinitialiser</a>
        </form>

        <div class="barre-resultats">
            <p class="resultats"><?= count($resultats) ?> vinyle(s) trouvé(s)</p>
            <!-- Tri : fait en JavaScript, sans recharger la page -->
            <select id="tri">
                <option value="defaut">Trier : par défaut</option>
                <option value="prix-asc">Prix croissant</option>
                <option value="prix-desc">Prix décroissant</option>
            </select>
        </div>

        <?php if (count($resultats) == 0) : ?>
            <p class="vide">Aucun vinyle ne correspond à ta recherche.</p>
        <?php else : ?>
            <div class="grille">
                <?php foreach ($resultats as $vinyle) : ?>
                    <a class="carte" href="/vinyle/<?= $vinyle["id"] ?>" data-prix="<?= $vinyle["prix"] ?>">
                        <div class="pochette" style="--couleur: <?= htmlspecialchars($vinyle["couleur"]) ?>">
                            <span class="pochette-titre"><?= htmlspecialchars($vinyle["titre"]) ?></span>
                        </div>
                        <div class="carte-infos">
                            <span class="genre"><?= htmlspecialchars($vinyle["genre"]) ?> · <?= $vinyle["annee"] ?></span>
                            <h3><?= htmlspecialchars($vinyle["titre"]) ?></h3>
                            <p class="artiste"><?= htmlspecialchars($vinyle["artiste"]) ?></p>
                            <div class="carte-bas">
                                <strong class="prix"><?= $vinyle["prix"] ?> €</strong>
                                <?php if ($vinyle["stock"] > 2) : ?>
                                    <span class="badge badge--ok">En stock</span>
                                <?php elseif ($vinyle["stock"] == 1 || $vinyle["stock"] == 2) : ?>
                                    <span class="badge badge--bientot">Plus que <?= $vinyle["stock"] ?> !</span>
                                <?php else : ?>
                                    <span class="badge badge--epuise">Épuisé</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    <?php require __DIR__ . '/footer.php'; ?>
</body>
</html>