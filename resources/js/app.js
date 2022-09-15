require('./bootstrap');
require('datatables.net-bs5');
$(document).ready(function () {

    if ( $('#DataTable_entretiens').length > 0){
        $('.dataTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées",
                "zeroRecords": "Aucune entrée correspondante trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                "infoFiltered": "(filtrées depuis un total de _MAX_ entrées)",
                "search": "Rechercher:",
                "paginate": {
                    "first": "Première",
                    "last": "Dernière",
                    "next": "Suivante",
                    "previous": "Précédente"
                },
            }
        });
    }
})
