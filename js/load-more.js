// Variable partagée entre les filtres et le bouton "Charger plus"
let page = 2; // au clic sur "Charger plus", on charge la page 2

/* ============ Filtres : catégories, formats et tri ============ */

jQuery(document).ready(function ($) {
    
    $('#filter-category, #filter-format, #filter-sort').on('change', function () {
      // Réinitialise la pagination
        page = 1;

        // Récupère les valeurs sélectionnées
        let category = $('#filter-category').val();
        let format = $('#filter-format').val();
        let sort = $('#filter-sort').val();

        $.ajax({
            url: ajax_params.ajax_url, // Point d'entrée Ajax de WordPress
            type: 'POST',
            data: {
                action: 'load_more',
                page: page,
                category: category,
                format: format,
                sort: sort
            },
         success: function (response) {

                // Transforme la réponse pour l'analyser
                let $response = $('<div>').html(response);

                // Compte le nombre de photos réellement retournées
                let filteredPhotos = $response.find('.photo-item').length;

                // Supprime l'élément technique avant affichage
                $response.find('.max-pages').remove();

                // si Aucun résultat → afficher message et masque le bouton
                if (filteredPhotos === 0) {
                    $('.photo-grid').html('<p class="no-results">Aucune photo trouvée.</p>');
                    $('#load-more').hide();
                    return;
                }

                // Remplace les photos affichées par les nouvelles photos filtrées
                $('.photo-grid').html($response.html());

                // S'il reste moins de 8 photos, il n'y a pas de page suivante
                if (filteredPhotos < 8) {
                    $('#load-more').hide();
                } else {
                    $('#load-more').show();
                }

                // Prépare la pagination pour le bouton "Charger plus"
                page = 2;
            }      
               
        });

    });

});

/* ========== connexion avec le select visuel  ========================*/

 // Parcourt chaque custom select (sélection personnalisée) présent sur la page
document.querySelectorAll('.custom-select').forEach(select => {

    // Élément qui affiche la valeur sélectionnée
    const selected = select.querySelector('.select-selected');

    // Conteneur des options personnalisées
    const options = select.querySelector('.select-options');

    // Récupère l'id du vrai select(select logique)à synchroniser
    const targetId = select.dataset.target;

    // Sélectionne le vrai select (caché)
    const realSelect = document.getElementById(targetId);
       
    // Ouvre ou ferme la liste des options au clic
    selected.addEventListener('click', () => {

    // Ferme toutes les autres listes ouvertes
    document.querySelectorAll('.select-options').forEach(otherOptions => {
        if (otherOptions !== options) {
            otherOptions.style.display = 'none';
        }
    });
    
    // Rotation de la flèche
    selected.classList.toggle('active');

    // Ouvre ou ferme la liste du select cliqué
    options.style.display = options.style.display === 'block' ? 'none' : 'block';
    });  

    // Parcourt chaque option personnalisée
    options.querySelectorAll('div').forEach(option => {

        option.addEventListener('click', () => { 

            selected.classList.remove('active'); // la flèche revient à sa position normale             
                     
            // Met à jour le texte affiché
            /* selected.textContent = option.textContent; */
            
            const optionLabel = option.dataset.label || option.textContent.trim();
            selected.textContent = optionLabel;

            // Supprime la classe "selected" des autres options
            options.querySelectorAll('div').forEach(otherOption => {
                otherOption.classList.remove('selected');
            });

            // Ajoute la classe "selected" à l’option cliquée
            option.classList.add('selected');

            // Met à jour la valeur du vrai select
            realSelect.value = option.dataset.value;
 
            // Déclenche l'événement change pour lancer l'Ajax
            jQuery(realSelect).trigger('change');

            // Ferme la liste des options
            options.style.display = 'none';
        });
    });
});

/* ============ Gestion du bouton "Charger plus" avec Ajax ============ */

jQuery(document).ready(function ($) {

    $('#load-more').on('click', function () {

        // Supprime ancien message si présent
        $('.no-more-photos').remove();

        // Désactive le bouton pour éviter les double clics
        $('#load-more').prop('disabled', true);

        // Indique le chargement
        $('#load-more').text('Chargement...');    

        // Récupère les filtres actuellement actifs
        let category = $('#filter-category').val();
        let format = $('#filter-format').val();
        let sort = $('#filter-sort').val();

        $.ajax({
            url: ajax_params.ajax_url, // Point d'entrée Ajax de WordPress
            type: 'POST',
            data: {
                action: 'load_more',
                page: page,
                category: category,
                format: format,
                sort: sort
            },
            success: function (response) {
                console.log(response);
                               
             // Si aucune photo supplémentaire n'est retournée, masque le bouton                                   
                    if ($.trim(response) === '') {

                    // Cache le bouton
                    $('#load-more').hide();

                    // Affiche le message sous le bouton
                    $('.load-more-container').after(
                        '<p class="no-more-photos">Il n y a plus de photos à afficher.</p>'
                    );
                    return;
                    }            
               
                // Transforme la réponse en objet jQuery pour récupérer les données utiles
                let $response = $('<div>').html(response);
                
                // Récupère le nombre total de pages disponibles
                let maxPages = $response.find('.max-pages').data('max');       
                            
                // supprimer le span avant affichage pour ne pas perturber la grille
                $response.find('.max-pages').remove();                

                // Ajoute les nouvelles photos à la suite de la grille
                $('.photo-grid').append($response.html()); 
                                
                // Si la dernière page est atteinte, masque le bouton
                if (page >= maxPages) {
                    $('#load-more').prop('disabled', false);
                    $('#load-more').text('Charger plus');
                    $('#load-more').hide();                
                 
                } else {
                    // Sinon, préparer la page suivante
                    page++;

                     /* Réactive le bouton */
                    setTimeout(function () {
                        $('#load-more').prop('disabled', false);
                        $('#load-more').text('Charger plus');
                    }, 70);
                }
            },
            error: function () {
        console.log('Erreur Ajax');
    }

        });
         
    });
    

});





