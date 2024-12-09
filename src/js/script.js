///ETML
///Auteur: Dany Carneiro Jeremias
///Date: 26.11.2024
///Description: script qui affiche une popup lors de la suppression d'un livre pour que l'utilisateur valide la suppression

// Affiche un popup pour confirmer la suppression d'un enseignant
function confirmDelete(idBook){
    if (confirm("Êtes-vous sûr de vouloir supprimer le livre ?") === true) {
        window.location.href = "../php/deleteBook.php?idBook="+idBook;
    }
}