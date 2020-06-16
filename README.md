# image-dump for NGINX Plus CDN Demo (uses nginx OSS)
Creates a docker container to use as a target for a CDN demo. I use this backend that I put in Asia: <https://github.com/jessegoodier/docker-backend-site-for-CDN-demo>

All images are mine and free to share.

forked from: <https://github.com/danyalette/image-dump>


Easily display all the images in a directory. 

This script generates a thumbnail for each image, and displays the thumbnails in a grid. 
Clicking on thumbnails opens a lightbox. 

###settings

(index.php)

`$dir = "images"; //directory containing images`  

`$max_page = 12; //pics per page`


###notes
- requires the PHP GD library 
- you will probably have to change some permissions in order to allow index.php to create the thumbnail directory and save images to that directory
