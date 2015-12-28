#!/bin/sh
#############################################################################
#
# Copyright (C) 2015  Valerio Bozzolan
#
#############################################################################
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#############################################################################

# This script downloads two files from the MISE and import them

path="$1"
if [ -z "$path" ]; then
	echo "Usage:   $0 IMPORTER"
	echo "Example: $0 \"php /var/www/cli/import-mise.php\""
	echo "The IMPORTER will receive two args: the petrol stations and the prices, as downloaded from the MISE"
	exit 1;
fi

# You are wrong.. I'm not curl!
wgets() {
	curl "http://www.sviluppoeconomico.gov.it/images/exportCSV/$1" -o "$2" \
	-H 'Host: www.sviluppoeconomico.gov.it' \
	-H 'User-Agent: Mozilla/5.0 (X11; Debian; Linux x86_64; rv:39.0) Gecko/20100101 Iceweasel/39.0' \
	-H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' \
	-H 'Accept-Language: en-US,it-IT;q=0.8,it;q=0.5,en;q=0.3' \
	--compressed -H 'Connection: keep-alive' \
	--silent
}

stations="$(mktemp)"
prices="$(mktemp)"

wgets "anagrafica_impianti_attivi.csv" "$stations"
wgets "prezzo_alle_8.csv"              "$prices"

# This will be something as:
# php .cli/import-mise.php /tmp/tmp.asduioasd /tmp/tmp.oisuodiasu
$1 "$stations" "$prices"

rm "$stations" "$prices"
