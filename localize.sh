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

# This script do the entire Gettext i18n workflow

# The copyright older of your localization
copyright="Valerio Bozzolan"

# The prefix of your localization's files
# (you have to know how Gettext works to change it).
package="fuel.reyboz.it"

# Generate/update the .pot file from the single script (index.php)
xgettext --copyright-holder="$copyright" --package-name=$package --from-code=UTF-8 --keyword=_e --default-domain=$package -o l10n/$package.pot *.php api/*.php includes/*.php

# Generate/update the .po files from the .pot file
find ./l10n/ -name \*.po -execdir msgmerge -o $package.po $package.po ../../$package.pot \;

# Generate/update the .mo files from .po files
find ./l10n/ -name \*.po -execdir msgfmt -o $package.mo $package.po \;
