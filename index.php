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

echo "Server IP Address:". $_SERVER['SERVER_ADDR']."		";
echo "Your IP Address:". $ClientIP.PHP_EOL;

//echo "test webhook relay";
/*
foreach (getallheaders() as $name => $value) {
    echo "$name: $value<br>\n";
}



*/
?>
