sassolino
=========

A very small flat-file CMS. 

Made by [PWR Studio](http://www.pwr-stud.io) at [Sasso Residency](http://www.sasso-residency.ch/)

[Example site](http://www.pwr-stud.io/sassolino)

sassolino will output a simple website from a structure of folders. If will create a page for each folder and automatically show the files within.

Currently the following material will be shown 
- Text (.md, .txt, .html)
- Images (.jpg, .png, .gif)
- Audio (mp3)
- Video (mp4)
- Embedded players like youtube, soundcloud, etc... (Embed code in text-file)

##Install

(1) Put the files in the root folder of your server.

(2) Rename the file “htaccess” to “.htaccess”

If the site is installed in a subfolder of your webserver (eg. www.server.com/subfolder/) change the line RewriteBase / into RewriteBase /subfolder/ in the files .htaccess.

##Use

Your site goes in the “content” directory. Create a folder to create a new page. The name of the folder is the title of the page. Underscore will be replaced with a space.

sassolino uses [markdown](https://help.github.com/articles/markdown-basics) to format text. You can also use plain text or html.

The file “index.md”, if present, will go at the top of the page. Everything else in alphabetical order underneath. 

The front page is a simple index with the first (alphabetically) image of each folder used as preview. If the file “index.md” is present in the root of the “content” folder it will be shown.

The appearance of the site can be changed by editing “style.css”.
