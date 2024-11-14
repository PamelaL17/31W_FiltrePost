<?php 

/**
 * plugin name: Filtre post
 * author: Pamela Limoges
 * description: Une extension qui permettra de filtrer nos articles
 * version: 1.0.0
 * author uri: https://referenced.ca
*/

 function charger_scripts_css() {
    $version_css = filemtime(plugin_dir_path(__FILE__) . "/style.css");
    $version_js = filemtime(plugin_dir_path(__FILE__) . "/js/filtrepost.js");


    wp_enqueue_style(
        "filtrepost",
        plugin_dir_path(__FILE__) . "/style.css",
        array(),
        $version_css
    );

    wp_enqueue_script(
        "filtrepost",
        plugin_dir_path(__FILE__) . "/js/filtrepost.js",
        array(),
        $version_css,
        true
    );

 }

 add_action("wp_enqueue_scripts", "charger_scripts_css");

 function genere_boutons() {
    $categories = get_categories();
    $contenu = "";
    foreach($categories as $elm) {
        $nom = $elm->name;
        $id = $elm->term_id;
        $contenu .= '<button data-id="' . $id . '">' . $nom . '</button>';
    }
    return '<div class="filtre__bouton">' . $contenu . '</div>';
 }

 add_shortcode('extraire_cours', 'genere_boutons');