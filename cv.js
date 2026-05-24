function validation() {
    var nom = document.forms["formulaire"]["nom"];
    var prenom = document.forms["formulaire"]["prenom"];
    var titre = document.forms["formulaire"]["titre"];
    var mail = document.forms["formulaire"]["mail"];
    var numero = document.forms["formulaire"]["numero"];
    var adresse = document.forms["formulaire"]["adresse"];
    var description = document.forms["formulaire"]["description"];

    if (nom.value == "") {
        alert("Veuillez entrer votre nom.");
        nom.focus();
        return false;
    }

    if (prenom.value == "") {
        alert("Veuillez entrer votre prénom.");
        prenom.focus();
        return false;
    }

    if (titre.value == "") {
        alert("Veuillez entrer votre titre professionnel.");
        titre.focus();
        return false;
    }

    if (mail.value == "") {
        alert("Veuillez entrer votre adresse email.");
        mail.focus();
        return false;
    }

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(mail.value)) {
        alert("Veuillez entrer une adresse email valide.");
        mail.focus();
        return false;
    }

    if (numero.value == "") {
        alert("Veuillez entrer votre numéro de téléphone.");
        numero.focus();
        return false;
    }

    if (adresse.value == "") {
        alert("Veuillez entrer votre adresse.");
        adresse.focus();
        return false;
    }

    if (description.value == "") {
        alert("Veuillez entrer une description (À propos de vous).");
        description.focus();
        return false;
    }

    var competences = document.querySelectorAll('input[name="competences[]"]:checked');
    if (competences.length === 0) {
        alert("Veuillez sélectionner au moins une compétence.");
        return false;
    }

    var formation1 = document.forms["formulaire"]["formation1"].value;
    var formation2 = document.forms["formulaire"]["formation2"].value;
    
    if (formation1 == "" && formation2 == "") {
        alert("Veuillez renseigner au moins une formation.");
        document.forms["formulaire"]["formation1"].focus();
        return false;
    }

    var poste1 = document.forms["formulaire"]["poste1"].value;
    var poste2 = document.forms["formulaire"]["poste2"].value;
    
    if (poste1 == "" && poste2 == "") {
        alert("Veuillez renseigner au moins une expérience professionnelle.");
        document.forms["formulaire"]["poste1"].focus();
        return false;
    }

    console.log("Formulaire valide ! Génération du CV en cours...");
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[name="formulaire"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (validation()) {
                // Optionnel : Afficher un loader
                const submitBtn = document.querySelector('input[type="submit"]');
                if (submitBtn) {
                    submitBtn.value = "Génération en cours...";
                    submitBtn.disabled = true;
                }
            }
        });
    }

    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
});