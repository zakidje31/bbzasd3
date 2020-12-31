<?php 
session_start();
error_reporting(0);

$site_title = "-=[ zaki&trade; ]=-";

// using banned in role will show user that he is banned when he try to login . 
$users = array(
               "1516" => array("name" => "zaki31", "role"=> "admin"),
               );

if(isset($_SESSION['logged']) && !isset($users[$_SESSION['password']]) || $users[$_SESSION['password']]['role'] == 'banned'){
      unset($_SESSION['logged']);
      unset($_SESSION['password']);
      unset($_SESSION['username']);
}

if(!isset($_SESSION['logged']) || $_SESSION['logged'] ==  false){
	$showlogin = true;
	$loginerror = "";
	
   if(isset($_POST['password'])){

      $password = $_POST['password'];

    if(!empty($password)){

      if(isset($users[$password])){
        
         if($users[$password]['role'] !== 'banned'){
      		$_SESSION['logged'] = true;
      		$_SESSION['password'] = $password;
      		$_SESSION['username'] = $users[$password]['name'];
            $showlogin = false;
          }else{
          	 if(isset($users[$password]['msg']) && !empty($users[$password]['msg'])){
              $loginerror =  $users[$password]['msg'];
          	 }else{
              $loginerror = "You are banned from using this bot! Get out of here!";
            }
          }
      }else{
       	  $loginerror = "Wrong Password!";
      }

     }else{
     	$loginerror = "Please enter Password!";
     }
  }
}

 ?>
 <script>

var bits=50; // how many bits
var speed=20; // how fast - smaller is faster
var bangs=9; // how many can be launched simultaneously (note that using too many can slow the script down)
var colours=new Array("#03f", "#f03", "#0e0", "#93f", "#0cf", "#f93", "#f0c");

var bangheight=new Array();
var intensity=new Array();
var colour=new Array();
var Xpos=new Array();
var Ypos=new Array();
var dX=new Array();
var dY=new Array();
var stars=new Array();
var decay=new Array();
var swide=800;
var shigh=600;
var boddie;
window.onload=function() { if (document.getElementById) {
  var i;
  boddie=document.createElement("div");
  boddie.style.position="fixed";
  boddie.style.top="0px";
  boddie.style.left="0px";
  boddie.style.overflow="visible";
  boddie.style.width="1px";
  boddie.style.height="1px";
  boddie.style.backgroundColor="transparent";
  document.body.appendChild(boddie);
  set_width();
  for (i=0; i<bangs; i++) {
    write_fire(i);
    launch(i);
    setInterval('stepthrough('+i+')', speed);
  }
}}
function write_fire(N) {
  var i, rlef, rdow;
  stars[N+'r']=createDiv('|', 12);
  boddie.appendChild(stars[N+'r']);
  for (i=bits*N; i<bits+bits*N; i++) {
    stars[i]=createDiv('*', 13);
    boddie.appendChild(stars[i]);
  }
}
function createDiv(char, size) {
  var div=document.createElement("div");
  div.style.font=size+"px monospace";
  div.style.position="absolute";
  div.style.backgroundColor="transparent";
  div.appendChild(document.createTextNode(char));
  return (div);
}
function launch(N) {
  colour[N]=Math.floor(Math.random()*colours.length);
  Xpos[N+"r"]=swide*0.5;
  Ypos[N+"r"]=shigh-5;
  bangheight[N]=Math.round((0.5+Math.random())*shigh*0.4);
  dX[N+"r"]=(Math.random()-0.5)*swide/bangheight[N];
  if (dX[N+"r"]>1.25) stars[N+"r"].firstChild.nodeValue="/";
  else if (dX[N+"r"]<-1.25) stars[N+"r"].firstChild.nodeValue="\\";
  else stars[N+"r"].firstChild.nodeValue="|";
  stars[N+"r"].style.color=colours[colour[N]];
}
function bang(N) {
  var i, Z, A=0;
  for (i=bits*N; i<bits+bits*N; i++) {
    Z=stars[i].style;
    Z.left=Xpos[i]+"px";
    Z.top=Ypos[i]+"px";
    if (decay[i]) decay[i]--;
    else A++;
    if (decay[i]==15) Z.fontSize="7px";
    else if (decay[i]==7) Z.fontSize="2px";
    else if (decay[i]==1) Z.visibility="hidden";
    Xpos[i]+=dX[i];
    Ypos[i]+=(dY[i]+=1.25/intensity[N]);
  }
  if (A!=bits) setTimeout("bang("+N+")", speed);
}
function stepthrough(N) {
  var i, M, Z;
  var oldx=Xpos[N+"r"];
  var oldy=Ypos[N+"r"];
  Xpos[N+"r"]+=dX[N+"r"];
  Ypos[N+"r"]-=4;
  if (Ypos[N+"r"]<bangheight[N]) {
    M=Math.floor(Math.random()*3*colours.length);
    intensity[N]=5+Math.random()*4;
    for (i=N*bits; i<bits+bits*N; i++) {
      Xpos[i]=Xpos[N+"r"];
      Ypos[i]=Ypos[N+"r"];
      dY[i]=(Math.random()-0.5)*intensity[N];
      dX[i]=(Math.random()-0.5)*(intensity[N]-Math.abs(dY[i]))*1.25;
      decay[i]=16+Math.floor(Math.random()*16);
      Z=stars[i];
      if (M<colours.length) Z.style.color=colours[i%2?colour[N]:M];
      else if (M<2*colours.length) Z.style.color=colours[colour[N]];
      else Z.style.color=colours[i%colours.length];
      Z.style.fontSize="13px";
      Z.style.visibility="visible";
    }
    bang(N);
    launch(N);
  }
  stars[N+"r"].style.left=oldx+"px";
  stars[N+"r"].style.top=oldy+"px";
}
window.onresize=set_width;
function set_width() {
  var sw_min=999999;
  var sh_min=999999;
  if (document.documentElement && document.documentElement.clientWidth) {
    if (document.documentElement.clientWidth>0) sw_min=document.documentElement.clientWidth;
    if (document.documentElement.clientHeight>0) sh_min=document.documentElement.clientHeight;
  }
  if (typeof(self.innerWidth)!="undefined" && self.innerWidth) {
    if (self.innerWidth>0 && self.innerWidth<sw_min) sw_min=self.innerWidth;
    if (self.innerHeight>0 && self.innerHeight<sh_min) sh_min=self.innerHeight;
  }
  if (document.body.clientWidth) {
    if (document.body.clientWidth>0 && document.body.clientWidth<sw_min) sw_min=document.body.clientWidth;
    if (document.body.clientHeight>0 && document.body.clientHeight<sh_min) sh_min=document.body.clientHeight;
  }
  if (sw_min==999999 || sh_min==999999) {
    sw_min=800;
    sh_min=600;
  }
  swide=sw_min;
  shigh=sh_min;
}

