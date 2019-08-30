<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
filename : index.php
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

copyright (c) 2018-2019 by cahya dsn; cahyadsn@gmail.com
================================================================================
Shahih Bukhari
Shahih Muslim
Sunan Abu Daud
Sunan Tarmidzi
Sunan Nasa'i
Sunan Ibnu Majah
Musnad Ahmad
Muwattha' Malik
Sunan Ar Darimi
*/
session_start();
$c=isset($_SESSION['c'])?$_SESSION['c']:(isset($_GET['c'])?$_GET['c']:'indigo');
define("_AUTHOR","cahyadsn");
$_SESSION['c']=$c;
$_SESSION['author']='cahyadsn';
$_SESSION['ver']=sha1(rand());
include 'inc/config.php';
/*header('Expires: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');*/
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
    <title><?php echo "{$app_name} v {$version}";?></title>
    <meta charset="utf-8" />
    <meta http-equiv="expires" content="<?php echo date('r');?>" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="content-language" content="en" />
    <meta name="author" content="Cahya DSN" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <meta name="keywords" content="<?php echo $keywords;?>" />
    <meta name="description" content="<?php echo "{$app_name} v {$version}";?> created by cahya dsn, Kumpulan Hadits, dalam bahasa pemrograman PHP dan database MySQL" />
    <meta name="robots" content="index, follow" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-theme-<?php echo $c;?>.css" media="all" id="hadits_css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway" //-->
    <link rel="stylesheet" href="css/neohadits_css.php?v=<?php echo md5(filemtime('css/neohadits_css.php'));?>">
    </head>
    <body>
    <div class="w3-top">
        <div class="w3-bar w3-theme-d5">
            <span class="w3-bar-item"># NeoHadits v<?php echo $version;?></span>
            <button onclick="document.getElementById('id01').style.display='block'" class="w3-bar-item w3-button">Login</button>
            <div class="w3-dropdown-hover">
                <button class="w3-button">Menu</button>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <a href='#' class='w3-bar-item w3-button' id='search'>Cari Hadits</a>
                    <a href='#' class='w3-bar-item w3-button' id='perawi'>Perawi Hadits</a>
                    <a href='#' class='w3-bar-item w3-button' id='mushthalah'>Mushthalah Hadits</a>
                </div>
            </div>
            <div class="w3-dropdown-hover">
                <button class="w3-button">Themes</button>
                <div class="w3-dropdown-content w3-white w3-card-4" id="theme">
                    <?php
                    $color=array("black","brown","pink","orange","amber","lime","green","teal","purple","indigo","blue","cyan");
                    foreach($color as $clr){
                        echo "<a href='#' class='w3-bar-item w3-button w3-{$clr} color' data-value='{$clr}'> </a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="w3-container">
    <div class="w3-card-4">
        <h2>&nbsp;</h2>
        <div class="w3-panel w3-bar w3-theme-d3">
            <h3 class="w3-theme-d3"><?php echo "{$app_name} v {$version}";?></h3>
        </div>
        <div class="w3-container">
            <div class="w3-row">
                <div class="w3-col m12 w3-padding" id="msg_box"></div>
            </div>
        </div>
        <div id="preload" class="w3-bar w3-center"><img src="img/preload.svg"></div>
        <div class="w3-container w3-padding">
            <div class="w3-row">
                <div class="w3-card-4 w3-padding">
                    <header class="w3-container w3-theme-d2">
                    <h3>HADITS SHAHIH BUKHARI</h3>
                    </header>
                    <div class="w3-container w3-padding w3-responsive" id="hadits_box">
                    <?php
                    $pattern=array('[',']');
                    $replacer=array('<b>','</b>');
                    $sql="SELECT a.no_hdt,d.kitab_indonesia, c.bab_indonesia, a.isi_indonesia, a.isi_arab
                        FROM
                        hadits_bukhari a
                        JOIN tema_bukhari b USING(no_hdt)
                        JOIN databab_bukhari c ON (c.id_bab=b.id_bab AND c.id_kitab=b.id_kitab)
                        JOIN datakitab_bukhari d ON b.id_kitab=d.id_kitab
                        WHERE a.no_hdt=1
                        ";
                    $result=$db->query($sql);
                    $r=$result->fetch_object();
                    echo "<table class='w3-table w3-border w3-striped'>";
                    echo "<tr class='w3-theme-d3'><td id='kitab_hdt'>KITAB : {$r->kitab_indonesia}</td></tr>";
                    echo "<tr class='w3-theme-d4'><td id='bab_hdt'>BAB : {$r->bab_indonesia}</td></tr>";
                    echo "<tr class='w3-theme-d5'><td id='no_hdt'>Hadits No. [{$r->no_hdt}]</td></tr>";
                    echo "<tr><td style='font-size:2em;text-align:right;font-family:Cambria, Arial, sans-serif;'><p id='isi_arab'>{$r->isi_arab}</p></td></tr>";
                    echo "<tr><td><p id='isi_indonesia'>".str_replace($pattern,$replacer,$r->isi_indonesia)."</p></td></tr>";
                    echo "</table>";
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="w3-container w3-padding cari">
            <div class='w3-row'>
                <div class="w3-card-4 w3-padding">
                    <header class="w3-container w3-theme-d2">
                    <h3>Pencarian Kata</h3>
                    </header>
                    <form class="w3-container w3-padding">
                        <label class="w3-label">Pilih Kitab</label>
                        <select name="kitab" id="kitab" class="w3-select w3-hover-theme slcKitab" readonly>
                        <option value="">-- Semua --</option>
                        <?php
                        $result=$db->query("SELECT id_kitab,kitab_indonesia FROM datakitab_bukhari ORDER BY id_kitab");
                        while ($data=$result->fetch_object()){
                            echo "<option value='{$data->id_kitab}'>Kitab {$data->id_kitab} ".ucwords($data->kitab_indonesia).'</option>';
                        }
                        ?>
                        <select>
                        <label class="w3-label">Pilih Bab</label>
                        <select name="bab" id="bab" class="w3-select w3-hover-theme slcBab" >
                        <option value="">-- Semua --</option>
                        <?php
                        $result=$db->query("SELECT id_bab,bab_indonesia FROM databab_bukhari WHERE id_kitab=1 ORDER BY id_bab");
                        while ($data=$result->fetch_object()){
                            echo '<option value="'.$data->id_bab.'">'.ucwords($data->bab_indonesia).'</option>';
                        }
                        ?>
                        <select>
                        <label class="w3-label">Cari Kata</label>
                        <input type='text' class='w3-input w3-border' id='query'>
                        <button class="w3-btn w3-theme-d3" style='width:100% !important;margin-top:5px;' id='btnCari'>Cari</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="w3-container w3-padding hasil">
            <div class="w3-row">
                <div class="w3-card-4 w3-padding">
                    <header class="w3-container w3-theme-d2">
                    <h3>Hasil Pencarian</h3>
                    </header>
                    <div class="w3-container" id="list_box">
                    </div>
                </div>
            </div>
        </div>
        <div class="w3-theme-d5 w3-padding">source code : <a href='https://github.com/cahyadsn/neohadits'>https://github.com/cahyadsn/neohadits</a></div>
        </div>
        <h1 class='w3-padding'>&nbsp;</h1>
        <h2></h2>
    </div>
            <div id="id01" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                <div class="w3-center w3-theme-d1 w3-padding-16"><br>
                    <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                </div>
                <div class="w3-container">
                    <div class="w3-section">
                    <label><b>Username</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="usrname" required autocomplete="off">
                    <label><b>Password</b></label>
                    <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required autocomplete="off">
                    </div>
                </div>
                <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                    <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
                    <button class="w3-button w3-theme-d3" type="submit">Login</button>
                </div>
                </div>
            </div>
            <div id="id02" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                <div class="w3-center w3-theme-d1 w3-padding-16"><br>
                    <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                </div>
                <div class="w3-container">
                    <div class="w3-section">
                    <h2>Sorry for your inconvinience, this feature still under construction</h2>
                    </div>
                </div>
                <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                    <button onclick="document.getElementById('id02').style.display='none'" type="button" class="w3-button w3-red">Close</button>
                </div>
                </div>
            </div>
        <div id="id03" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
                <div class="w3-container">
                    <div class="w3-section">
                    <img src="img/preload.svg">
                    </div>
                </div>
                </div>
            </div>
    </div>
    <div class="w3-bottom">
        <div class="w3-bar w3-theme-d4 w3-center w3-padding">
            NeoHadits v<?php echo $version;?> copyright &copy; 2018<?php echo (date('Y')>2018?date('-Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a><br />
        </div>
    </div>
    </body>
    <script src="js/jquery.min.js"></script>
    <script src="js/neohadits_js.php?v=<?php echo $_SESSION['ver'];?>"></script>
</html>