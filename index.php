<<<<<<< HEAD
<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }

$user_id = $_SESSION['user_id'];

function getYouTubeId($url) {
    preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return isset($match[1]) ? $match[1] : false;
}

if (isset($_POST['ajouter'])) {
    $stmt = $pdo->prepare("INSERT INTO liens (id_utilisateur, titre, url, categorie) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $_POST['titre'], $_POST['url'], $_POST['categorie']]);
    header('Location: index.php');
    exit();
}

if (isset($_GET['suppr'])) {
    $stmt = $pdo->prepare("DELETE FROM liens WHERE id = ? AND id_utilisateur = ?");
    $stmt->execute([$_GET['suppr'], $user_id]);
    header('Location: index.php');
    exit();
}

$stmt = $pdo->prepare("SELECT categorie, id, titre, url FROM liens WHERE id_utilisateur = ? ORDER BY categorie ASC");
$stmt->execute([$user_id]);
$liens_groupes = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

$total_liens = 0;
foreach($liens_groupes as $cat) {
    $total_liens += count($cat);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pro - <?php echo htmlspecialchars($_SESSION['nom']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #121212 0%, #1c1c2b 100%);
            min-height: 100vh;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        .header-dashboard {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 40px;
        }
        .welcome-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 4px; color: rgba(255, 255, 255, 0.4); }
        .user-name-pro { font-size: 2.2rem; font-weight: 700; margin: 0; }
        .user-name-pro span { color: #00f2fe; text-shadow: 0 0 25px rgba(0, 242, 254, 0.4); }

        .progress-container {
            height: 6px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: flex;
            overflow: hidden;
            margin-top: 12px;
            width: 250px;
        }
        .progress-segment { height: 100%; transition: width 0.5s ease; }
        .bg-videos { background: #ff4757; }
        .bg-travail { background: #00f2fe; }
        .bg-loisirs { background: #a29bfe; }
        .bg-general { background: #55efc4; }

        .btn-logout {
            background: rgba(255, 118, 117, 0.1);
            border: 1px solid rgba(255, 118, 117, 0.3);
            color: #ff7675;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .btn-logout:hover { background: #ff7675; color: white; transform: translateY(-2px); }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 30px;
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px;
            border-radius: 12px;
        }
        .form-control:focus, .form-select:focus { background: rgba(255, 255, 255, 0.08); color: white; border-color: #00f2fe; box-shadow: none; }
        .form-select option { background: #1c1c2b; color: white; }
        .form-control::placeholder { color: rgba(0, 242, 254, 0.4) !important; font-style: italic; font-size: 0.9rem; }

        .category-header {
            color: #00f2fe;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 25px 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .category-header::after { content: ""; flex: 1; height: 1px; background: rgba(0, 242, 254, 0.2); }

        .link-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 14px 20px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }
        .link-card:hover { background: rgba(255, 255, 255, 0.06); transform: translateX(5px); border-color: rgba(0, 242, 254, 0.3); }
        .link-info a { color: #e0e0e0; text-decoration: none; font-weight: 500; }
        .link-info a:hover { color: #00f2fe; }
        .btn-delete { color: rgba(255, 255, 255, 0.2); font-size: 1.1rem; transition: 0.3s; cursor: pointer; border:none; background:none; }
        .btn-delete:hover { color: #ff7675; transform: scale(1.2); }
        .img-thumb { object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<div class="container">
    <header class="header-dashboard">
        <div class="welcome-section">
            <span class="welcome-label">Tableau de bord</span>
            <h1 class="user-name-pro">Bienvenue, <span><?php echo htmlspecialchars($_SESSION['nom']); ?></span></h1>
            
            <?php if($total_liens > 0): ?>
            <div class="progress-container shadow-sm">
                <?php foreach($liens_groupes as $nom_cat => $liens_cat): 
                    $pourcent = (count($liens_cat) / $total_liens) * 100;
                    $couleur = 'bg-general';
                    if($nom_cat == 'Vidéos') $couleur = 'bg-videos';
                    if($nom_cat == 'Travail') $couleur = 'bg-travail';
                    if($nom_cat == 'Loisirs') $couleur = 'bg-loisirs';
                ?>
                    <div class="progress-segment <?php echo $couleur; ?>" 
                         style="width: <?php echo $pourcent; ?>%" 
                         title="<?php echo $nom_cat; ?>: <?php echo count($liens_cat); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <small class="opacity-50" style="font-size: 0.65rem;"><?php echo $total_liens; ?> liens enregistrés</small>
            <?php endif; ?>
        </div>

        <a href="logout.php" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Quitter</span>
        </a>
    </header>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="glass-panel shadow">
                <h5 class="mb-4 fw-bold"><i class="bi bi-plus-circle me-2"></i>Nouveau lien</h5>
                <form method="POST">
                    <input type="text" name="titre" class="form-control mb-3" placeholder="Nom du site / Vidéo" required>
                    <input type="url" name="url" class="form-control mb-3" placeholder="Lien (https://...)" required>
                    
                    <label class="small opacity-50 mb-2">Catégorie</label>
                    <select name="categorie" class="form-select mb-4">
                        <option value="Général">Général</option>
                        <option value="Vidéos">Vidéos</option>
                        <option value="Travail">Travail</option>
                        <option value="Loisirs">Loisirs</option>
                        <option value="Réseaux Sociaux">Réseaux Sociaux</option>
                    </select>

                    <button type="submit" name="ajouter" class="btn btn-info w-100 fw-bold py-3 shadow-sm text-white" style="background: #00f2fe; border:none; border-radius:12px;">
                        Ajouter
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-panel shadow">
                <h5 class="mb-2 fw-bold"><i class="bi bi-collection me-2"></i>Ma Collection</h5>
                
                <?php if (empty($liens_groupes)): ?>
                    <p class="text-center opacity-50 my-5">Aucun lien enregistré.</p>
                <?php else: ?>
                    <?php foreach ($liens_groupes as $nom_categorie => $liens): ?>
                        <div class="category-header">
                            <i class="bi <?php echo ($nom_categorie == 'Vidéos') ? 'bi-play-circle' : 'bi-folder2-open'; ?>"></i> 
                            <?php echo htmlspecialchars($nom_categorie); ?>
                        </div>

                        <?php foreach ($liens as $l): 
                            $ytId = getYouTubeId($l['url']);
                            $domaine = parse_url($l['url'], PHP_URL_HOST);
                            if ($ytId) {
                                $imgSrc = "https://img.youtube.com/vi/$ytId/mqdefault.jpg";
                                $imgStyle = "width: 70px; height: 40px;";
                            } else {
                                $imgSrc = "https://www.google.com/s2/favicons?sz=64&domain=$domaine";
                                $imgStyle = "width: 26px; height: 26px;";
                            }
                        ?>
                            <div class="link-card">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $imgSrc; ?>" class="me-3 img-thumb" style="<?php echo $imgStyle; ?>">
                                    <div class="link-info">
                                        <a href="<?php echo $l['url']; ?>" target="_blank">
                                            <?php echo htmlspecialchars($l['titre']); ?>
                                        </a>
                                    </div>
                                </div>
                                <a href="index.php?suppr=<?php echo $l['id']; ?>" class="btn-delete" onclick="return confirm('Supprimer ce lien ?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
=======
<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }

$user_id = $_SESSION['user_id'];

// --- FONCTION POUR EXTRAIRE L'ID YOUTUBE ---
function getYouTubeId($url) {
    preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return isset($match[1]) ? $match[1] : false;
}

// --- LOGIQUE D'AJOUT ---
if (isset($_POST['ajouter'])) {
    $stmt = $pdo->prepare("INSERT INTO liens (id_utilisateur, titre, url, categorie) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $_POST['titre'], $_POST['url'], $_POST['categorie']]);
    header('Location: index.php');
    exit();
}

// --- LOGIQUE DE SUPPRESSION ---
if (isset($_GET['suppr'])) {
    $stmt = $pdo->prepare("DELETE FROM liens WHERE id = ? AND id_utilisateur = ?");
    $stmt->execute([$_GET['suppr'], $user_id]);
    header('Location: index.php');
    exit();
}

// --- RÉCUPÉRATION GROUPÉE PAR CATÉGORIE ---
$stmt = $pdo->prepare("SELECT categorie, id, titre, url FROM liens WHERE id_utilisateur = ? ORDER BY categorie ASC");
$stmt->execute([$user_id]);
$liens_groupes = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

// --- CALCUL POUR LA BARRE DE PROGRESSION ---
$total_liens = 0;
foreach($liens_groupes as $cat) {
    $total_liens += count($cat);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pro - <?php echo htmlspecialchars($_SESSION['nom']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #121212 0%, #1c1c2b 100%);
            min-height: 100vh;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        /* HEADER */
        .header-dashboard {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 40px;
        }
        .welcome-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 4px; color: rgba(255, 255, 255, 0.4); }
        .user-name-pro { font-size: 2.2rem; font-weight: 700; margin: 0; }
        .user-name-pro span { color: #00f2fe; text-shadow: 0 0 25px rgba(0, 242, 254, 0.4); }

        /* BARRE DE PROGRESSION */
        .progress-container {
            height: 6px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: flex;
            overflow: hidden;
            margin-top: 12px;
            width: 250px;
        }
        .progress-segment { height: 100%; transition: width 0.5s ease; }
        .bg-videos { background: #ff4757; }
        .bg-travail { background: #00f2fe; }
        .bg-loisirs { background: #a29bfe; }
        .bg-general { background: #55efc4; }

        /* BOUTON DECONNEXION */
        .btn-logout {
            background: rgba(255, 118, 117, 0.1);
            border: 1px solid rgba(255, 118, 117, 0.3);
            color: #ff7675;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .btn-logout:hover { background: #ff7675; color: white; transform: translateY(-2px); }

        /* PANNEAUX GLASS */
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 30px;
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px;
            border-radius: 12px;
        }
        .form-control:focus, .form-select:focus { background: rgba(255, 255, 255, 0.08); color: white; border-color: #00f2fe; box-shadow: none; }
        .form-select option { background: #1c1c2b; color: white; }
        .form-control::placeholder { color: rgba(0, 242, 254, 0.4) !important; font-style: italic; font-size: 0.9rem; }

        /* CATEGORIES ET CARTES */
        .category-header {
            color: #00f2fe;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 25px 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .category-header::after { content: ""; flex: 1; height: 1px; background: rgba(0, 242, 254, 0.2); }

        .link-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 14px 20px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }
        .link-card:hover { background: rgba(255, 255, 255, 0.06); transform: translateX(5px); border-color: rgba(0, 242, 254, 0.3); }
        .link-info a { color: #e0e0e0; text-decoration: none; font-weight: 500; }
        .link-info a:hover { color: #00f2fe; }
        .btn-delete { color: rgba(255, 255, 255, 0.2); font-size: 1.1rem; transition: 0.3s; cursor: pointer; border:none; background:none; }
        .btn-delete:hover { color: #ff7675; transform: scale(1.2); }
        .img-thumb { object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<div class="container">
    <header class="header-dashboard">
        <div class="welcome-section">
            <span class="welcome-label">Tableau de bord</span>
            <h1 class="user-name-pro">Bienvenue, <span><?php echo htmlspecialchars($_SESSION['nom']); ?></span></h1>
            
            <?php if($total_liens > 0): ?>
            <div class="progress-container shadow-sm">
                <?php foreach($liens_groupes as $nom_cat => $liens_cat): 
                    $pourcent = (count($liens_cat) / $total_liens) * 100;
                    $couleur = 'bg-general';
                    if($nom_cat == 'Vidéos') $couleur = 'bg-videos';
                    if($nom_cat == 'Travail') $couleur = 'bg-travail';
                    if($nom_cat == 'Loisirs') $couleur = 'bg-loisirs';
                ?>
                    <div class="progress-segment <?php echo $couleur; ?>" 
                         style="width: <?php echo $pourcent; ?>%" 
                         title="<?php echo $nom_cat; ?>: <?php echo count($liens_cat); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <small class="opacity-50" style="font-size: 0.65rem;"><?php echo $total_liens; ?> liens enregistrés</small>
            <?php endif; ?>
        </div>

        <a href="logout.php" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Quitter</span>
        </a>
    </header>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="glass-panel shadow">
                <h5 class="mb-4 fw-bold"><i class="bi bi-plus-circle me-2"></i>Nouveau lien</h5>
                <form method="POST">
                    <input type="text" name="titre" class="form-control mb-3" placeholder="Nom du site / Vidéo" required>
                    <input type="url" name="url" class="form-control mb-3" placeholder="Lien (https://...)" required>
                    
                    <label class="small opacity-50 mb-2">Catégorie</label>
                    <select name="categorie" class="form-select mb-4">
                        <option value="Général">Général</option>
                        <option value="Vidéos">Vidéos</option>
                        <option value="Travail">Travail</option>
                        <option value="Loisirs">Loisirs</option>
                        <option value="Réseaux Sociaux">Réseaux Sociaux</option>
                    </select>

                    <button type="submit" name="ajouter" class="btn btn-info w-100 fw-bold py-3 shadow-sm text-white" style="background: #00f2fe; border:none; border-radius:12px;">
                        Ajouter
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="glass-panel shadow">
                <h5 class="mb-2 fw-bold"><i class="bi bi-collection me-2"></i>Ma Collection</h5>
                
                <?php if (empty($liens_groupes)): ?>
                    <p class="text-center opacity-50 my-5">Aucun lien enregistré.</p>
                <?php else: ?>
                    <?php foreach ($liens_groupes as $nom_categorie => $liens): ?>
                        <div class="category-header">
                            <i class="bi <?php echo ($nom_categorie == 'Vidéos') ? 'bi-play-circle' : 'bi-folder2-open'; ?>"></i> 
                            <?php echo htmlspecialchars($nom_categorie); ?>
                        </div>

                        <?php foreach ($liens as $l): 
                            $ytId = getYouTubeId($l['url']);
                            $domaine = parse_url($l['url'], PHP_URL_HOST);
                            if ($ytId) {
                                $imgSrc = "https://img.youtube.com/vi/$ytId/mqdefault.jpg";
                                $imgStyle = "width: 70px; height: 40px;";
                            } else {
                                $imgSrc = "https://www.google.com/s2/favicons?sz=64&domain=$domaine";
                                $imgStyle = "width: 26px; height: 26px;";
                            }
                        ?>
                            <div class="link-card">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $imgSrc; ?>" class="me-3 img-thumb" style="<?php echo $imgStyle; ?>">
                                    <div class="link-info">
                                        <a href="<?php echo $l['url']; ?>" target="_blank">
                                            <?php echo htmlspecialchars($l['titre']); ?>
                                        </a>
                                    </div>
                                </div>
                                <a href="index.php?suppr=<?php echo $l['id']; ?>" class="btn-delete" onclick="return confirm('Supprimer ce lien ?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
>>>>>>> d896d1d1d23b6c7584381f5a6f942cdd47bd767b
</html>