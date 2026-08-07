<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : js/neohadits_js.php
purpose      : NeoHadist javascript file
AUTHOR       : CAHYA DSN
CREATED DATE : 2018-05-22 09:05:29
UPDATED DATE : 2026-08-07 09:14:39
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
header("Content-type: text/javascript");
$c=isset($_SESSION['c'])?$_SESSION['c']:(isset($_GET['c'])?$_GET['c']:'indigo');
if(isset($_SESSION['author']) && $_SESSION['author']=='cahyadsn'){
    $v=$_GET['v'];
    //session_destroy();
} else {
    unset($_SESSION['author']);
    die('illegal call');
}
?>
// Helper function to send POST requests in application/x-www-form-urlencoded format
function postData(url, data) {
    const params = new URLSearchParams();
    for (const key in data) {
        params.append(key, data[key]);
    }
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params
    }).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    });
}

var pesan = function(msg) {
    var msgBox = document.getElementById("msg_box");
    if (!msgBox) return;
    msgBox.innerHTML = msg;
    msgBox.classList.add("w3-red");
    msgBox.style.display = "block";
    msgBox.style.opacity = "1";
    setTimeout(function() {
        msgBox.style.transition = "opacity 0.5s";
        msgBox.style.opacity = "0";
        setTimeout(function() {
            msgBox.style.display = "none";
            msgBox.style.transition = "";
        }, 500);
    }, 2000);
}

var showHadits = function(no) {
    var loader = document.getElementById('id03');
    if (loader) loader.style.display = 'block';

    postData('inc/neohadits_ajax.php', { n: no })
        .then(data => {
            if (data.status) {
                document.getElementById('no_hdt').innerHTML = 'HADITS No. [' + data.data.no + ']';
                document.getElementById('kitab_hdt').innerHTML = 'KITAB : ' + data.data.kitab;
                document.getElementById('bab_hdt').innerHTML = 'BAB : ' + data.data.bab;
                document.getElementById('isi_indonesia').innerHTML = data.data.isi;
                document.getElementById('isi_arab').innerHTML = data.data.arab;
                
                var cariModal = document.getElementById('cari_modal');
                if (cariModal) cariModal.style.display = 'none';
            } else {
                document.getElementById('msg_box').innerHTML = data.error;
            }
            if (loader) loader.style.display = 'none';
        })
        .catch(err => {
            console.error(err);
            if (loader) loader.style.display = 'none';
        });
}