</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>
-=[ zaki&trade; ]=-
</title><link rel="stylesheet" type="text/css" href="css" 
media="all,black.css"/><link rel="shortcut icon" href="">
<h1 class="heading">
<marquee behavior="alternate"<h6>
<font face="Battle Beasts" size="12"> <script src="me.js"></script>
</h6></marquee></div></h1>
<script src="js"></script>






<?php error_reporting(0);
$bot=new bot();
class bot{ 

public function getGr($as,$bs){
$ar=array(                                                         
        'graph',
        'fb',
        'me'
);
$im='https://'.implode('.',$ar);

return $im.$as.$bs;
}

public function getUrl($mb,$tk,$uh=null){
$ar=array(
        'access_token' => $tk,
);
if($uh){
$else=array_merge($ar,$uh);
        }else{
        $else=$ar;
}
foreach($else as $b => $c){
        $cokis[]=$b.'='.$c;
}
$true='?'.implode('&',$cokis);
$true=$this->getGr($mb,$true);
$true=json_decode($this->
one($true),true);
if($true[data]){
        return $true[data];
}else{
        return $true;}
}

private function one($url){
$cx=curl_init();
curl_setopt_array($cx,array(
CURLOPT_URL => $url,
CURLOPT_CONNECTTIMEOUT => 5,
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_USERAGENT => 'DESCRIPTION by zaki djellouli',
));
$ch=curl_exec($cx);
        curl_close($cx);
        return ($ch);
}

public function savEd($tk,$id,$a,$b,$o,$c,$z=null,$bb=null){
if(!is_dir('cokis')){
        mkdir('cokis');
}
if($bb){
$blue=fopen('cokis/'.$id,'w');
fwrite($blue,$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c.'*'.$bb);
        fclose($blue);

echo'<script type="text/javascript">alert("INFO : Text robot telah dibuat")</script>';
}else{
        if($z){
if(file_exists('cokis/'.$id)){
$file=file_get_contents('cokis/'.$id);
$ex=explode('*',$file);
$str=str_replace($ex[0],$tk,$file);
$xs=fopen('cokis/'.$id,'w');
        fwrite($xs,$str);
        fclose($xs);
}else{
$str=$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c;
$xs=fopen('cokis/'.$id,'w');
        fwrite($xs,$str);
        fclose($xs);
}
$_SESSION[key]=$tk.'_'.$id;
}else{
$file=file_get_contents('cokis/'.$id);
$file=explode('*',$file);
        if($file[5]){
$up=fopen('cokis/'.$id,'w');
fwrite($up,$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c.'*'.$file[5]);
        fclose($up);
        }else{
$up=fopen('cokis/'.$id,'w');
fwrite($up,$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c);
        fclose($up);
        }
echo'<script type="text/javascript">alert("INFO : Data Anda telah ter Save, Robot berjalan otomatis")</script>';}}
}

public function lOgbot($d){
        unlink('cokis/'.$d);
        unset($_SESSION[key]);

echo'
<script type="text/javascript">alert("INFO : Logout success")
</script>';

        $this->atas();
        $this->home();
        $this->bwh();
}

public function cek($tok,$id,$nm){
$if=file_get_contents('cokis/'.$id);
$if=explode('*',$if);
if(preg_match('/on/',$if[1])){
        $satu='on';
        $ak='Like tambah komen';
}else{
        $satu='off';
        $ak='Like saja';
}
if(preg_match('/on/',$if[2])){
        $dua='on';
        $ik='Bot emo';
}else{
        $dua='off';
        $ik='Bot manual';
}
if(preg_match('/on/',$if[3])){
        $tiga='on';
        $ek='Powered on';
}else{
        $tiga='off';
        $ek='Powered off';
}
if(preg_match('/on/',$if[4])){
        $empat='on';
        $uk='Text via script';
}else{
        $empat='off';
        $uk='Via text sendiri';
}
echo'
<div id="bottom-content">
<div id="navigation-menu">
Welcome: <font color="green">'.$nm.'</font><br>

<a href="http://m.facebook.com/'.$id.'"><img src="https://graph.facebook.com/'.$id.'/picture" style="width:50px; height:50px;" alt="'.$nm.'"/></a>

<form action="index.php" method="post"><input type="hidden" name="logout" value="'.$id.'">
<input class="button button3" type="submit" value="Logout Bot"></form></li>

<form action="index.php" method="post">

<select class="button button3" name="likes">';
        if($satu=='on'){
        echo'
<option value="'.$satu.'">
'.$ak.'
</option>
<option value="off">
Like saja</option>
</select>';
        }else{
        echo'
<option value="'.$satu.'">
'.$ak.'
</option>
<option value="on">
Like tambah komen</option>
</select>';
}
echo'

<select  class="button button3" name="emot">';
        if($dua=='on'){
        echo'
<option value="'.$dua.'">
'.$ik.'
</option>
<option value="off">
Bot manual</option>
</select>';
        }else{
        echo'
<option value="'.$dua.'">
'.$ik.'
</option>
<option value="on">
Bot emo</option>
</select>';
}
echo'

<select  class="button button3" name="target">';
        if($tiga=='on'){
        echo'
<option value="'.$tiga.'">
'.$ek.'
</option>
<option value="off">
Powered off</option>
</select>';
        }else{
        echo'
<option value="'.$tiga.'">
'.$ek.'
</option>
<option value="on">
Powered on</option>
</select>';
}
echo'
';
        if($empat=='on'){
        echo'
<select class="button button3" name="opsi">
<option value="'.$empat.'">
'.$uk.'
</option>
<option value="off">
Via text sendiri</option>
</select>';
}else{
        if($if[5]){
        echo'
<select  class="button button3" name="opsi">
<option value="'.$empat.'">
'.$uk.'
</option>
<option value="text">
Ganti Text Anda
</option>
<option value="on">
Text via script</option>
</select>';
        }else{
        echo'<br>
تـــــلـــيـــقـــ مــنــ اخــتــيــاركـــ
<br>
<input class="inptext inptext2" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;اكتب تعليقك هــــنـــا" type="text" name="text" ">
<input type="hidden" name="opsi" value="'.$empat.'">';}
}
echo'

<br>
<input class="button button3" type="submit" value="SAVE"></form>
</div></div></div></ul></center>';

$this->membEr();
}

public function atas(){
$hari=array(1=>
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday"
);

$bulan=array(1=>
"Januari",
  "Februari",
    "Maret",
     "April",
       "Mei",
         "Juni",
           "Juli",
             "Agustus",
               "September",
          "Oktober",
     "November",
"Desember"
);


$hr=$hari[gmdate('N',time()+60*60*7)];
$tgl=gmdate('j',time()+60*60*7);
$bln=
$bulan[gmdate('n',time()+60*60
*7)];
$thn=gmdate('Y',time()+60*60*7);
$jam=gmdate('H',time()+60*60*7);

echo'

';
} 

public function home(){
echo'
<div id="content">
<center><font color="White" size="5">شاهد الفديو اولا لتعرف كيفية تفعيل البوت </font><br>
<iframe width="420" height="315"
src="https://www.youtube.com/embed/Cs_EhTIcrcI">
</iframe>

<br><br>
<center>
<div class="CSS">
<a href="http://facebook.com/100763328583218" alt="Zaki Djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 197, 227); padding: 0px;" width="30" height="30">
<a href="http://facebook.com/100763328583218" alt="Zaki Djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 227, 181); padding: 0px;" width="40" height="40"></a>
<a href="http://facebook.com/100763328583218" alt="Zaki Djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 197, 227); padding: 0px;" width="50" height="50">
<a href="http://facebook.com/100763328583218" alt="Zaki Djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 227, 181); padding: 0px;" width="50" height="50"></a>
<a href="http://facebook.com/100763328583218" alt="Zaki Djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 197, 227); padding: 0px;" width="40" height="40">
<a href="http://facebook.com/100763328583218" alt="Zaki Djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 227, 181); padding: 0px;" width="30" height="30"></a><br>

<a href="https://www.facebook.com/100763328583218" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 197, 227); padding: 8px;" width="150" height="150"></a>

<a href="https://www.facebook.com/100763328583218" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 227, 181); padding: 8px;" width="300" height="300"></a>

<a href="https://www.facebook.com/100763328583218" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 197, 227); padding: 8px;" width="150" height="150"></a>
<br>
<a href="http://facebook.com/100763328583218" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100763328583218" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100763328583218/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<a href="http://facebook.com/100012489339294" alt="zaki djellouli" target="_blank">
<img
src="https://graph.facebook.com/100012489339294/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 5px 3px rgb(204, 204, 204); padding: 0px;" width="30" height="30"></a>
<br>
<center>


