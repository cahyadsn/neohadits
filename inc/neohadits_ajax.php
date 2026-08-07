<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : inc/neohadits_ajax.php
purpose      : NeoHadist ajax call process
AUTHOR       : CAHYA DSN
CREATED DATE : 2018-05-22 09:05:29
UPDATED DATE : 2026-08-07 09:13:22
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