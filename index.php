<?
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


$ClientIP = getRealIpAddr();

echo "Server IP :". $_SERVER['SERVER_ADDR']."		";
echo "Your IP :". $ClientIP."		";
echo 'PHP version: ' . phpversion()."		";

$version = apache_get_version();
echo "Apache version:"."$version";

echo "User_Agent:".$_SERVER['HTTP_USER_AGENT'].PHP_EOL;
echo "------------------------------------------".PHP_EOL;

?>