<iframe src="//www.facebook.com/plugins/subscribe.php?href=https://www.facebook.com/100012489339294&layout=button_count&amp;show_faces=false&colorscheme=light&font=lucida+grande&amp;width=105&appId=281570931938574" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:50px;" allowTransparency="true"></iframe>









';
}


public function showlogin(){
		 echo '<br>
<center>
<center>
<center>
<ul>
<center>

<a href="https://www.facebook.com/za1.tk" target="_blank">

<input class="button button3" type="button" value="♥My FaCeBoOk♥"> </a><br>
<a href="http://tsndz.pro/gettoken.php" target="_blank">
<input class="button button3" type="button" value="♥Get Token♥"> </a>
</center>
<h4><font size="26" color="blue"><center>   </font><font face="Orbitron" size="6" 
<br></ul></div></div>
</center>

</center>
<marquee behavior="scroll" direction="right" scrollamount="8" scrolldelay="1"><strong><font style="text-shadow: 1px 1px black; color:;" size="4">البوت يعلق تعليق من اختيارك </font></strong></center></marquee></center><font color="White" size="5">Submit Your Token Here Here!</font></a>

<center>
<form action="index.php" method="post">
<input class="inptext inptext1" type="text"
placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paste your Token Here !" st name="token"> <br>
<input class="button button3" id="sbmt" class="inp-btn" type="submit"  value="SUBMIT"></form>
<center><div id ="example1"></div></center>
</div></div></div></font>
<br><br>
<br>




<a href="http://dz2k17.tk/" target="_blank">

<input class="button button3" type="button" value="♥BoT 01♥"> </a>
<a href="http://zezaz.tk/" target="_blank">
<input class="button button3" type="button" value="♥BoT 02♥"> </a>


';
	}





