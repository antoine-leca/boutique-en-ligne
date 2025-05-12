$btnCR = document.getElementById("modalCRbtn");
modalCR = document.getElementById("modalCR");

// $btnCR.addEventListener("click", function () {
//     if (modalCR.classList.contains("hidden")) {
//         modalCR.classList.remove("hidden");
//     } else {
//         modalCR.classList.add("hidden");
//     }
// });

document.addEventListener("DOMContentLoaded", function () {
    const connexionTab = document.getElementById("connexionTab");
    const inscriptionTab = document.getElementById("inscriptionTab");
    const connexionForm = document.getElementById("connexionForm");
    const inscriptionForm = document.getElementById("inscriptionForm");

    // Fonction pour activer un onglet
    function activateTab(activeTab, inactiveTab) {
    activeTab.classList.add("tab-active");
    inactiveTab.classList.remove("tab-active");

    // Change the triangle color dynamically
    const modalContent = document.querySelector(".modal-content");
    if (activeTab.id === "connexionTab") {
        modalContent.style.setProperty("--triangle-color", "var(--grey-color)");
    } else {
        modalContent.style.setProperty("--triangle-color", "var(--blue-color)");
    }
}

    // Afficher le formulaire de connexion
    connexionTab.addEventListener("click", function () {
        connexionForm.style.display = "block";
        inscriptionForm.style.display = "none";
        activateTab(connexionTab, inscriptionTab);
    });

    // Afficher le formulaire d'inscription
    inscriptionTab.addEventListener("click", function () {
        connexionForm.style.display = "none";
        inscriptionForm.style.display = "block";
        activateTab(inscriptionTab, connexionTab);
    });

    // Optionnel : Lien dans le formulaire de connexion pour basculer vers inscription
    const switchToInscription = document.getElementById("switchToInscription");
    switchToInscription.addEventListener("click", function () {
        connexionForm.style.display = "none";
        inscriptionForm.style.display = "block";
        activateTab(inscriptionTab, connexionTab);
    });
});