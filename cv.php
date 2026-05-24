<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="cv.css" rel="stylesheet" />
    <title>Mon CV</title>
    <style>
        .cv-generated {
            background-color: white;
            padding: 0;
            max-height: 100vh;
            overflow-y: auto;
        }

        .cv-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
        }

        .cv-header {
            background: linear-gradient(135deg, #7b2cbf 0%, #9d4edd 100%);
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .photo-profile {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .cv-nom {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .cv-titre {
            font-size: 22px;
            opacity: 0.95;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .cv-contact-header {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 20px;
            font-size: 14px;
        }

        .cv-contact-header > div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cv-body {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 0;
        }

        .cv-sidebar {
            background: #f8f9fa;
            padding: 30px;
            border-right: 3px solid #9d4edd;
        }

        .cv-main {
            padding: 30px 40px;
        }

        .cv-section {
            margin-bottom: 30px;
        }

        .cv-section-title {
            font-size: 18px;
            font-weight: bold;
            color: #7b2cbf;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #9d4edd;
        }

        .cv-about {
            color: #495057;
            line-height: 1.8;
            text-align: justify;
        }

        .cv-comp-item {
            display: inline-block;
            background: linear-gradient(135deg, #7b2cbf 0%, #9d4edd 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            margin: 5px 5px 5px 0;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(157, 78, 221, 0.3);
        }

        .cv-langue-item,
        .cv-certif-item,
        .cv-social-item {
            margin-bottom: 12px;
            color: #495057;
            font-size: 14px;
        }

        .cv-langue-item strong,
        .cv-social-item strong {
            color: #7b2cbf;
        }

        .cv-exp-item,
        .cv-formation-item,
        .cv-projet-item {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .cv-exp-item:last-child,
        .cv-formation-item:last-child,
        .cv-projet-item:last-child {
            border-bottom: none;
        }

        .cv-exp-title,
        .cv-formation-title,
        .cv-projet-title {
            font-size: 16px;
            font-weight: bold;
            color: #2b2d42;
            margin-bottom: 5px;
        }

        .cv-exp-company,
        .cv-formation-school {
            color: #7b2cbf;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cv-exp-date,
        .cv-formation-date {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .cv-exp-desc {
            color: #495057;
            line-height: 1.6;
            font-size: 14px;
        }

        .cv-projet-tech {
            color: #7b2cbf;
            font-size: 13px;
            font-style: italic;
            margin-top: 5px;
        }

        .cv-interets {
            color: #495057;
            line-height: 1.6;
        }

        .back-buttons {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
        }

        .back-buttons a {
            display: inline-block;
            padding: 12px 30px;
            margin: 10px;
            background: linear-gradient(135deg, #9d4edd 0%, #7b2cbf 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(157, 78, 221, 0.3);
        }

        .back-buttons a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(157, 78, 221, 0.5);
        }
    </style>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = isset($_POST["nom"]) ? htmlspecialchars($_POST["nom"]) : "";
        $prenom = isset($_POST["prenom"]) ? htmlspecialchars($_POST["prenom"]) : "";
        $titre = isset($_POST["titre"]) ? htmlspecialchars($_POST["titre"]) : "";
        $mail = isset($_POST["mail"]) ? htmlspecialchars($_POST["mail"]) : "";
        $numero = isset($_POST["numero"]) ? htmlspecialchars($_POST["numero"]) : "";
        $adresse = isset($_POST["adresse"]) ? htmlspecialchars($_POST["adresse"]) : "";
        $description = isset($_POST["description"]) ? nl2br(htmlspecialchars($_POST["description"])) : "";
        
        $linkedin = isset($_POST["linkedin"]) ? htmlspecialchars($_POST["linkedin"]) : "";
        $github = isset($_POST["github"]) ? htmlspecialchars($_POST["github"]) : "";
        $portfolio = isset($_POST["portfolio"]) ? htmlspecialchars($_POST["portfolio"]) : "";
        
        $competences = isset($_POST["competences"]) ? $_POST["competences"] : [];
        
        $langue1 = isset($_POST["langue1"]) ? htmlspecialchars($_POST["langue1"]) : "";
        $niveau_langue1 = isset($_POST["niveau_langue1"]) ? htmlspecialchars($_POST["niveau_langue1"]) : "";
        $langue2 = isset($_POST["langue2"]) ? htmlspecialchars($_POST["langue2"]) : "";
        $niveau_langue2 = isset($_POST["niveau_langue2"]) ? htmlspecialchars($_POST["niveau_langue2"]) : "";
        $langue3 = isset($_POST["langue3"]) ? htmlspecialchars($_POST["langue3"]) : "";
        $niveau_langue3 = isset($_POST["niveau_langue3"]) ? htmlspecialchars($_POST["niveau_langue3"]) : "";
        
        // Certifications
        $certification1 = isset($_POST["certification1"]) ? htmlspecialchars($_POST["certification1"]) : "";
        $certification2 = isset($_POST["certification2"]) ? htmlspecialchars($_POST["certification2"]) : "";
        $certification3 = isset($_POST["certification3"]) ? htmlspecialchars($_POST["certification3"]) : "";
        
        $interets = isset($_POST["interets"]) ? nl2br(htmlspecialchars($_POST["interets"])) : "";
        
        $_SESSION['cv_data'] = $_POST;
    ?>

    <div class="back-buttons">
        <a href="index.html">Retour au formulaire</a>
        <a href="export.php">Télécharger en PDF</a>
    </div>

    <div class="cv-generated">
        <div class="cv-container">
            <div class="cv-header">
                <?php if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode(file_get_contents($_FILES['photo']['tmp_name'])); ?>" 
                         alt="Photo" class="photo-profile">
                <?php endif; ?>
                
                <div class="cv-nom"><?php echo strtoupper($nom . " " . $prenom); ?></div>
                <div class="cv-titre"><?php echo $titre; ?></div>
                
                <div class="cv-contact-header">
                    <?php if ($mail): ?>
                        <div><?php echo $mail; ?></div>
                    <?php endif; ?>
                    <?php if ($numero): ?>
                        <div><?php echo $numero; ?></div>
                    <?php endif; ?>
                    <?php if ($adresse): ?>
                        <div><?php echo $adresse; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="cv-body">
                <div class="cv-sidebar">
                    
                    <?php if ($linkedin || $github || $portfolio): ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Liens</div>
                            <?php if ($linkedin): ?>
                                <div class="cv-social-item"><strong>LinkedIn:</strong><br><?php echo $linkedin; ?></div>
                            <?php endif; ?>
                            <?php if ($github): ?>
                                <div class="cv-social-item"><strong>GitHub:</strong><br><?php echo $github; ?></div>
                            <?php endif; ?>
                            <?php if ($portfolio): ?>
                                <div class="cv-social-item"><strong>Portfolio:</strong><br><?php echo $portfolio; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (count($competences) > 0): ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Compétences</div>
                            <?php foreach ($competences as $comp): ?>
                                <span class="cv-comp-item"><?php echo htmlspecialchars($comp); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($langue1 || $langue2 || $langue3): ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Langues</div>
                            <?php if ($langue1): ?>
                                <div class="cv-langue-item">
                                    <strong><?php echo $langue1; ?></strong>
                                    <?php if ($niveau_langue1): ?>
                                        <br><span><?php echo $niveau_langue1; ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($langue2): ?>
                                <div class="cv-langue-item">
                                    <strong><?php echo $langue2; ?></strong>
                                    <?php if ($niveau_langue2): ?>
                                        <br><span><?php echo $niveau_langue2; ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($langue3): ?>
                                <div class="cv-langue-item">
                                    <strong><?php echo $langue3; ?></strong>
                                    <?php if ($niveau_langue3): ?>
                                        <br><span><?php echo $niveau_langue3; ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($certification1 || $certification2 || $certification3): ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Certifications</div>
                            <?php if ($certification1): ?>
                                <div class="cv-certif-item">• <?php echo $certification1; ?></div>
                            <?php endif; ?>
                            <?php if ($certification2): ?>
                                <div class="cv-certif-item">• <?php echo $certification2; ?></div>
                            <?php endif; ?>
                            <?php if ($certification3): ?>
                                <div class="cv-certif-item">• <?php echo $certification3; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($interets): ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Intérêts</div>
                            <div class="cv-interets"><?php echo $interets; ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cv-main">
                    
                    <?php if ($description): ?>
                        <div class="cv-section">
                            <div class="cv-section-title">À propos</div>
                            <div class="cv-about"><?php echo $description; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $has_experience = false;
                    for ($i = 1; $i <= 2; $i++) {
                        if (isset($_POST["poste$i"]) && $_POST["poste$i"]) {
                            $has_experience = true;
                            break;
                        }
                    }
                    if ($has_experience): 
                    ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Expériences</div>
                            <?php for ($i = 1; $i <= 2; $i++): 
                                $poste = isset($_POST["poste$i"]) ? htmlspecialchars($_POST["poste$i"]) : "";
                                $entreprise = isset($_POST["entreprise$i"]) ? htmlspecialchars($_POST["entreprise$i"]) : "";
                                $debut = isset($_POST["debut_experience$i"]) ? htmlspecialchars($_POST["debut_experience$i"]) : "";
                                $fin = isset($_POST["fin_experience$i"]) ? htmlspecialchars($_POST["fin_experience$i"]) : "";
                                $missions = isset($_POST["missions$i"]) ? nl2br(htmlspecialchars($_POST["missions$i"])) : "";
                                
                                if ($poste):
                            ?>
                                <div class="cv-exp-item">
                                    <div class="cv-exp-title"><?php echo $poste; ?></div>
                                    <?php if ($entreprise): ?>
                                        <div class="cv-exp-company"><?php echo $entreprise; ?></div>
                                    <?php endif; ?>
                                    <?php if ($debut || $fin): ?>
                                        <div class="cv-exp-date"><?php echo $debut . ($fin ? " - " . $fin : ""); ?></div>
                                    <?php endif; ?>
                                    <?php if ($missions): ?>
                                        <div class="cv-exp-desc"><?php echo $missions; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php 
                                endif;
                            endfor; 
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $has_projet = false;
                    for ($i = 1; $i <= 2; $i++) {
                        if (isset($_POST["projet{$i}_nom"]) && $_POST["projet{$i}_nom"]) {
                            $has_projet = true;
                            break;
                        }
                    }
                    if ($has_projet): 
                    ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Projets</div>
                            <?php for ($i = 1; $i <= 2; $i++): 
                                $projet_nom = isset($_POST["projet{$i}_nom"]) ? htmlspecialchars($_POST["projet{$i}_nom"]) : "";
                                $projet_desc = isset($_POST["projet{$i}_desc"]) ? nl2br(htmlspecialchars($_POST["projet{$i}_desc"])) : "";
                                $projet_tech = isset($_POST["projet{$i}_tech"]) ? htmlspecialchars($_POST["projet{$i}_tech"]) : "";
                                
                                if ($projet_nom):
                            ?>
                                <div class="cv-projet-item">
                                    <div class="cv-projet-title"><?php echo $projet_nom; ?></div>
                                    <?php if ($projet_desc): ?>
                                        <div class="cv-exp-desc"><?php echo $projet_desc; ?></div>
                                    <?php endif; ?>
                                    <?php if ($projet_tech): ?>
                                        <div class="cv-projet-tech">Technologies: <?php echo $projet_tech; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php 
                                endif;
                            endfor; 
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $has_formation = false;
                    for ($i = 1; $i <= 2; $i++) {
                        if (isset($_POST["formation$i"]) && $_POST["formation$i"]) {
                            $has_formation = true;
                            break;
                        }
                    }
                    if ($has_formation): 
                    ?>
                        <div class="cv-section">
                            <div class="cv-section-title">Formation</div>
                            <?php for ($i = 1; $i <= 2; $i++): 
                                $formation = isset($_POST["formation$i"]) ? htmlspecialchars($_POST["formation$i"]) : "";
                                $lieu = isset($_POST["lieu$i"]) ? htmlspecialchars($_POST["lieu$i"]) : "";
                                $debut = isset($_POST["debut_formation$i"]) ? htmlspecialchars($_POST["debut_formation$i"]) : "";
                                $fin = isset($_POST["fin_formation$i"]) ? htmlspecialchars($_POST["fin_formation$i"]) : "";
                                
                                if ($formation):
                            ?>
                                <div class="cv-formation-item">
                                    <div class="cv-formation-title"><?php echo $formation; ?></div>
                                    <?php if ($lieu): ?>
                                        <div class="cv-formation-school"><?php echo $lieu; ?></div>
                                    <?php endif; ?>
                                    <?php if ($debut || $fin): ?>
                                        <div class="cv-formation-date"><?php echo $debut . ($fin ? " - " . $fin : ""); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php 
                                endif;
                            endfor; 
                            ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php
    } else {
        echo "<div style='text-align: center; padding: 50px;'>";
        echo "<p>Aucune donnée reçue. <a href='index.html' style='color: #9d4edd; font-weight: bold;'>Retour au formulaire</a></p>";
        echo "</div>";
    }
    ?>
</body>
</html>