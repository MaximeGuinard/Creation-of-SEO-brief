<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = htmlspecialchars($_POST['keyword']);

    $prompt = "Tu es un expert en référencement SEO reconnu en France. Ton objectif est de fournir un brief de très haute qualité pour rédiger un article optimisé, sans écrire le contenu directement. Voici les instructions pour structurer le brief :

Structure et Instructions
Structure de la Page :

Utilise une structure <hn> comprenant un seul <h1>, plusieurs <h2>, et si nécessaire, des <h3> et <h4>.
Le <h1> doit représenter le titre principal de l’article et être unique dans le brief.
Les <h3> doivent être inclus dans des <h2>, jamais isolés.
Descriptions et Contenu :

Après chaque balise <h2>, <h3>, ou <h4>, ajoute une brève description expliquant les points clés à aborder avec les mots liés au mot-clé principal et des synonymes.
Chaque description doit aider à la rédaction en soulignant les aspects importants à couvrir en rapport avec le champ sémantique du titre.
Mot-clé Principal :

Le mot-clé principal à utiliser dans le brief est : \"$keyword\".
Éviter Certain Langage :

Ne pas utiliser les expressions suivantes :
dans cet article nous
il est important de
cet article nous allons
dont vous avez besoin
afin que vous puissiez
article nous allons explorer
fois que vous avez
il est possible de
que ce soit pour
les différents types de
en conclusions
conclusion
introduction
Exemple de Structure de Brief
<h1> Titre Principal : \"$keyword\"
Description : Ce titre doit clairement représenter le sujet principal de l’article. Assure-toi d’inclure le mot-clé principal et ses variantes dans ce titre.
<h2> Sous-Titre 1 : Sujet Pertinent
Description : Développe ce sous-titre en expliquant les aspects essentiels du sujet en relation avec le mot-clé principal. Utilise des mots et des synonymes pour enrichir le contenu.
<h3> Sous-Sous-Titre 1.1 : Détail Spécifique
Description : Fournis des détails supplémentaires sous ce sous-sous-titre pour approfondir le sujet. Inclue des mots liés et des variations du mot-clé principal.
<h2> Sous-Titre 2 : Autre Aspect Important
Description : Aborde un autre aspect du sujet principal, en utilisant des synonymes et des termes associés pour enrichir l’article et optimiser le référencement.
<h3> Sous-Sous-Titre 2.1 : Détail Pertinent
Description : Développe ce point en fournissant des informations supplémentaires et des mots-clés liés.
Points Importants pour l'Introduction
Points à Inclure : Énonce quelques points clés à considérer lors de la rédaction de l’introduction. Ceux-ci doivent être en rapport avec les mots liés et les synonymes du mot-clé principal.
Champ Sémantique : Assure-toi que tous les aspects du champ sémantique du titre sont couverts dans l’article.

Ajoute le rendu normal sans format markdown !";

    $api_key = 'sk-proj-Hw1JD41k6as4RbFzfXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = array(
        'model' => 'gpt-3.5-turbo',
        'messages' => array(
            array('role' => 'system', 'content' => 'Vous êtes un assistant de rédaction de contenu.'),
            array('role' => 'user', 'content' => $prompt)
        ),
        'max_tokens' => 2048,
        'temperature' => 0.7
    );

    $options = array(
        'http' => array(
            'header' => "Content-Type: application/json\r\n" .
                        "Authorization: Bearer $api_key\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
            'ignore_errors' => true
        )
    );

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        $error = error_get_last();
        die('Erreur : ' . print_r($error, true));
    }

    $responseData = json_decode($response, true);
    if (isset($responseData['choices'][0]['message']['content'])) {
        $brief = $responseData['choices'][0]['message']['content'];

        // Afficher le brief généré avec des boutons
        echo '<!DOCTYPE html>';
        echo '<html lang="fr">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Brief généré</title>';
        echo '<link rel="stylesheet" href="styles.css">'; // Inclure le CSS
        echo '<style>';
        echo 'body { font-family: Arial, sans-serif; text-align: center; margin: 20px; position: relative; }';
        echo '#brief-container { margin: 20px auto; padding: 20px; max-width: 800px; background: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }';
        echo '#brief-text { white-space: pre-wrap; font-family: Courier, monospace; }';
        echo '.button-container { margin-top: 20px; }';
        echo 'button { background-color: #007bff; border: none; color: #fff; padding: 10px 20px; font-size: 16px; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease; margin: 0 10px; }';
        echo 'button:hover { background-color: #0056b3; }';
        echo '#loading-spinner { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border: 16px solid #f3f3f3; border-top: 16px solid #007bff; border-radius: 50%; width: 80px; height: 80px; animation: spin 1s linear infinite; }';
        echo '@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<div id="loading-spinner"></div>'; // Loader
        echo '<h1>Brief généré</h1>';
        echo '<div id="brief-container">';
        echo '<pre id="brief-text">' . htmlspecialchars($brief) . '</pre>';
        echo '</div>';
        echo '<div class="button-container">';
        echo '<button id="generate-new-brief">Générer un autre brief</button>';
        echo '<button id="copy-brief">Copier le brief</button>';
        echo '</div>';
        echo '<script>';
        echo 'function copyBrief() {';
        echo '  var text = document.getElementById("brief-text").innerText;';
        echo '  navigator.clipboard.writeText(text).then(function() {';
        echo '    alert("Brief copié dans le presse-papiers");';
        echo '  }).catch(function(err) {';
        echo '    alert("Erreur lors de la copie : " + err);';
        echo '  });';
        echo '}';
        echo 'document.getElementById("copy-brief").addEventListener("click", copyBrief);';
        echo 'document.getElementById("generate-new-brief").addEventListener("click", function() {';
        echo '  window.location.href = "https://tool.dev-maxime-guinard.fr/brief/index.html";';
        echo '});';
        echo 'function showLoader() { document.getElementById("loading-spinner").style.display = "block"; }';
        echo 'function hideLoader() { document.getElementById("loading-spinner").style.display = "none"; }';
        echo 'window.onload = function() { hideLoader(); };';
        echo 'document.addEventListener("DOMContentLoaded", function() { showLoader(); });';
        echo '</script>';
        echo '</body>';
        echo '</html>';
    } else {
        die('Erreur dans la réponse de l\'API : ' . print_r($responseData, true));
    }
}
?>
