<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
filename : neohadits_js.php
purpose  :
create   : 2018/05/22
last edit: 190830,180522
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
var pesan=function(msg){
    $("#msg_box").html(msg);
    $("#msg_box").addClass("w3-red");
    $("#msg_box").show();
    $("#msg_box").delay(2000).fadeOut();
}
var showHadits=function(no){
    $('#id03').show();
    $.post(
        'inc/neohadits_ajax.php',
        {n:no},
        function(data){
            if(data.status){
                $('#no_hdt').html('HADITS No. ['+data.data.no+']');
                $('#kitab_hdt').html('KITAB : '+data.data.kitab);
                $('#bab_hdt').html('BAB : '+data.data.bab);
                $('#isi_indonesia').html(data.data.isi);
                $('#isi_arab').html(data.data.arab);
            }else{
                $('#msg_box').html(data.error);
            }
            $('#id03').hide();
        }
    );
}
$(document).ready(function(){
    //--
    $('a.color').on('click',function() {
    var a = $(this).attr('data-value');
    document.getElementById('hadits_css').href = 'css/w3-theme-' + a + '.css';
    $.post('inc/change.color.php', {
        'color': a
    })
    });
    //--
    $('.slcKitab').on('change',function(){
        $('#id03').show();
        $.post(
            'inc/neohadits_ajax.php',
            {k:$('.slcKitab').val()},
            function(data){
                if(data.status){
                    $('select.slcBab').html("<option value=''>--Semua--</option>"+JSON.stringify(data.list));
                    var s='';
                    for(i=0;i<10;i++){
                        if(data.data[i]){
                            s+="<b><a href='#' class='item' onclick='showHadits("+data.data[i][0]+");return false;'>"+data.data[i][0]+"</a></b> "+data.data[i][1]+" ...<br>";
                        }
                    }
                    $('.hasil').show();
                    $('#list_box').html(s);
                }else{
                    $('#msg_box').html(data.error);
                }
                $('#id03').hide();
            }
        );
    });
    //--
    $('.slcBab').on('change',function(){
        $('#id03').show();
        $.post(
            'inc/neohadits_ajax.php',
            {b:$('.slcBab').val()},
            function(data){
                if(data.status){
                    var s='';
                    for(i=0;i<10;i++){
                        if(data.data[i]){
                            s+="<b><a href='#' class='item' onclick='showHadits("+data.data[i][0]+");return false;'>"+data.data[i][0]+"</a></b> "+data.data[i][1]+" ...<br>";
                        }
                    }
                    $('.hasil').show();
                    $('#list_box').html(s);
                }else{
                    $('#msg_box').html(data.error);
                }
                $('#id03').hide();
            }
        );
    });
    //--
    $('#btnCari').on('click',function(e){
        e.preventDefault();
        $('#id03').show();
        $.post(
            'inc/neohadits_ajax.php',
            {q:$('#query').val()},
            function(data){
                if(data.status){
                    var s='';
                    for(i=0;i<10;i++){
                        if(data.data[i]){
                            s+="<b><a href='#' class='item' onclick='showHadits("+data.data[i][0]+");return false;'>"+data.data[i][0]+"</a></b> "+data.data[i][1]+" ...<br>";
                        }
                    }
                    $('.hasil').show();
                    $('#list_box').html(s);
                }else{
                    $('#msg_box').html(data.error);
                }
                $('#id03').hide();
            }
        );
    });
    //--
    $('#search').on('click',function(e){
        e.preventDefault();
        $('.cari').show();;
    });
    //--
    $('#perawi, #mushthalah').on('click',function(e){
        e.preventDefault();
        $('#id02').show();
    });
});