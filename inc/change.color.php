<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
filename : inc/change_color.php
purpose  :
create   : 2018/05/23
last edit: 2018/05/24
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
if(isset($_POST)){
    session_start();
    $_SESSION['c']=$_POST['color'];
}