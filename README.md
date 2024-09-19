
# OSIRIS Gästeformulare

Dieses Addon erlaubt Euch, OSIRIS zu nutzen, um Gäste anzumelden.


## CONFIG.php

Die Datei `CONFIG.default.php` muss kopiert und in `CONFIG.php` umbenannt werden. Passt dort eure Parameter an. 

Wichtig ist der `SECRET_KEY`, er muss exakt mit dem in den OSIRIS-Einstellungen verwendeten Key (Admin > Funktionen > Gäste) übereinstimmen und sollte nicht leicht zu erraten sein. Wenn die Keys nicht übereinstimmen, wird die Übertragung zwischen den Servern nicht funktionieren, also achtet bitte darauf.

## In einem Unterordner installieren

OSIRIS Guests lässt sich auch in einem Unterordner installieren. Dafür müssen der `ROOTPATH` in der `CONFIG.php` und die `RewriteBase` in der `.htaccess`-Datei angepasst werden. Wenn ihr die `.htaccess`-Datei anpasst, solltet ihr dafür sorgen, dass git sie nicht wieder überschreibt:

```bash
git update-index --assume-unchanged .htaccess
```


<!-- ## Gästeformulare auf dem gleichen Server

In manchen Fällen ist 
Wenn ihr die Gästeformulare auf dem gleichen Server wie OSIRIS installiert, könnt ihr dies in einen  -->


