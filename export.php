<?php
session_start();

if (!file_exists('vendor/autoload.php')) {
    die("Erreur: Dompdf n'est pas installé. Exécutez: composer require dompdf/dompdf");
}

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_SESSION['cv_data'])) {
    die("Aucune donnée de CV trouvée. <a href='index.html'>Retour au formulaire</a>");
}

$data = $_SESSION['cv_data'];

$nom = isset($data["nom"]) ? htmlspecialchars($data["nom"]) : "";
$prenom = isset($data["prenom"]) ? htmlspecialchars($data["prenom"]) : "";
$titre = isset($data["titre"]) ? htmlspecialchars($data["titre"]) : "";
$mail = isset($data["mail"]) ? htmlspecialchars($data["mail"]) : "";
$numero = isset($data["numero"]) ? htmlspecialchars($data["numero"]) : "";
$adresse = isset($data["adresse"]) ? htmlspecialchars($data["adresse"]) : "";
$description = isset($data["description"]) ? nl2br(htmlspecialchars($data["description"])) : "";

$linkedin = isset($data["linkedin"]) ? htmlspecialchars($data["linkedin"]) : "";
$github = isset($data["github"]) ? htmlspecialchars($data["github"]) : "";
$portfolio = isset($data["portfolio"]) ? htmlspecialchars($data["portfolio"]) : "";

$competences = isset($data["competences"]) ? $data["competences"] : [];

$langue1 = isset($data["langue1"]) ? htmlspecialchars($data["langue1"]) : "";
$niveau_langue1 = isset($data["niveau_langue1"]) ? htmlspecialchars($data["niveau_langue1"]) : "";
$langue2 = isset($data["langue2"]) ? htmlspecialchars($data["langue2"]) : "";
$niveau_langue2 = isset($data["niveau_langue2"]) ? htmlspecialchars($data["niveau_langue2"]) : "";
$langue3 = isset($data["langue3"]) ? htmlspecialchars($data["langue3"]) : "";
$niveau_langue3 = isset($data["niveau_langue3"]) ? htmlspecialchars($data["niveau_langue3"]) : "";

$certification1 = isset($data["certification1"]) ? htmlspecialchars($data["certification1"]) : "";
$certification2 = isset($data["certification2"]) ? htmlspecialchars($data["certification2"]) : "";
$certification3 = isset($data["certification3"]) ? htmlspecialchars($data["certification3"]) : "";

$interets = isset($data["interets"]) ? nl2br(htmlspecialchars($data["interets"])) : "";

