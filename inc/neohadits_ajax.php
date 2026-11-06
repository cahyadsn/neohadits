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
	$n = (int)$_POST['n'];
	$sql="SELECT a.no_hdt, d.kitab_indonesia, c.bab_indonesia, a.tema_indonesia AS isi_indonesia, a.tema_arab AS isi_arab
		  FROM
		  tema_bukhari a
		  JOIN databab_bukhari c ON (c.id_bab=a.id_bab AND c.id_kitab=a.id_kitab)
		  JOIN datakitab_bukhari d ON a.id_kitab=d.id_kitab
		  WHERE a.no_hdt=?";
	if ($stmt = $db->prepare($sql)) {
		$stmt->bind_param("i", $n);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result && $row=$result->fetch_object()){
			$pattern=array('[',']');
			$replacer=array('<b>','</b>');
			$data=array(
				'no'=>$row->no_hdt,
				'kitab'=>htmlspecialchars($row->kitab_indonesia, ENT_QUOTES, 'UTF-8'),
				'bab'=>htmlspecialchars($row->bab_indonesia, ENT_QUOTES, 'UTF-8'),
				'isi'=>str_replace($pattern,$replacer,htmlspecialchars($row->isi_indonesia, ENT_QUOTES, 'UTF-8')),
				'arab'=>htmlspecialchars($row->isi_arab, ENT_QUOTES, 'UTF-8')
			);
			$r=array('status'=>true,'data'=>$data);
		}else{
			$r=array('status'=>false,'error'=>'data not found');
		}
		$stmt->close();
	} else {
		$r=array('status'=>false,'error'=>'query preparation failed');
	}
}else{
	$sql="SELECT b.no_hdt, d.kitab_indonesia, c.bab_indonesia, SUBSTRING(b.tema_indonesia,1,100) AS isi
		  FROM
		  tema_bukhari b
		  JOIN databab_bukhari c ON (c.id_bab=b.id_bab AND c.id_kitab=b.id_kitab)
		  JOIN datakitab_bukhari d ON b.id_kitab=d.id_kitab
		  WHERE 1=1";
	
	$types = "";
	$params = [];
	
	if(isset($_POST['b']) && !empty($_POST['b'])){
		$sql .= " AND c.id_bab = ?";
		$types .= "i";
		$params[] = (int)$_POST['b'];
	}elseif(isset($_POST['k']) && !empty($_POST['k'])){
		$sql .= " AND d.id_kitab = ?";
		$types .= "i";
		$params[] = (int)$_POST['k'];
	}
	
	if(isset($_POST['q']) && !empty($_POST['q'])){
		$sql .= " AND b.tema_indonesia LIKE ?";
		$types .= "s";
		$query_raw = trim($_POST['q']);
		if (mb_strlen($query_raw, 'UTF-8') > 100) {
			$query_raw = mb_substr($query_raw, 0, 100, 'UTF-8');
		}
		$params[] = "%" . $query_raw . "%";
	}
	
	$sql .= " LIMIT ?, ?";
	$types .= "ii";
	$params[] = $offset;
	$params[] = $limit;
	
	if ($stmt = $db->prepare($sql)) {
		if (!empty($params)) {
			$stmt->bind_param($types, ...$params);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		
		$data=array();
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$data[]=array($row['no_hdt'], htmlspecialchars($row['isi'], ENT_QUOTES, 'UTF-8'));
			}
		}
		
		$list='';
		if(isset($_POST['k']) && !empty($_POST['k'])){
			$k = (int)$_POST['k'];
			$sql_list="SELECT id_bab,bab_indonesia FROM databab_bukhari WHERE id_kitab=? ORDER BY id_bab";
			if ($stmt_list = $db->prepare($sql_list)) {
				$stmt_list->bind_param("i", $k);
				$stmt_list->execute();
				$result_list = $stmt_list->get_result();
				while ($d=$result_list->fetch_object()){
					$list.="<option value='".(int)$d->id_bab."'>".htmlspecialchars(ucwords($d->bab_indonesia), ENT_QUOTES, 'UTF-8')."</option>";
				}
				$stmt_list->close();
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
		$stmt->close();
	} else {
		$r=array('status'=>false,'error'=>'query preparation failed');
	}
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($r);