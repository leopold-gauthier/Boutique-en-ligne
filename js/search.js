function fetchAutocompleteData() {
    fetch('search.php')
      .then(response => response.json())
      .then(data => {
        console.log(data);
        // Appeler la fonction d'autocomplétion en passant les données récupérées
        autocomplete(document.getElementById('search-bar'), data);
      })
      .catch(error => {
        console.error('Erreur lors de la récupération des données :', error);
      });
  }
  
  function autocomplete(input, data) {
    input.addEventListener('input', function() {
      let inputValue = this.value.trim();
      let suggestions = [];
      

      if (inputValue.length > 1) {
        suggestions = data.filter(function(item) {
            if (typeof item === 'string') {
              return item.toLowerCase().startsWith(inputValue.toLowerCase());
            }
            return false;
          });
      }
  
      let suggestionList = document.getElementById('suggestion-list');
      suggestionList.innerHTML = '';

      if (suggestions.length > 0) {
        suggestions.forEach(function(suggestion) {

            console.log(suggestions);
          let listItem = document.createElement('p');
          listItem.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> <a class="text-decoration-none text-black" href="details.php?product=">' + data.product + '</a>'; // Ajouter la suggestion à l'élément HTML
          suggestionList.appendChild(listItem);
  
          listItem.addEventListener('click', function() {
            input.value = suggestion;
            suggestionList.innerHTML = '';
          });
  
          suggestionList.appendChild(listItem);
        });
      }
    });
  }
  
  fetchAutocompleteData();
  