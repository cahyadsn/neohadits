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
================================================================================*/
session_start();
$c=isset($_SESSION['c'])?$_SESSION['c']:(isset($_GET['c'])?$_GET['c']:'indigo');
define("_AUTHOR","cahyadsn");
$_SESSION['c']=$c;
$_SESSION['author']='cahyadsn';
$_SESSION['ver']=sha1(rand());
include 'inc/config.php';
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
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/neohadits.css?v=<?php echo md5(filemtime('css/neohadits.css'));?>" id="hadits_css">
    <script>
        const colors = {
            black: '#374151',
            brown: '#8b5cf6',
            pink: '#ec4899',
            orange: '#f97316',
            amber: '#f59e0b',
            lime: '#84cc16',
            green: '#22c55e',
            teal: '#14b8a6',
            purple: '#a855f7',
            indigo: '#6366f1',
            blue: '#3b82f6',
            cyan: '#06b6d4'
        };
        const initialColor = '<?php echo $c; ?>';
        document.documentElement.style.setProperty('--accent-color', colors[initialColor] || '#6366f1');
        document.documentElement.style.setProperty('--accent-glow', (colors[initialColor] || '#6366f1') + '26');
    </script>
    </head>
    <body>
    <header class="navbar">
        <a href="index.php" class="brand"># <span>NeoHadits</span></a>
        <div class="nav-links">
            <div class="dropdown">
                <button class="nav-item">Menu <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <a href='#' class='dropdown-item' id='search'>Cari Hadits</a>
                    <a href='#' class='dropdown-item' id='perawi'>Perawi Hadits</a>
                    <a href='#' class='dropdown-item' id='mushthalah'>Mushthalah Hadits</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="theme-pill">Theme <span class="theme-pill-dot"></span> <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content theme-presets">
                    <?php
                    $colors_hex = array(
                        "black" => "#374151",
                        "brown" => "#8b5cf6",
                        "pink" => "#ec4899",
                        "orange" => "#f97316",
                        "amber" => "#f59e0b",
                        "lime" => "#84cc16",
                        "green" => "#22c55e",
                        "teal" => "#14b8a6",
                        "purple" => "#a855f7",
                        "indigo" => "#6366f1",
                        "blue" => "#3b82f6",
                        "cyan" => "#06b6d4"
                    );
                    $color=array("black","brown","pink","orange","amber","lime","green","teal","purple","indigo","blue","cyan");
                    foreach($color as $clr){
                        $hex = isset($colors_hex[$clr]) ? $colors_hex[$clr] : '#6366f1';
                        $activeClass = ($clr === $c) ? ' active' : '';
                        echo "<a href='#' class='theme-preset-btn color{$activeClass}' data-value='{$clr}' style='background: {$hex}' title='{$clr}'></a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Message box -->
        <div id="msg_box"></div>

        <!-- Preloader -->
        <div id="preload"><img src="img/preload.svg" alt="Loading..."></div>

        <!-- Main Hadits Card -->
        <div class="glass-card">
            <div class="card-header">
                <h3>HADITS SHAHIH BUKHARI</h3>
            </div>
            <div id="hadits_box">
                <?php
                $pattern=array('[',']');
                $replacer=array('<b>','</b>');
                $sql="SELECT a.no_hdt,d.kitab_indonesia, c.bab_indonesia, a.tema_indonesia as isi_indonesia, a.tema_arab as isi_arab
                    FROM
                    tema_bukhari a
                    JOIN tema_bukhari b USING(no_hdt)
                    JOIN databab_bukhari c ON (c.id_bab=b.id_bab AND c.id_kitab=b.id_kitab)
                    JOIN datakitab_bukhari d ON b.id_kitab=d.id_kitab
                    WHERE a.no_hdt=1
                    ";
                $result=$db->query($sql);
                if ($result && $r=$result->fetch_object()) {
                    echo "<div class='hadits-meta' id='kitab_hdt'>KITAB : {$r->kitab_indonesia}</div>";
                    echo "<div class='hadits-meta' id='bab_hdt'>BAB : {$r->bab_indonesia}</div>";
                    echo "<div class='hadits-meta' id='no_hdt' style='font-weight:600;color:var(--accent-color)'>Hadits No. [{$r->no_hdt}]</div>";
                    echo "<div class='hadits-arab' id='isi_arab'>{$r->isi_arab}</div>";
                    echo "<div class='hadits-indo' id='isi_indonesia'>".str_replace($pattern,$replacer,$r->isi_indonesia)."</div>";
                }
                ?>
            </div>
        </div>

        <!-- Search Card -->
        <div class="glass-card cari">
            <div class="card-header">
                <h3>Pencarian Kata</h3>
            </div>
            <form>
                <div class="form-group">
                    <label class="form-label" for="kitab">Pilih Kitab</label>
                    <select name="kitab" id="kitab" class="form-select slcKitab">
                        <option value="">-- Semua --</option>
                        <?php
                        $result=$db->query("SELECT id_kitab,kitab_indonesia FROM datakitab_bukhari ORDER BY id_kitab");
                        while ($data=$result->fetch_object()){
                            echo "<option value='{$data->id_kitab}'>Kitab {$data->id_kitab} ".ucwords($data->kitab_indonesia).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="bab">Pilih Bab</label>
                    <select name="bab" id="bab" class="form-select slcBab">
                        <option value="">-- Semua --</option>
                        <?php
                        $result=$db->query("SELECT id_bab,bab_indonesia FROM databab_bukhari WHERE id_kitab=1 ORDER BY id_bab");
                        while ($data=$result->fetch_object()){
                            echo '<option value="'.$data->id_bab.'">'.ucwords($data->bab_indonesia).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="query">Cari Kata</label>
                    <input type='text' class='form-input' id='query' placeholder="Ketik kata kunci pencarian...">
                </div>
                <button class="btn" id='btnCari'><i class="fa fa-search" style="margin-right: 0.5rem;"></i> Cari</button>
            </form>
        </div>

        <!-- Results Card -->
        <div class="glass-card hasil">
            <div class="card-header">
                <h3>Hasil Pencarian</h3>
            </div>
            <div id="list_box">
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="id01" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sign In</h4>
                <button onclick="document.getElementById('id01').style.display='none'" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input class="form-input" type="text" placeholder="Enter Username" name="usrname" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input class="form-input" type="password" placeholder="Enter Password" name="psw" required autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="document.getElementById('id01').style.display='none'" type="button" class="btn" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); width: auto;">Cancel</button>
                <button class="btn" type="submit" style="width: auto;">Login</button>
            </div>
        </div>
    </div>

    <!-- Notice Modal -->
    <div id="id02" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notice</h4>
                <button onclick="document.getElementById('id02').style.display='none'" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p>Sorry for your inconvenience, this feature is still under construction.</p>
            </div>
            <div class="modal-footer">
                <button onclick="document.getElementById('id02').style.display='none'" type="button" class="btn" style="width: auto;">Close</button>
            </div>
        </div>
    </div>

    <!-- Global Preloader Modal -->
    <div id="id03" class="modal">
        <div class="modal-content" style="max-width: 120px; background: transparent; border: none; box-shadow: none;">
            <div class="modal-body" style="text-align: center;">
                <img src="img/preload.svg" alt="Loading..." style="width: 64px; height: 64px;">
            </div>
        </div>
    </div>

    <footer>
        NeoHadits v<?php echo $version;?> copyright &copy; 2018<?php echo (date('Y')>2018?date('-Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a><br />
        Source code: <a href='https://github.com/cahyadsn/neohadits' target="_blank">github.com/cahyadsn/neohadits</a>
    </footer>

    <script src="js/neohadits_js.php?v=<?php echo $_SESSION['ver'];?>"></script>
    </body>
</html>