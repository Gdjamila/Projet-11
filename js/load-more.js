/* ==== Gestion du bouton "Charger plus" avec Ajax (pagination infinie) ==== */

jQuery(document).ready(function ($) {

    let page = 2; // on commence à la page 2 (la 1 est déjà affichée)

    $('#load-more').on('click', function () {

        $.ajax({
            url: ajax_params.ajax_url, // Point d'entrée Ajax de WordPress pour communiquer avec le PHP
            type: 'POST',
            data: {
                action: 'load_more',
                page: page
            },
            success: function (response) {

                // Ajoute les nouvelles photos à la grille
                $('.photo-grid').append(response);

                page++; // passe à la page suivante
            }
        });

    });

});