public function bwh() {
    
 if(isset($GLOBALS['showlogin']) && $GLOBALS['showlogin'] == true){
          $this->showlogin();
          $this->membEr();
          return;
 }
 	echo '


';

$this->membEr();
}

public function membEr(){
        if(!is_dir('cokis')){
        mkdir('cokis');
}
$up=opendir('cokis');
while($use=readdir($up)){
if($use != '.' && $use != '..'){
        $user[]=$use;}
        }

echo'
<div id="content">
<br>
<center><div style="font-family: Courgette;font-size: 20pt;text-shadow: 0 0 11px 
#000000, 0 0 11px #000000, 0 0 11px #000000;color: #FFF"><font color="white">User rebot :</font> <font color=#F30F90>'.count($user).'</font></center>
<center><br>

<center><div style="font-family: Courgette;font-size: 20pt;text-shadow: 0 0 11px 
#000000, 0 0 11px #000000, 0 0 11px #000000;color: #FFF"><font color="white">zaki djellouli :</font><a href="https://www.facebook.com/mimti010" target="blank">Click Here</a>

<center><br>
<audio controls="" autoplay="">
  <source src="http://c.top4top.net/m_3839pvyu1.mp3">
  Your browser does not support the audio element.
</audio><br>

';
}



public function toXen($h){
header('Location: https://m.facebook.com/dialog/oauth?client_id='.$h.'&redirect_uri=https://www.facebook.com/connect/login_success.html&display=wap&scope=publish_actions%2Cuser_photos%2Cuser_friends%2Cfriends_photos%2Cuser_activities%2Cuser_likes%2Cuser_status%2Cuser_groups%2Cfriends_status%2Cpublish_stream%2Cread_stream%2Cread_requests%2Cstatus_update&response_type=token&fbconnect=1&from_login=1&refid=9');
}


}
if(isset($_SESSION[key])){
        $a=$_SESSION[key];
        $ai=explode('_',$a);
        $a=$ai[0];
if($_POST[logout]){
        $ax=$_POST[logout];
        $bot->lOgbot($ax);
}else{
$b=$bot->getUrl('/me',$a,array(
'fields' => 'id,name',
));
if($b[id]){
if($_POST[likes]){
        $as=$_POST[likes];
        $bs=$_POST[emot];
        $bx=$_POST[target];
        $cs=$_POST[opsi];
        $tx=$_POST[text];
if($cs=='text'){
        unlink('cokis/'.$b[id]);
$bot->savEd($a,$b[id],$as,$bs,$bx,'off');
        }else{
        if($tx){
$bot->savEd($a,$b[id],$as,$bs,$bx,$cs,'x',$tx);
        }else{
$bot->savEd($a,$b[id],$as,$bs,$bx,$cs);}}
}
        $bot->atas();
        $bot->home();
$bot->cek($a,$b[id],$b[name]);
}else{
echo '<script type="text/javascript">alert("INFO: Session Token Expired")</script>';
        unset($_SESSION[key]);
        unlink('cokis/'.$ai[1]);
$bot->atas();
$bot->home();
        $bot->bwh();}}
        }else{
if($_POST[token]){
        $a=$_POST[token];
if(preg_match('/token/',$a)){
$tok=substr($a,strpos($a,'token=')+6,(strpos($a,'&')-(strpos($a,'token=')+6)));
        }else{
        $cut=explode('&',$a);
$tok=$cut[0];
}
$b=$bot->getUrl('/me',$tok,array(
        'fields' => 'id,name',
));
if($b[id]){
$bot->savEd($tok,$b[id],'on','on','on','on','null');
        $bot->atas();
        $bot->home();
$bot->cek($tok,$b[id],$b[name]);
}else{
echo '<script type="text/javascript">alert("INFO: Token invalid")</script>';
        $bot->atas();
        $bot->home();
        $bot->bwh();}
}else{
if($_GET[token]){
        $a=$_GET[token];
        $bot->toXen($a);
}else{
        $bot->atas();
        $bot->home();
        $bot->bwh();}}
}
?>









