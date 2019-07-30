
<?php
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
*/


/*===============dari==================*/

$myHost	= "10.1.49.6";
$myUser	= "nplnet";
$myPass	= "nplnet01";
$myDbs	= "hrd";

/*
$myHost	= "10.1.49.8";
$myUser	= "nplnet";
$myPass	= "nplnet01";
$myDbs	= "hrd";
*/
# Konek ke Server Sumber
$conn2	= mysql_connect($myHost, $myUser, $myPass);
if (! $conn2) {
  echo "Failed Connection  !".$myDbs;
}else{
	mysql_select_db($myDbs, $conn2);
	//echo "yesss";
}


/*====================Tujuan====================*/

$myHost	= "10.1.49.8";
$myUser	= "nplnet";
$myPass	= "nplnet01";
$myDbs	= "hrd";


/*
$myHost	= "10.1.49.8";
$myUser	= "nplnet";
$myPass	= "nplnet01";
$myDbs	= "hrd";
*/
# Konek ke Web Server Tujuan
$conn1	= mysql_connect($myHost, $myUser, $myPass);
if (! $conn1) {
  echo "Failed Connection  !".$myDbs;
}else{
	mysql_select_db($myDbs, $conn1);
	//echo "yesss";
}



//=============================================================================================

$iSkemaId=389;

//Proses 1
$sql = "SELECT * FROM hrd.pk_skema WHERE id='".$iSkemaId."'";
$row = mysql_fetch_array(mysql_query($sql,$conn2));
	$iPostId 		= $row['iPostId'];
	$iLevel 		= $row['iLevel'];
	$vName 			= $row['vName'];
	$cRequestor 	= $row['cRequestor'];
	$iActive 		= $row['iActive'];
	$iStatus 		= $row['iStatus'];
	$lDeleted 		= $row['lDeleted'];
	$cCreatedBy 	= $row['cCreatedBy'];
	$tCreated 		= $row['tCreated'];

$sqlins = "INSERT INTO hrd.pk_skema (iPostId,iLevel,vName,cRequestor,iActive,iStatus,lDeleted,cCreatedBy,tCreated)
	VALUES ('".$iPostId."','".$iLevel."','".$vName."','".$cRequestor."','".$iActive."','".$iStatus."','".$lDeleted."','".$cCreatedBy."','".$tCreated."')";
mysql_query($sqlins,$conn1);




//proses 2;
//cari

$sql = "SELECT id FROM hrd.pk_skema WHERE vName='".$vName."' order by id DESC limit 1 ";
$row = mysql_fetch_array(mysql_query($sql,$conn1));
	$newiSkemaId = $row['id'];


$sql = "SELECT * FROM hrd.pk_group_aspek WHERE iSkemaId='".$iSkemaId."'";
$result = mysql_query($sql,$conn2);
while ($rows = mysql_fetch_array($result)){
	$iMsGroupAspekId = $rows['iMsGroupAspekId'];
	$nBobot 	= $rows['nBobot'];
	$lDeleted 	= $rows['lDeleted'];
	$tUpdated 	= $rows['tUpdated'];
	$cUpdatedBy = $rows['cUpdatedBy'];
	$cCreatedBy = $rows['cCreatedBy'];
	$tCreated 	= $rows['tCreated'];

	$sqlins = "INSERT INTO hrd.pk_group_aspek
	(iSkemaId,iMsGroupAspekId,nBobot,lDeleted,cCreatedBy,tCreated)
	VALUES
	('".$newiSkemaId."','".$iMsGroupAspekId."','".$nBobot."','".$lDeleted."','".$cCreatedBy."','".$tCreated."');";
	mysql_query($sqlins,$conn1);


}


//proses 3
$sql = "SELECT *  FROM pk_aspek WHERE iSkemaId ='".$iSkemaId."' ";
$result = mysql_query($sql,$conn2);
while ($rows = mysql_fetch_array($result)){
	$id 				= $rows['id'];
	$iMsGroupAspekId 	= $rows['iMsGroupAspekId'];
	$iUrut 				= $rows['iUrut'];
	$vAspekName 		= $rows['vAspekName'];
	$nBobot 			= $rows['nBobot'];
	$lAutoCalculation 	= $rows['lAutoCalculation'];
	$vFunctionLink 		= $rows['vFunctionLink'];
	$iSupportData 		= $rows['iSupportData'];
	$iSupportData 		= $rows['iSupportData'];
	$lDeleted 			= $rows['lDeleted'];
	$tUpdated 			= $rows['tUpdated'];
	$cUpdatedBy 		= $rows['cUpdatedBy'];
	$cCreatedBy 		= $rows['cCreatedBy'];
	$tCreated 			= $rows['tCreated'];
	echo $vAspekName."<bt />";
	$sql = "INSERT INTO hrd.pk_aspek (iSkemaId,iMsGroupAspekId,iUrut,vAspekName,nBobot,
	lAutoCalculation,vFunctionLink,iSupportData,lDeleted,cCreatedBy,tCreated) VALUES
		('".$newiSkemaId."','".$iMsGroupAspekId."','".$iUrut."','".$vAspekName."','".$nBobot."','".$lAutoCalculation."','".$vFunctionLink."',
		'".$iSupportData."','".$lDeleted."','".$cCreatedBy."','".$tCreated."')  ";

	mysql_query($sql,$conn1);

	//cari last id pkaspek
	$sql = "SELECT id FROM hrd.pk_aspek WHERE vAspekName='".$vAspekName."' order by id DESC limit 1";
	$row = mysql_fetch_array(mysql_query($sql,$conn1));
	$newiAspekId = $row['id'];

	//insert detailnya
	$sqld = "SELECT * FROM hrd.pk_aspek_detail WHERE iAspekId='".$id."'";
	$resultd = mysql_query($sqld,$conn2);
	while ($r = mysql_fetch_array($resultd)){
		$vDescription 	= $r['vDescription'];
		$nPoint 		= $r['nPoint'];
		$yNilai1 		= $r['yNilai1'];
		$yNilai2 		= $r['yNilai2'];
		$lDeleted 		= $r['lDeleted'];
		$tCreated 		= $r['tCreated'];
		$cCreatedBy		= $r['cCreatedBy'];
		$tUpdated		= $r['tUpdated'];
		$cUpdatedBy		= $r['cUpdatedBy'];

		$sqlinsd = "INSERT INTO hrd.pk_aspek_detail (iAspekId,vDescription,nPoint,yNilai1,yNilai2,lDeleted,tUpdated,cUpdatedBy,cCreatedBy,tCreated)
					VALUES ('".$newiAspekId."','".$vDescription."','".$nPoint."','".$yNilai1."','".$yNilai2."','".$lDeleted."','".$tUpdated."','".$cUpdatedBy."',
					'".$cCreatedBy."','".$tCreated."') ";
		mysql_query($sqlinsd,$conn1);
	}


}




?>
