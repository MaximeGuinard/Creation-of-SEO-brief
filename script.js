document.addEventListener('DOMContentLoaded', function () {
    var spinner = document.getElementById('loading-spinner');
    var generateButton = document.getElementById('generate-new-brief');
    var copyButton = document.getElementById('copy-brief');

    if (spinner) {
        spinner.style.display = 'none'; // Caché par défaut
    }

    // Afficher le spinner lors de la soumission du formulaire
    if (generateButton) {
        generateButton.addEventListener('click', function() {
            window.location.href = 'https://tool.dev-maxime-guinard.fr/brief/index.html'; // Redirection vers la page d'accueil des briefs
        });
    }

    // Copier le brief dans le presse-papiers
    if (copyButton) {
        copyButton.addEventListener('click', function() {
            var text = document.getElementById('brief-text').innerText;
            navigator.clipboard.writeText(text).then(function() {
                alert('Brief copié dans le presse-papiers');
            }).catch(function(err) {
                alert('Erreur lors de la copie : ' + err);
            });
        });
    }
});
