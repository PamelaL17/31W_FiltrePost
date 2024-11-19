<?php

/**
 * Plugin Name: Filtre Post
 * Author: Pamela Limoges
 * Description: Une extension qui permet de filtrer les articles.
 * Version: 1.0.0
 * Author URI: https://referenced.ca
 */

function charger_scripts_css() {
    $version_css = filemtime(plugin_dir_path(__FILE__) . "/style.css");
    $version_js = filemtime(plugin_dir_path(__FILE__) . "/js/filtrepost.js");


    wp_enqueue_style(
        "filtrepost",
        plugins_url("style.css", __FILE__),
        array(),
        $version_css,
    );

    wp_enqueue_script(
        "filtrepost",
        plugins_url("js/filtrepost.js", __FILE__),
        array(),
        $version_js,
        true
    );
    
}

add_action("wp_enqueue_scripts", "charger_scripts_css");

function genere_boutons() {
    $categories = get_categories();
    $contenu = "";

    // Générer les boutons pour chaque catégorie
    foreach ($categories as $elm) {
        $nom = esc_html($elm->name); // Sécuriser l'affichage
        $id = esc_attr($elm->term_id); // Sécuriser l'attribut
        $contenu .= '<button data-id="' . $id . '" class="filtrepost__bouton">' . $nom . '</button>';
    }

    // Retourner les boutons + conteneur pour les résultats
    return '<div class="filtre__bouton">' . $contenu . '</div><div id="filtre-resultats"></div>';
}

// Enregistrer le shortcode
add_shortcode('extraire_cours', 'genere_boutons');

// Fonction pour afficher les articles filtrés
function afficher_articles_filtrés($articles) {
    $contenu = '<div class="filtrepost__articles">';
    foreach ($articles as $article) {
        $contenu .= '<div class="filtrepost__article">';
        $contenu .= '<h5>' . esc_html($article->title->rendered) . '</h5>';
        $contenu .= '<p>' . esc_html($article->excerpt->rendered) . '</p>';
        $contenu .= '</div>';
    }
    $contenu .= '</div>';
    return $contenu;
}