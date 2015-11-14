<?php
require 'load.php';

echo("<div>CIAO</div>");
// Ogni volta che lancio svuota il DB e lo riempe di merda

$db->query("TRUNCATE station");
$db->query("TRUNCATE price");

echo("<div>STAR Tabella price</div>");
try
    {
      $fileName = 'import/prezzo_alle_8.csv';
      if ( !file_exists($fileName) ) {
        throw new Exception('File not found.');
      }
      $handle = fopen($fileName, "r");
      if ( !$handle ) {
        throw new Exception('File open failed.');
      }
      fgetcsv($handle); // get line 0 and move pointer to line 1
      fgetcsv($handle); // get line 1 and move pointer to line 2
			while(($data = fgetcsv($handle, 255, ";")) !== FALSE) {
				$db->insertRow(
					'price',
					[
						new DBCol('idImpianto', intval($data[0]), 'd'),
						new DBCol('descCarburante', $data[1], 's'),
						new DBCol('prezzo', floatval($data[2]), 'f'),
						new DBCol('isSelf', intval($data[3]), 'd'),
						new DBCol('dtComu', $data[4], 's')
					]
				);
			}
      fclose($handle);
      // send success JSON

    } catch ( Exception $e ) {
      // send error message if you can
			echo($e->getMessage());
    }
echo("<div>END Tabella price</div>");
echo("<div>STAR Tabella station</div>");
try
    {
      $fileName = 'import/prezzo_alle_8.csv';
      if ( !file_exists($fileName) ) {
        throw new Exception('File not found.');
      }
      $handle = fopen($fileName, "r");
      if ( !$handle ) {
        throw new Exception('File open failed.');
      }
      fgetcsv($handle); // get line 0 and move pointer to line 1
      fgetcsv($handle); // get line 1 and move pointer to line 2
			while(($data = fgetcsv($handle, 255, ";")) !== FALSE) {
				$db->insertRow(
					'station',
					[
						new DBCol('idImpianto', intval($data[0]), 'd'),
						new DBCol('gestore', $data[1], 's'),
            new DBCol('bandiera', $data[2], 's'),
            new DBCol('tipoImpianto', $data[3], 's'),
            new DBCol('nomeImpianto', $data[4], 's'),
            new DBCol('indirizzo', $data[5], 's'),
            new DBCol('comune', $data[6], 's'),
            new DBCol('provincia', $data[7], 's'),
						new DBCol('latitudine', floatval($data[8]), 'f'),
						new DBCol('longitudine', intval($data[9]), 'f')
					]
				);
			}
      fclose($handle);
      // send success JSON

    } catch ( Exception $e ) {
      // send error message if you can
			echo($e->getMessage());
    }
echo("<div>END Tabella station</div>");
echo("<div>FINE</div>");
