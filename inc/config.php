<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
filename : inc/config.php
purpose  :
create   : 2018/05/22
last edit: 190830,180525
author   : cahya dsn
================================================================================
This program is free software; you can redistribute it and/or modify it under the
terms of the GNU General Public License as published by the Free Software
Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

copyright (c) 2018 by cahya dsn; cahyadsn@gmail.com
================================================================================*/
//-- 
define('_ISONLINE',false);
//-- assets folder
define('_ASSET','');
$version='0.1';
$app_name='NeoHadits!';
$keywords='kumpulan, hadits, bukhari, neo, islam, cahyadsn';
$limit=10;
$offset=0;
//-- database configuration
$dbhost='localhost';
$dbuser='root';
$dbpass='password';
$dbname='neohadits';
//-- database connection
$db=new mysqli($dbhost,$dbuser,$dbpass,$dbname);