# Italian fuel pumps comparator

This webapp creates an OpenStreetMap map with all fuel stations and their current prices.

We engineered this solution in a Hackathon that was organized by Facile.it in 2015. This submission **won the competition**.

## Use

You can just use this online mirror:

https://fuel.reyboz.it

It should have the data updated on a daily basis.

## More about

Heroes and original technologies in the about page:

https://fuel.reyboz.it/about.php

## Hacking

Clone the source code somewhere using git:

```
git clone https://gitpull.it/source/italian-fuel-comparator/
git clone https://gitpull.it/source/suckless-php/
```

Then enter in the directory of the main project and fill your configuration:

```
cd italian-fuel-comparator/
```

And fill the configuration:

```
cp installation/load-example.php load.php
nano load.php
```

Then you are ready to test:

```
cd italian-fuel-comparator
php -S localhost:8000
```

Have fun visiting this and working in realtime:

http://localhost:8000

NOTE: At this point you may still need some dependencies like jQuery. We don't have this problem because we have done `apt install libjs-jquery` in production in our Debian GNU/Linux webserver and it just works.

Read the next section.

## Database

Enter in MySQL and import the database schema. Example command:

```
mysql MY_DATABASE < installation/database-schema.sql
```

## Import data from MISE

Please download data from the Italian [Ministero dello Sviluppo Economico](http://www.sviluppoeconomico.gov.it/index.php/it/open-data/elenco-dataset/2032336-carburanti-prezzi-praticati-e-anagrafica-degli-impianti):
 * http://www.sviluppoeconomico.gov.it/images/exportCSV/prezzo_alle_8.csv
 * http://www.sviluppoeconomico.gov.it/images/exportCSV/anagrafica_impianti_attivi.csv

They are released under the terms of the Italian [Open Data License v2.0](http://www.dati.gov.it/iodl/2.0/).

### Manually import MISE .csv

The `cli/import-mise.php` helps you:

    php ./cli/import-mise.php

### Automatically download and import MISE .csv

Put a similar line in your `crontab -e`:

    /var/www/cli/download-import-mise.sh

.. or:

    su www-data -s /bin/sh -c /var/www/cli/download-import-mise.sh

## Pull requests

Pull requests are accepted via GitPull.it (funny) or via GitHub (simple).

GitPull.it repository:

* https://gitpull.it/source/italian-fuel-comparator/

GitHub repository:

* https://github.com/valerio-bozzolan/italian-fuel-stations-comparator

## Translations

Translations are easily made using GNU Gettext. See the `l10n/` folder structure. Use something as Poedit to edit existing `.po` files or to create a new one from the `.pot`.

Remember to run this command twice every time you want to start to translate some `.po` files:

```
./cli/localize.sh
```

## Bugs and Ideas

Any idea or any bug can be submitted on GitPull.it here:

* https://gitpull.it/tag/italian_fuel_comparator/

NOTE: GitPull.it has an automatic registration via GitHub.

If you don't want to create a bug request, just contact this person using the first email address in that list:

* https://boz.reyboz.it/

Thank you so much for your support!

## License

Copyright (C) 2015 Valerio Bozzolan, Marcelino Franchini, Fabio Mottan, Alexander Bustamente, Cesare de Cal, Edoardo de Cal

Copyright (C) 2016-2022 Valerio Bozzolan

This is a **Free** as in **Freedom** project. It comes with ABSOLUTELY NO WARRANTY. You are welcome to redistribute it under the terms of the **GNU Affero General Public License v3+**.

You can do whatever you want with this project, also for commercial purposes, but you have to give the same freedoms to everyone.
