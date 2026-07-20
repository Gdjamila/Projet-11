/* ======== Gestion de la modale ====== */

document.addEventListener('DOMContentLoaded', function () {

  const modal = document.getElementById('contact-modal');

  // sélectionne l'élément du menu avec la classe "open-contact-modal"
    const contactLinks = document.querySelectorAll('.open-contact-modal');
  // (sécurité) si pas présent, on quitte 
  if (!modal) return;
    
  // Clique sur un élément "Contact"
  contactLinks.forEach(function (contactLink) {
    contactLink.addEventListener('click', function (e) {
      e.preventDefault(); // empêche l'action par défaut
      openModal();
    });
});
  
  // Fonction pour ouvrir la modale
  function openModal() {
    modal.classList.add('show');
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
  }  

  // Fonction pour fermer la modale
  function closeModal() {
    modal.classList.remove('show');
    document.documentElement.style.overflow = '';
    document.body.style.overflow = '';
  }
  
  // Ferme la modale avec la touche Échap
    document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeModal();
    }
  });

  // Ferme la modale au clic sur l'arrière-plan
    modal.addEventListener('click', function (e) {
    if (e.target === modal) {
      closeModal();
      }
    });
 });

  /* ==== Ouverture de la modale + préremplissage automatique du champ “RÉF. PHOTO” ==== */
  
jQuery(document).ready(function ($) {

    $('.open-contact-modal').on('click', function () {
        
        let photoRef = $('#photo-ref').data('photo-ref');
        console.log('Référence récupérée :', photoRef);

        setTimeout(function () {
            $('input[name="your-refPhoto"]').val(photoRef);
            console.log('Champ rempli');
        }, 300);

    });
});

 /* ======== Ouvrir le menu mobile (le burger avec une animation) ======== */

// Attend que le DOM soit complètement chargé avant d’exécuter le script
jQuery(document).ready(function ($) {

    // Ouvre le menu mobile au clic sur le burger
    $('.menu-toggle').on('click', function () {

        // Affiche le menu mobile
        $('.main-nav').toggleClass('active');

        // Ajoute la classe "active" au burger pour lancer l’animation en croix
        $('.menu-toggle').toggleClass('active');

    });

    // Ferme le menu mobile au clic sur la croix
    $('.menu-close').on('click', function () {

        // Masque le menu mobile
        $('.main-nav').removeClass('active');

        // Supprime la classe "active" du burger pour revenir à l’état initial
        $('.menu-toggle').removeClass('active');

    });

    // Ferme le menu mobile au clic sur un lien du menu
    $('.main-nav a').on('click', function () {

        // Masque le menu mobile
        $('.main-nav').removeClass('active');

        // Remet le burger dans son état initial
        $('.menu-toggle').removeClass('active');
    });

});


