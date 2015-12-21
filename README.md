# Italian petrol pumps comparator
![Italian petrol pumps comparator](http://fuel.reyboz.it/images/fuel-64px.png)

This web app allows you to list in a map and sort all fuel suppliers who are in a particular area, also it provides the current prices on every suppliers.

We have engineered this solution in a Hackathon that was sponsored by *Facile.it*, an Italian price comparator. This submission **won the competition**.

## Use
Use the http://fuel.reyboz.it online mirror. It has data updated on a daily basis.

## More about
Heroes and original technologies in the [/about.php](http://fuel.reyboz.it/about.php) page of the online mirror.

## Hacking
Clone the source code using Bazaar:

    bzr clone lp:it-fuel-stations-comparator

## Installation
This project is built over the [Boz-PHP - Another PHP framework](https://github.com/valerio-bozzolan/boz-php-another-php-framework). Install it in your `/usr/share`:

    bzr branch lp:boz-php-another-php-framework /usr/share/boz-php-another-php-framework

After that you only have to rename and fill the `load-sample.php` to `load.php` and import in MySQL/MariaDB the `database-schema.sql` from the `installation` folder.

## Import data from MISE
Please download data from the Italian [Ministero dello Sviluppo Economico](http://www.sviluppoeconomico.gov.it/index.php/it/open-data/elenco-dataset/2032336-carburanti-prezzi-praticati-e-anagrafica-degli-impianti):
 * http://www.sviluppoeconomico.gov.it/images/exportCSV/prezzo_alle_8.csv
 * http://www.sviluppoeconomico.gov.it/images/exportCSV/anagrafica_impianti_attivi.csv

They are released under the terms of the Italian [Open Data License v2.0](http://www.dati.gov.it/iodl/2.0/).

The `cli/import.php` can import them into your DB:

    php ./cli/import.php anagrafica_impianti_attivi.csv prezzo_alle_8.csv

## Pull requests
Push in Launchpad:

https://code.launchpad.net/it-fuel-stations-comparator

## License
This is a **Free** as in **Freedom** project. It comes with ABSOLUTELY NO WARRANTY. You are welcome to redistribute it under the terms of the **GNU Affero General Public License v3+**.
