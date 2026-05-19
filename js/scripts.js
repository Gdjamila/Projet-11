/* ======== Gestion de la modale ====== */

document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('contact-modal');
  // sélectionne l'élément du menu avec la classe "open-contact-modal"
  const contactLink = document.querySelector('.open-contact-modal a');
// (sécurité) si pas présent, on quitte 
  if (!modal) return;

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

  // Clique sur le lien "Contact"
  if (contactLink) {
    contactLink.addEventListener('click', function (e) {
      e.preventDefault(); // empêche l’action par défaut (recharge de la page)
      openModal();
    });
  }

  // Clique en dehors du contenu de la modale
  modal.addEventListener('click', function (e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  // Appuie sur la touche Échap
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeModal();
    }
  });
});

  /* ==== Ouverture de la modale + préremplissage automatique du champ “RÉF. PHOTO” ==== */

  jQuery(document).ready(function ($) {

    $('.open-contact-modal').on('click', function () {

        // Récupère la référence photo depuis la page
        let photoRef = $('#photo-ref').data('photo-ref');

        // Remplit le champ CF7
        $('input[name="your-refPhoto"]').val(photoRef);

    });
});

 /* ======== Ouvrir le menu mobile (le burger avec une animation) ======== */ 

// Attend que le DOM soit complètement chargé avant d’exécuter le script
jQuery(document).ready(function ($) {

    // Ouvre le menu mobile au clic sur le burger
    $('.menu-toggle').on('click', function () {

        // Affiche le menu mobile
        $('.main-nav').addClass('active');

        // Ajoute la classe "active" au burger pour lancer l’animation en croix
        $('.menu-toggle').addClass('active');
    });

    // Ferme le menu mobile au clic sur la croix
    $('.menu-close').on('click', function () {

        // Masque le menu mobile
        $('.main-nav').removeClass('active');

        // Supprime la classe "active" du burger pour revenir à l’état initial
        $('.menu-toggle').removeClass('active');
    });

});


