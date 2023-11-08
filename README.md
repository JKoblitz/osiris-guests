
# OSIRIS Gästeformulare

Dieses Addon erlaubt Euch, OSIRIS zu nutzen, um Gäste anzumelden.


## CONFIG.php

Die Datei `CONFIG.default.php` muss kopiert und in `CONFIG.php` umbenannt werden. Passt dort eure Parameter an.
Alternativ könnt ihr auch einfach eure `CONFIG.php` von OSIRIS kopieren, das sollte auch funktionieren.


## .htaccess
Damit der Server funktioniert muss eine `.htaccess`-Datei im Root angelegt werden.

```apache
DirectoryIndex index.php

# enable apache rewrite engine
RewriteEngine on

# set your rewrite base
RewriteBase /

# Deliver the folder or file directly if it exists on the server
RewriteRule ^(css|img|js|uploads|settings.json|data)($|/) - [L]

# Push every request to index.php
RewriteRule ^(.*)$ index.php [QSA]
```


<!-- ## Gästeformulare auf dem gleichen Server

In manchen Fällen ist 
Wenn ihr die Gästeformulare auf dem gleichen Server wie OSIRIS installiert, könnt ihr dies in einen  -->


