(function () {
  // Récupérer tous les boutons de la classe "filtre__bouton"
  const filtreBoutons = document.querySelectorAll(".filtre__bouton button");

  // Fonction pour gérer le clic sur les boutons et lancer la requête REST API
  function handleButtonClick(event) {
    // Récupérer l'ID de la catégorie sélectionnée
    const categorieId = event.target.dataset.id;
    console.log("Catégorie sélectionnée:", categorieId);

    // Lancer la requête REST API pour récupérer les articles de la catégorie
    fetch(
      `http://localhost/31w/wp-json/wp/v2/posts?categories=${categorieId}&per_page=30`
    )
      .then((response) => response.json()) // Conversion de la réponse en JSON
      .then((data) => {
        console.log("Articles récupérés:", data); // Afficher les articles récupérés pour déboguer
        afficherArticles(data); // Appel de la fonction pour afficher les articles
      })
      .catch((error) =>
        console.error("Erreur lors de l'extraction des cours:", error)
      ); // En cas d'erreur
  }

  // Fonction pour afficher les articles récupérés de l'API
  function afficherArticles(articles) {
    const container = document.querySelector(".principal__conteneur");
    container.innerHTML = ""; // Réinitialise l'affichage

    // Pour chaque article créer un élément d'affichage
    articles.forEach((article) => {
      const articleElement = document.createElement("article");
      articleElement.classList.add("principal__article");

      // Ajouter le titre de l'article
      const titleElement = document.createElement("h5");
      titleElement.textContent = article.title.rendered;
      articleElement.appendChild(titleElement);

      // Ajouter l'extrait de l'article
      const excerptElement = document.createElement("p");
      excerptElement.innerHTML = article.excerpt.rendered;
      articleElement.appendChild(excerptElement);

      // Ajouter l'article au conteneur
      container.appendChild(articleElement);
    });
  }

  // Ajouter l'événement de clic à chaque bouton
  filtreBoutons.forEach((button) => {
    button.addEventListener("click", handleButtonClick);
  });
})();