$html = '
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt;
        }
        .cv-header {
            background: linear-gradient(135deg, #7b2cbf 0%, #9d4edd 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .cv-nom {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .cv-titre {
            font-size: 16px;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }
        .cv-contact-header {
            font-size: 9pt;
            margin-top: 10px;
        }
        .cv-body {
            display: table;
            width: 100%;
        }
        .cv-sidebar {
            display: table-cell;
            width: 35%;
            background: #f8f9fa;
            padding: 20px;
            vertical-align: top;
            border-right: 3px solid #9d4edd;
        }
        .cv-main {
            display: table-cell;
            width: 65%;
            padding: 20px 25px;
            vertical-align: top;
        }
        .cv-section {
            margin-bottom: 20px;
        }
        .cv-section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #7b2cbf;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #9d4edd;
        }
        .cv-about {
            color: #495057;
            line-height: 1.6;
            text-align: justify;
            font-size: 9pt;
        }
        .cv-comp-item {
            display: inline-block;
            background: linear-gradient(135deg, #7b2cbf 0%, #9d4edd 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 8pt;
            margin: 3px 3px 3px 0;
            font-weight: 600;
        }
        .cv-langue-item,
        .cv-certif-item,
        .cv-social-item {
            margin-bottom: 8px;
            color: #495057;
            font-size: 9pt;
            line-height: 1.4;
        }
        .cv-langue-item strong,
        .cv-social-item strong {
            color: #7b2cbf;
        }
        .cv-social-item {
            word-break: break-all;
        }
        .cv-exp-item,
        .cv-formation-item,
        .cv-projet-item {
            margin-bottom: 15px;
            padding-bottom: 12px;
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
            font-size: 11pt;
            font-weight: bold;
            color: #2b2d42;
            margin-bottom: 3px;
        }
        .cv-exp-company,
        .cv-formation-school {
            color: #7b2cbf;
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 9pt;
        }
        .cv-exp-date,
        .cv-formation-date {
            color: #6c757d;
            font-size: 8pt;
            margin-bottom: 6px;
        }
        .cv-exp-desc {
            color: #495057;
            line-height: 1.5;
            font-size: 9pt;
        }
        .cv-projet-tech {
            color: #7b2cbf;
            font-size: 8pt;
            font-style: italic;
            margin-top: 3px;
        }
        .cv-interets {
            color: #495057;
            line-height: 1.5;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <div class="cv-header">
        <div class="cv-nom">' . strtoupper($nom . ' ' . $prenom) . '</div>
        <div class="cv-titre">' . $titre . '</div>
        <div class="cv-contact-header">';
        
if ($mail) $html .= 'Email: ' . $mail . ' ';
if ($numero) $html .= '| Tel: ' . $numero . ' ';
if ($adresse) $html .= '| Adresse: ' . $adresse;

$html .= '
        </div>
    </div>
    
    <div class="cv-body">
        <div class="cv-sidebar">';

if ($linkedin || $github || $portfolio) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">LIENS</div>';
    if ($linkedin) $html .= '<div class="cv-social-item"><strong>LinkedIn</strong><br>' . $linkedin . '</div>';
    if ($github) $html .= '<div class="cv-social-item"><strong>GitHub</strong><br>' . $github . '</div>';
    if ($portfolio) $html .= '<div class="cv-social-item"><strong>Portfolio</strong><br>' . $portfolio . '</div>';
    $html .= '</div>';
}

if (count($competences) > 0) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">COMPÉTENCES</div>';
    foreach ($competences as $comp) {
        $html .= '<span class="cv-comp-item">' . htmlspecialchars($comp) . '</span>';
    }
    $html .= '</div>';
}

if ($langue1 || $langue2 || $langue3) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">LANGUES</div>';
    if ($langue1) {
        $html .= '<div class="cv-langue-item"><strong>' . $langue1 . '</strong>';
        if ($niveau_langue1) $html .= '<br>' . $niveau_langue1;
        $html .= '</div>';
    }
    if ($langue2) {
        $html .= '<div class="cv-langue-item"><strong>' . $langue2 . '</strong>';
        if ($niveau_langue2) $html .= '<br>' . $niveau_langue2;
        $html .= '</div>';
    }
    if ($langue3) {
        $html .= '<div class="cv-langue-item"><strong>' . $langue3 . '</strong>';
        if ($niveau_langue3) $html .= '<br>' . $niveau_langue3;
        $html .= '</div>';
    }
    $html .= '</div>';
}

if ($certification1 || $certification2 || $certification3) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">CERTIFICATIONS</div>';
    if ($certification1) $html .= '<div class="cv-certif-item">- ' . $certification1 . '</div>';
    if ($certification2) $html .= '<div class="cv-certif-item">- ' . $certification2 . '</div>';
    if ($certification3) $html .= '<div class="cv-certif-item">- ' . $certification3 . '</div>';
    $html .= '</div>';
}

if ($interets) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">INTÉRÊTS</div>
                <div class="cv-interets">' . $interets . '</div>
              </div>';
}

$html .= '
        </div>
        <div class="cv-main">';

if ($description) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">À PROPOS</div>
                <div class="cv-about">' . $description . '</div>
              </div>';
}

$has_experience = false;
for ($i = 1; $i <= 2; $i++) {
    if (isset($data["poste$i"]) && $data["poste$i"]) {
        $has_experience = true;
        break;
    }
}