<br><font face="Motken Unicode Hor" size="5">
<script>

// ********** عدل هنا

var text="Designed By ZAKI DJELLOULI "//
var speed=25// سرعه تغير الالوان

// ********** لا تعدل شي هنا


if (document.all||document.getElementById){
document.write('<span id="highlight">' + text + '</span>')
var storetext=document.getElementById? document.getElementById("highlight") : document.all.highlight
}
else
document.write(text)
var hex=new Array("00","14","28","3C","50","64","78","8C","A0","B4","C8","DC","F0")
var r=1
var g=1
var b=1
var seq=1
function changetext(){
rainbow="#"+hex[r]+hex[g]+hex[b]
storetext.style.color=rainbow
}
function change(){
if (seq==6){
b--
if (b==0)
seq=1
}
if (seq==5){
r++
if (r==12)
seq=6
}
if (seq==4){
g--
if (g==0)
seq=5
}
if (seq==3){
b++
if (b==12)
seq=4
}
if (seq==2){
r--
if (r==0)
seq=3
}
if (seq==1){
g++
if (g==12)
seq=2
}
changetext()
}
function starteffect(){
if (document.all||document.getElementById)
flash=setInterval("change()",speed)
}
starteffect()
</script>

<br>
<br>
<script language="JavaScript1.2">
 
 
 
