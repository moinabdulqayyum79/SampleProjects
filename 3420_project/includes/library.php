<?php
// Get the acutal document and webroot path for virtual directories
$direx = explode('/', getcwd());
define('DOCROOT', "/$direx[1]/$direx[2]/"); // /home/username/
define('WEBROOT', "/$direx[1]/$direx[2]/$direx[3]/"); //home/username/public_html

/*############################################################
Function for connecting to the database
##############################################################*/

//From the Notes 
function checkErrors($filekey, $sizelimit){
    //modified from http://www.php.net/manual/en/features.file-upload.php
    try{
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if(!isset($_FILES[$filekey]['error']) || is_array($_FILES[$filekey]['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }
   
        // Check Error value.
        switch ($_FILES[$filekey]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return '0';
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }
   
        // You should also check filesize here.
        if ($_FILES[$filekey]['size'] > $sizelimit) {
            throw new RuntimeException('Exceeded filesize limit.');
        }
   
        if (exif_imagetype( $_FILES[$filekey]['tmp_name']) != IMAGETYPE_JPEG
            and exif_imagetype( $_FILES[$filekey]['tmp_name']) != IMAGETYPE_PNG){

            throw new RuntimeException('Invalid file format.');
     }
   //i just edited the function to either return the error message
   //or 0
        return '0';
   
    } catch (RuntimeException $e) {
   
        return $e->getMessage();
   
    }
}

function connectDB()
{
    // Load configuration as an array.
    $config = parse_ini_file(DOCROOT . "pwd/config.ini");
    $dsn = "mysql:host=$config[domain];dbname=$config[dbname];charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

    return $pdo;
}
function checkpwd($password){
    if (!preg_match('@[0-9]@', $password))
            return true;
        if (!preg_match('@[a-z]@', $password))
            return true;
        if (!preg_match('@[A-Z]@', $password))
            return true;
        if (!preg_match('@[^\w]@', $password))
            return true;
        if (strlen($password) < 8)
            return true;
        return false;
}
