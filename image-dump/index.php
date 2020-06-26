<?php 

/* settings */
$dir = "images"; //directory containing images
$max_page = 12; //pics per page 


?>
<!DOCTYPE html>
<html>
<head>
     <title>NGINX CDN Demo</title>
     <link href='style.css' rel='stylesheet' />   
</head>
<script src='jquery-1.11.3.min.js'></script>
<script language="JavaScript" src="PageLoadTime.js"></script>
     <body>The code to this project is on <a href="https://github.com/jessegoodier/docker-backend-site-for-CDN-demo">github</a>.
     <p>This is the actual web server in Singapore.
    Caching site in Ohio:<a href="http://aws-ohio.nginx.rocks">http://aws-ohio.nginx.rocks</a></p>
<script language="JavaScript">
PLT_DisplayFormat = "Your connection took %%S%% seconds to load the page.";
PLT_BackColor = "palegreen";
PLT_ForeColor = "navy";
PLT_FontPix = "16";
PLT_DisplayElementID = "display_here";
</script>
<span id="display_here"></span>
    <div class="lightbox">
        <div class='lightbox-background'></div>
        <div class='lightbox-content'>
            
        </div>
    </div>
    <div class='images'>
        
        <?php

        
        $files = glob($dir .'/*.*');
        $page = 1;
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];
        }
        $files_paged = array_chunk($files,$max_page);
        
        /* if there's no thumbnails dir, make dir and a thumbnail for each file */ 
        if (!file_exists('thumbnails/' . $dir)) {
            set_time_limit(0);//prevent timing when making the thumbnails
            mkdir('thumbnails/' . $dir, 0755, true);
            foreach($files as $file) {
                if (!file_exists("thumbnails/" . $file)) {
                    make_thumb($file,"thumbnails/" . $file, 300);
                }  
            }   
        }
        
        if (count($files_paged)) 
        foreach($files_paged[$page-1] as $file) {
            if (!file_exists("thumbnails/" . $file)) {
                make_thumb($file,"thumbnails/" . $file, 300);
            }
            $name = preg_replace('/^' . $dir . '\//', '', $file);
            echo imageHtml($file,$name,$dir);
        }
        if (count($files_paged)>1){
            echo paginationHtml($files_paged,$page);
        }
        
        
        /* functions to generate html */
        function imageHtml($file,$name,$dir){
            return "<div class='image' title='" . $name . "'><a href='" . $file . "'><img src='thumbnails/" . $file . "'></a></div>";
        }
        function paginationHtml($paginated,$page){
            $n = 1;
            $html = "<div class='pagination'>"; 
            while ($n <= count($paginated)){
                if (($page) == $n)$html .= pageHtml($n);
                else $html .= pageLinkHtml($n);
                $n++;
            }
            return $html;
        }
        function pageLinkHtml($n){
            if ($n == 1) return "<a href='?'>{$n}</a>";
            return "<a href='?page={$n}'>{$n}</a>";
        }
        function pageHtml($n){
            return "<span>{$n}</span>";
        }
        
        /* make da thumbnails - david walsh*/
        function make_thumb($src, $dest, $desired_width) {
            $source_image = imagecreatefromjpeg($src);
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            //$desired_height = floor($height * ($desired_width / $width));
            $virtual_image = imagecreatetruecolor($width, $height);
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $width, $height, $width, $height);
            imagejpeg($virtual_image, $dest);
        }
        ?>
        
    </div>

<script>
$(".lightbox").hide();
$("body").fadeIn();
$(".lightbox-background").click(function(){
    $(".lightbox").fadeOut();
})
$(".image").click(function(event){
    if (!event.metaKey) {
        event.preventDefault(); 
        var src = $(this).find("a").attr("href");
        var elem = $(this).clone().find("img").attr("src",src);
        $(".lightbox-content").html(elem);
        $(".lightbox").fadeIn(); 
    }
})
</script>
</body>
</html>
