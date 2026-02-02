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
