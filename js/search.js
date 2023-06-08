// Fonction pour effectuer une requête GET en utilisant fetch
function fetchAutocompleteData() {
  fetch('search.php')
      .then(response => response.json())
      .then(data => {
          console.log(data)
          // Appeler la fonction d'autocomplétion en passant les données récupérées
          autocomplete(document.getElementById('search-bar'), data);
      })
      .catch(error => {
          console.error('Erreur lors de la récupération des données :', error);
      });
}

// Fonction d'autocomplétion
function autocomplete(input, data) {
  input.addEventListener('input', function() {
      let inputValue = this.value.trim();
      // Ignorer les espaces avant et après la valeur saisie
      let suggestions = [];

      // Vérifier si la valeur saisie a une longueur supérieure à zéro
      if (inputValue.length > 0) {
          // Filtrer les données en fonction de la valeur saisie
          suggestions = data.filter(function(item) {
              if (typeof item.product === 'string') {
                  return item.product.toLowerCase().startsWith(inputValue.toLowerCase());
              } else {
                  return false;
              }
          });

      }

      // Récupérer l'élément de la liste des suggestions
      let suggestionList = document.getElementById('suggestion-list');

      // Effacer la liste des suggestions précédentes
      suggestionList.innerHTML = '';

      // Vérifier si des suggestions existent
      if (suggestions.length > 0) {
          // Ajouter les nouvelles suggestions à la liste
          suggestions.forEach(function(suggestion) {
              // Créer un élément de liste pour chaque suggestion
              let cheminImage = suggestion.path;
                let indexDernierPoint = cheminImage.indexOf(".");
                let nouveauCheminImage = cheminImage.slice(0, indexDernierPoint) + "./" + cheminImage.slice(indexDernierPoint);

              let listItem = document.createElement('div');
              listItem.innerHTML = '<a href="details.php?id=' + suggestion.id + '" class=" text-black"><img height="50px" src="' + nouveauCheminImage + '"/>&nbsp;' + suggestion.product + '</a>';

              suggestionList.appendChild(listItem);
              // Ajouter un gestionnaire d'événements pour remplir la barre de recherche avec la suggestion sélectionnée
              listItem.addEventListener('click', function() {
                  input.value = suggestion;
                  suggestionList.innerHTML = '';
              });
              // Ajouter l'élément de liste à la liste des suggestions
              suggestionList.appendChild(listItem);
          });
      }
  });
}

// Appelez la fonction pour récupérer les données d'autocomplétion
fetchAutocompleteData();