function verifCat() {
    var name = document.getElementById("name").value;
    var genre = document.getElementsByName('genre');
    var isChecked = false;

for (var i = 0; i < genre.length; i++) {
  if (genre[i].checked) {
    isChecked = true;
    break;
  }
}
    if (isChecked == false) {
        document.getElementById("erreurcat").textContent = "Veuillez saisir le genre.";
        return false;
    } else {
        document.getElementById("erreurcat").textContent = "";
    }

    if (name === "") {
        document.getElementById("erreurcat").textContent = "Veuillez entrer un nom de catégorie";
        return false;
    } else {
        document.getElementById("erreurcat").textContent = "";
    }

    return true;
}

function openConfirmationModal(id) {
   
    var modal = document.getElementById("confirmationModal");
    var confirmBtn = document.getElementById("confirmDeleteBtn");


    modal.querySelector(".modal-body").textContent = "Voulez-vous vraiment supprimer la catégorie avec l'ID " + id + " ?";

  
    confirmBtn.addEventListener("click", function() {
    
      document.getElementById("deleteForm_" + id).submit();
    });

    modal.style.display = "block";
  }
  function closeConfirmationModal() {
    var modal = document.getElementById("confirmationModal");
    modal.style.display = "none";
  }

  

    document.getElementById("addproduct").addEventListener("submit", function(event) {
      // Soumettre le formulaire normalement
      // Vous pouvez également effectuer des opérations supplémentaires avant la soumission
  
      // Redirection vers la page actuelle avec un ancre vers le marqueur
      window.location.href = window.location.href + "#add";
    });

