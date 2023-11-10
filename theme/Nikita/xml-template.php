<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); } ?>
<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php get_page_clean_title(); ?></title>
        <?php get_header(); ?>
        <link href="<?php get_theme_url(); ?>/reset.css" rel="stylesheet">
        <link href="<?php get_theme_url(); ?>/default.css" rel="stylesheet">
        <link href="<?php get_theme_url(); ?>/style.css" rel="stylesheet">
    </head>
    <body>
        <nav><?php get_component('navbar'); ?></nav>
        <?php
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
        } else {
            $category = 'NULL';
        }

        $xml = simplexml_load_file('data/pages/content/' . $category . '.xml');
        if ($xml) {
            echo '<h1 id="category">' . $category . ' games' . '</h1>';
            $games = $xml->xpath("./*");
            usort($games, function($x, $y) { // sorting by lexicographic order
                return strcmp($x->name, $y->name);
            });
            foreach ($games as $game) {
                echo '<article>';
                echo '<h2>' . $game->name . '</h2>';
                echo '<img src="' . $game->picture . '" style="width: 300px; height: 300px;" alt="Error, the image could not be loaded">';
                echo '<p>' . $game->description . '</p>';
                echo '<table>'; // creating a table to organise some of this data
                echo '<tr><td><b>Subject:</b></td><td>' . $game->subject . '</td></tr>';
                echo '<tr><td><b>Grade:</b></td><td>' . $game->grade . '</td></tr>';
                echo '<tr><td><b>Multiplayer:</b></td><td>' . $game->multiplayer . '</td></tr>';
                echo '<tr><td><b>Cost:</b></td><td>';
                if ($game->cost) {
                    echo $game->cost; // cost is optional
                } else {
                    echo 'N/A';
                }
                echo '</td></tr>';
                echo '</table>';
                if ($game->tag) {
                    echo '<p>Tags: ';
                    $i = 1;
                    foreach ($game->tag as $tag) { // iterating through tags, and adding a comma if there's more left
                        echo $tag;
                        if ($i < count($game->tag)) {
                            echo ', ';
                        }
                        $i = $i + 1;
                    }
                    echo '</p>';
                }
                if (count($game->author) > 1) { // there can be more than 1 author
                    echo '<p>Authors: ';
                } else { 
                    echo '<p>Author: ';
                }
                $i = 1;
                foreach ($game->author as $author) {
                    if ($author['profile']) { // authors can have pages, not functional but it's in my XML
                        echo '<a href="'. $author['profile'] . '">' . $author . '</a>';
                    }
                    else {
                        echo $author;
                    }
                    if ($i < count($game->author)) {
                        echo ', ';
                    }
                    $i = $i + 1;
                }
                echo '</p>';

                echo '<table>';
                echo '<thead><tr><td>Equipment</td><td>Cost</td></tr></thead>';
                foreach ($game->equipment as $equipment) {
                    echo '<tr>';
                    echo '<td>' . $equipment->name . '</td><td>';
                    if ($equipment->cost) {
                        echo $equipment->cost;
                    } else {
                        echo 'N/A';
                    }
                    echo '</td></tr>';
                }
                echo '</table>';
                if ($game->review) {
                    $i = 1;
                    foreach ($game->review as $review) {
                        echo '<details><summary>Review ' . $i . ': '. $review['rating'] .'/5</summary>';
                        echo '<p>' . $review . '</p></details>';
                        $i = $i + 1;
                    }
                }
                echo '<p>' . $game->url . '</p>'; // I'm not putting this in a link element because no functionality
                echo '</article>';
            }
        } else {
            echo '<h1>This game category doesn\'t exist</h1>';
        }
        ?>
        <?php get_component('copyright'); ?>
        <script> // storing date and page name in a cookie
            // Function to set a cookie
            var name = document.getElementById('category').innerHTML.split(' ')[0];
            var time = new Date();
            var t = (' '+time).split(' '); // stripping time zone and other extraneous information
            time = t[5] + ' ' + t[0] + ' ' + t[1] + ' ' + t[2] + ' ' + t[3] + ' ' + t[4];
            document.cookie = 'page' + "=" + name;
            document.cookie = 'time' + "=" + time;
        </script>
    </body>
</html>
