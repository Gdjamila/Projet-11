/* ==== Récupération des éléments HTML nécessaires au fonctionnement de la lightbox ====*/

const lightbox = document.getElementById('lightbox');

const lightboxTitle = document.querySelector('.lightbox-title');

const lightboxImage = document.querySelector('.lightbox-image');

const lightboxReference = document.querySelector('.lightbox-reference');

const lightboxCategory = document.querySelector('.lightbox-category');

const openButtons = document.querySelectorAll('.open-lightbox');

const closeButton = document.querySelector('.lightbox-close');

const prevButton = document.querySelector('.lightbox-prev');

const nextButton = document.querySelector('.lightbox-next');

// Tableau contenant tous les boutons
const photos = Array.from(openButtons);

// Index de la photo courante
let currentIndex = 0;

// Fonction affichage photo
function showPhoto(index) {

    const photos = Array.from(document.querySelectorAll('.open-lightbox'));

    const photo = photos[index];

    lightboxTitle.textContent = photo.dataset.title;

    lightboxImage.src = photo.dataset.image;

    lightboxReference.textContent = photo.dataset.reference;    

    lightboxCategory.textContent = photo.dataset.category;
}

document.addEventListener('click', function (event) {

    const button = event.target.closest('.open-lightbox');

    if (!button) {
        return;
    }

    event.preventDefault();

    const photos = Array.from(document.querySelectorAll('.open-lightbox'));

    currentIndex = photos.indexOf(button);

    showPhoto(currentIndex);

    lightbox.classList.add('is-open'); 
    document.body.classList.add('no-scroll');
});

// Photo précédente
prevButton.addEventListener('click', function () {

    currentIndex--;

    // Retour dernière photo
    if (currentIndex < 0) {

        currentIndex = photos.length - 1;
    }
    showPhoto(currentIndex);

});

// Photo suivante
nextButton.addEventListener('click', function () {

    currentIndex++;

    // Retour première photo
    if (currentIndex >= photos.length) {

        currentIndex = 0;
    }
    showPhoto(currentIndex);
});

// Fonction fermeture lightbox
function closeLightbox() {

    // Ferme la lightbox
    lightbox.classList.remove('is-open');

    // Réactive le scroll de la page
    document.body.classList.remove('no-scroll');

}

// Fermeture avec 'X'
closeButton.addEventListener('click', function () {
    closeLightbox();
});

// Fermeture (overlay) au clic sur l'arrière-plan noir
lightbox.addEventListener('click', function (event) {

    if (event.target === lightbox) {
        closeLightbox();
    }
});

// Fermeture avec la touche ESC
document.addEventListener('keydown', function (event) {

    if (event.key === 'Escape') {
        closeLightbox();
    }

});

