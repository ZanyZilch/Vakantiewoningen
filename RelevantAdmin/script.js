// Liggingen verwijderen
var openDeleteForm = document.getElementById("openDeleteForm");
var deleteForm = document.getElementById("deleteForm");
var isDeleteFormOpen = false;

openDeleteForm.addEventListener("click", function () {
    if (isDeleteFormOpen) {
        deleteForm.style.display = "none";
        isDeleteFormOpen = false;
    } else {
        deleteForm.style.display = "block";
        isDeleteFormOpen = true;
    }
});

deleteForm.querySelector("form").addEventListener("submit", function () {
    deleteForm.style.display = "none";
    isDeleteFormOpen = false;
});

// Ligging toevoegen
var openForm = document.getElementById("openForm");
var liggingForm = document.getElementById("liggingForm");
var isLiggingFormOpen = false;

openForm.addEventListener("click", function () {
    if (isLiggingFormOpen) {
        liggingForm.style.display = "none";
        isLiggingFormOpen = false;
    } else {
        liggingForm.style.display = "block";
        isLiggingFormOpen = true;
    }
});

liggingForm.querySelector("form").addEventListener("submit", function () {
    liggingForm.style.display = "none";
    isLiggingFormOpen = false;
});

// Eigenschappen verwijderen
var openEigenschapDeleteForm = document.getElementById("openEigenschapDeleteForm");
var deleteEigenschapForm = document.getElementById("deleteEigenschapForm");
var isDeleteEigenschapFormOpen = false;

openEigenschapDeleteForm.addEventListener("click", function () {
    if (isDeleteEigenschapFormOpen) {
        deleteEigenschapForm.style.display = "none";
        isDeleteEigenschapFormOpen = false;
    } else {
        deleteEigenschapForm.style.display = "block";
        isDeleteEigenschapFormOpen = true;
    }
});

deleteEigenschapForm.querySelector("form").addEventListener("submit", function () {
    deleteEigenschapForm.style.display = "none";
    isDeleteEigenschapFormOpen = false;
});

// Eigenschappen toevoegen
var openEigenschapForm = document.getElementById("openEigenschapForm");
var eigenschapForm = document.getElementById("eigenschapForm");
var isEigenschapFormOpen = false;

openEigenschapForm.addEventListener("click", function () {
    if (isEigenschapFormOpen) {
        eigenschapForm.style.display = "none";
        isEigenschapFormOpen = false;
    } else {
        eigenschapForm.style.display = "block";
        isEigenschapFormOpen = true;
    }
});

eigenschapForm.querySelector("form").addEventListener("submit", function () {
    eigenschapForm.style.display = "none";
    isEigenschapFormOpen = false;
});

// Afbeeldingen verwijderen
var openImgForm = document.getElementById("openImgForm");
var imgForm = document.getElementById("imgForm");
var isImgFormOpen = false;

openImgForm.addEventListener("click", function () {
    if (isImgFormOpen) {
        imgForm.style.display = "none";
        isImgFormOpen = false;
    } else {
        imgForm.style.display = "block";
        isImgFormOpen = true;
    }
});

imgForm.querySelector("form").addEventListener("submit", function () {
    imgForm.style.display = "none";
    isImgFormOpen = false;
});


