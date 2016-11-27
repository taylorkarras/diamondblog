<?php
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php';
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/retrival.php';

$retrive = new DB_retrival;
$global = new DB_global;
unset($_SESSION["errors"]);
$imagedir = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');
for($i=0; $i<count($_FILES['uploadimage']['name']); $i++){
    ############ Edit settings ##############
    $UploadDirectory    = $imagedir['files_root']; //specify upload directory ends with / (slash)
	$UploadDirectoryFTP = $_SERVER['DOCUMENT_ROOT'].'/includes/console/scripts/ddcfinder/tmp/';
    ##########################################
    
    /*
    Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
    Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
    and set them adequately, also check "post_max_size".
    */
    
    //Is file size is less than allowed size.
    if ($_FILES["uploadimage"]["size"][$i] > 5242880) {
		$_SESSION['errors']['uploaderror'] = "File size is larger than 5MBs.";
		echo json_encode($_SESSION['errors']);
exit;
    }
    
    //allowed file type Server side check
    switch(strtolower($_FILES['uploadimage']['type'][$i]))
        {
            //allowed file types
            case 'image/png': 
            case 'image/gif': 
            case 'image/jpeg': 
            case 'image/pjpeg':
                break;
            default:
		$_SESSION['errors']['uploaderror'] = "File is not an image.";
		echo json_encode($_SESSION['errors']);
exit;
    }
    
    $File_Name          = strtolower($_FILES['uploadimage']['name'][$i]);
    $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
    $Random_Number      = $global->generate_code();
    $NewFileName        = $Random_Number.$File_Ext; //new file name

		  if($retrive->isftpenabled()){
move_uploaded_file($_FILES['uploadimage']['tmp_name'][$i], $UploadDirectoryFTP.$Random_Number.$File_Ext);
$ftpinit = $global->sqlquery("SELECT * FROM dd_storage");
$ftp = $ftpinit->fetch_assoc();
$conn_id = ftp_ssl_connect($ftp['ftp_server']);
$login_result = ftp_login($conn_id, $ftp['ftp_user'], $ftp['ftp_password']);
ftp_pasv($conn_id, true);

if (isset($_GET['dir'])){
if ($_GET['dir'] !== 'null'){
$directory = $ftp['ftp_directory'].$_GET['dir'].'/';
} else {
$directory = $ftp['ftp_directory'];
}} else {
$directory = $ftp['ftp_directory'];
}

if(ftp_chdir($conn_id, $directory) && ftp_put($conn_id, $Random_Number.$File_Ext, $UploadDirectoryFTP.$Random_Number.$File_Ext, FTP_BINARY) && unlink($UploadDirectoryFTP.$Random_Number.$File_Ext)){
} else {
$_SESSION['errors']['uploaderror'] = "There was an error uploading one of the file to the FTP server.";
echo json_encode($_SESSION['errors']);
unlink $UploadDirectoryFTP.$Random_Number.$File_Ext;
exit;
	  }
}else {
if (!move_uploaded_file($_FILES['uploadimage']['tmp_name'][$i], $_SERVER["DOCUMENT_ROOT"].$UploadDirectory.'/'.$Random_Number.$File_Ext)){
	$_SESSION['errors']['uploaderror'] = "There was an error uploading the file.";
echo json_encode($_SESSION['errors']);
exit;
}	
}}

$resp = array();
				$resp['uploadsuccess'] = true;
                echo json_encode($resp);
				unlink $UploadDirectoryFTP.$Random_Number.$File_Ext;
		        exit;