document.addEventListener('DOMContentLoaded', function() {
    //-- Dropdown click toggling
    document.querySelectorAll('.dropdown > button').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var content = this.nextElementSibling;
            if (content) {
                document.querySelectorAll('.dropdown-content').forEach(function(c) {
                    if (c !== content) {
                        c.classList.remove('show');
                    }
                });
                content.classList.toggle('show');
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-content').forEach(function(c) {
            c.classList.remove('show');
        });
    });

    //-- Theme change
    document.querySelectorAll('a.color').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            var a = this.getAttribute('data-value');
            if (typeof colors !== 'undefined' && colors[a]) {
                document.documentElement.style.setProperty('--accent-color', colors[a]);
                document.documentElement.style.setProperty('--accent-glow', colors[a] + '26');
            }
            document.querySelectorAll('a.color').forEach(function(btn) {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            postData('inc/change_color.php', { 'color': a });
        });
    });

    //-- Select Kitab change
    var slcKitab = document.querySelector('.slcKitab');
    if (slcKitab) {
        slcKitab.addEventListener('change', function() {
            var loader = document.getElementById('id03');
            if (loader) loader.style.display = 'block';

            postData('inc/neohadits_ajax.php', { k: this.value })
                .then(data => {
                    if (data.status) {
                        var slcBab = document.querySelector('select.slcBab');
                        if (slcBab) {
                            slcBab.innerHTML = "<option value=''>--Semua--</option>" + data.list;
                        }
                        var s = '';
                        for (var i = 0; i < 10; i++) {
                            if (data.data[i]) {
                                s += "<b><a href='#' class='item' onclick='showHadits(" + data.data[i][0] + ");return false;'>" + data.data[i][0] + "</a></b> " + data.data[i][1] + " ...<br>";
                            }
                        }
                        document.querySelectorAll('.hasil').forEach(function(el) {
                            el.style.display = 'block';
                        });
                        var listBox = document.getElementById('list_box');
                        if (listBox) {
                            listBox.innerHTML = s;
                        }
                    } else {
                        var msgBox = document.getElementById('msg_box');
                        if (msgBox) {
                            msgBox.innerHTML = data.error;
                        }
                    }
                    if (loader) loader.style.display = 'none';
                })
                .catch(err => {
                    console.error(err);
                    if (loader) loader.style.display = 'none';
                });
        });
    }

    //-- Select Bab change
    var slcBab = document.querySelector('.slcBab');
    if (slcBab) {
        slcBab.addEventListener('change', function() {
            var loader = document.getElementById('id03');
            if (loader) loader.style.display = 'block';

            postData('inc/neohadits_ajax.php', { b: this.value })
                .then(data => {
                    if (data.status) {
                        var s = '';
                        for (var i = 0; i < 10; i++) {
                            if (data.data[i]) {
                                s += "<b><a href='#' class='item' onclick='showHadits(" + data.data[i][0] + ");return false;'>" + data.data[i][0] + "</a></b> " + data.data[i][1] + " ...<br>";
                            }
                        }
                        document.querySelectorAll('.hasil').forEach(function(el) {
                            el.style.display = 'block';
                        });
                        var listBox = document.getElementById('list_box');
                        if (listBox) {
                            listBox.innerHTML = s;
                        }
                    } else {
                        var msgBox = document.getElementById('msg_box');
                        if (msgBox) {
                            msgBox.innerHTML = data.error;
                        }
                    }
                    if (loader) loader.style.display = 'none';
                })
                .catch(err => {
                    console.error(err);
                    if (loader) loader.style.display = 'none';
                });
        });
    }

    //-- Search button click
    var btnCari = document.getElementById('btnCari');
    if (btnCari) {
        btnCari.addEventListener('click', function(e) {
            e.preventDefault();
            var queryInput = document.getElementById('query');
            if (!queryInput) return;

            var loader = document.getElementById('id03');
            if (loader) loader.style.display = 'block';

            postData('inc/neohadits_ajax.php', { q: queryInput.value })
                .then(data => {
                    if (data.status) {
                        var s = '';
                        for (var i = 0; i < 10; i++) {
                            if (data.data[i]) {
                                s += "<b><a href='#' class='item' onclick='showHadits(" + data.data[i][0] + ");return false;'>" + data.data[i][0] + "</a></b> " + data.data[i][1] + " ...<br>";
                            }
                        }
                        document.querySelectorAll('.hasil').forEach(function(el) {
                            el.style.display = 'block';
                        });
                        var listBox = document.getElementById('list_box');
                        if (listBox) {
                            listBox.innerHTML = s;
                        }
                    } else {
                        var msgBox = document.getElementById('msg_box');
                        if (msgBox) {
                            msgBox.innerHTML = data.error;
                        }
                    }
                    if (loader) loader.style.display = 'none';
                })
                .catch(err => {
                    console.error(err);
                    if (loader) loader.style.display = 'none';
                });
        });
    }

    //-- Search toggle click
    var searchBtn = document.getElementById('search');
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var cariModal = document.getElementById('cari_modal');
            if (cariModal) {
                cariModal.style.display = 'flex';
            }
        });
    }

    //-- Perawi and Mushthalah click
    var perawiBtn = document.getElementById('perawi');
    var mushthalahBtn = document.getElementById('mushthalah');
    var clickHandler = function(e) {
        e.preventDefault();
        var modal = document.getElementById('id02');
        if (modal) {
            modal.style.display = 'flex';
        }
    };
    if (perawiBtn) perawiBtn.addEventListener('click', clickHandler);
    if (mushthalahBtn) mushthalahBtn.addEventListener('click', clickHandler);

    // Close modals when clicking outside the modal content card
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });
});