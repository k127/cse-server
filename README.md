# cse-server
Crowd Sourced Elevation

Development
===========
 
Arbeiten mit und in der Virtual Machine
=======================================
 
Setup nach dem Checkout des Projektes
-------------------------------------
* VirtualBox ggf. installieren
* [Vagrant](http://www.vagrantup.com/downloads.html) ggf. installieren 
* Erforderliche PlugIns (Installation mittels `vagrant plugin install $PLUGIN`)
    * Um die Virtual Hosts ueber ihren Hostnamen zu erreichen, wird eines der folgenden PlugIns benoetigt:
        * `PLUGIN=vagrant-dns` (nur fuer *Mac OS X*), Konfiguration: `vagrant dns --install` bzw. [vagrant-dns/README.md](https://github.com/BerlinVagrant/vagrant-dns)
        * `PLUGIN=vagrant-hostmanager`, Konfiguration: `vagrant hostmanager` bzw. [vagrant-hostmanager/README.md](https://github.com/smdahlen/vagrant-hostmanager)
 
Virtual Machine starten
-----------------------
* `vagrant up` (in `.../trunk`)

CSE Webservice aufrufen
-----------------------
    http://cse-api.dev/
    
REST-API testen
---------------
* PUT: `curl -vX PUT http://cse-api.dev/track -d '{"name": "foo", "points": [{"lat": 49.0, "lon": 12.0, "ele": 450.0}]}'`
  
Update der PHP-Pakete mit *composer*
------------------------------------
`/usr/bin/php composer.phar update`

DB-Schema aus `src/Classes/Models` mit *Doctrine2* erstellen
------------------------------------------------------------
    vagrant ssh
    cd /vagrant
    php vendor/bin/doctrine orm:schema-tool:drop --force
    php vendor/bin/doctrine orm:schema-tool:create

Troubleshooting
---------------

*TODO*

Useful Links
------------

* [best available php restful micro frameworks]
  (http://www.gajotres.net/best-available-php-restful-micro-frameworks/)
