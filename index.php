<?php header('Content-type: text/html; charset=utf-8'); ?>
<html>
<head><link rel="stylesheet" type="text/css" href="style.css"></head>
<?php include 'lib/parsedown.php'; ?>
<?php echo '<body>';    
// Get 
$base = $_GET['dir'];
// If frontpage
if(empty($base)) 
{    
$base = "content/";     
// Output index text    
if(file_exists($base . "index.md")) 
{
        echo '<div id="top_container">';
        $index_content = file_get_contents($base . "index.md");
        $Parsedown = new Parsedown();
        echo $Parsedown->text($index_content);
        echo '</div>';
}   
$files = scandir($base);
foreach ($files as $result) 
{
    if ($result === '.' or $result === '..') continue;
    
    if (is_dir($base . $result)) 
    {
        echo '<div class="item_container">';
        $title = str_replace("_", " ", $result);
        $link = str_replace("content/", "", $base);
        echo '<a href="' . $link . $result . '" class="menu_item" ><h1>' . $title . '</h1></a>';
        
        echo '<a href="' . $link . $result . '" class="menu_item" ><img src="' . $base . $result . '/featured.jpg"></a>';

        echo '</div>';
    }
}      
}
//If normal page
else
{     
$base = 'content/' . $base;                
// Clean directory names into titles
$title = str_replace("_", " ", $base);
$title = str_replace("/", "", $title);
$title = str_replace("content", "", $title);
// Back to index     
echo '<div id="index"><a href="index.php">Index</a><br></div>';
            echo '<div id="top_container">';

    echo '<h1>' . $title . '</h1>';
// Output index text    
if(file_exists($base . "/index.md"))
{
        $index_content = file_get_contents($base . "index.md");
        $Parsedown = new Parsedown();
        echo $Parsedown->text($index_content);
}
            echo '</div>';

//Write images in directory    
$files = scandir($base);    
foreach ($files as $file)
{ 
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if($ext == "jpg" || $ext == "png" || $ext == "gif" || $ext == "jpeg")
    {
    echo '<div class="item_container">';
    echo '<img src="' . $base . '/' . $file . '">';
    echo '</div>';       
    } else if($ext == "md" && $file != "index.md") {
    echo '<div class="item_container">';
    $index_content = file_get_contents($base . '/' . $file);
    $Parsedown = new Parsedown();
    echo $Parsedown->text($index_content);
    echo '</div>';       
    }
}

}
?>
</body>
</html>