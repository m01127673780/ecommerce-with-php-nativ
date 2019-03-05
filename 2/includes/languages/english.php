<?php

function lang($phrase){

	static $lang = array(
        // navbar
        'Home'      	=> 'Home',
        'Categories'	=> 'Categories',
        'Items'			=> 'Items',
        'Members'		=> 'Members',
        'Comments'      => 'Comments',
        'Statistics'	=> 'Statistics',
        'Logs'			=> 'Logs',
        'Admin'			=> 'Admin',
        'Edit profile'	=> 'Edit profile',
        'Settings'		=> 'Settings',
        'Logout'		=> 'Logout',


	);

return $lang[$phrase];
}


?>