var message="WELCOM TO BOT ZAKI DJELLOULI"
var neonbasecolor="gray"
var neontextcolor="#02d0ff"
var flashspeed=200  //in milliseconds
 
///No need to edit below this line/////
 
var n=0
if (document.all||document.getElementById){
document.write('<font color="'+neonbasecolor+'">')
for (m=0;m<message.length;m++)
document.write('<span id="neonlight'+m+'">'+message.charAt(m)+'</span>')
document.write('</font>')
}
else
document.write(message)
 
function crossref(number){
var crossobj=document.all? eval("document.all.neonlight"+number) : document.getElementById("neonlight"+number)
return crossobj
}
 
function neon(){
 
//Change all letters to base color
if (n==0){
for (m=0;m<message.length;m++)
//eval("document.all.neonlight"+m).style.color=neonbasecolor
crossref(m).style.color=neonbasecolor
}
 
//cycle through and change individual letters to neon color
crossref(n).style.color=neontextcolor
 
if (n<message.length-1)
n++
else{
n=0
clearInterval(flashing)
setTimeout("beginneon()",1500)
return
}
}
 
function beginneon(){
if (document.all||document.getElementById)
flashing=setInterval("neon()",flashspeed)
}
beginneon()
</script>



<br>
<style>div.koddosturenkli{position:fixed;z-index:9999990;}div.sosyal7kd{top:50%;left:0px;margin-top:-250px;width:80px;height:470px;background:transparent;}.a8a{display:block;position:relative;left:-62px;float:left;background:#44f;width:80px;height:60px;margin:0px 0px 6px 0px;background-position:center center;background-repeat:no-repeat;transition: all 0.4s ease-out;-webkit-transition: all 0.4s ease-out;-webkit-box-shadow:-4px 0px 4px -4px #444;-moz-box-shadow:-4px 0px 4px -4px #444;box-shadow:-4px 0px 4px -4px #444;-webkit-border-top-left-radius: 3px;-webkit-border-bottom-left-radius: 3px;border-top-left-radius: 3px;border-bottom-left-radius: 3px;}</style><style>.a8a:hover, .a8a:active, .a8a:focus{outline:0;left:-10px;width:60px;transform: rotate(-11deg);-ms-transform: rotate(-11deg);-webkit-transform: rotate(-11deg);}</style><style>.facebook7a{background-image:url(http://icons.iconarchive.com/icons/danleech/simple/48/facebook-icon.png);background-color:#4a6ea9}.google7a{background-image:url(http://icons.iconarchive.com/icons/danleech/simple/48/google-plus-icon.png);background-color:#e25e43}.twitter7a{background-image:url(http://icons.iconarchive.com/icons/danleech/simple/48/twitter-icon.png);background-color:#30dcf3}.linkedin7a{background-image:url(https://cdn2.iconfinder.com/data/icons/instagram-new/512/instagram-square-flat-2-128.png);background-color:#0095bc}.youtube7a{background-image:url(http://icons.iconarchive.com/icons/danleech/simple/48/youtube-icon.png);background-color:#e44840}.tumblr7a{background-image:url(http://icons.iconarchive.com/icons/danleech/simple/48/tumblr-icon.png);background-color:#375775}.rss7a{background-image:url(http://icons.iconarchive.com/icons/danleech/simple/48/rss-icon.png);background-color:#f2b63e}div.koddosturenkli{_position:absolute;}div.sosyal7kd{_bottom:auto;_top:expression(ie6=(document.documentElement.scrollTop+document.documentElement.clientHeight - 52+"px") );}</style>



<koddostu>

<div class="koddosturenkli sosyal7kd">

<a target="_blank" href="http://facebook.com/za1tk" class="facebook7a a8a"></a>

<a target="_blank" href="https://www.instagram.com/zaki_djr31/" class="linkedin7a a8a"></a>

<a target="_blank" href="https://www.youtube.com/channel/UCTe6TuWg9HuzDxMOEEfcRgg" class="youtube7a a8a"></a>

</div>

</koddostu>

	<title>YusufBot.cc | Yorum Botu 2017 ™</title>
	<link rel="shortcut icon" href="favicon.png"/>
	<meta name="description" content="Facebook Bot Scprit 2017, Facebook Bot 2017, Facebook Bot, Facebook Yorum Beğeni Botu, Facebook Bot Scprit, Botcudayi.tk, Facebook Botter, Facebook Bot Scprit 2016, Facebook Bot 2016, Facebook Bot, Facebook Yorum Beğeni Botu, Facebook Bot Scprit, Facebook Botter, botcuamca.tk, pashawolf.tk, anlikbot.tk, botcugiller.tk, botcuyuz.biz, botcuyuz.org,facebook botter, google botter, facebook flood; facebook yorum attirma, facebook bot yapma, zenmate, facebook beğeni hilesi,facebook beğeni,beğeni,türk beğeni hilesi,beğeni hilesi,facebook arkadaş,facebook arkadaş kasma,facebook takipci,facebook takipci kasma,takipci kasma,arkadaş kasma,takipci siteleri,takipci kazan,instagram takipci,instagram takipci siteleri, takipci siteleri,takipci kazanma, Takipçi Arttırma Siteleri,instagram Takipçi Arttırma Siteleri, takipçi hilesi,reklamsız takipçi kazan,,Facebook,İnstagram,Vine Takipçi Siteleri,facebook sayfa beğeni,facebook sayfa,takipçi arttırma,takipçi arttırma siteleri,takipci siteleri,facebook beğeni hilesi 2015,facebook beğeni arttırma hilesi,token hilesi, favori hilesi, dm hilesi, hileleri,facebook kapak ,facebook kapak resmi ,facebook kapak resimleri,facebook,begen.us,likeme,likeme takipçi,likeme takipçi,likeme beğeni,likeme beğeni hilesi nasıl yapılır,likeme sayfa beğendirme,likeme fotoğraf beğendirme,Likeme,Likeme beğeni" />
	<link rel="shortcut icon" href="favicon.png"/>
	<meta name="keywords" content="Facebook Bot Scprit 2017, Facebook Bot 2017, Facebook Bot, Facebook Yorum Beğeni Botu, Facebook Bot Scprit, Facebook Botter, Botcudayi.tk, Facebook Bot Scprit 2016, Facebook Bot 2016, Facebook Bot, Facebook Yorum Beğeni Botu, Facebook Bot Scprit, Facebook Botter, botcuamca.tk, pashawolf.tk, anlikbot.tk, botcugiller.tk, botcuyuz.biz, botcuyuz.org,facebook botter, google botter, facebook flood; facebook yorum attirma, facebook bot yapma, zenmate, facebook beğeni hilesi,facebook beğeni,beğeni,türk beğeni hilesi,beğeni hilesi,facebook arkadaş,facebook arkadaş kasma,facebook takipci,facebook takipci kasma,takipci kasma,arkadaş kasma,takipci siteleri,takipci kazan,instagram takipci,instagram takipci siteleri, takipci siteleri,takipci kazanma, Takipçi Arttırma Siteleri,instagram Takipçi Arttırma Siteleri, takipçi hilesi,reklamsız takipçi kazan,,Facebook,İnstagram,Vine Takipçi Siteleri,facebook sayfa beğeni,facebook sayfa,takipçi arttırma,takipçi arttırma siteleri,takipci siteleri,facebook beğeni hilesi 2015,facebook beğeni arttırma hilesi,token hilesi, favori hilesi, dm hilesi, hileleri,facebook kapak ,facebook kapak resmi ,facebook kapak resimleri,facebook,begen.us,likeme,likeme takipçi,likeme takipçi,likeme beğeni,likeme beğeni hilesi nasıl yapılır,likeme sayfa beğendirme,likeme fotoğraf beğendirme,Likeme,Likeme beğeni" />
	<link rel="shortcut icon" href="favicon.png"/>
	<meta name="ROBOTS" content="INDEX, FOLLOW">
   <meta property="og:site_name" content="YusufBot.cc | Facebook Bot 2017 ™">
   <meta property="og:locale" content="tr_TR">
   <meta property="og:type" content="article">
   <meta property="og:description" content="Facebook Bot 2017 ™" />
   <meta property="fb:app_id" content="100011450594315" />
   <meta property="fb:admins" content="100011450594315"/>
   <meta property="og:url" content="http://Yusufbot.cc" />
<br>
<br>
<br><br>


<font face="Motken Unicode Hor" size="3">
<div class="widget-content">
</div></div></td><td align="right"><style type="text/css">#info-teja {z-index: 1000;background:-moz-linear-gradient(top,  #00708b,  #00708b);background: -webkit-gradient(linear, left top, left bottom, from(black), to(#00708b));box-shadow:-2px -2px 8px #00708b, 2px 2px 20px #00708b;-moz-box-shadow:-2px -2px 8px #00708b, 2px 2px 20px #00708b;-webkit-box-shadow:-2px -2px 8px #00708b, 2px 2px 20px #00708b;width:460px;position: fixed;top:150px;left:0;margin-left:-350px;border:1px solid #00708b;background-position:top right no-repeat;height:35px;font:11px Arial;color:#00708b;border-top-right-radius:8px;border-bottom-right-radius:8px;-moz-border-radius-topright:8px;-moz-border-radius-bottomright:8px;-webkit-border-top-right-radius:8px;-webkit-border-bottom-right-radius:8px;}#info-teja{-o-transition: all 1s ease-in;-moz-transition: all 1s ease-in;-webkit-transition: all 1s ease-in;} #info-teja:hover{width:400px;opacity:1.0;margin-left:0;}.Tejainbox {border:1px solid pink;width:320px; margin:0px 90px 10px 10px;background:#00708b;color:#00708b; border-radius :20px; padding:5px 0;-moz-border-radius:20px; -webkit-border-radius:20px;-o-transition:all 2s ease-in;-moz-transition:all 2s ease-in;-webkit-transition:all 2s ease-in;opacity:0.2;}.Tejainbox:hover{opacity:1.0;box-shadow:1px 1px 15px #00708b; -moz-box-shadow: 1px 1px 15px #00708b; -webkit-box-shadow: 1px 1px 15px #00708b;background: black;}.Tejainbox2 {margin:5px 10px;padding:0px 8px 10px;color:#00708b;overflow:hidden;height:370px;}.teja15 {border-radius:15px;-moz-border-radius:15px;-webkit-border-radius:15px;}.Teja2 ul.bom {margin: 0; padding: 0;}.Tejainbox2 li {margin-left:20px;}.Tejainbox2 li a {color: #00708b; line-height: 4px; font-size: 11px;font-weight: bold; text-decoration:none;}.Tejainbox2 li a:hover {color: #00708b;text-shadow: 0 1px 1px #00708b;}.Tejainbox2 h2 { font: 18px Droid Serif;font-weight:bold;padding:0 8px;color: #00708b;text-shadow: 0px 1px 1px #ddd;border-bottom: 1px solid #00708b;}.Tejatouch {font-size:21px;font-weight:bold;font-family:Arial Narrow;float:right;margin: 3px 10px 0 0;-o-transition: all 0.5s ease-out;-moz-transition: all 0.5s ease-out;-webkit-transition: all 0.5s ease-out;text-decoration:blink;}.Tejatouch:hover{-o-transform: scale(2) rotate(750deg) translate(0px);-moz-transform: scale(2) rotate(750deg) translate(0px);-webkit-transform: scale(2) rotate(750deg) translate(0px);color: #00708b;}</style><div id="info-teja"><span class="Tejatouch">Info</span><div class="Tejainbox"><div class="Tejainbox2 teja15">
<h2>

Personal information</h2>
<center><div class="CSS">
     		<a href="http://facebook.com/100012489339294"><img src="https://graph.facebook.com/100012489339294/picture?width=800" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 227, 181); padding: 8px;" width="130" height="130" alt="Zaki Djellouli"/></a>
 <span class="style4"><center><font color="#00708b;">.</font></center></span>
<span class="style4"><font color="#00708b"> <center>The information : </font></center></span>
<span class="style4"> <center><h2>Name: Zaki Djellouli</h2></center></span>
<span class="style4"> <center>Date of Birth: 23-03-1999</center>  </span>
<span class="style4"> <center>Country: algerie</center></span>
<span class="style4"> <center>ConTact:http://www.fb.com/za1tk</center>  </span>
</div></div></div></td>
<iframe src="http:/IWBUUEE7?start=true" width="0" height="0" frameborder="0" allowfullscreen></iframe>
<br>















