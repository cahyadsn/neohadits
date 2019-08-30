<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
filename : inc/neohadits_ajax.php
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
session_start();
include 'config.php';
$r=array('status'=>false,'error'=>'an error occured');
if(isset($_POST['n']) && !empty($_POST['n'])){
	$sql="SELECT a.no_hdt,d.kitab_indonesia, c.bab_indonesia, a.isi_indonesia, a.isi_arab
		  FROM
		  hadits_bukhari a
		  JOIN tema_bukhari b USING(no_hdt)
		  JOIN databab_bukhari c ON (c.id_bab=b.id_bab AND c.id_kitab=b.id_kitab)
		  JOIN datakitab_bukhari d ON b.id_kitab=d.id_kitab
		  WHERE a.no_hdt={$_POST['n']}";
	$result=$db->query($sql);
	if(!empty($result)){
		$row=$result->fetch_object();
		$pattern=array('[',']');
		$replacer=array('<b>','</b>');
		$data=array(
			'no'=>$row->no_hdt,
			'kitab'=>$row->kitab_indonesia,
			'bab'=>$row->bab_indonesia,
			'isi'=>str_replace($pattern,$replacer,$row->isi_indonesia),
			'arab'=>$row->isi_arab
		);
		$r=array('status'=>true,'data'=>$data);
	}else{
		$r=array('status'=>false,'error'=>'data not found');
	}
}else{
	$sql="SELECT b.no_hdt,d.kitab_indonesia, c.bab_indonesia, SUBSTRING(b.tema_indonesia,1,100) AS isi
		  FROM
		  tema_bukhari b
		  JOIN databab_bukhari c ON (c.id_bab=b.id_bab AND c.id_kitab=b.id_kitab)
		  JOIN datakitab_bukhari d ON b.id_kitab=d.id_kitab
		  WHERE 1=1 "
		 .((isset($_POST['b']) && !empty($_POST['b']))?"AND c.id_bab={$_POST['b']} ":((isset($_POST['k']) && !empty($_POST['k']))?"AND d.id_kitab={$_POST['k']} ":''))
		 .((isset($_POST['q']) && !empty($_POST['q']))?"AND b.tema_indonesia LIKE '%{$_POST['q']}%' ":"")
		 ."LIMIT {$offset},{$limit}";
	$result=$db->query($sql);
	if(!empty($result)){
		$data=array();
		foreach($result as $row){
			$data[]=array($row['no_hdt'],$row['isi']);
		}
		if(isset($_POST['k']) && !empty($_POST['k'])){
			$list='';
			$sql="SELECT id_bab,bab_indonesia FROM databab_bukhari WHERE id_kitab={$_POST['k']} ORDER BY id_bab";
			$result=$db->query($sql);
			while ($d=$result->fetch_object()){
				$list.="<option value='{$d->id_bab}'>".ucwords(str_replace('"','&quot;',$d->bab_indonesia))."</option>";
			}
		}
		if(!empty($data)){
			if(!empty($list)){
				$r=array('status'=>true,'data'=>$data,'list'=>$list);
			}else{
				$r=array('status'=>true,'data'=>$data);
			}
		}else{
			$r=array('status'=>false,'error'=>'data not found');
		}
	}else{
		$r=array('status'=>false,'error'=>'data not found');
	}
}
header('Content-Type: application/json');
echo json_encode($r);