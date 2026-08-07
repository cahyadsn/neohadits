<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : index.php
purpose      : NeoHadist main page
AUTHOR       : CAHYA DSN
CREATED DATE : 2018-05-22 09:05:29
UPDATED DATE : 2026-08-07 10:27:39
DEMO SITE    : 
SOURCE CODE  : https://github.com/cahyadsn/neohadist
================================================================================
This program is free software; you can redistribute it and/or modify it under the
terms of the MIT License.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

See the MIT License for more details

copyright (c) 2018-2026 by cahya dsn; cahyadsn@gmail.com
================================================================================*/
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
        <a href="index.php" class="brand"># <span>NeoHadits v<?php echo $version;?></span></a>
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
                <div class="dropdown-content">
					<div class="theme-presets">
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

    <!-- Search Modal -->
    <div id="cari_modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pencarian Kata</h4>
                <button onclick="document.getElementById('cari_modal').style.display='none'" class="modal-close">&times;</button>
            </div>
            <form>
                <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
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
                    
                    <!-- Search Results inside modal body -->
                    <div class="glass-card hasil" style="margin-top: 1.5rem; margin-bottom: 0; padding: 1.25rem;">
                        <div class="card-header" style="padding-bottom: 0.5rem; margin-bottom: 0.75rem;">
                            <h3 style="font-size: 0.95rem;">Hasil Pencarian</h3>
                        </div>
                        <div id="list_box" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-primary);">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="document.getElementById('cari_modal').style.display='none'" type="button" class="btn" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); width: auto;">Batal</button>
                    <button class="btn" id='btnCari' style="width: auto;"><i class="fa fa-search" style="margin-right: 0.5rem;"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        NeoHadits v<?php echo $version;?> copyright &copy; 2018<?php echo (date('Y')>2018?date('-Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a><br />
        Source code: <a href='https://github.com/cahyadsn/neohadits' target="_blank">github.com/cahyadsn/neohadits</a>
    </footer>

    <script src="js/neohadits_js.php?v=<?php echo $_SESSION['ver'];?>"></script>
    </body>
</html>