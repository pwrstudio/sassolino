<?php
// sassolino. A very small flat-file cms.
// Copyright (C) 2014 PWR Studio
//
// This program is free software: you can redistribute it and/or modify it
// under the terms of the GNU General Public License as published by the Free
// Software Foundation, either version 3 of the License, or (at your option)
// any later version.
//
// This program is distributed in the hope that it will be useful, but WITHOUT
// ANY WARRANTY; without even the implied warranty of  MERCHANTABILITY or
// FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
// more details.
//
// You should have received a copy of the GNU General Public License along with
// this program.  If not, see <http://www.gnu.org/licenses/>.
include 'parsedown.php'; // Used to parse markdown
echo '<!DOCTYPE html>';
echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">';
echo '<head>';
echo '<title>sassolino. A very small flat-file CMS.</title>'; // Site title
echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '</head>';
echo '<body>';
$base = $_GET['dir']; // Get the name of the subdirectory
echo '<div id="main_container">';
if (empty($base)) // If no subdirectory: frontpage 
  {
    $base = "content/";
    if (file_exists($base . "index.md")) // Output index.md if it exists
      {
        $index_content = file_get_contents($base . "index.md");
        $Parsedown     = new Parsedown();
        echo $Parsedown->text($index_content);
      }
    $files = scandir($base); // Find all subdirectories of "content"
    foreach ($files as $result)
      {
        if ($result === '.' or $result === '..')
            continue;
        if (is_dir($base . $result))
          {
            echo '<div class="item_container">';
            $title = str_replace("_", " ", $result);
            $link  = str_replace("content/", "", $base);
            echo '<h1><a href="' . $link . $result . '">' . $title . '</a></h1>';
            $images = glob($base . $result . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE); //get all images in folder
            if (count($images) > 0) // make sure there is at least one
              {
                echo '<a href="' . $link . $result . '" class="menu_item" ><img src="' . $images[0] . '" alt="' . $title . '"></a>'; //Output first image
              }
            echo '</div>';
          }
      }
  }
else //If not frontpage
  {
    $base  = 'content/' . $base;
    // Clean directory names into titles
    $title = str_replace("_", " ", $base);
    $title = str_replace("/", "", $title);
    $title = str_replace("content", "", $title);
    // Back to index     
    echo '<div id="index"><a href=".">←Index</a></div>'; //Link back to the index-page
    echo '<h1>' . $title . '</h1>';
    // Output index text    
    if (file_exists($base . "/index.md"))
      {
        $index_content = file_get_contents($base . "/index.md");
        $Parsedown     = new Parsedown();
        echo $Parsedown->text($index_content);
      }
    $files = scandir($base); // Find all files in directory
    foreach ($files as $file)
      {
        $ext = pathinfo($file, PATHINFO_EXTENSION); //Get file extension
        if ($ext == "jpg" || $ext == "png" || $ext == "gif" || $ext == "jpeg") //Output images
          {
            echo '<div class="item_container">';
            echo '<img src="' . $base . '/' . $file . '" alt="' . str_replace(("." . $ext), "", $file) . '">';
            echo '</div>';
          }
        if (($ext == "md" || $ext == "txt" || $ext == "html" || $ext == "htm") && $file != "index.md") //Output all markdownfiles except index.md
          {
            echo '<div class="item_container">';
            $index_content = file_get_contents($base . '/' . $file);
            $Parsedown     = new Parsedown();
            echo $Parsedown->text($index_content);
            echo '</div>';
          }
        if ($ext == "mp3") //Embed mp3-files in html5 audio-tag
          {
            echo '<div class="item_container">';
            echo '<audio controls><source src="' . $base . '/' . $file . '" type="audio/mpeg"></audio>';
            echo "<p>" . str_replace(("." . $ext), "", $file) . "</p>";
            echo '</div>';
          }
        if ($ext == "mp4") //Embed mp4-files in html5 video-tag
          {
            echo '<div class="item_container">';
            echo '<video controls><source src="' . $base . '/' . $file . '" type="video/mp4"></video>';
            echo "<p>" . str_replace(("." . $ext), "", $file) . "</p>";
            echo '</div>';
          }
      }
  }
echo '</div>'; // Closing #main_container
echo '</body>';
echo '</html>';
?>    