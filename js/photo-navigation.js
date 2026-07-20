// Sélection des éléments de navigation
document.addEventListener('DOMContentLoaded', function () {

    const navThumbnail = document.getElementById('nav-thumbnail');
    const photoPrev = document.querySelector('.photo-prev');
    const photoNext = document.querySelector('.photo-next');    

    if (!navThumbnail || !photoPrev || !photoNext) {
        return;
    }
    
    // Miniature précédente visible
    photoPrev.addEventListener('mouseenter', function () {
        navThumbnail.src = photoPrev.dataset.thumbnail;
        navThumbnail.parentElement.style.visibility = 'visible';
    });

    // Miniature suivante visible
    photoNext.addEventListener('mouseenter', function () {
        navThumbnail.src = photoNext.dataset.thumbnail;
        navThumbnail.parentElement.style.visibility = 'visible';
    });

    // Miniature cachée après survol de la flèche précédente
    photoPrev.addEventListener('mouseleave', function () {
        navThumbnail.parentElement.style.visibility = 'hidden';
    });

    // Miniature cachée après survol de la flèche suivante
    photoNext.addEventListener('mouseleave', function () {
        navThumbnail.parentElement.style.visibility = 'hidden';
    });

});



