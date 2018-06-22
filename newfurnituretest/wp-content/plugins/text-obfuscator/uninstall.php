<?php

/*

	Uninstall script for Text Obfuscator.

*/

#
#  uninstall.php
#
#  Created by Jonathon Wardman on 20-01-2012.
#  Copyright 2012, Jonathon Wardman. All rights reserved.
#
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  You may obtain a copy of the License at:
#  http://www.gnu.org/licenses/gpl-3.0.txt
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.

if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {

	delete_option( 'obfuscator_replacements' );
	delete_transient( 'obfuscator_new_pairs' );

}