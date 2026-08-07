<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : inc/config.php
PURPOSE      : NeoHadist configuration settings
AUTHOR       : CAHYA DSN
CREATED DATE : 2018-05-22 09:05:29
UPDATED DATE : 2026-08-07 09:02:10
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
session_start();
//-- 
define('_ISONLINE',false);
//-- assets folder
define('_ASSET','');
$app_name='NeoHadits!';
$keywords='kumpulan, hadits, bukhari, neo, islam, cahyadsn';
$c=isset($_SESSION['c'])?$_SESSION['c']:(isset($_GET['c'])?$_GET['c']:'indigo');
define("_AUTHOR","cahyadsn");
$_SESSION['c']=$c;
$_SESSION['author']='cahyadsn';
$_SESSION['ver']=sha1(rand());
$limit=10;
$offset=0;
//-- Load .env configuration
if (file_exists(dirname(__DIR__) . '/.env')) {
    $lines = file(dirname(__DIR__) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            if (preg_match('/^([\'"])(.*)\1$/', $val, $matches)) {
                $val = $matches[2];
            }
            putenv("$key=$val");
            $_ENV[$key] = $val;
            $_SERVER[$key] = $val;
        }
    }
}

//-- database configuration
$dbhost = getenv('DB_HOST') ?: 'localhost';
$dbuser = getenv('DB_USER') !== false ? getenv('DB_USER') : '';
$dbpass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$dbname = getenv('DB_NAME') ?: 'neo_hadits';
$version = getenv('APP_VER') ?: '1.0.0';
//-- database connection
$db=new mysqli($dbhost,$dbuser,$dbpass,$dbname);