if ($has_experience) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">EXPÉRIENCES</div>';
    
    for ($i = 1; $i <= 2; $i++) {
        $poste = isset($data["poste$i"]) ? htmlspecialchars($data["poste$i"]) : "";
        $entreprise = isset($data["entreprise$i"]) ? htmlspecialchars($data["entreprise$i"]) : "";
        $debut = isset($data["debut_experience$i"]) ? htmlspecialchars($data["debut_experience$i"]) : "";
        $fin = isset($data["fin_experience$i"]) ? htmlspecialchars($data["fin_experience$i"]) : "";
        $missions = isset($data["missions$i"]) ? nl2br(htmlspecialchars($data["missions$i"])) : "";
        
        if ($poste) {
            $html .= '<div class="cv-exp-item">
                        <div class="cv-exp-title">' . $poste . '</div>';
            if ($entreprise) $html .= '<div class="cv-exp-company">' . $entreprise . '</div>';
            if ($debut || $fin) $html .= '<div class="cv-exp-date">' . $debut . ($fin ? ' - ' . $fin : '') . '</div>';
            if ($missions) $html .= '<div class="cv-exp-desc">' . $missions . '</div>';
            $html .= '</div>';
        }
    }
    $html .= '</div>';
}

$has_projet = false;
for ($i = 1; $i <= 2; $i++) {
    if (isset($data["projet{$i}_nom"]) && $data["projet{$i}_nom"]) {
        $has_projet = true;
        break;
    }
}

if ($has_projet) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">PROJETS</div>';
    
    for ($i = 1; $i <= 2; $i++) {
        $projet_nom = isset($data["projet{$i}_nom"]) ? htmlspecialchars($data["projet{$i}_nom"]) : "";
        $projet_desc = isset($data["projet{$i}_desc"]) ? nl2br(htmlspecialchars($data["projet{$i}_desc"])) : "";
        $projet_tech = isset($data["projet{$i}_tech"]) ? htmlspecialchars($data["projet{$i}_tech"]) : "";
        
        if ($projet_nom) {
            $html .= '<div class="cv-projet-item">
                        <div class="cv-projet-title">' . $projet_nom . '</div>';
            if ($projet_desc) $html .= '<div class="cv-exp-desc">' . $projet_desc . '</div>';
            if ($projet_tech) $html .= '<div class="cv-projet-tech">Technologies: ' . $projet_tech . '</div>';
            $html .= '</div>';
        }
    }
    $html .= '</div>';
}

$has_formation = false;
for ($i = 1; $i <= 2; $i++) {
    if (isset($data["formation$i"]) && $data["formation$i"]) {
        $has_formation = true;
        break;
    }
}

if ($has_formation) {
    $html .= '<div class="cv-section">
                <div class="cv-section-title">FORMATION</div>';
    
    for ($i = 1; $i <= 2; $i++) {
        $formation = isset($data["formation$i"]) ? htmlspecialchars($data["formation$i"]) : "";
        $lieu = isset($data["lieu$i"]) ? htmlspecialchars($data["lieu$i"]) : "";
        $debut = isset($data["debut_formation$i"]) ? htmlspecialchars($data["debut_formation$i"]) : "";
        $fin = isset($data["fin_formation$i"]) ? htmlspecialchars($data["fin_formation$i"]) : "";
        
        if ($formation) {
            $html .= '<div class="cv-formation-item">
                        <div class="cv-formation-title">' . $formation . '</div>';
            if ($lieu) $html .= '<div class="cv-formation-school">' . $lieu . '</div>';
            if ($debut || $fin) $html .= '<div class="cv-formation-date">' . $debut . ($fin ? ' - ' . $fin : '') . '</div>';
            $html .= '</div>';
        }
    }
    $html .= '</div>';
}

$html .= '
        </div>
    </div>
</body>
</html>
';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$fichier = "CV_" . $nom . "_" . $prenom . ".pdf";

$dompdf->stream($fichier, array("Attachment" => true));
?>