#!/bin/bash
#############################################################################
#
# Copyright (C) 2015, 2021  Valerio Bozzolan
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

# You are wrong.. I'm not curl!
not_really_curl() {
	local url="https://www.mise.gov.it/images/exportCSV/$1"

	curl "$url" \
		--output "$2" \
		--header 'User-Agent: Mozilla/5.0 (X11; Debian; Linux x86_64; rv:39.0) Gecko/20100101 Iceweasel/39.0' \
		--header 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' \
		--header 'Accept-Language: en-US,it-IT;q=0.8,it;q=0.5,en;q=0.3' \
		--header 'Connection: keep-alive' \
		--compressed \
		--silent
}

stations="stations.csv"
prices="prices.csv"

# download shit
not_really_curl "anagrafica_impianti_attivi.csv" "$stations"
not_really_curl "prezzo_alle_8.csv"              "$prices"

# import shit
php "$(dirname $0)"/import-mise.php "$stations" "$prices"
