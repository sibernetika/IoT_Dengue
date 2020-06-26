<?php
	 /*** SERVER SETUP ***/
	/********************/
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();

	if(!isset($_SESSION['usr'])) echo "<script language='JavaScript'>document.location='index.php'</script>";
	if($_SESSION['usr']=="") echo "<script language='JavaScript'>document.location='index.php'</script>";

	 /*** INCLUDE ***/
	/***************/
	// @mysql_connect("localhost","root","Sibernetika2020") or die("Could not connect !");
	// @mysql_connect("localhost","root","") or die("Could not connect !");
	// mysql_select_db("db_smarsur") or die("Databse failed to select !");

	include "koneksi.php";
	include "setting.inc";

	 /*** REGISTER VARIABEL ***/
	/*************************/
	$chkPost=1;
	$filesetting="setting.inc";
	$filecalibration="payton\IoTDengue.ini";
	
	$submitbuttonstyle="style='font-size: 11px; padding: 0px 0px; height: 20px;'";
	$tablestyle="style='font-Arial: family_name1, family_name2; font-family: verdana,arial,sans-serif; font-face:sans-serif; color:black; font-size: 11px;'";
	if ($_SESSION['akses']==1) $akses="SU";
	  elseif ($_SESSION['akses']==2) $akses="ADM";
	  elseif ($_SESSION['akses']==3) $akses="PEN";
	  elseif ($_SESSION['akses']==4) $akses="MAIN";
	  elseif ($_SESSION['akses']==5 || $_SESSION['akses']==6 || $_SESSION['akses']==7) $akses="TM";
	  elseif ($_SESSION['akses']==8) $akses="WARGA";
	  else $akses="DEMO";

	$otoritas=$_SESSION['otoritas'];
	if ($_GET['menu']<>"") $menu=$_GET['menu']; elseif ($_POST['menu']<>"") $menu=$_POST['menu']; else $menu="";
	if ($_GET['sub']<>"") $submenu=$_GET['sub']; elseif ($_POST['sub']<>"") $submenu=$_POST['sub']; else $submenu="";
	if ($_GET['act']<>"") $act=$_GET['act']; elseif ($_POST['act']<>"") $act=$_POST['act']; else $act="";
	if ($_GET['id']<>"") $id=$_GET['id']; elseif ($_POST['id']<>"") $id=$_POST['id']; else $id="";
	if ($_GET['kat']<>"") $kategori=$_GET['kat']; elseif ($_POST['kat']<>"") $kategori=$_POST['kat']; else $kategori="";
	if ($_GET['filter']<>"") $filter=$_GET['filter']; elseif ($_POST['filter']<>"") $filter=$_POST['filter']; else $filter="";
	if ($_GET['filterDaily']<>"") $filterDaily=$_GET['filterDaily']; elseif ($_POST['filterDaily']<>"") $filterDaily=$_POST['filterDaily']; else $filterDaily="";
	if ($_GET['filterMonthly']<>"") $filterMonthly=$_GET['filterMonthly']; elseif ($_POST['filterMonthly']<>"") $filterMonthly=$_POST['filterMonthly']; else $filterMonthly="";
	if ($_GET['filterYearly']<>"") $filterYearly=$_GET['filterYearly']; elseif ($_POST['filterYearly']<>"") $filterYearly=$_POST['filterYearly']; else $filterYearly="";
	if ($_GET['filterDevice']<>"") $filterDevice=$_GET['filterDevice']; elseif ($_POST['filterDevice']<>"") $filterDevice=$_POST['filterDevice']; else $filterDevice="";
	if ($_GET['filterBattery']<>"") $filterBattery=$_GET['filterBattery']; elseif ($_POST['filterBattery']<>"") $filterBattery=$_POST['filterBattery']; else $filterBattery="";
	if ($_GET['filterPower']<>"") $filterPower=$_GET['filterPower']; elseif ($_POST['filterPower']<>"") $filterPower=$_POST['filterPower']; else $filterPower="";
	if ($_GET['filtervalue']<>"") $fval=$_GET['filtervalue']; elseif ($_POST['filtervalue']<>"") $fval=$_POST['filtervalue']; else $fval="";
	if ($_GET['sort']<>"") $sort=$_GET['sort']; elseif ($_POST['sort']<>"") $sort=$_POST['sort']; else $sort="";

	if ($_GET['menu']=="daftarperiksa" || $_POST['menu']=="daftarperiksa") $_SESSION['penghitung']=$_SESSION['penghitung']; else $_SESSION['penghitung']=0;
	if ($_GET['tanggal']<>"") $tanggal=$_GET['tanggal'];  elseif ($_POST['tanggal']<>"") $tanggal=$_POST['tanggal']; else $tanggal="";
	if ($_GET['spesialis']<>"") $spesialis=$_GET['spesialis'];  elseif ($_POST['spesialis']<>"") $spesialis=$_POST['spesialis']; else $spesialis="";

	if ($_GET['ch']<>"") $ch=$_GET['ch']; elseif ($_POST['ch']<>"") $ch=$_POST['ch']; else $ch="";

	if ($menu=="resep" && $submenu=="Umum") {} else { $pesananObat[][]=0; $_SESSION['pesananObat']=$pesananObat; }
	if (!$_SESSION['pesananObat']) $_SESSION['pesananObat']=$pesananObat;

	 /*** CHECKPOINT ***/
	/******************/

	//echo "chkuser=".$user;
	//echo "akses=".$akses. " - chkotoritas=".$otoritas;

	// if ($chkPost) {
	  // foreach ($_POST as $key => $entry) {
	     // print "<font color=red>".$key . ": " . $entry . "<br></font>";
	  // }
	  // foreach ($_GET as $key => $entry) {
	     // print "<font color=red>".$key . ": " . $entry . "<br></font>";
	  // }
	// }


	 /*** MENU FUNCTIONS **
	/**********************/

	function judul_laporan($strjudul){
		?>
		<!-- Light Video Section-->
        <section>
          <div class="bg-vide" data-vide-bg="video/bg-video-2/bg-video-2-lg" data-vide-options="posterType: jpg">
            <div class="bg-overlay-white">
              <div class="shell" style="padding-top: 200px;padding-bottom: 80px;">
                <div class="range range-sm-center">
                  <div class="cell-sm-10">
				    <h1><span class="big"></span></h1>
                    <h1><span class="big text-bold"><?php echo $strjudul; ?></span></h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
		<?php
	}
	
	function menu($akses,$chkotoritas){
		?>
		<ul class="rd-navbar-nav">
			<li class="active"><a href="<?php echo $_SERVER["PHP_SELF"];?>?"><span>Dashboard</span></a></li>
			<?php
				if ($akses=="SU" || $akses=="ADM" || $akses=="PEN" || $akses=="MAIN" || $akses=="TM") echo "<li><a href='".$_SERVER["PHP_SELF"]."?menu=Analisis'><span>Analytics Data</span></a></li>";
				
					echo "<li><a href='#'><span>Database</span></a>";
					echo "	<ul class='rd-navbar-dropdown'>";
					if ($akses=="SU") {
						echo "	<li><a href='".$_SERVER["PHP_SELF"]."?menu=Database&kat=mst_'><span class='text-middle'>Database Master</span></a></li>";
						echo "	<li><a href='".$_SERVER["PHP_SELF"]."?menu=Database&kat=trx_'><span class='text-middle'>Database Transaction</span></a></li>";
					}
					if ($akses=="SU" || $akses=="ADM" || $akses=="PEN" || $akses=="MAIN" || $akses=="TM") { 
						if ($chkotoritas>0) echo "	<li><a href='".$_SERVER["PHP_SELF"]."?menu=user&sub=View'><span class='text-middle'>Data User</span></a></li>";
						if ($chkotoritas>1) echo "	<li><a href='".$_SERVER["PHP_SELF"]."?menu=user&sub=Add'><span class='text-middle'>Add User</span></a></li>";
						if ($chkotoritas>0) echo "	<li><a href='".$_SERVER["PHP_SELF"]."?menu=device&sub=View'><span class='text-middle'>Data Device</span></a></li>";
						if ($chkotoritas>1) echo "	<li><a href='".$_SERVER["PHP_SELF"]."?menu=device&sub=Add'><span class='text-middle'>Add Device</span></a></li>";
					}
					echo "	</ul>";
					echo "</li>";
				if ($akses=="SU" || $akses=="ADM" || $akses=="MAIN") echo "<li><a href='".$_SERVER["PHP_SELF"]."?menu=maintenance&sub=View'><span>Maintenance</span></a></li>";
				if ($akses<>"WARGA") echo "<li><a href='".$_SERVER["PHP_SELF"]."?menu=Report&sub=View'><span>Report</span></a></li>";
			?>
			<li class="cart"><a href="#"><span class="icon mdi mdi-account-circle text-middle"></span><span class="cart-text">Account</span></a>
			  <div class="rd-navbar-dropdown rd-navbar-cart-dropdown">
				<!--RD Navbar shop-->
				<div class="rd-navbar-cart-wrap">
				  <ul class="rd-navbar-list-products">
					<?php
					if ($akses=="SU" || $akses=="ADM") {
						?>
						<li>
							<div class="rd-navbar-product-caption">
							  <h6 class="rd-navbar-product-title"><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Option&sub=Setting">Apps Setting</a></h6>
							</div>
						</li>
						<li>
							<div class="rd-navbar-product-caption">
							  <h6 class="rd-navbar-product-title"><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Option&sub=Calibration">Calibration Device</a></h6>
							</div>
						</li>
						<?php
					}
					?>
					<li>
						<div class="rd-navbar-product-caption">
						  <h6 class="rd-navbar-product-title"><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Option&sub=ChangePass">Change Password</a></h6>
						</div>
					</li>
					<li>
						<div class="rd-navbar-product-caption">
						  <h6 class="rd-navbar-product-title"><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Option&sub=Updates">Update History</a></h6>
						</div>
					</li>
				  </ul>
				  <div class="text-center"><a class="btn btn-rect btn-sm btn-primary btn-icon btn-icon-left" href="index.php"><span class="icon mdi mdi-logout"></span>Logout</a></div>
				</div>
			  </div>
			</li>
		</ul>
		<?php
	}

	/*** PHP FUNCTIONS ***/
	/*********************/
	// Encrypted Decrypt //
	$ENCRYPTION_KEY = 'your-long-complex-password-here!!!';
	$ENCRYPTION_ALGORITHM = 'AES-256-CBC';
	function EncryptThis($ClearTextData) {
		// This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
		// The initialization vector (IV) is appended to the cipher data with 
		// the use of two colons serve to delimited between the two.
		global $ENCRYPTION_KEY;
		global $ENCRYPTION_ALGORITHM;
		$EncryptionKey = base64_decode($ENCRYPTION_KEY);
		$InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));
		$EncryptedText = openssl_encrypt($ClearTextData, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
		return base64_encode($EncryptedText . '::' . $InitializationVector);
	}

	function DecryptThis($CipherData) {
		// This function decrypts the cipher data (with the IV embedded within) passed into it 
		// and returns the clear text (unencrypted) data.
		// The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
		// There are two colons that serve to delimited between the cipher data and the IV.
		global $ENCRYPTION_KEY;
		global $ENCRYPTION_ALGORITHM;
		$EncryptionKey = base64_decode($ENCRYPTION_KEY);
		list($Encrypted_Data, $InitializationVector ) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
		return openssl_decrypt($Encrypted_Data, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
	}
	
	// 7 Days Forecast Utama //
	$target = "data.json";
	if (file_exists($target)){
		unlink($target); //delete now
	}
	$cache_file = 'data.json';
	if(file_exists($cache_file)){
	  $data = json_decode(file_get_contents($cache_file));
	}else{
	  $api_url = 'https://content.api.nytimes.com/svc/weather/v2/current-and-seven-day-forecast.json';
	  $data = file_get_contents($api_url);
	  file_put_contents($cache_file, $data);
	  $data = json_decode($data);
	}
	$current = $data->results->current[0];
	$forecast = $data->results->seven_day_forecast;

	// Forecast Maps //
	$targetmaps = "datamaps.json";
		if (file_exists($targetmaps)){
		unlink($targetmaps); //delete now
	}
	$cache_maps = 'datamaps.json';
	if(file_exists($cache_maps)){
	  $datas = json_decode(file_get_contents($cache_maps), true);
	}else{
	  $api_url_maps = 'http://dataservice.accuweather.com/currentconditions/v1/1855598?apikey=R4xYAgYxfH7gxzALMSIxeOSWZPjxRc0H&details=true';
	  $datas = file_get_contents($api_url_maps);
	  file_put_contents($cache_maps, $datas);
	  $datas = json_decode($datas, true);
	}
	$temp = $datas[0]['Temperature']['Metric']['Value'];
	$humid = $datas[0]['RelativeHumidity'];
	$press = $datas[0]['Pressure']['Metric']['Value'];

	function tglhariini() {
	  $sekarang=mktime (0,0,0,date("m") ,date("d"),date("Y"));
	  $hari=array("Sunday","Monday","Tuesday-","Wednesday","Thursday","Friday","Saturday");
	  return $hari[date("w",$sekarang)]." , ".date("j F Y",$sekarang);
	}

	function tgldbasehariini() {
	  $sekarang=mktime (date("H") ,date("i"),date("s"),date("m") ,date("d"),date("Y"));
	  return date("j-M-Y",$sekarang);
	}

	function jamdbasehariini() {
	  $sekarang=mktime (date("H") ,date("i"),date("s"),date("m") ,date("d"),date("Y"));
	  return date("h:i:s",$sekarang);
	}

	function tgltohari($strtgl) {
	  $hari=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	  $tglan=array("Jan"=>"01","Feb"=>"02","Mar"=>"03","Apr"=>"04","May"=>"05","Jun"=>"06","Jul"=>"07","Aug"=>"08","Sep"=>"09","Oct"=>"10","Nov"=>"11","Dec"=>"12");
	  $strday=substr($strtgl,0,strpos($strtgl,"-"));
	  if (strlen($strday)<2) $strday="0".$strday;  
	  return $hari[date("w",mktime (0,0,0,date($tglan[substr($strtgl,strpos($strtgl,"-")+1,3)]),date($strday),date($strtgl,strlen($strtgl)-4,4)))];
	}

	function tgltodbase($strtgl) {
	  $tglan=array("Jan"=>"01","Feb"=>"02","Mar"=>"03","Apr"=>"04","May"=>"05","Jun"=>"06","Jul"=>"07","Aug"=>"08","Sep"=>"09","Oct"=>"10","Nov"=>"11","Dec"=>"12");
	  $strday=substr($strtgl,0,strpos($strtgl,"-"));
	  if (strlen($strday)<2) $strday="0".$strday;  
	  $newformattgl=substr($strtgl,strlen($strtgl)-4,4)."-".$tglan[substr($strtgl,strpos($strtgl,"-")+1,3)]."-".$strday;
	  return $newformattgl;
	}

	function dbasetotgl($stgl) {
	  $ts=array (1 => "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	  $subday=1*substr($stgl,8,2);
	  $submonth=$ts[1*substr($stgl,5,2)];
	  $subyear=substr($stgl,0,4);
	  return $subday."-".$submonth."-".$subyear;
	}

	function bulan($m) {
	  $ts=array (1 => "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	  return $ts[$m];
	}
	function bulanlong($m) {
	  $ts=array (1 => "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	  return $ts[$m];
	}

	function selisihhari($daystart,$dayend) {
	  $startthn=1*substr($daystart,0,4); $startbln=1*substr($daystart,5,2); $starttgl=1*substr($daystart,8,2);
	  $endthn =1*substr($dayend,0,4); $endbln=1*substr($dayend,5,2); $endtgl=1*substr($dayend,8,2);
	  
	  $startcalc = mktime (0,0,0,$startbln,$starttgl,$startthn);
	  $endcalc = mktime (0,0,0,$endbln,$endtgl,$endthn);
	  
	  return round(((($endcalc-$startcalc)/24)/60)/60);
	}

	function umur($daystart,$dayend) {
	  $startthn=1*substr($daystart,0,4); $startbln=1*substr($daystart,5,2); $starttgl=1*substr($daystart,8,2);
	  $endthn =1*substr($dayend,0,4); $endbln=1*substr($dayend,5,2); $endtgl=1*substr($dayend,8,2);
	  if (($endbln-$startbln)<0) {
		$bln=12+$endbln-$startbln; 
		$thn=$endthn-$startthn-1;
	  } else {
		$bln=$endbln-$startbln;
		$thn=$endthn-$startthn;
	  }
	  return ($thn." tahun ".$bln." bulan");
	}

	function umurtahun($daystart,$dayend) {
	  $startthn=1*substr($daystart,0,4); $startbln=1*substr($daystart,5,2); $starttgl=1*substr($daystart,8,2);
	  $endthn =1*substr($dayend,0,4); $endbln=1*substr($dayend,5,2); $endtgl=1*substr($dayend,8,2);
	  if (($endbln-$startbln)<0) {
		$bln=12+$endbln-$startbln; 
		$thn=$endthn-$startthn-1;
	  } else {
		$bln=$endbln-$startbln;
		$thn=$endthn-$startthn;
	  }
	  return $thn;
	}

	function convert2cen($value,$unit){
	  if($unit=='C'){
		return $value;
	  } else if($unit=='F'){
		$cen = ($value - 32) / 1.8;
		return round($cen,2);
	  }
	}
	
	function analytics($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle){
		?>
		<section class="section-34 section-sm-top-14 section-sm-bottom-85 bg-lighter section-graph-demonstration">
			<div class="container">
			  <div class="offset-top-4">
				<div class="isotope-wrap">
				  <div class="row">
					<!-- Isotope Filters-->
					<div class="col-lg-3">
					  <div class="isotope-filters isotope-filters-vertical isotope-filter-collapse-lg">
						<h4 class="text-uppercase text-bold isotope-filters-title offset-top-34"> </h4>
						<ul class="list-inline list-inline-sm">
						  <li class="veil-md">
							<p>Choose your device:</p>
						  </li>
						  <li class="section-relative">
							<button class="isotope-filters-toggle btn btn-sm btn-default" data-custom-toggle="isotope-higcharts" data-custom-toggle-disable-on-blur="true">Filter<span class="caret"></span></button>
							<ul class="list-sm-inline isotope-filters-list" id="isotope-higcharts">
							  <?php
							  $perPage=10;
							  if (isset($_GET['pagefilterchart'])){
								$page = $_GET['pagefilterchart'];
							  } else {
								$page = 1;
							  }

							  if ($page>1){
								$start = ($page * $perPage) - $perPage;
							  } else {
								$start = 0;
							  }

							  $query="SELECT nama_device FROM trx_device where activated=1 and id_device_jenis < 2 LIMIT $start, $perPage";
							  $strq=mysql_query($query) or die(mysql_error());
							  if(mysql_num_rows($strq)>0) {
								for($i=0;$i<mysql_num_rows($strq);$i++){
								$str=mysql_fetch_array($strq);
								echo "<li><a class='text-bold active' data-isotope-filter='Area Graph with Filter ". $i ."' data-isotope-group='gallery' href='#''>".$str[0]."</a></li>";
								}
							  }
							  ?>
							</ul>
						  </li>
						</ul>
					  </div>
					  <div class="range range-xs-center offset-top-20">
						<nav>
						  <ul class="pagination pagination-sm">
							<?php
							  $querys = "Select * From trx_device where activated=1 and id_device_jenis < 2";
							  $datas = mysql_query($querys) or die(mysql_error());
							  $jmlBaris = mysql_num_rows($datas);
							  $halaman = ceil($jmlBaris/$perPage);
							  for($i=1;$i<=$halaman;$i++){
								echo "<li><a href='".$_SERVER["PHP_SELF"]."?menu=Analisis&pagefilterchart=$i''>$i</a></li>";
							  }
							?>
						  </ul>
						</nav>
					  </div>
					</div>
					<!-- Isotope Content-->
					<div class="col-lg-9 offset-lg-top-0 offset-top-34">
					  <div class="isotope" data-isotope-layout="fitRows" data-isotope-group="gallery">
						<div class="row">
						  <!--Isotope item-->
						  <?php
							$query="SELECT id_device, nama_device FROM trx_device where activated=1 and id_device_jenis < 2 LIMIT $start, $perPage";
							$strq=mysql_query($query) or die(mysql_error());
							if(mysql_num_rows($strq)>0) {
							  for($i=0;$i<mysql_num_rows($strq);$i++){
								$str=mysql_fetch_array($strq);
								// <!--Chart for Egg Count & Larva Count-->
								echo "<div class='col-xs-12 isotope-item' data-filter='Area Graph with Filter ". $i ."'>";
								echo "  <div class='bg-white shadow-drop-sm section-34 inset-left-10 inset-right-10 inset-md-left-30 inset-md-right-30 section-graph-demonstration'>";
								echo "    <div>";
								echo "      <h3 class='text-left text-darker'>History Chart ".$str[1]."</h3>";
								echo "    </div>";
								echo "    <div class='offset-top-41'>";
								echo "      <div class='chart-legend' data-chart-id='#high-line3'>";
								echo "        <div class='group-sm text-md-left'><a class='legend-item btn btn-sm btn-deluge' href='#' data-chart-id='0'>Data 1</a><a class='legend-item btn btn-info btn-sm' href='#' data-chart-id='1'>Data 2</a></div>";
								echo "      </div>";
								echo "      <div class='offset-top-14 graph-content'>";
								echo "        <div class='higchart' id='high-line3' data-graph-object='{&quot;credits&quot;:false,&quot;colors&quot;:[&quot;#695999&quot;,&quot;#64aae1&quot;,&quot;#f5bf49&quot;],&quot;chart&quot;:{&quot;backgroundColor&quot;:&quot;transparent&quot;,&quot;className&quot;:&quot;br-r&quot;,&quot;type&quot;:&quot;line&quot;,&quot;zoomType&quot;:&quot;x&quot;,&quot;panning&quot;:true,&quot;panKey&quot;:&quot;shift&quot;,&quot;marginTop&quot;:25,&quot;marginRight&quot;:1},&quot;title&quot;:{&quot;text&quot;:null},&quot;xAxis&quot;:{&quot;gridLineColor&quot;:&quot;#EEE&quot;,&quot;lineColor&quot;:&quot;#EEE&quot;,&quot;tickColor&quot;:&quot;#EEE&quot;,&quot;labels&quot;:{&quot;style&quot;:{&quot;color&quot;:&quot;#9b9b9b&quot;,&quot;fontSize&quot;:&quot;12px&quot;,&quot;fontWeight&quot;:&quot;400&quot;,&quot;fontFamily&quot;:&quot;Lato&quot;}},&quot;categories&quot;:[";
								$counter0=mysql_query("set @counter=0") or die(mysql_error());
								$querys=mysql_query("SELECT waktu, DATE_FORMAT(waktu, '&quot;%H:%i&quot;,') as time, @counter:=@counter+1 as IncrementingValuebyOne FROM trx_device_anal where id_device = ".$str[0]." ORDER BY waktu desc LIMIT 25") or die(mysql_error());
								$counter0=mysql_query("select @counter:=@counter as counter;") or die(mysql_error());
								$k = mysql_fetch_array($counter0);
								$counter = $k['counter'];

								while ($data = mysql_fetch_array($querys)) {
								  $waktu=$data['time'];
								  if ($data['IncrementingValuebyOne']==$counter){
									echo rtrim($waktu,",");
								  } else {
									echo $waktu;
								  }
								}
								echo "]},&quot;yAxis&quot;:{&quot;min&quot;:0,&quot;tickInterval&quot;:10,&quot;gridLineColor&quot;:&quot;#f6f6f6&quot;,&quot;title&quot;:{&quot;text&quot;:null},&quot;labels&quot;:{&quot;style&quot;:{&quot;color&quot;:&quot;#9b9b9b&quot;,&quot;fontSize&quot;:&quot;12px&quot;,&quot;fontWeight&quot;:&quot;400&quot;,&quot;fontFamily&quot;:&quot;Lato&quot;}}},&quot;plotOptions&quot;:{&quot;spline&quot;:{&quot;lineWidth&quot;:3},&quot;area&quot;:{&quot;fillOpacity&quot;:0.2}},&quot;legend&quot;:{&quot;enabled&quot;:false},&quot;series&quot;:[{&quot;name&quot;:&quot;Egg&quot;,&quot;data&quot;:[";
								$counter=mysql_query("set @counter=0") or die(mysql_error());
								$querys=mysql_query("SELECT @counter:=@counter+1 as IncrementingValuebyOne, CONCAT(egg_count, ',') as egg_count FROM trx_device_anal where id_device = ".$str[0]." ORDER BY waktu desc LIMIT 25") or die(mysql_error());
								$counter0=mysql_query("select @counter:=@counter as counter;") or die(mysql_error());
								$k = mysql_fetch_array($counter0);
								$counter = $k['counter'];
								while ($data = mysql_fetch_array($querys)) {
								  $egg_count=$data['egg_count'];
								  if ($data['IncrementingValuebyOne']==$counter){
									echo rtrim($egg_count,",");
								  } else {
									echo $egg_count;
								  }
								}
								echo "]},{&quot;name&quot;:&quot;Larva&quot;,&quot;data&quot;:[";
								$counter=mysql_query("set @counter=0") or die(mysql_error());
								$querys=mysql_query("SELECT @counter:=@counter+1 as IncrementingValuebyOne, CONCAT(larva_count, ',') as larva_count FROM trx_device_anal where id_device = ".$str[0]." ORDER BY waktu desc LIMIT 25") or die(mysql_error());
								$counter0=mysql_query("select @counter:=@counter as counter;") or die(mysql_error());
								$k=mysql_fetch_array($counter0);
								$counter = $k['counter'];
								while ($data = mysql_fetch_array($querys)) {
								  $larva_count=$data['larva_count'];
								  if ($data['IncrementingValuebyOne']==$counter){
									echo rtrim($larva_count,",");
								  } else {
									echo $larva_count;
								  }
								}
								echo "]}]}' style='width: 100%; height: 360px; margin: 0 auto;''></div>";
								echo "      </div>";
								echo "   </div>";
								echo "  </div>";
								echo "</div>";

								// <!--Chart for Mosq Egg-->
								echo "<div class='col-xs-12 isotope-item' data-filter='Area Graph with Filter ". $i ."'>";
								echo "  <div class='bg-white shadow-drop-sm section-34 inset-left-10 inset-right-10 inset-md-left-30 inset-md-right-30 section-graph-demonstration'>";
								echo "    <div>";
								echo "      <h3 class='text-left text-darker'>History Chart ".$str[1]."</h3>";
								echo "    </div>";
								echo "    <div class='offset-top-41'>";
								echo "      <div class='chart-legend' data-chart-id='#high-lines3'>";
								echo "        <div class='group-sm text-md-left'><a class='legend-item btn btn-sm btn-deluge' href='#' data-chart-id='0'>Data 1</a></div>";
								echo "      </div>";
								echo "      <div class='offset-top-14 graph-content'>";
								echo "      <div class='higchart' id='high-lines3' data-graph-object='{&quot;credits&quot;:false,&quot;colors&quot;:[&quot;#695999&quot;,&quot;#64aae1&quot;,&quot;#695999&quot;,&quot;#42b574&quot;],&quot;chart&quot;:{&quot;type&quot;:&quot;column&quot;,&quot;zoomType&quot;:&quot;x&quot;,&quot;panning&quot;:true,&quot;panKey&quot;:&quot;shift&quot;,&quot;marginRight&quot;:50,&quot;marginTop&quot;:5},&quot;title&quot;:{&quot;text&quot;:null},&quot;xAxis&quot;:{&quot;gridLineColor&quot;:&quot;#EEE&quot;,&quot;lineColor&quot;:&quot;#EEE&quot;,&quot;labels&quot;:{&quot;style&quot;:{&quot;color&quot;:&quot;#9b9b9b&quot;,&quot;fontSize&quot;:&quot;12px&quot;,&quot;fontWeight&quot;:&quot;400&quot;,&quot;fontFamily&quot;:&quot;Lato&quot;}},&quot;tickColor&quot;:&quot;#EEE&quot;,&quot;categories&quot;:[";
								$counter0=mysql_query("set @counter=0") or die(mysql_error());
								$querys=mysql_query("SELECT waktu, DATE_FORMAT(waktu, '&quot;%H:%i&quot;,') as time, @counter:=@counter+1 as IncrementingValuebyOne FROM trx_device_anal where id_device = ".$str[0]." ORDER BY waktu desc LIMIT 25") or die(mysql_error());
								$counter0=mysql_query("select @counter:=@counter as counter;") or die(mysql_error());
								$k = mysql_fetch_array($counter0);
								$counter = $k['counter'];

								while ($data = mysql_fetch_array($querys)) {
								  $waktu=$data['time'];
								  if ($data['IncrementingValuebyOne']==$counter){
									echo rtrim($waktu,",");
								  } else {
									echo $waktu;
								  }
								}
								echo "]},&quot;tooltip&quot;:{&quot;headerFormat&quot;:&quot;&lt;span style=\&quot;font-size:10px\&quot;&gt;{point.key}&lt;/span&gt;&lt;table&gt;&quot;,&quot;pointFormat&quot;:&quot;&lt;tr&gt;&lt;td style=\&quot;color:{series.color};padding:0\&quot;&gt;{series.name}: &lt;/td&gt;&lt;td style=\&quot;padding:0\&quot;&gt;&lt;b&gt;{point.y:.0f} %&lt;/b&gt;&lt;/td&gt;&lt;/tr&gt;&quot;,&quot;footerFormat&quot;:&quot;&lt;/table&gt;&quot;,&quot;shared&quot;:true,&quot;useHTML&quot;:true},&quot;yAxis&quot;:{&quot;max&quot;:100,&quot;tickInterval&quot;:20,&quot;gridLineColor&quot;:&quot;#EEE&quot;,&quot;title&quot;:{&quot;text&quot;:&quot;Traffic ( % )&quot;,&quot;style&quot;:{&quot;color&quot;:&quot;#695999&quot;,&quot;fontWeight&quot;:&quot;700&quot;}},&quot;labels&quot;:{&quot;style&quot;:{&quot;color&quot;:&quot;#9b9b9b&quot;,&quot;fontSize&quot;:&quot;12px&quot;,&quot;fontWeight&quot;:&quot;400&quot;,&quot;fontFamily&quot;:&quot;Lato&quot;}}},&quot;plotOptions&quot;:{&quot;spline&quot;:{&quot;lineWidth&quot;:3},&quot;area&quot;:{&quot;fillOpacity&quot;:0.2}},&quot;legend&quot;:{&quot;enabled&quot;:false},&quot;series&quot;:[{&quot;name&quot;:&quot;Mosquito Type&quot;,&quot;data&quot;:[";
								$counter=mysql_query("set @counter=0") or die(mysql_error());
								$querys=mysql_query("SELECT @counter:=@counter+1 as IncrementingValuebyOne, waktu, CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(type_mosq, '%&', 1), '=', -1), ',') as type_mosq FROM trx_device_anal_type where id_device = ".$str[0]." ORDER BY waktu desc LIMIT 25;") or die(mysql_error());
								$counter0=mysql_query("select @counter:=@counter as counter;") or die(mysql_error());
								$k = mysql_fetch_array($counter0);
								$counter = $k['counter'];
								while ($data = mysql_fetch_array($querys)) {
								  $type_mosq=$data['type_mosq'];
								  if ($data['IncrementingValuebyOne']==$counter){
									echo rtrim($type_mosq,",");
								  } else {
									echo $type_mosq;
								  }
								}
								echo "]}]}' style='width: 100%; height: 360px; margin: 0 auto;'></div>";
								echo "      </div>";
								echo "   </div>";
								echo "  </div>";
								echo "</div>";
							  }
							} else {
							  echo "Tidak Ada Data ...!";
							}
						  ?>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		</section>
		<?php
	}
	
	function user($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle){
		$dispform=false;
		if ($menu == "user" && $submenu== "View" && $akses=="SU") {
			echo "<section class='section-98 section-sm-50'>";
			echo "	<div class='shell'>";
			echo "	<section class='section-bottom-20'>";
			echo "	<center><form name='form_action' method='get' action='$_SERVER[PHP_SELF]'>Filter by Name : ";
			echo "		<input type='hidden' name='menu' value='user'><input type='hidden' name='sub' value='View'>";
			echo "		<input type='hidden' name='filter' value='namalengkap'>";
			echo "		<input type='text' name='filtervalue' width='300' value='".$fval."'>";
			echo "		<input type='submit' name='submit' value='Search'>";
			echo "		</form></center>";
			echo "	</section>";
            echo "		<div class='table-responsive clearfix'>";
			echo "			<table class='table table-custom' data-responsive='true'>";
			echo "				<tr>";
			echo "  				<th class='text-regular text-dark big' width='10'>Login</th>";
			echo "  				<th class='text-regular text-dark big'>Full Name</th>";
			echo "  				<th class='text-regular text-dark big'>Address</th>";
			echo "  				<th class='text-regular text-dark big'>Position</th>";
			echo "  				<th class='text-regular text-dark big'>Phone</th>";
			if ($otoritas>2) echo " <th class='text-regular text-dark big' width='500'>Action</th>";
			echo "				</tr>";
			
			$query="select a.id_pengguna,a.username,a.nama_pengguna,a.alamat,b.jabatan_sdm,a.telephone from trx_pengguna a, mst_pengguna_jabatan b where a.id_jabatan=b.id_jabatan and a.activated=true";
			if ($filter=="namalengkap") $query.=" and a.nama_pengguna like '%".$fval."%'";
			$strq=mysql_query($query) or die(mysql_error());
			if(mysql_num_rows($strq)>0) {
				for($i=0;$i<mysql_num_rows($strq);$i++){
					$str=mysql_fetch_array($strq);
					echo "		<tr>";
					for ($k=1;$k<mysql_num_fields($strq);$k++){
						echo "		<td>&nbsp;".$str[$k]."&nbsp;</td>";	  
					}
					if ($otoritas>2) {
						echo "		<form name='form_action' method='get' action='$_SERVER[PHP_SELF]'><td>";
						echo "		<input type='hidden' name='menu' value='user'>";
						echo "		<input type='hidden' name='id' value='".$str[0]."'>";
						echo "		<button class='btn btn-xs btn-info mdi mdi-eye' type='submit' name='sub' value='Detail'></button> | ";
						echo "		<button class='btn btn-xs btn-warning mdi mdi-border-color' type='submit' name='sub' value='Edit'></button> | ";
						if ($otoritas>3) echo "<button class='btn btn-xs btn-danger btn-icon mdi mdi-delete' type='submit' name='sub' value='Delete'></button> ";
						echo "		</td></form>";
					}
					echo"		</tr>";
				}
			}
			echo "			</table>";
			echo "		</div>";
			echo "	</div>";
			echo "</section>";
		} elseif ($menu == "user" && $submenu== "View" && $akses!="SU") {
			echo "<section class='section-98 section-sm-50'>";
			echo "	<div class='shell'>";
			echo "	<section class='section-bottom-20'>";
			echo "	<center><form name='form_action' method='get' action='$_SERVER[PHP_SELF]'>Filter by Name : ";
			echo "		<input type='hidden' name='menu' value='user'><input type='hidden' name='sub' value='View'>";
			echo "		<input type='hidden' name='filter' value='namalengkap'>";
			echo "		<input type='text' name='filtervalue' width='300' value='".$fval."'>";
			echo "		<input type='submit' name='submit' value='Search'>";
			echo "		</form></center>";
			echo "	</section>";
            echo "		<div class='table-responsive clearfix'>";
			echo "			<table class='table table-custom' data-responsive='true'>";
			echo "				<tr>";
			echo "  				<th class='text-regular text-dark big'>NIP</th>";
			echo "  				<th class='text-regular text-dark big'>Full Name</th>";
			echo "  				<th class='text-regular text-dark big'>Address</th>";
			echo "  				<th class='text-regular text-dark big'>Position</th>";
			echo "  				<th class='text-regular text-dark big'>Phone</th>";
			if ($otoritas>2) echo " <th class='text-regular text-dark big' width='500'>Action</th>";
			echo "				</tr>";
			
			$query="select a.id_pengguna,a.username,a.nip,a.nama_pengguna,a.alamat,b.jabatan_sdm,a.telephone from trx_pengguna a, mst_pengguna_jabatan b where a.activated=true and a.id_jabatan=b.id_jabatan and a.id_akses > 1 ";
			if ($filter=="namalengkap") $query.=" and a.nama_pengguna like '%".$fval."%'";
			$strq=mysql_query($query) or die(mysql_error());
			if(mysql_num_rows($strq)>0) {
				for($i=0;$i<mysql_num_rows($strq);$i++){
					$str=mysql_fetch_array($strq);
					echo "		<tr>";
					for ($k=2;$k<mysql_num_fields($strq);$k++){
						echo "		<td>&nbsp;".$str[$k]."&nbsp;</td>";	  
					}
					if ($otoritas>2) {
						echo "		<form name='form_action' method='get' action='$_SERVER[PHP_SELF]'><td>";
						echo "		<input type='hidden' name='menu' value='user'>";
						echo "		<input type='hidden' name='id' value='".$str[0]."'>";
						echo "		<button class='btn btn-xs btn-info mdi mdi-eye' type='submit' name='sub' value='Detail'></button> | ";
						echo "		<button class='btn btn-xs btn-warning mdi mdi-border-color' type='submit' name='sub' value='Edit'></button> ";
						if ($otoritas>3) echo "		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-xs btn-danger btn-icon mdi mdi-delete' type='submit' name='sub' value='Delete'></button> ";
						echo "		</td></form>";
					}
					echo"		</tr>";
				}
			}
			echo "			</table>";
			echo "		</div>";
			echo "	</div>";
			echo "</section>";
		} else {
			if ($menu == "user" && $submenu== "Add") {
				?>
				<form id="form1" name="form1" method="post" action="">
					<table width="422" border="0" align ="center">
						<tr>
							<td width="390"><?php if($_POST['yes']){ 
								echo "";
								$dispform=true;
							} else { 
								echo "Will this employee be given Application Access? &nbsp;&nbsp;<br/>";
								echo "<input type=\"submit\" name=\"yes\" id=\"yes\" value=\"Yes\" /> <input type=\"submit\" name=\"yes\" id=\"yes\" value=\"No\" />";
							}
							?>
							</td>
						</tr>
					</table>
				</form>
				<?php
				$username="";
				$password="";
				$namapengguna="";
				$nip=""; 
				$tgllahir="";
				$kelamin=1;
				$alamat="";
				$agama=1;
				$email="";
				$telepon="";
				$jabatan=1;
				$portofolio="";
				$photo1="";
				$otoriras=1;
				$akses=1;
				$cek=1;
			} elseif (($menu=="user") && ($submenu== "Detail" || $submenu=="Edit" || $submenu=="Delete")) {
				$dispform=true;
				$query="select username,password from trx_pengguna where id_pengguna='".$id."'";
				$strq=mysql_query($query) or die(mysql_error()); $str=mysql_fetch_array($strq);
				if ($str[0]<>"") {
					$query="select a.id_pengguna,a.username ,a.password ,a.nama_pengguna, a.nip ,a.tanggal_lahir,b.nama_kelamin, a.alamat, a.telephone, c.id_agama,a.email, d.jabatan_sdm, e.jabatan, f.otoritas, a.portofolio, a.id_otoritas, a.id_akses from trx_pengguna a, mst_kelamin b, mst_agama c, mst_pengguna_jabatan d, mst_akses e, mst_akses_otoritas f where a.id_kelamin = b.id_kelamin and a.id_agama=c.id_agama and a.id_jabatan=d.id_jabatan and a.id_akses=e.id_akses and a.id_otoritas=f.id_otoritas and a.id_pengguna='".$id."'";
				} else {
					$query="select a.id_pengguna,a.username ,a.password ,a.nama_pengguna, a.nip ,a.tanggal_lahir,b.nama_kelamin, a.alamat, a.telephone,c.agama,a.email,a.portofolio, j.jabatan_sdm, a.id_akses from trx_pengguna a, mst_kelamin b, mst_agama c, mst_pengguna_jabatan j where a.id_kelamin = b.id_kelamin and a.id_agama=c.id_agama and a.id_jabatan=j.id_jabatan and a.id_pengguna='".$id."'";
					$cek="null";
				}
				$strq=mysql_query($query) or die(mysql_error());
				$str=mysql_fetch_array($strq);
				$username=$str['username'];
				$password=$str['password'];
				$namapengguna=$str['nama_pengguna'];
				$nip=$str['nip'];
				$tgllahir=$str['tanggal_lahir'];
				$kelamin=$str['nama_kelamin'];
				$alamat=$str['alamat'];
				$id_agama=$str['id_agama'];
				$email=$str['email'];
				$telepon=$str['telephone'];
				$jabatansdm=$str['jabatan_sdm'];
				$portofolio=$str['portofolio'];
				$photo1=$str['photo1'];
				$idakses=$str['id_akses'];
				$otoritas=$str['otoritas'];	
				$id_otoritas=$str['id_otoritas'];
				$aksesappl=$str['jabatan'];
			}
			
			if ($dispform) {
				?>			
				<form id="formInputDataUser" name="formInputDataUser" method="post" action="">
					<section class="section-98 section-sm-50">
						<div class="shell">
							<?php if ($submenu == "Add"){ ?><h1>Input Data User</h1> <hr class="divider divider-sm bg-mantis">
							<?php }elseif ($submenu == "Edit"){ ?><h1>Edit Data User</h1> <hr class="divider divider-sm bg-mantis">
							<?php }elseif ($submenu == "Delete"){ ?><h1>Delete Data User</h1> <hr class="divider divider-sm bg-mantis">
							<?php } if (($submenu == "Detail" && $cek!="null")||($submenu == "Add" && $_POST['yes']=="Yes")||$submenu == "Edit") {?>
								<div class="range range-md-bottom range-sm-center text-left" style="margin-top: 5px;">
									<div class="cell-sm-7 cell-md-4">
										<div class="form-group">
										  <label class="form-label form-label-outside" for="username">Username</label>
										  <input class="form-control" id="username" name="username" type="text" value="<?php echo $username; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
										</div>
										<div class="form-group">
										  <label class="form-label form-label-outside" for="password">Password</label>
										  <input class="form-control" id="password" name="password" type="password" value="<?php echo $password; ?>" <?php if($submenu<>"Add") echo "disabled='disabled'"; ?> data-constraints="@Required">
										</div>
										<div class="form-group">
										  <label class="form-label form-label-outside" for="confirmpassword">Confirm Password</label>
										  <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" value="<?php echo $password; ?>" <?php if($submenu<>"Add") echo "disabled='disabled'"; ?> data-constraints="@Required">
										</div>
									</div>
									<div class="cell-sm-7 offset-top-20 cell-md-4 offset-md-top-0">
										<div class="form-group">
										  <label class="form-label form-label-outside" for="aksessdm">Access Level</label>
										  <select class="form-control select-filter" name="aksessdm" id="aksessdm" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
											<?php
											$q= mysql_query("select * from mst_akses");
											while($dengue=mysql_fetch_object($q)){
											echo"<option "; if ($dengue->id_akses==$idakses) echo " selected ='yes' ";echo"<option value=\"$dengue->id_akses\">$dengue->jabatan</option>";
											}
											?>
										  </select>
										</div>
										<div class="form-group">
										  <label class="form-label form-label-outside" for="otoritas">Otority</label>
										  <select class="form-control select-filter" name="otoritas" id="otoritas" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
											<?php 
											$q= mysql_query("select * from mst_akses_otoritas");
											while($dengue=mysql_fetch_object($q)){
											echo"<option "; if ($dengue->id_otoritas==$id_otoritas) echo " selected ='yes' ";echo"<option value=\"$dengue->id_otoritas\">$dengue->otoritas</option>";
											}
											?>
										  </select>
										</div>
										<br/><br/>
									</div>
								</div>
								<hr class="divider divider-sm bg-mantis">
							<?php } ?>
							<div class="range range-md-bottom range-sm-center text-left" style="margin-top: 5px;">
								<div class="cell-sm-7 cell-md-4">
									<div class="form-group">
									  <label class="form-label form-label-outside" for="nipsdm">NIP</label>
									  <input class="form-control" id="nipsdm" name="nipsdm" type="text" value="<?php echo $nip; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="namasdm">Full Name</label>
									  <input class="form-control" id="namasdm" name="namasdm" type="text" value="<?php echo $namapengguna; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="tgl_lahir">Date</label>
									  <input class="form-control" maxlength="11" name="tgl_sdm" id="tgl_lahir" type="text" value="<?php if ($tgllahir) echo dbasetotgl($tgllahir); else echo "";?>" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?> data-constraints="@Required">
										<?php if ($submenu<>"Detail") { ?>
										<img src="images/cal.gif" onclick="javascript:NewCssCal('tgl_lahir','ddmmmyyyy')" style="cursor:pointer"/>
										<?php } ?>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="kelaminsdm">Gender</label>
									  <select class="form-control select-filter" name="kelaminsdm" id="kelaminsdm" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
										<?php 
										$q= mysql_query("select*from mst_kelamin");
										while($dengue=mysql_fetch_object($q)){
										echo"<option "; if ($dengue->nama_kelamin==$id_kelamin) echo " selected ='yes' ";echo"<option value=\"$dengue->id_kelamin\">$dengue->nama_kelamin</option>";
										}
										?>
									  </select>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="alamatsdm">Address</label>
									  <textarea class="form-control" id="alamatsdm" name="alamatsdm" type="text" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?> data-constraints="@Required"><?php echo $alamat; ?></textarea>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="agamasdm">Religion</label>
									  <select class="form-control select-filter" name="agamasdm" id="agamasdm" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
										<?php 
										$q= mysql_query("select*from mst_agama");
										while($dengue=mysql_fetch_object($q)){
										echo"<option "; if ($dengue->id_agama==$id_agama) echo " selected ='yes' ";echo"<option value=\"$dengue->id_agama\">$dengue->agama</option>";
										}
										?>
									  </select>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="teleponsdm">Telephone</label>
									  <input class="form-control" id="teleponsdm" name="teleponsdm" type="text" value="<?php echo $telepon; ?>" data-constraints="@Required @Numeric" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="emailsdm">Email</label>
									  <input class="form-control" id="emailsdm" name="emailsdm" type="text" value="<?php echo $email; ?>" data-constraints="@Required @Email" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="jabatansdm">Position</label>
									  <select class="form-control select-filter" name="jabatansdm" id="jabatansdm" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
										<?php 
										$q= mysql_query("select * from mst_pengguna_jabatan");
										while($dengue=mysql_fetch_object($q)){
										echo"<option "; if ($dengue->jabatan_sdm==$jabatan_sdm) echo " selected ='yes' ";echo"<option value=\"$dengue->id_jabatan\">$dengue->jabatan_sdm</option>";
										}
										?>
									  </select>
									</div>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="portofoliosdm">Portofolio</label>
									  <textarea class="form-control" id="portofoliosdm" name="portofoliosdm" type="text" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>><?php echo $portofolio; ?></textarea>
									</div>
								</div>
							</div>
							<div class="group offset-top-34">
								<?php 
								echo "<input type='hidden' name='menu' value='user'>";
								echo "<input type='hidden' name='sub' value='".$submenu."'>";
								if ($submenu=="Add") {
									echo "<input type='hidden' name='act' value='Add'>";
									echo "<button class='btn-primary btn btn-nuka-effect' name='AddSDM' type='submit'><span>Add Data</span></button>";
									echo "<button class='btn-warning btn btn-nuka-effect' name='CancelSDM' type='submit'><span>Cancel</span></button>";
								} else {
									echo "<input type='hidden' name='id' value='".$str["id_pengguna"]."'>";
									if ($submenu=="Edit") { 
										if ($akses=="SU"||$akses=="ADM") echo "<button class='btn-primary btn btn-nuka-effect' name='EditSDM' type='submit'><span>Edit Data</span></button>";
										echo "<button class='btn-warning btn btn-nuka-effect' name='CancelSDM' type='submit'><span>Cancel</span></button>";
									} elseif ($submenu=="Delete") { 
										//echo "<script>alert('ANDA YAKIN AKAN MENGHAPUS DATA?')</script>";
										echo "<font size=-1><i>Are you sure, you want to delete ?</i></font>";
										echo "<input type='submit' name='DeleteSDM' value='Delete'>";
									}
								}
								?>
							</div>
						</div>
					</section>
				</form>
				<?php
			}
		}
	}
	
	function device($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle){
		if ($submenu=="View"){
			echo "<section class='section-98 section-sm-50'>";
			echo "	<div class='shell'>";
			echo "	<section class='section-bottom-20'>";
			if(isset($_POST['fnamadevice'])) $fnamadevice=$_POST['fnamadevice']; else $fnamadevice="";
			echo "	<center><form name='form_action' method='post' action='$_SERVER[PHP_SELF]'>Filter by : "; //JUDUL FILTER
			echo "	<input type='hidden' name='menu' value='device'><input type='hidden' name='sub' value='View'>";
			echo "	<input type='hidden' name='filter' value='namadevice'>";  //VALUE DIISI DG FIELD APA YG DI FILTER
			echo "	<table bgcolor='white'>";
			echo "	<tr>";
			echo "	<td>Device Name : &nbsp;&nbsp;&nbsp;</td><td><input type='text' name='fnamadevice' width='300' value='".$fnamadevice."'></td>";
			echo "	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			echo "	<td>&nbsp;&nbsp;&nbsp;Device Connection : &nbsp;&nbsp;&nbsp;</td><td width='150'>";
			echo "	<select name='filter'>";
			echo "		<option "; if ($filter=="all") echo "selected=yes"; echo "  value='all'>All Connection</option>";
			echo "		<option "; if ($filter=="connected") echo "selected=yes"; echo " value='connected'>Connected</option>";
			echo "		<option "; if ($filter=="disconnected") echo "selected=yes"; echo "  value='disconnected'>Disconnected</option>";
			echo "	</select>";
			echo "	</td>";
			echo "	</tr>";
			echo "	<tr>";
			echo "	</td><td align=right colspan=3><input type='submit' name='submit' value='Search'></td>";
			echo "	</tr>";
			echo "	</table>";
			echo "	</form></center>";
			echo "	</section>";
            echo "		<div class='table-responsive clearfix'>";
			echo "			<table class='table table-custom' data-responsive='true'>";
			echo "				<tr>";
			echo "  				<th class='text-regular text-dark big'>Device Name</th>";
			echo "  				<th class='text-regular text-dark big'>Date Activ</th>";
			echo "  				<th class='text-regular text-dark big'>Device Condition</th>";
			echo "  				<th class='text-regular text-dark big'>Owner</th>";
			echo "  				<th class='text-regular text-dark big'>Address</th>";
			if ($otoritas>2) echo " <th class='text-regular text-dark big' width='280'>Action</th>";
			echo "				</tr>";
			
			if (isset($_POST['submit'])||isset($_GET['submit'])) {
				$query="select a.id_device, a.nama_device, DATE_FORMAT(a.date_activate,'%W %M %e %Y') date_activ, IF (a.connection='1', CONCAT('<b>Connection:</b> ', IF (a.`connection`='1', 'Connected', 'Disconnected'),', <b>Battery:</b> ', a.battery,'%, <b>Power:</b> ', IF (a.power='1', 'Plug', 'Unplugged')), '<b>Device:</b> Disconnected') as status_device, b.nama_pengguna, b.alamat from trx_device a, trx_pengguna b where a.id_pengguna=b.id_pengguna and a.activated = 1 ";
				if ($_POST['fnamadevice']<>"") $query.=" and a.nama_device like '%".$_POST['fnamadevice']."%'";
				if ($filter=="connected") $query.=" and a.connection = 1 "; elseif($filter=="disconnected") $query.=" and a.connection = 0";
			} else {
				$query="select a.id_device, a.nama_device, DATE_FORMAT(a.date_activate,'%W %M %e %Y') date_activ, IF (a.connection='1', CONCAT('<b>Connection:</b> ', IF (a.`connection`='1', 'Connected', 'Disconnected'),', <b>Battery:</b> ', a.battery,'%, <b>Power:</b> ', IF (a.power='1', 'Plug', 'Unplugged')), '<b>Device:</b> Disconnected') as status_device, b.nama_pengguna, b.alamat from trx_device a, trx_pengguna b where a.id_pengguna=b.id_pengguna and a.activated = 1 ";
			}
			$strq=mysql_query($query) or die(mysql_error());
			if(mysql_num_rows($strq)>0) {
				for($i=0;$i<mysql_num_rows($strq);$i++){
					$str=mysql_fetch_array($strq);
					echo "		<tr>";
					for ($k=1;$k<mysql_num_fields($strq);$k++){
						echo "		<td>&nbsp;".$str[$k]."&nbsp;</td>";	  
					}
					if ($otoritas>2) {
						echo "		<form name='form_action' method='get' action='$_SERVER[PHP_SELF]'><td>";
						echo "		<input type='hidden' name='menu' value='device'>";
						echo "		<input type='hidden' name='id' value='".$str[0]."'>";
						echo "		<button class='btn btn-xs btn-info mdi mdi-eye' type='submit' name='sub' value='Detail'></button> | ";
						echo "		<button class='btn btn-xs btn-warning mdi mdi-border-color' type='submit' name='sub' value='Edit'></button> | ";
						if ($otoritas>3) echo "<button class='btn btn-xs btn-danger btn-icon mdi mdi-delete' type='submit' name='sub' value='Delete'></button> ";
						echo "		</td></form>";
					}
					echo"		</tr>";
				}
			}
			echo "			</table>";
			echo "		</div>";
			echo "	</div>";
			echo "</section>";
		} else {
			if($submenu=="Add"){
				$id_pengguna=1;
				$id_device_jenis=1;
				$id_lokasi=1;
				$date_activate="";
				$nama_device="";
				$pemilik="";
				$imei1="";
				$imei2="";
				$serial_number="";
				$credential_number="";
				$capture_path="";
				$sound_path="";
				$video_path="";
				$device_path="";
				$latitudedev="";
				$longitudedev="";
				$waktu_capture="";
				$battery="";
				$power="";
				$light="";
				$connection="";
				$egg_counting="";
				$larva_counting="";
				$type_counting="";
				$result="";
			} elseif ($submenu=="Detail" || $submenu=="Edit" || $submenu=="Delete") {
				$query="select a.id_device, b.id_pengguna, b.nama_pengguna, c.id_device_jenis, c.jenis_device, d.id_lokasi, d.point_name, a.date_activate, a.nama_device, a.pemilik, a.imei1, a.imei2,a.credential_qr, a.serial_number, a.latitude, a.longitude from trx_device a, trx_pengguna b, mst_device_jenis c, mst_lokasi d where a.id_pengguna=b.id_pengguna and a.id_device_jenis=c.id_device_jenis and a.id_lokasi=d.id_lokasi and a.activated = 1 and a.id_device='".$id."'";
				$strq=mysql_query($query) or die(mysql_error());
				$str=mysql_fetch_array($strq);
				$nama_device=$str['nama_device'];
				$date_activate=date_create($str['date_activate']);
				$imei1=$str['imei1'];
				$imei2=$str['imei2'];
				$serial_number=$str['serial_number'];
				$credential_number=DecryptThis($str['credential_qr']);
				$latitudedev=$str['latitude'];
				$longitudedev=$str['longitude'];
				$id_pengguna=$str['id_pengguna'];
				$nama_pengguna=$str['nama_pengguna'];
				$id_lokasi=$str['id_lokasi'];
				$point_name=$str['point_name'];
				$id_device_jenis=$str['id_device_jenis'];
				$jenis_device=$str['jenis_device'];
				$pemilikdev=$str['pemilik'];
			}
			?>
			<form id="formInputDataDevice" name="formInputDataDevice" method="post" action="">
				<section class="section-98 section-sm-50">
					<div class="shell">
						<?php if ($submenu == "Add"){ ?><h1>Input Data Device</h1> <hr class="divider divider-sm bg-mantis">
						<?php }elseif ($submenu == "Edit"){ ?><h1>Edit Data Device</h1> <hr class="divider divider-sm bg-mantis">
						<?php }elseif ($submenu == "Delete"){ ?><h1>Delete Data Device</h1> <hr class="divider divider-sm bg-mantis"> <?php } ?>
						<div class="range range-md-bottom range-sm-center text-left" style="margin-top: 5px;">
							<div class="cell-sm-7 cell-md-4">
								<div class="form-group">
								  <label class="form-label form-label-outside" for="nama_device">Nama Device</label>
								  <input class="form-control" id="nama_device" name="nama_device" type="text" value="<?php echo $nama_device; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="date_activate">Date Activate</label>
								  <input class="form-control" id="date_activate" type="text" name="date_activate" value="<?php echo date_format($date_activate, 'l d F Y'); ?>" data-constraints="@Required" data-time-picker="date" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="imei1">Imei 1</label>
								  <input class="form-control" maxlength="15" id="imei1" name="imei1" type="text" value="<?php echo $imei1; ?>" data-constraints="@Required @Numeric" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="imei1">Imei 2</label>
								  <input class="form-control" maxlength="15" id="imei2" name="imei2" type="text" value="<?php echo $imei2; ?>" data-constraints="@Required @Numeric" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="serial_number">Serial Number</label>
								  <input class="form-control" maxlength="18" id="serial_number" name="serial_number" type="text" value="<?php echo $serial_number; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="credential_number">Credential QR</label>
								  <input class="form-control" id="credential_number" name="credential_number" type="text" value="<?php echo $credential_number; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="latitudedev">Latitude</label>
								  <input class="form-control" id="latitudedev" name="latitudedev" type="text" value="<?php echo $latitudedev; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="longitudedev">Longitude</label>
								  <input class="form-control" id="longitudedev" name="longitudedev" type="text" value="<?php echo $longitudedev; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="penggunadev">User OvTrapIoT</label>
								  <select class="form-control select-filter" name="penggunadev" id="penggunadev" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
									<?php 
									$q= mysql_query("select*from trx_pengguna where id_jabatan > 1");
									while($dengue=mysql_fetch_object($q)){
									echo"<option "; if ($dengue->id_pengguna==$id_pengguna) echo " selected ='yes' ";echo"<option value=\"$dengue->id_pengguna\">$dengue->nama_pengguna</option>";
									}
									?>
								  </select>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="locdev">Location Installation</label>
								  <select class="form-control select-filter" name="locdev" id="locdev" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
									<?php 
									$q= mysql_query("select*from mst_lokasi");
									while($dengue=mysql_fetch_object($q)){
									echo"<option "; if ($dengue->id_lokasi==$id_lokasi) echo " selected ='yes' ";echo"<option value=\"$dengue->id_lokasi\">$dengue->point_name</option>";
									}
									?>
								  </select>
								</div>
								<div class="form-group">
								  <label class="form-label form-label-outside" for="typedev">Device Type</label>
								  <select class="form-control select-filter" name="typedev" id="typedev" data-placeholder="Select an option" data-minimum-results-for-search="Infinity" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled"; ?>>
									<?php 
									$q= mysql_query("select*from mst_device_jenis");
									while($dengue=mysql_fetch_object($q)){
									echo"<option "; if ($dengue->id_device_jenis==$id_device_jenis) echo " selected ='yes' ";echo"<option value=\"$dengue->id_device_jenis\">$dengue->jenis_device</option>";
									}
									?>
								  </select>
								</div>
								<?php
								if ($submenu=="Detail" || $submenu=="Delete"){
									?>
									<div class="form-group">
									  <label class="form-label form-label-outside" for="longitudedev">Development</label>
									  <input class="form-control" id="pemilikdev" name="pemilikdev" type="text" value="<?php echo $pemilikdev; ?>" data-constraints="@Required" <?php if($submenu=="Detail" || $submenu=="Delete") echo "disabled='disabled'"; ?>>
									</div>
									<?php
								}
								?>
							</div>
						</div>
						<div class="group offset-top-34">
							<?php 
							echo "<input type='hidden' name='menu' value='device'>";
							echo "<input type='hidden' name='sub' value='".$submenu."'>";
							if ($submenu=="Add") {
								echo "<input type='hidden' name='act' value='Add'>";
								echo "<button class='btn-primary btn btn-nuka-effect' name='AddDevice' type='submit'><span>Add Data</span></button>";
								echo "<button class='btn-warning btn btn-nuka-effect' name='CancelDevice' type='submit'><span>Cancel</span></button>";
							} else {
								echo "<input type='hidden' name='id' value='".$str["id_device"]."'>";
								if ($submenu=="Edit") { 
									if ($akses=="SU"||$akses=="ADM") echo "<button class='btn-primary btn btn-nuka-effect' name='EditDevice' type='submit'><span>Edit Data</span></button>";
									echo "<button class='btn-warning btn btn-nuka-effect' name='CancelDevice' type='submit'><span>Cancel</span></button>";
								} elseif ($submenu=="Delete") { 
									//echo "<script>alert('ANDA YAKIN AKAN MENGHAPUS DATA?')</script>";
									echo "<font size=-1><i>Are you sure, you want to delete ?</i></font>";
									echo "<input type='submit' name='DeleteDevice' value='Delete'>";
								}
							}
							?>
						</div>
					</div>
				</section>
			</form>
			<?php
		}
	}
	
	function ControlDevice($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$UrlContolDevice){
		echo "<div style='width: 1330px; height: 1024px; padding-left: 10px; overflow: hidden;'>";
		echo "  <iframe style='width: 1344px; height: 1024px;' src='$UrlContolDevice' scrolling='no'></iframe>";
		echo "</div>";
	}
	
	function Maintenance($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle){
		?>
		<section class="section-bottom-50">
			  <div class="shell">
				<?php
				echo "<form class='text-left' name='form_action' method='post' action='$_SERVER[PHP_SELF]'>";
				echo "	<h5 class='text-bold'>Your filters</h5>";
				echo "	<div class='range range-xs-center offset-top-0'>";
				echo "		<div class='cell-sm-6 cell-md-4'>";
				echo "			<div class='form-group'>";
				echo "				<label class='form-label form-label-outside' for='date_start'>From:</label>";
				echo "				<input class='form-control' id='date_start' type='text' name='date_start' data-constraints='@Required'> <img src='images/cal.gif' onclick='javascript:NewCssCal('date_start','ddmmmyyyy')' style='cursor:pointer'/>";
				echo "			</div>";
				echo "		</div>";
				echo "		<div class='cell-sm-6 cell-md-4 offset-top-20 offset-sm-top-0'>";
				echo "			<div class='form-group'>";
				echo "				<label class='form-label form-label-outside' for='date_end'>To:</label>";
				echo "				<input class='form-control' id='date_end' type='text' name='date_end' data-constraints='@Required'> <img src='images/cal.gif' onclick='javascript:NewCssCal('date_end','ddmmmyyyy')' style='cursor:pointer'/>";
				echo "			</div>";
				echo "		</div>";
				echo "		<div class='cell-sm-6 cell-md-4 offset-top-20 offset-md-top-0'>";
				echo "	  		<div class='form-group'>";
				echo "				<label class='form-label form-label-outside' for='devicenumber'>Device:</label>";
				echo "				<select class='form-control' id='devicenumber' name='devicenumber'>";
				echo "					<option "; if ($filter=="AllDevice") echo "selected=yes"; echo "value='AllDevice'>All Device</option>";
										$q= mysql_query("select*from trx_device where id_device_jenis=1");
											while($dengue=mysql_fetch_object($q)){
											echo"<option "; if ($filter==$dengue->id_device_jenis) echo " selected ='yes' ";echo"<option value=\"$dengue->id_device_jenis\">$dengue->nama_device</option>";
										}
				echo "				</select>";
				echo "			</div>";
				echo "			<div class='cell-sm-1' style='padding-right: 30px;padding-left: 180px;'>";
				echo "				<input class='btn btn-primary btn-block' type='submit' name='submitSearch' value='Search'>";
				echo "			</div>";
				echo "		</div>";
				echo "	</div>";
				echo "</form>";
				?>
			  </div>
			</section>
		<?php
	}
	
	function report($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$filterDaily,$filterMonthly,$filterYearly,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle) {
		?>
		<section class="section-50 section-sm-50">
          <div class="shell">
            <div class="offset-sm-top-34 text-left">
              <!-- Responsive-tabs-->
              <div class="responsive-tabs responsive-tabs-classic" data-type="horizontal">
                <ul class="resp-tabs-list tabs-1 text-center tabs-group-default" data-group="tabs-group-default">
                  <li>Dilly</li>
                  <li>Monthly</li>
                  <li>Yearly</li>
                </ul>
                <div class="resp-tabs-container text-left tabs-group-default" data-group="tabs-group-default">
                  <div>
                    <section class="section-bottom-50">
					  <div class="shell">
						<?php
						echo "<form class='text-left' name='form_action' method='post' action='$_SERVER[PHP_SELF]#undefined1'>";
						echo "	<input type='hidden' name='menu' value='Report'><input type='hidden' name='sub' value='View'>";
						echo "	<input type='hidden' name='filter' value='date_start'>";  //VALUE DIISI DG FIELD APA YG DI FILTER
						echo "	<h5 class='text-bold'>Your filters</h5>";
						echo "	<div class='range range-xs-center offset-top-0'>";
						echo "		<div class='cell-sm-6 cell-md-4'>";
						echo "			<div class='form-group'>";
						echo "				<label class='form-label form-label-outside' for='date_start'>From :</label>";
						echo "				<input class='form-control' id='date_start' type='text' name='date_start' data-constraints='@Required'>";
											?><img src="images/cal.gif" onclick="javascript:NewCssCal('date_start','ddmmmyyyy')" style="cursor:pointer"/><?php
						echo "			</div>";
						echo "		</div>";
						echo "		<div class='cell-sm-6 cell-md-4 offset-top-20 offset-sm-top-0'>";
						echo "			<div class='form-group'>";
						echo "				<label class='form-label form-label-outside' for='date_end'>To :</label>";
						echo "				<input class='form-control' id='date_end' type='text' name='date_end' data-constraints='@Required'>";
											?><img src="images/cal.gif" onclick="javascript:NewCssCal('date_end','ddmmmyyyy')" style="cursor:pointer"/><?php
						echo "			</div>";
						echo "		</div>";
						echo "		<div class='cell-sm-6 cell-md-4 offset-top-20 offset-md-top-0'>";
						echo "	  		<div class='form-group'>";
						echo "				<label class='form-label form-label-outside' for='filterDaily'>Device :</label>";
						echo "				<select class='form-control' id='filterDaily' name='filterDaily'>";
						echo "					<option "; if ($filterDaily=="AllDevice") echo "selected=yes"; echo "value='AllDevice'>All Device</option>";
												$q= mysql_query("select*from trx_device where id_device_jenis=1");
													while($dengue=mysql_fetch_object($q)){
													echo"<option "; if ($filterDaily==$dengue->id_device) echo " selected ='yes' ";echo"value=\"$dengue->id_device\">$dengue->nama_device</option>";
												}
						echo "				</select>";
						echo "			</div>";
						echo "			<div class='cell-sm-1' style='padding-right: 30px;padding-left: 180px;'>";
						echo "				<input class='btn btn-primary btn-block' type='submit' name='submitDaily' value='Go'>";
						echo "			</div>";
						echo "		</div>";
						echo "	</div>";
						echo "</form><br/>";
						
						if (isset($_POST['submitDaily'])||isset($_GET['submitDaily'])) {
							$kriteriausia=array(1,5,10,15,20,25,30,31);
							echo "<div class='table-responsive clearfix'>";
							echo "<table class='table table-custom' data-responsive='true' cellspacing='1' cellpadding='2'>";
							echo "<tr>";
							echo "  <th class='text-regular text-center text-dark big' colspan='".(count($kriteriausia)+2)."'>Date</th>";
							echo "	<tr>";
							echo "		<tr><th align='center'>Device OvTrapIoT</td>";
							for($i=0;$i<count($kriteriausia);$i++){
								if ($i==count($kriteriausia)-1) echo "<th width='100' align='center'>".$kriteriausia[$i]."</th>";
								else echo "<th width='100' align='right'>".$kriteriausia[$i]."-".$kriteriausia[($i+1)]."</th>";
							}
							echo "		</tr>";
							echo "	</tr>";
							echo "</tr>";
							
							echo "<tr>";
							echo "	<td> OvTrapIoT 01</td>";
							echo "</tr>";
							echo "<tr>";
							echo "	<td> OvTrapIoT 02</td>";
							echo "</tr>";
							echo "</table>";
							echo "</div>";
						}
						?>
					  </div>
					</section>
                  </div>
                  <div>
                    <?php
					if ($_POST['bln']) $bln=$_POST['bln']; else $bln=date("m");
					if ($_POST['thn']) $thn=$_POST['thn']; else $thn=date("Y");
					echo "<form class='text-left' name='form_action' method='post' action='$_SERVER[PHP_SELF]#undefined2'>";
					echo "	<input type='hidden' name='menu' value='Report'><input type='hidden' name='sub' value='View'>";
					echo "	<input type='hidden' name='filter' value='bln'>";  //VALUE DIISI DG FIELD APA YG DI FILTER
					echo "	<h5 class='text-bold'>Your filters</h5>";
					echo "	<div class='range range-xs-center offset-top-0'>";
					echo "		<div class='cell-sm-6 cell-md-4'>";
					echo "			<div class='form-group'>";
					echo "				<label class='form-label form-label-outside' for='bln'>Month : </label>";
					echo "				<select name='bln' id='bln' style='font-size: 14px; background-color:lightgrey;'>";
										for($m=1;$m<=12;$m++){ echo "<option style='background-color:white;' "; if($bln==$m) echo " selected='yes'"; echo" value='".$m."'>".bulan($m)."</option>"; }
					echo "				</select>";
					echo "			</div>";
					echo "		</div>";
					echo "		<div class='cell-sm-6 cell-md-4 offset-top-20 offset-sm-top-0'>";
					echo "			<div class='form-group'>";
					echo "				<label class='form-label form-label-outside' for='thn'>Year : </label>";
					echo "				<select name='thn' id='thn' style='font-size: 14px; background-color:lightgrey;'>";
										for($m=2010;$m<=2020;$m++){ echo "<option style='background-color:white;' "; if($thn==$m) echo " selected='yes'"; echo" value='".$m."'>".$m."</option>"; }
					echo "				</select>";
					echo "			</div>";
					echo "		</div>";
					echo "		<div class='cell-sm-6 cell-md-4 offset-top-20 offset-md-top-0'>";
					echo "	  		<div class='form-group'>";
					echo "				<label class='form-label form-label-outside' for='filterMonthly'>Device :</label>";
					echo "				<select class='form-control' id='filterMonthly' name='filterMonthly'>";
					echo "					<option "; if ($filterMonthly=="filterMonthly") echo "selected=yes"; echo "value='AllDevice'>All Device</option>";
											$q= mysql_query("select*from trx_device where id_device_jenis=1");
												while($dengue=mysql_fetch_object($q)){
												echo"<option "; if ($filterMonthly==$dengue->id_device) echo " selected ='yes' ";echo"value=\"$dengue->id_device\">$dengue->nama_device</option>";
											}
					echo "				</select>";
					echo "			</div>";
					echo "			<div class='cell-sm-1' style='padding-right: 30px;padding-left: 180px;'>";
					echo "				<input class='btn btn-primary btn-block' type='submit' name='submitMonthly' value='Go'>";
					echo "			</div>";
					echo "		</div>";
					echo "	</div>";
					echo "</form>";
					
					if (isset($_POST['submitMonthly'])||isset($_GET['submitMonthly'])) {
							// if ($_POST['date_start']<>"") echo "".$_POST['date_start']."";
							// if ($_POST['date_end']<>"") echo "".$_POST['date_end']."";
							// if ($filterDaily=="1") echo "".$filterDaily."";
							// header("location: generatepdf.php");
						if ($_POST['bln']<>"") echo "".$_POST['bln']."";
						if ($_POST['thn']<>"") echo "".$_POST['thn']."";
						if ($filterDaily=="1") echo "".$filterDaily."";
					}
					?>
                  </div>
                  <div>
                    <?php
					if ($_POST['thn']) $thn=$_POST['thn']; else $thn=date("Y");
					echo "<form class='text-left' name='form_action' method='post' action='$_SERVER[PHP_SELF]#undefined3'>";
					echo "	<input type='hidden' name='menu' value='Report'><input type='hidden' name='sub' value='View'>";
					echo "	<input type='hidden' name='filter' value='thn'>";  //VALUE DIISI DG FIELD APA YG DI FILTER
					echo "	<h5 class='text-bold'>Your filters</h5>";
					echo "	<div class='range range-xs-center offset-top-0'>";
					echo "		<div class='cell-sm-6 cell-md-4'>";
					echo "			<div class='form-group'>";
					echo "				<label class='form-label form-label-outside' for='thn'>Year : </label>";
					echo "				<select name='thn' id='thn' style='font-size: 14px; background-color:lightgrey;'>";
										for($m=2010;$m<=2020;$m++){ echo "<option style='background-color:white;' "; if($thn==$m) echo " selected='yes'"; echo" value='".$m."'>".$m."</option>"; }
					echo "				</select>";
					echo "			</div>";
					echo "		</div>";
					echo "		<div class='cell-sm-6 cell-md-4 offset-top-20 offset-md-top-0'>";
					echo "	  		<div class='form-group'>";
					echo "				<label class='form-label form-label-outside' for='devicenumber'>Device :</label>";
					echo "				<select class='form-control' id='devicenumber' name='devicenumber'>";
					echo "					<option "; if ($filter=="AllDevice") echo "selected=yes"; echo "value='AllDevice'>All Device</option>";
											$q= mysql_query("select*from trx_device where id_device_jenis=1");
												while($dengue=mysql_fetch_object($q)){
												echo"<option "; if ($filter==$dengue->id_device_jenis) echo " selected ='yes' ";echo"<option value=\"$dengue->id_device_jenis\">$dengue->nama_device</option>";
											}
					echo "				</select>";
					echo "			</div>";
					echo "			<div class='cell-sm-1' style='padding-right: 30px;padding-left: 180px;'>";
					echo "				<input class='btn btn-primary btn-block' type='submit' name='submitYearly' value='Go'>";
					echo "			</div>";
					echo "		</div>";
					echo "	</div>";
					echo "</form>";
					
					if (isset($_POST['submitYearly'])||isset($_GET['submitYearly'])) {
						if ($_POST['incnt']) $topcount=$_POST['incnt']; else $topcount=20;
						echo "<center><br>";
						$jdlatas="Data Statistik Device";
						$judul=array("No","Device Name"); 
						$query="SELECT nama_device FROM trx_device WHERE id_device_jenis = 1 ORDER BY nama_device limit 0,".$topcount;
						$colnumber=12;
						for ($m=1;$m<=12;$m++) { $judul[]=bulan($m); }
						echo "<table align='center' bgcolor='white' border='1' bordercolor='grey' cellspacing='0' cellpadding='2'>";
						echo "<form name='form_action' method='post' action='$_SERVER[PHP_SELF]#undefined3'>";
							echo "<tr><td valign='bottom' align='center' bgcolor='lightgreen' colspan='".count($judul)."'><font size='+1'>";
							echo "<b> &nbsp; <INPUT type='text' name='incnt' STYLE='color:#000000; font-family:Verdana; font-weight:bold; font-size:16px; text-align:right; background-color:lightgreen;' size='1' value='".$topcount."'> ".$jdlatas."</b></font>";
							echo "<input type='hidden' name='menu' value='Report'><input type='hidden' name='sub' value='".$submenu."'>";
							echo "&nbsp;&nbsp;<input type='submit' name='submitYearly' value='Go'>";
							echo "&nbsp;</td><tr>";
						echo "</form>";
						$strq=mysql_query($query) or die(mysql_error());
						if (mysql_num_rows($strq)>0) {
							for($i=0;$i<mysql_num_rows($strq);$i++){
								$str=mysql_fetch_array($strq);
								for($k=0;$k<mysql_num_fields($strq);$k++){ $data[$i][$k]=$str[$k]; } 
								for($m=1;$m<=12;$m++){ $k++; $data[$i][$k]=bulan($m); }
										
							}
							$total[]=0;
							echo "	<tr align='center' bgcolor='lightblue'>"; for($k=0;$k<count($judul);$k++){ echo "<td bgcolor='"; if ($k<count($judul)-12) echo "yellow"; else echo "orange"; echo "'><b>".$judul[$k]."</b></td>"; } echo "</tr>";
							for($i=0;$i<count($data);$i++){
								echo "<td align='center'>".($i+1)."</td>";
								for($k=0;$k<count($judul)-13;$k++){
									if ($k>(count($judul)-$colnumber)) {
										echo "<td align='right'>"; 
										if (($submenu=="dagum"||$submenu=="spk")&&$k==count($judul)-$colnumber+2) echo number_format($data[$i][$k],1)."%";
										elseif($data[$i][$k]>0) echo number_format($data[$i][$k],0);
										elseif($data[$i][$k]<0) echo "<font color='red'><b>(".number_format(-1*$data[$i][$k],0).")</b></font>";
										else echo "-"; 
										echo "</td>";
									} else echo "<td>".$data[$i][$k]."</td>";
									$total[$k]=$total[$k]+$data[$i][$k];
								}
								echo "</tr>";
							}
						} else echo "<tr><td align='center'><font color='red'><b><i>Data Not Found !</i></b></font></td></tr>";
						echo "</table>";
						echo "</center>";
					}
					?>
                  </div>
                </div>
              </div>
            </div>
          </div>
		</section>
		<?php
	}

	function mnudatabase($akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$submitbuttonstyle,$tablestyle){
		$in_query="SHOW TABLES LIKE '%".$kategori."%'";
		$sql_res=mysql_query($in_query);
		//<!-- Navs-->
		echo "<section>";
		echo "  <div class='shell'>";
		for ($i=0; $i<mysql_num_fields($sql_res); $i++) {echo "  <h1 class='text-md-left'>".mysql_field_name($sql_res,$i)."</h1>";}
		echo "	<div class='offset-top-20 section-sm-20'>";
		//	  <!-- Bootstrap Tabs-->
		echo "	  <div class='nav-stacked-container'>";
		echo "		<ul class='nav nav-pills text-center text-md-left'>";
		for ($brs=0; $brs<mysql_num_rows($sql_res); $brs++) {
			$data=mysql_fetch_array($sql_res);
			for ($col=0; $col<mysql_num_fields($sql_res); $col++) {
				echo "		<li class='active'><a href='".$_SERVER["PHP_SELF"]."?menu=Database&kat=".$kategori."&sub=".$data[$col]."'>".$data[$col]."</a></li>";
			}
		}
		echo "		</ul>";
		?>
				<div class="tab-content tab-conten-vert offset-top-30 text-md-left"></div>
			  </div>
			</div>
		  </div>
		</section>
		<?php
	}
	
	function Database($akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$submitbuttonstyle,$tablestyle){
		$in_query="SELECT * FROM ".$submenu;
		$sql_res=mysql_query($in_query);
		if (mysql_num_rows($sql_res)>0) {
			echo "<section>";
			echo "	<div class='shell'>";
			echo "		<div class='range offset-sm-top-41 section-bottom-41' style='overflow-x:auto;'>";
			echo "			<table class='table table-striped'>";
			echo "				<tr>";
			for ($i=0; $i<mysql_num_fields($sql_res); $i++) { echo "<td>".mysql_field_name($sql_res,$i)."</td>"; }
			echo "					<td><B>Action</B></TD>";
			echo "				</tr>";
			for ($brs=0; $brs<mysql_num_rows($sql_res); $brs++) {
				if ($brs%2<>0) $warnabaris=$warna_genap; else $warnabaris=$warna_ganjil;
				$data=mysql_fetch_array($sql_res);
				echo "			<tr>";
				echo "			<form name='form_action' method='post' action='$_SERVER[PHP_SELF]'>";
				echo "			<input type='hidden' name='menu' value='Database'><input type='hidden' name='kat' value='".$kategori."'>";
				echo "			<input type='hidden' name='table' value='".$submenu."'>";
				echo "			<td>".$data[0];
				if ($akses=="SU" && $otoritas>=4) echo " &nbsp;&nbsp; <a href='".$_SERVER["PHP_SELF"]."?menu=Database&kat=".$kategori."&table=".$submenu."&".mysql_field_name($sql_res,0)."=".$data[0]."&DatabaseUpdate=Delete' ";?>onclick="return confirm('Are you sure you want to delete?')"<?php echo" ><img src='images/delete.png' height='18' border='0' alt='DELETE !!'></a>";
				echo "			</td>";
				$maxlbr[]=0;
				for ($col=0; $col<mysql_num_fields($sql_res); $col++) {
					if ($col==0) {
						echo "	<input type='hidden' name='".mysql_field_name($sql_res,$col)."' value='".$data[$col]."'>";
					} else {
						if (strlen($data[$col])<=5) $lbr=4; elseif (strlen($data[$col])>5 && strlen($data[$col])<=10) $lbr=18;elseif (strlen($data[$col])>10 && strlen($data[$col])<20) $lbr=30;  else $lbr=45; 
						if ($maxlbr[$col]<$lbr) $maxlbr[$col]=$lbr;
						echo "	<TD><input name='".mysql_field_name($sql_res,$col)."' type='text' size='".$lbr."' value='".$data[$col]."'></TD>";
					}
				}
				echo "			<td align='right' colspan='".mysql_num_fields($sql_res)."'>";
				echo "			<input type='submit' name='DatabaseUpdate' value='Update'>";
				if ($akses=="SU" && $otoritas>=4) echo "<input type='submit' name='DatabaseUpdate' ";?>onclick="return confirm('Are you sure you want to delete?')"<?php echo" value='Delete'>";
				echo "			</td>";
				echo "			</form>";
				echo "			</tr>";
			}
			
			echo "				<tr>";
			echo "				<form name='form_action' method='post' action='$_SERVER[PHP_SELF]'>";
			echo "				<input type='hidden' name='menu' value='Database'><input type='hidden' name='kat' value='".$kategori."'>";
			echo "				<input type='hidden' name='table' value='".$submenu."'>";
			echo "				<td align='right'>Add >> </td>";
			for ($col=0; $col<mysql_num_fields($sql_res); $col++) {
				if ($col==0) {
					echo "<input type='hidden' name='".mysql_field_name($sql_res,$col)."' value=''>";
				} else {
					echo "<td><input name='".mysql_field_name($sql_res,$col)."' type='text' size='".$maxlbr[$col]."' value=''></td>";
				}
			}
			echo "				<td align='center' colspan='".mysql_num_fields($sql_res)."'>";
			if ($akses=="SU" && $otoritas>=4) echo "<input type='submit' name='DatabaseNew' value='Save New Record'>";
			echo "				</td>";
			echo "				</form>";
			echo "				</tr>";
			echo "			</table>";
			echo "		</div>";
			echo "	</div>";
		}
	}

	function Option($akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$filesetting,$filecalibration,$submitbuttonstyle,$tablestyle){
		if ($submenu=='Setting'){
			$fn = $filesetting;
			?>
			 <!-- Apps Setting-->
			<section class="section-41">
			  <div class="shell">
				<div class="range range-xs-center">
				  <div class="cell-sm-8 cell-md-7 cell-lg-8">
					<!-- RD Mailform-->
					<form class="text-left" method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
					  <div class="range">
						<div class="cell-lg-12 offset-top-10">
						  <div class="form-group">
							<label class="form-label form-label-outside" for="make-appointment-message">Message:</label>
							<textarea class="form-control" id="make-appointment-message" name="content" data-constraints="@Required" style="height: 500px;"><?php readfile($fn); ?></textarea>
						  </div>
						</div>
					  </div>
					  <div class="text-center text-lg-left offset-top-30">
						<button class="btn btn-primary" type="submit" value="Simpan">Save Setting</button>
					  </div>
					</form>
				  </div>
				</div>
			  </div>
			</section>
			<?php
		} elseif ($submenu=='Calibration'){
			$fc = $filecalibration;
			?>
			 <!-- Apps Setting-->
			<section class="section-41">
			  <div class="shell">
				<div class="range range-xs-center">
				  <div class="cell-sm-8 cell-md-7 cell-lg-8">
					<!-- RD Mailform-->
					<form class="text-left" method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
					  <div class="range">
						<div class="cell-lg-12 offset-top-10">
						  <div class="form-group">
							<label class="form-label form-label-outside" for="make-appointment-message">Message:</label>
							<textarea class="form-control" id="make-appointment-message" name="contentCalibration" data-constraints="@Required" style="height: 500px;"><?php readfile($fc); ?></textarea>
						  </div>
						</div>
					  </div>
					  <div class="text-center text-lg-left offset-top-30">
						<button class="btn btn-primary" type="submit" value="SimpanKalibrasi">Save Setting</button>
					  </div>
					</form>
				  </div>
				</div>
			  </div>
			</section>
			<?php
		} elseif ($submenu=="ChangePass"){
			$dataq = "select id_pengguna, username, nama_pengguna, password from trx_pengguna where id_pengguna='".$_SESSION['iduser']."'";
			$dataquery = mysql_query($dataq);
			$rs=mysql_fetch_array($dataquery);
			?>
			<section class="section-98 section-sm-110">
			  <div class="shell">
				<div class="range range-xs-center">
				  <div class="cell-sm-8 cell-md-7 cell-lg-8">
					<!-- RD Mailform-->
					<form class="text-left" data-form-output="form-output-global" method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
					  <div class="range">
						<div class="cell-lg-6">
						  <div class="form-group">
							<label class="form-label form-label-outside" for="make-appointment-name">Full Name:</label>
							<input class="form-control" id="make-appointment-name" type="text" name="fullname" value="<?php echo $rs[2]; ?>" disabled>
						  </div>
						</div>
						<div class="cell-lg-6 offset-top-20 offset-lg-top-0">
						  <div class="form-group">
							<label class="form-label form-label-outside" for="make-appointment-name">Username:</label>
							<input class="form-control" id="make-appointment-name" type="text" name="username" value="<?php echo $rs[1]; ?>" disabled>
						  </div>
						</div>
						<div class="cell-lg-6">
						  <div class="form-group">
							<label class="form-label form-label-outside" for="make-appointment-name">Old Password:</label>
							<input class="form-control" id="make-appointment-name" type="password" name="oldpassword" data-constraints="@Required">
						  </div>
						</div><div class="cell-lg-6"></div>
						<div class="cell-lg-6 offset-top-20">
						  <div class="form-group">
							<label class="form-label form-label-outside" for="make-appointment-name">New Password:</label>
							<input class="form-control" id="make-appointment-name" type="password" name="newpassword" data-constraints="@Required">
						  </div>
						</div>
						<div class="cell-lg-6 offset-top-20">
						  <div class="form-group">
							<label class="form-label form-label-outside" for="make-appointment-name">Verify New Password:</label>
							<input class="form-control" id="make-appointment-name" type="password" name="verifypassword" data-constraints="@Required">
						  </div>
						</div>
					  </div>
					  <div class="text-center text-lg-left offset-top-30">
						<input type="hidden" name="action" value="changepassword">
						<input type='hidden' name='menu' value='12'>
						<input type='hidden' name='det' value="<?php echo $rs[0]; ?>">
						<input class="btn btn-primary" type="submit" name="changepassword" Value="Save New Password">
					  </div>
					</form>
				  </div>
				</div>
			  </div>
			</section>
			<?php
		} elseif($submenu=="Updates"){
			?>
			<!-- Bootstrap Pills (Stacked)-->
			<section class="offset-top-41 section-bottom-41">
			  <div class="shell">
				<div class="offset-sm-top-66 text-left">
				  <!-- Bootstrap Tabs-->
				  <div class="nav-stacked-container">
					<ul class="tabs nav nav-pills nav-stacked text-center text-md-left" role="tablist" id="tabs-3" style="width: 320px;">
					<?php
					  $query = mysql_query("select * from trx_app_version order by id_app_version desc limit 3 ");
					  while ($data = mysql_fetch_array($query)) {
						if ($data['id_app_version']==3){
							echo "    <li class='active' role='presentation'><a href='#tab00".$data['id_app_version']."' role='tab'>".$data['app_version']."</a></li>";
						} else {
							echo "    <li role='presentation'><a href='#tab00".$data['id_app_version']."' role='tab'>".$data['app_version']."</a></li>";
						}
					  }
					?>
					</ul>
					<div class="tab-content tab-conten-vert offset-top-30 text-md-left">
					  <?php
					    $query = mysql_query("select * from trx_app_version order by id_app_version desc limit 3 ");
					    while ($data = mysql_fetch_array($query)) {
							if ($data['id_app_version']==3){
								echo "<div class='tab-pane fade active in' role='tabpanel' id='tab00".$data['id_app_version']."'><p><span class='text-bold big'>".$data['app_version']." - Date Release: ".$data['dt_version']."</span><p>".$data['Keterangan']."</p></div>";
							} else {
								echo "<div class='tab-pane fade in' role='tabpanel' id='tab00".$data['id_app_version']."'><p><span class='text-bold big'>".$data['app_version']." - Date Release: ".$data['dt_version']."</span><p>".$data['Keterangan']."</p></div>";
							}
					    }
					  ?>
					</div>
				  </div>
				</div>
			  </div>
			</section>
			<?php
		} elseif ($submenu=="underconstraction"){
			?>
			<!-- Page-->
			<div class="page text-center">
			  <!-- Page Content-->
			  <div class="page-content context-dark" style="background: url(images/backgrounds/background-44-1920x1024.jpg) 0/cover no-repeat;">
				<div class="one-page">
				  <!-- Coming Soon-->
				  <section>
					<div id="particles-container"></div>
					<div class="shell">
					  <div class="range">
						<div class="range range-xs-center section-41 section-cover">
						  <div class="cell-xs-12">
							<h3 class="text-center">We're getting ready to launch in</h3>
							<hr class="divider divider-md bg-mantis">
							<div class="offset-top-34">
								<!-- Countdown-->
								<div class="countdown-custom countdown-ellipse">
								  <div class="countdown" data-type="until" data-time="25 Sep 2016" data-format="dhms"></div>
								</div>
							</div>
							<p class="offset-top-30 offset-sm-top-66">Our website is under construction, we are working very hard to give you the best <br class="veil reveal-sm-inline-block"> experience on our new web site.</p>
							<div class="range range-xs-center offset-top-24">
							  <div class="cell-sm-8 cell-md-6 cell-lg-4"><small>Stay ready, we`re launching soon</small></div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </section>
				  <div class="one-page-footer">
					<p class="small">Cinovasi &copy; <span class="copyright-year"></span> . <a href="privacy.php">Privacy Policy</a></p>
				  </div>
				</div>
			  </div>
			</div>
			<?php
		} else {
			
		}
	}
	
	function startup() {
		$query="select id_pengguna from trx_pengguna";
	}
	
 /*** SECURITY ACCESS ***/
/***********************/
	if (!$_SESSION['startup']) {
		$query="select id_pengguna from trx_pengguna"; $sql=mysql_query($query);
		$_SESSION['startup']=true;
	}

 /*** PROCESS SELECTION ***/
/*************************/
		// INPUT SDM
	if (isset($_POST['AddSDM'])||isset($_GET['AddSDM'])) {
		if ($_POST['password'] != $_POST['confirmpassword']){
			echo " <script>alert('INPUT DATA FAILED - Cek your password please !!')</script>";
		} else {
			$query="insert into trx_pengguna (activated, username, password, nama_pengguna, id_kelamin, nip, tanggal_lahir, id_agama, alamat, telephone, email, id_jabatan, portofolio, photo1, id_akses, id_otoritas) values ('1','".$_POST['username']."',md5('".$_POST['password']."'),'".$_POST['namasdm']."','".$_POST['kelaminsdm']."','".$_POST['nipsdm']."','".tgltodbase($_POST['tgl_sdm'])."','".$_POST['agamasdm']."','".$_POST['alamatsdm']."','".$_POST['teleponsdm']."','".$_POST['emailsdm']."','".$_POST['jabatansdm']."','".$_POST['portofoliosdm']."','images/user-milana-stark-140x140.jpg','".$_POST['aksessdm']."','".$_POST['otoritas']."')";
			// echo $query;
			$sql=mysql_query($query);
			if($sql) echo "<script>alert('INPUT DATA SUCCESS')</script>"; else echo " <script>alert('INPUT DATA FAILED')</script>";
		}
		$menu="user"; $submenu="View";
		
		// EDIT SDM
	} elseif (isset($_POST['EditSDM'])||isset($_GET['EditSDM'])) {
		$query="update trx_pengguna set nama_pengguna='".$_POST['namasdm']."',id_kelamin='".$_POST['kelaminsdm']."', nip='".$_POST['nipsdm']."', tanggal_lahir='".tgltodbase($_POST['tgl_sdm'])."',id_agama='".$_POST['agamasdm']."',alamat='".$_POST['alamatsdm']."',telephone='".$_POST['teleponsdm']."',email='".$_POST['emailsdm']."',id_jabatan='".$_POST['jabatansdm']."',portofolio='".$_POST['portofoliosdm']."',id_akses='".$_POST['aksessdm']."',id_otoritas='".$_POST['otoritas']."' where id_pengguna='".$_POST['id']."'";
		// echo $query;
		$sql=mysql_query($query);
		if($sql) echo "<script>alert('EDIT DATA SUCCESS')</script>"; else echo " <script>alert('EDIT DATA FAILED')</script>";
		$menu="user"; $submenu="View";

		// Delete SDM
	} elseif (isset($_POST['DeleteSDM'])||isset($_GET['DeleteSDM'])) {
		$query="update trx_pengguna set activated=false where id_pengguna='".$_POST['id']."'";
		$sql=mysql_query($query);
		if($sql) echo "<script>alert('DELETE DATA SUCCESS')</script>"; else echo " <script>alert('DELETE DATA FAILED')</script>";
		$submenu="View";

		// Cancel SDM
	} elseif (isset($_POST['CancelSDM'])||isset($_GET['CancelSDM'])) {
		echo "<script>alert('Input Data User has been cencelled !')</script>";
		header("location: ".$_SERVER["PHP_SELF"]."?menu=user&sub=View");
	
		// Add Device
	} elseif (isset($_POST['AddDevice'])||isset($_GET['AddDevice'])) {
		$date_activate=date_create($_POST['date_activate']);
		$query="insert into trx_device (activated, id_pengguna, id_device_jenis, id_lokasi, date_activate, nama_device, imei1, imei2, serial_number, credential_qr, latitude, longitude) values ('1','".$_POST['penggunadev']."','".$_POST['typedev']."','".$_POST['locdev']."','".date_format($date_activate, 'Y-m-d')."','".$_POST['nama_device']."','".$_POST['imei1']."','".$_POST['imei2']."','".$_POST['serial_number']."','".EncryptThis($_POST['credential_number'])."','".$_POST['latitudedev']."','".$_POST['longitudedev']."')";
		// echo $query;
		$sql=mysql_query($query);
		if($sql) echo "<script>alert('INPUT DATA SUCCESS')</script>"; else echo " <script>alert('INPUT DATA FAILED')</script>";
		$menu="device"; $submenu="View";
		
		// EDIT Device
	} elseif (isset($_POST['EditDevice'])||isset($_GET['EditDevice'])) {
		$date_activate=date_create($_POST['date_activate']);
		$query="update trx_device set id_pengguna='".$_POST['penggunadev']."', id_device_jenis='".$_POST['typedev']."', id_lokasi='".$_POST['locdev']."', date_activate='".date_format($date_activate, 'Y-m-d')."', nama_device='".$_POST['nama_device']."', imei1='".$_POST['imei1']."', imei2='".$_POST['imei2']."', serial_number='".$_POST['serial_number']."', credential_qr='".EncryptThis($_POST['credential_number'])."', latitude='".$_POST['latitudedev']."', longitude='".$_POST['longitudedev']."' where id_device='".$_POST['id']."'";
		// echo $query;
		$sql=mysql_query($query);
		if($sql) echo "<script>alert('INPUT DATA SUCCESS')</script>"; else echo " <script>alert('INPUT DATA FAILED')</script>";
		$menu="device"; $submenu="View";
	
		// DELETE Device
	} elseif (isset($_POST['DeleteDevice'])||isset($_GET['DeleteDevice'])) {
		$query="update trx_device set activated=0 where id_device='".$_POST['id']."'";
		$sql=mysql_query($query);
		if($sql) echo "<script>alert('DELETE DATA SUCCESS')</script>"; else echo " <script>alert('DELETE DATA FAILED')</script>";
		$submenu="View";
		
		// Cancel Device
	} elseif (isset($_POST['CancelDevice'])||isset($_GET['CancelDevice'])) {
		echo "<script>alert('Input Data Device has been cencelled !')</script>";
		header("location: ".$_SERVER["PHP_SELF"]."?menu=device&sub=View");
		
		// Read Write setting.inc
	} elseif (isset($_POST['content'])) {
		$fn = $filesetting;
		$content = stripslashes($_POST['content']);
		$fp = fopen($fn,"w") or die ("Error opening file in write mode!");
		fputs($fp,$content);
		fclose($fp) or die ("Error closing file!");
		header("location: ".$_SERVER["PHP_SELF"]."?menu=Option&sub=Setting");
	
	// Read Write Calibration.ini
	} elseif (isset($_POST['contentCalibration'])) {
		$fn = $filecalibration;
		$content = stripslashes($_POST['contentCalibration']);
		$fp = fopen($fn,"w") or die ("Error opening file in write mode!");
		fputs($fp,$content);
		fclose($fp) or die ("Error closing file!");
		header("location: ".$_SERVER["PHP_SELF"]."?menu=Option&sub=Calibration");
		
		// Update Password
	} elseif (isset($_POST['changepassword'])) {
		$strsql = "SELECT * FROM trx_pengguna WHERE username='".$_SESSION['usr']."' and password=md5('".$_POST['oldpassword']."')";
		$sql = mysql_query($strsql); 
		if (mysql_num_rows($sql)==0) echo "<script>alert('Old Password is not Match !')</script>";
		elseif ($_POST['newpassword']=="") echo "<script>alert('Please fill your New Password  ! ')</script>";
		elseif ($_POST['newpassword']<>$_POST['verifypassword']) echo "<script>alert('New Password is not Macth with Verify Password ! ')</script>"; 
		else {
			$strquery="update trx_pengguna set password=md5('".$_POST['newpassword']."') where id_pengguna='".$_POST['det']."'";
			$dataquery = mysql_query($strquery);
			echo "<script>alert('Password has been changed !')</script>";
		}
		
		// Update DB
	} elseif (isset($_POST['DatabaseUpdate'])||isset($_GET['DatabaseUpdate'])) {
		$x=0;
		if ($_POST['DatabaseUpdate']=="Update") {
			foreach ($_POST as $key => $entry) {
				if ($key<>"DatabaseUpdate") {
					$x++;
					if ($x==1 || $x==2) $query="";
					elseif ($x==3) { $query="update ".$entry." set "; $submenu=$entry; }
					elseif ($x==4) $whr=" where ".$key."='".$entry."' ";
					elseif ($x==5) $query.=$key."='".$entry."' ";
					else $query.=", ".$key."='".$entry."' ";
				}
			}
			$query.=$whr;
		} elseif ($_POST['DatabaseUpdate']=="Delete") {
			foreach ($_POST as $key => $entry) {
				if ($key<>"DatabaseUpdate") {
					$x++;
					if ($x==1 || $x==2) $query="";
					elseif ($x==3) { $query="delete from ".$entry; $submenu=$entry; }
					elseif ($x==4) $whr=" where ".$key."='".$entry."' ";
				}
			}
			$query.=$whr;
		} elseif ($_GET['DatabaseUpdate']=="Delete") {
			foreach ($_GET as $key => $entry) {
				if ($key<>"DatabaseUpdate") {
					$x++;
					if ($x==1 || $x==2) $query="";
					elseif ($x==3) { $query="delete from ".$entry; $submenu=$entry; }
					elseif ($x==4) $whr=" where ".$key."='".$entry."' ";
				}
			}
			$query.=$whr;
		}
		if ($akses=="SU" && $otoritas>=4) {
			$sql=mysql_query($query);
			echo " <script>alert('Database Updated!')</script>";
		} else echo " <script>alert('You have no privileged to update Database!')</script>";
		
		// Add DB
	} elseif (isset($_POST['DatabaseNew'])||isset($_GET['DatabaseNew'])) {
		$x=0;
		if ($_POST['DatabaseNew']) {
			foreach ($_POST as $key => $entry) {
				if ($key<>"DatabaseNew") {
					$x++;
					if ($x==1 || $x==2) $query="";
					elseif ($x==3) { $query="insert into ".$entry." values ('',"; $submenu=$entry; }
					elseif ($x==4) $whr=") ";
					elseif ($x==5) $query.="'".$entry."'";
					else $query.=",'".$entry."' ";
				}
			}
			$query.=$whr;
			echo $query;
			$sql=mysql_query($query);
			if ($sql) echo " <script>alert('Successful add new data !')</script>"; else echo " <script>alert('Failed add new data !')</script>";
		}

	}
 /*** HTML OUTPUT ***/
/*******************/
?>
<!DOCTYPE html>
<html class="wide wow-animation scrollTo smoothscroll" lang="en">
  <head>
    <!-- Site Title-->
    <title><?php echo $TitleProject; ?></title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="keywords" content="intense web design multipurpose template html">
    <meta name="date" content="Dec 26">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
	<script src="js/datetimepicker_css.js"></script>
	<style>
	  body{
		background-color:#aaa!important;
	  }
	  .wrapper .single{
		color:#fff;
		width:100%;
		padding:10px;
		text-align:center;
		margin-bottom:10px;
	  }
	  .aqi-value{
		font-family : "Noto Serif","Palatino Linotype","Book Antiqua","URW Palladio L";
		font-size:40px;
		font-weight:bold;
	  }
	  h1{
		text-align: center;
		font-size:3em;
	  }
	  .forecast-block{
		background-color: #3b463d!important;
		width:20% !important;
	  }
	  .title{
		background-color:#673f3f;
		width: 100%;
		color:#fff;
		margin-bottom:0px;
		padding-top:10px;
		padding-bottom: 10px;
	  }
	  .bordered{
		border:1px solid #fff;
	  }
	  .weather-icon{
		width:40%;
		font-weight: bold;
		background-color: #673f3f;
		padding:10px;
		border: 1px solid #fff;
	  }
	</style>
	<style>
    body {font-family: Arial, Helvetica, sans-serif;}
    * {box-sizing: border-box;}

    /* Button used to open the contact form - fixed at the bottom of the page */
    .open-button {
      background-color: #555;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      opacity: 0.8;
      position: fixed;
      bottom: 23px;
      right: 28px;
      width: 280px;
    }

    /* The popup form - hidden by default */
    .form-popup {
      display: none;
      position: fixed;
      bottom: 0;
      right: 15px;
      border: 3px solid #f1f1f1;
      z-index: 9;
    }

    /* Add styles to the form container */
    .form-container {
      max-width: 300px;
      padding: 10px;
      background-color: white;
    }

    /* Full-width input fields */
    .form-container input[type=text], .form-container input[type=password] {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      border: none;
      background: #f1f1f1;
    }

    /* When the inputs get focus, do something */
    .form-container input[type=text]:focus, .form-container input[type=password]:focus {
      background-color: #ddd;
      outline: none;
    }

    /* Set a style for the submit/login button */
    .form-container .btn {
      background-color: #4CAF50;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      width: 100%;
      margin-bottom:10px;
      opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
      background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover, .open-button:hover {
      opacity: 1;
    }
    </style>
	<!-- GMaps & Weathers-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />
	<script type="text/javascript" src="//maps.google.com/maps/api/js?key=<?php echo $APIKeyGmap; ?>&sensor=false&libraries=geometry,places&v=3.7"></script>
    <script type="text/javascript">
      <?php
      $query = mysql_query("select * from mst_lokasi where id_lokasi= '1'");
      while($l=mysql_fetch_array($query)){
        $id_lokasi = $l['id_lokasi'];
        $point_name = $l['point_name'];
        $latitude = $l['latitude'];
        $longitude = $l['longitude'];
        $coverage_x = $l['coverage_x'];
        $coverage_y = $l['coverage_y'];
        $id_zoom = $l['id_zoom'];
        $outlat= preg_split("/[\s,]+/",$coverage_x);  
        $outlong= preg_split("/[\s,]+/",$coverage_y);
      }
      ?>
      /**
       * Called on the initial page load For GMaps.
       */ 
    function init() {
      var mapCenter = new google.maps.LatLng(<?php echo $latitude .",". $longitude; ?>);
      var map = new google.maps.Map(document.getElementById('mapp'), {
          'zoom': <?php echo $id_zoom;?>,
          'center': mapCenter,
          'mapTypeId': google.maps.MapTypeId.ROADMAP
      });
  
/**
    var cluster1 = [
      new google.maps.LatLng(-6.746441, 105.21183),
      new google.maps.LatLng(-6.761443, 105.223503),
      new google.maps.LatLng(-6.260697372951358, 106.9903564453125),
      new google.maps.LatLng(-6.312568616406119, 106.85028076171875),
      new google.maps.LatLng(-6.1978989780452, 106.70745849609375)
    ];
**/
      
      var cluster2 = [
        new google.maps.LatLng(<?php echo $outlat[0].",".$outlong[0]; ?>),
		new google.maps.LatLng(<?php echo $outlat[1].",".$outlong[1]; ?>),
		new google.maps.LatLng(<?php echo $outlat[2].",".$outlong[2]; ?>),
		new google.maps.LatLng(<?php echo $outlat[3].",".$outlong[3]; ?>),
		new google.maps.LatLng(<?php echo $outlat[4].",".$outlong[4]; ?>),
		new google.maps.LatLng(<?php echo $outlat[5].",".$outlong[5]; ?>),
		new google.maps.LatLng(<?php echo $outlat[6].",".$outlong[6]; ?>),
		new google.maps.LatLng(<?php echo $outlat[7].",".$outlong[7]; ?>),
		new google.maps.LatLng(<?php echo $outlat[8].",".$outlong[8]; ?>),
		new google.maps.LatLng(<?php echo $outlat[9].",".$outlong[9]; ?>),
		new google.maps.LatLng(<?php echo $outlat[10].",".$outlong[10]; ?>),
		new google.maps.LatLng(<?php echo $outlat[11].",".$outlong[11]; ?>),
		new google.maps.LatLng(<?php echo $outlat[12].",".$outlong[12]; ?>),
		new google.maps.LatLng(<?php echo $outlat[13].",".$outlong[13]; ?>),
		new google.maps.LatLng(<?php echo $outlat[14].",".$outlong[14]; ?>),
		new google.maps.LatLng(<?php echo $outlat[15].",".$outlong[15]; ?>),
		new google.maps.LatLng(<?php echo $outlat[16].",".$outlong[16]; ?>),
		new google.maps.LatLng(<?php echo $outlat[17].",".$outlong[17]; ?>),
		new google.maps.LatLng(<?php echo $outlat[18].",".$outlong[18]; ?>),
		new google.maps.LatLng(<?php echo $outlat[19].",".$outlong[19]; ?>),
		new google.maps.LatLng(<?php echo $outlat[20].",".$outlong[20]; ?>),
		new google.maps.LatLng(<?php echo $outlat[21].",".$outlong[21]; ?>),
		new google.maps.LatLng(<?php echo $outlat[22].",".$outlong[22]; ?>),
		new google.maps.LatLng(<?php echo $outlat[23].",".$outlong[23]; ?>),
		new google.maps.LatLng(<?php echo $outlat[24].",".$outlong[24]; ?>),
		new google.maps.LatLng(<?php echo $outlat[25].",".$outlong[25]; ?>),
		new google.maps.LatLng(<?php echo $outlat[26].",".$outlong[26]; ?>),
		new google.maps.LatLng(<?php echo $outlat[27].",".$outlong[27]; ?>),
		new google.maps.LatLng(<?php echo $outlat[28].",".$outlong[28]; ?>),
		new google.maps.LatLng(<?php echo $outlat[29].",".$outlong[29]; ?>),
		new google.maps.LatLng(<?php echo $outlat[30].",".$outlong[30]; ?>),
		new google.maps.LatLng(<?php echo $outlat[31].",".$outlong[31]; ?>),
		new google.maps.LatLng(<?php echo $outlat[32].",".$outlong[32]; ?>),
		new google.maps.LatLng(<?php echo $outlat[33].",".$outlong[33]; ?>),
		new google.maps.LatLng(<?php echo $outlat[34].",".$outlong[34]; ?>),
		new google.maps.LatLng(<?php echo $outlat[35].",".$outlong[35]; ?>),
		new google.maps.LatLng(<?php echo $outlat[36].",".$outlong[36]; ?>),
		new google.maps.LatLng(<?php echo $outlat[37].",".$outlong[37]; ?>),
		new google.maps.LatLng(<?php echo $outlat[38].",".$outlong[38]; ?>),
		new google.maps.LatLng(<?php echo $outlat[39].",".$outlong[39]; ?>),
		new google.maps.LatLng(<?php echo $outlat[40].",".$outlong[40]; ?>),
		new google.maps.LatLng(<?php echo $outlat[41].",".$outlong[41]; ?>),
		new google.maps.LatLng(<?php echo $outlat[42].",".$outlong[42]; ?>),
		new google.maps.LatLng(<?php echo $outlat[43].",".$outlong[43]; ?>),
		new google.maps.LatLng(<?php echo $outlat[44].",".$outlong[44]; ?>),
		new google.maps.LatLng(<?php echo $outlat[45].",".$outlong[45]; ?>),
		new google.maps.LatLng(<?php echo $outlat[46].",".$outlong[46]; ?>),
		new google.maps.LatLng(<?php echo $outlat[47].",".$outlong[47]; ?>),
		new google.maps.LatLng(<?php echo $outlat[48].",".$outlong[48]; ?>),
		new google.maps.LatLng(<?php echo $outlat[49].",".$outlong[49]; ?>),
		new google.maps.LatLng(<?php echo $outlat[50].",".$outlong[50]; ?>),
		new google.maps.LatLng(<?php echo $outlat[51].",".$outlong[51]; ?>),
		new google.maps.LatLng(<?php echo $outlat[52].",".$outlong[52]; ?>),
		new google.maps.LatLng(<?php echo $outlat[53].",".$outlong[53]; ?>),
		new google.maps.LatLng(<?php echo $outlat[54].",".$outlong[54]; ?>),
		new google.maps.LatLng(<?php echo $outlat[55].",".$outlong[55]; ?>),
		new google.maps.LatLng(<?php echo $outlat[56].",".$outlong[56]; ?>),
		new google.maps.LatLng(<?php echo $outlat[57].",".$outlong[57]; ?>),
		new google.maps.LatLng(<?php echo $outlat[58].",".$outlong[58]; ?>),
		new google.maps.LatLng(<?php echo $outlat[59].",".$outlong[59]; ?>),
		new google.maps.LatLng(<?php echo $outlat[60].",".$outlong[60]; ?>),
		new google.maps.LatLng(<?php echo $outlat[61].",".$outlong[61]; ?>),
		new google.maps.LatLng(<?php echo $outlat[62].",".$outlong[62]; ?>),
		new google.maps.LatLng(<?php echo $outlat[63].",".$outlong[63]; ?>),
		new google.maps.LatLng(<?php echo $outlat[64].",".$outlong[64]; ?>),
		new google.maps.LatLng(<?php echo $outlat[65].",".$outlong[65]; ?>),
		new google.maps.LatLng(<?php echo $outlat[66].",".$outlong[66]; ?>),
		new google.maps.LatLng(<?php echo $outlat[67].",".$outlong[67]; ?>),
		new google.maps.LatLng(<?php echo $outlat[68].",".$outlong[68]; ?>),
		new google.maps.LatLng(<?php echo $outlat[69].",".$outlong[69]; ?>),
		new google.maps.LatLng(<?php echo $outlat[70].",".$outlong[70]; ?>),
		new google.maps.LatLng(<?php echo $outlat[71].",".$outlong[71]; ?>),
		new google.maps.LatLng(<?php echo $outlat[72].",".$outlong[72]; ?>),
		new google.maps.LatLng(<?php echo $outlat[73].",".$outlong[73]; ?>),
		new google.maps.LatLng(<?php echo $outlat[74].",".$outlong[74]; ?>),
		new google.maps.LatLng(<?php echo $outlat[75].",".$outlong[75]; ?>),
		new google.maps.LatLng(<?php echo $outlat[76].",".$outlong[76]; ?>),
		new google.maps.LatLng(<?php echo $outlat[77].",".$outlong[77]; ?>),
		new google.maps.LatLng(<?php echo $outlat[78].",".$outlong[78]; ?>),
		new google.maps.LatLng(<?php echo $outlat[79].",".$outlong[79]; ?>),
		new google.maps.LatLng(<?php echo $outlat[80].",".$outlong[80]; ?>),
		new google.maps.LatLng(<?php echo $outlat[81].",".$outlong[81]; ?>),
		new google.maps.LatLng(<?php echo $outlat[82].",".$outlong[82]; ?>),
		new google.maps.LatLng(<?php echo $outlat[83].",".$outlong[83]; ?>),
		new google.maps.LatLng(<?php echo $outlat[84].",".$outlong[84]; ?>)
      ];
/**
      var p1 = new google.maps.Polygon({
		 map: map,
		 path: cluster1,
		 strokeColor: "#FF0000",
		 strokeOpacity: 0.8,
		 strokeWeight: 2,
		 fillColor: "#FF0000",
		 fillOpacity: 0.35
      });
**/	
      var p2 = new google.maps.Polygon({
         map: map,
         path: cluster2,
         strokeColor: "#00FF00",
         strokeOpacity: 0.8,
         strokeWeight: 2,
         fillColor: "#00FF00",
         fillOpacity: 0.35
      });

      // Variabel untuk menyimpan batas kordinat
      var infoWindow = new google.maps.InfoWindow;  
      var bounds = new google.maps.LatLngBounds();
      
      // Pengambilan data dari database
      <?php
      $query = mysql_query("select nama_device, pemilik, latitude, longitude, battery, power, light, egg_counting, larva_counting, type_mosq from trx_device where id_device_jenis = 1 and activated = 1 ");
      while ($data = mysql_fetch_array($query)) {
        $nama_device =$data['nama_device'];
        $latitudes =$data['latitude'];
        $longitudes =$data['longitude'];
        $egg_countings =intval($data['egg_counting']);
        $larva_countings =intval($data['larva_counting']);
        parse_str($data['type_mosq']);

        echo ("addMarker($latitudes, $longitudes, '<b>$nama_device</b> <br/> Egg Counting : $egg_countings<br/> Larva Counting: $larva_countings<br/> Aedes Aegypti: $aegypti');\n");
      }

      $querys = mysql_query("select a.point_name, a.latitude, a.longitude, b.nama_device, IF(b.connection=1, 'Connected', 'Disconnected') as connection, b.result from mst_lokasi a, trx_device b where b.id_lokasi=b.id_lokasi and b.id_device_jenis=2 and b.activated=1 ");
      while ($daquer = mysql_fetch_array($querys)) {
        $point_name =$daquer['point_name'];
        $latitude =$daquer['latitude'];
        $longitude =$daquer['longitude'];
        $nama_sensor =$daquer['nama_device'];
        $connection =$daquer['connection'];
        $result =$daquer['result'];
        echo ("addMarkerWeather($latitude, $longitude, '<b>Weather Condition at $point_name</b> <br/> Weather: ".$datas[0]['WeatherText']."<br/> Temperature: ".$datas[0]['Temperature']['Metric']['Value']." °C<br/> Humidity: ".$datas[0]['RelativeHumidity']." %<br/> Pressure: ".$datas[0]['Pressure']['Metric']['Value']." mbar <br/> Co2: $result ppm <br/> Device Status: $connection');\n");
      }

      ?>
      // Proses membuat marker 
      function addMarker(lat, lng, info) {
        var lokasi = new google.maps.LatLng(lat, lng);
        bounds.extend(lokasi);
        var marker = new google.maps.Marker({
            map: map,
            position: lokasi,
            icon: 'images/ovtrapicon.png'
        });       
        map.fitBounds(bounds);
        var listener = google.maps.event.addListener(map, "idle", function() { 
          if (map.getZoom() > 16) map.setZoom(8); 
          google.maps.event.removeListener(listener); 
        });
        bindInfoWindow(marker, map, infoWindow, info);
      }

      function addMarkerWeather(lat, lng, info) {
        var lokasiw = new google.maps.LatLng(lat, lng);
        bounds.extend(lokasiw);
        var markerw = new google.maps.Marker({
            map: map,
            position: lokasiw,
            icon: 'images/gmap_marker.png'
        });       
        map.fitBounds(bounds);
        var listenerw = google.maps.event.addListener(map, "idle", function() { 
          if (map.getZoom() > 16) map.setZoom(8); 
          google.maps.event.removeListener(listenerw); 
        });
        bindInfoWindow(markerw, map, infoWindow, info);
      }

      // Menampilkan informasi pada masing-masing marker yang diklik
      function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
          infoWindow.setContent(html);
          infoWindow.open(map, marker);
        });
      }
    }
      // Register an event listener to fire when the page finishes loading.
      google.maps.event.addDomListener(window, 'load', init);
    </script>
	<!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Montserrat:400,700%7CLato:300,300italic,400,700,900%7CYesteryear">
    <link rel="stylesheet" href="css/style.css">
		<!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
		<![endif]-->
  </head>
  <body>
	<script language=JavaScript>
		var message="Sorry for inconvenience .. right click is disabled in this page!";
		///////////////////////////////
		function clickIE4(){
			if (event.button==2){
				alert(message);
				return false;
			}
		}

		function clickNS4(e){
			if (document.layers||document.getElementById&&!document.all){
				if (e.which==2||e.which==3){
					alert(message);
					return false;
				}
			}
		}

		if (document.layers){
			document.captureEvents(Event.MOUSEDOWN);
			document.onmousedown=clickNS4;
		}
			else if (document.all&&!document.getElementById){
			document.onmousedown=clickIE4;
		}
		document.oncontextmenu=new Function("alert(message);return false")
		// --> 
	</script>
    <!-- Page-->
    <div class="page text-center">
      <div class="page-loader page-loader-variant-1">
        <div><img class='img-responsive' style='margin-top: -20px;margin-left: -18px;' width='340' height='67' src='<?php echo $PathLogoUtama; ?>' alt=''/>
          <div class="offset-top-41 text-center">
            <div class="spinner"></div>
          </div>
        </div>
      </div>
      <!-- Page Head-->
      <header class="page-head slider-menu-position">
        <!-- RD Navbar Transparent-->
        <div class="rd-navbar-wrap">
		  <nav class="rd-navbar rd-navbar-logo-center rd-navbar-dark" data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-static" data-lg-stick-up-offset="110px" data-lg-auto-height="true" data-md-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-stick-up="true">
            <div class="rd-navbar-inner">
              <div class="container">
                <div class="rd-navbar-top-block range range-lg-center range-lg-middle">
                  <div class="cell-lg-3">
                    <p class="veil reveal-lg-block">Get in touch: <span class="mdi mdi-phone"></span> <a href="tel:<?php echo $PhoneNumber; ?>"><?php echo $PhoneNumber; ?></a></p>
                  </div>
                  <div class="cell-lg-6 text-center">
                    <!--Navbar Brand-->
                    <div class="rd-navbar-brand"><a href="<?php echo $_SERVER["PHP_SELF"];?>?"><img style='margin-top: -5px;margin-left: -15px;' width='150' height='31' src='<?php echo $PathLogoUtama; ?>' alt=''/></a></div>
                  </div>
                  <div class="cell-lg-3">
                    <div class="form-search-wrap">
                      <!-- RD Search Form-->
                      <form class="form-search rd-search" action="#" method="GET">
                        <div class="form-group">
                          <label class="form-label form-search-label form-label-sm" for="rd-navbar-form-search-widget">Search</label>
                          <input class="form-search-input input-sm form-control form-control-gray-lightest input-sm" id="rd-navbar-form-search-widget" type="text" name="s" autocomplete="off"/>
                        </div>
                        <button class="form-search-submit" type="submit"><span class="mdi mdi-magnify"></span></button>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar, .rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Top Panel Toggle-->
                  <button class="rd-navbar-search-toggle" data-rd-navbar-toggle=".rd-navbar, .form-search-wrap"><span></span></button>
                </div>
              </div>
              <div class="rd-navbar-menu-wrap">
                <div class="container">
                  <div class="rd-navbar-nav-wrap">
                    <div class="rd-navbar-mobile-scroll">
                      <!--Navbar Brand Mobile-->
                      <div class="rd-navbar-mobile-brand"><a href="<?php echo $_SERVER["PHP_SELF"];?>?"><img style='margin-top: -5px;margin-left: -15px;' width='138' height='31' src='<?php echo $PathLogoUtama; ?>' alt=''/></a></div>
					  <!-- RD Navbar Nav-->
					  <?php
						/***** ini area function menu *****/
						menu($akses,$otoritas);
					  ?>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!-- Page Contents-->
      <main class="page-content">
		<?php
        /***** ini area konten / isi tampilan program .. berisi function isi konten *****/
		if ($menu=="Database") {
			judul_laporan("Control Database");
			mnudatabase($akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$submitbuttonstyle,$tablestyle);
		} 
		if ($menu=="Analisis") {
			judul_laporan("Dashboard Analytics");
			analytics($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle);
        } elseif ($menu=="ControlDevice") {
			judul_laporan("Control Device");
			ControlDevice($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$UrlContolDevice);
        } elseif ($menu=="user"){
			judul_laporan("Data User Application");
			user($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle);
		} elseif ($menu=="device"){
			judul_laporan("Data Device OvTrapIoT");
			device($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle);
		} elseif ($menu=="maintenance"){
			  judul_laporan("Data Maintenance");
			  Maintenance($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$UrlContolDevice);
		} elseif ($menu=="Report"){
			  judul_laporan("Report");
			  report($menu,$akses,$otoritas,$submenu,$id,$kategori,$filter,$filterDaily,$filterMonthly,$filterYearly,$fval,$sort,$warna_ganjil,$warna_genap,$ch,$submitbuttonstyle,$tablestyle);
        } elseif ($menu=="Database"){
			  if ($submenu<>"") echo "<h1>Database Editor , Table: ".$submenu."</h1>";
			  Database($akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$submitbuttonstyle,$tablestyle);
        } elseif ($menu=="Option"){
			if ($submenu=="Setting") judul_laporan("Setting Application");
			elseif ($submenu=="Calibration") judul_laporan("Calibration Device");
			elseif ($submenu=="ChangePass") judul_laporan("Change Password");
			elseif ($submenu=="Updates") judul_laporan("Update History");
			else judul_laporan("Under Construction");
			option($akses,$otoritas,$submenu,$id,$kategori,$filter,$fval,$sort,$warna_ganjil,$warna_genap,$filesetting,$filecalibration,$submitbuttonstyle,$tablestyle);
        } else {
        ?>
		<!-- Light Video Section-->
        <section>
          <div class="bg-vide" data-vide-bg="video/bg-video-2/bg-video-2-lg" data-vide-options="posterType: jpg">
            <div class="bg-overlay-white">
              <div class="shell" style="padding-top: 200px;padding-bottom: 80px;">
                <div class="range range-sm-center">
                  <div class="cell-sm-10">
				    <h1><span class="big"></span></h1>
                    <h1><span class="big text-bold">Dashboard <?php echo $TitleProject; ?></span></h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
		<!-- RD Google Map-->
		<section>
          <div class="offset-top-0">
            <div class="rd-google-map">
              <center><div class="rd-google-map__model" id="mapp" style="position: relative;overflow: hidden;height: 570px; width: 100%;"></div></center>
            </div>
          </div>
        </section>
		<!-- Skills-->
        <section class="section-34 section-md-41 context-dark" style="background: #191919 url(images/backgrounds/background-02-481x360.png);">
          <div class="shell-fluid">
            <div class="range">
              <div class="cell-sm-8 cell-sm-preffix-2 cell-md-12 cell-md-preffix-0">
				<?php
                echo "Update: ".tglhariini()."<br/>";
                $query = mysql_query("SELECT count(id_device) device_connect, sum(egg_counting) jumlah_egg, sum(larva_counting) jumlah_larva, ROUND(AVG(SUBSTRING_INDEX(SUBSTRING_INDEX(type_mosq, '&', 1), '=', -1)),2) as type_mosq from trx_device where activated= 1 and connection = 1 and id_device_jenis = 1 and waktu_capture BETWEEN '".date_format(date_create(tgldbasehariini()), "Y-m-d")." 00:00:00' AND '".date_format(date_create(tgldbasehariini()), "Y-m-d")." 23:59:59'"); 
                if (mysql_num_rows($query)>0) {
                  $k = mysql_fetch_array($query);
                  $device_connect = $k['device_connect'];
                  $egg_counting = $k['jumlah_egg'];
                  $larva_counting = $k['jumlah_larva'];
                  $type_mosq = $k['type_mosq'];
                } else{
				  $device_connect = 0;
                  $egg_counting = 0;
                  $larva_counting = 0;
                  $type_mosq = '-';
                }
                ?>
                <div class="range">
                  <div class="cell-sm-6 cell-md-3 cell-md-preffix-0">
					<!-- Counter type 1-->
					<div class="counter-type-1">
					  <div class="h1"><span class="big counter text-bold text-blue-gray" data-step="3000" data-from="0" data-to="<?php echo $device_connect; ?>"></span>
						<hr class="divider bg-white">
					  </div>
					  <h6 class="text-uppercase text-bold text-spacing-60 offset-top-20">Total OvTrapIoT</h6>
					</div>
                  </div>
                  <div class="cell-sm-6 cell-md-3 offset-top-66 offset-sm-top-0">
					<!-- Counter type 1-->
					<div class="counter-type-1">
					  <div class="h1"><span class="big counter text-bold text-blue-gray" data-speed="2500" data-from="0" data-to="<?php echo $egg_counting; ?>"></span>
						<hr class="divider bg-white">
					  </div>
					  <h6 class="text-uppercase text-bold text-spacing-60 offset-top-20">Total Egg</h6>
					</div>
                  </div>
                  <div class="cell-sm-6 cell-md-3 offset-top-66 offset-md-top-0">
					<!-- Counter type 1-->
					<div class="counter-type-1">
					  <div class="h1"><span class="big counter text-bold text-blue-gray" data-step="1500" data-from="0" data-to="<?php echo $larva_counting; ?>"></span>
						<hr class="divider bg-white">
					  </div>
					  <h6 class="text-uppercase text-bold text-spacing-60 offset-top-20">Total Larva</h6>
					</div>
                  </div>
                  <div class="cell-sm-6 cell-md-3 offset-top-66 offset-md-top-0">
					<!-- Counter type 1-->
					<div class="counter-type-1">
					  <div class="h1"><span class="big counter text-bold text-blue-gray" data-speed="1300" data-from="0" data-to="<?php echo $type_mosq; ?>"></span><span class="big text-bold text-blue-gray">%</span>
						<hr class="divider bg-white">
					  </div>
					  <h6 class="text-uppercase text-bold text-spacing-60 offset-top-20">Aedes Aegypti</h6>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
		<section class="section-98 section-sm-50">
          <div class="shell">
            <h1><span class="big text-bold">OvTrapIoT Status</span></h1>
            <hr class="divider divider-sm bg-darkers" style="margin-bottom: 10px;">
			<!--Section Themes Filter-->
			<section class="section-bottom-50">
			  <div class="shell">
				<form class="text-left" name="form_action" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
				  <h5 class="text-bold">Your filters</h5>
				  <div class="range range-xs-center offset-top-0">
					<div class="cell-sm-6 cell-md-4">
					  <div class="form-group">
						<label class="form-label form-label-outside" for="form-filter-location">Device Status:</label>
						<select class="form-control" id="form-filter-location" name="filterDevice" data-minimum-results-for-search="Infinity">
						  <?php echo "<option "; if ($filterDevice=="Connected") echo "selected=yes"; echo "value='Connected'>Connected</option>";?>
						  <?php echo "<option "; if ($filterDevice=="Diconnected") echo "selected=yes"; echo "value='Diconnected'>Diconnected</option>";?>
						</select>
					  </div>
					</div>
					<div class="cell-sm-6 cell-md-4 offset-top-20 offset-sm-top-0">
					  <div class="form-group">
						<label class="form-label form-label-outside" for="form-filter-property-status">Battery Status:</label>
						<select class="form-control" id="form-filter-property-status" name="filterBattery" data-minimum-results-for-search="Infinity">
						  <?php echo "<option "; if ($filterBattery=="Above 50%") echo "selected=yes"; echo "value='Above 50%'> Above 50%</option>";?>
						  <?php echo "<option "; if ($filterBattery=="Below 50%") echo "selected=yes"; echo "value='Below 50%'> Below 50%</option>";?>
						</select>
					  </div>
					</div>
					<div class="cell-sm-6 cell-md-4 offset-top-20 offset-md-top-0">
					  <div class="form-group">
						<label class="form-label form-label-outside" for="form-filter-property-type">Power Status:</label>
						<select class="form-control" id="form-filter-property-type" name="filterPower" data-minimum-results-for-search="Infinity">
						  <?php echo "<option "; if ($filterPower=="Plugged") echo "selected=yes"; echo "value='Plugged'>Plugged</option>";?>
						  <?php echo "<option "; if ($filterPower=="Unplugged") echo "selected=yes"; echo "value='Unplugged'>Unplugged</option>";?>
						</select>
					  </div>
					  <div class="cell-sm-1" style="padding-right: 30px;padding-left: 180px;">
						  <input class="btn btn-primary btn-block" type="submit" name="search" value='Search'>
					  </div>
					</div>
				  </div>
				</form>
			  </div>
			</section>
            <!-- Bootstrap Table-->
            <div class="table-responsive clearfix">
              <?php
                echo "<table class='table table-striped'>";
                echo "<tr>";
                echo "  <th class='text-regular text-dark big'>Device</th>";
                echo "  <th class='text-regular text-dark big'>Egg Counting</th>";
                echo "  <th class='text-regular text-dark big'>Larva Counting</th>";
                echo "  <th class='text-regular text-dark big'>Type Mosquito</th>";
                echo "  <th class='text-regular text-dark big'>Device Status</th>";
                echo "  <th class='text-regular text-dark big'>Image</th>";
                echo "  <th class='text-regular text-dark big'>Sound</th>";
                if ($akses<5)echo "  <th class='text-regular text-dark big'>Control</th>";
                echo "</tr>";
                $perPage=10;
                if (isset($_GET['pagedevice'])){
                  $page = $_GET['pagedevice'];
                } else {
                  $page = 1;
                }

                if ($page>1){
                  $start = ($page * $perPage) - $perPage;
                } else {
                  $start = 0;
                }
				if(isset($_POST['search'])){
					$query="SELECT pemilik, latitude, longitude, capture_path, sound_path, nama_device, egg_counting, larva_counting, SUBSTRING_INDEX(type_mosq,'&',1) as type_mosq, IF (connection='1', CONCAT('Battery: ', battery,'%, Power:', IF (power='1', 'Plug', 'Unplugged')), 'Device: Disconnect') as status_device FROM trx_device where activated = 1 and id_device_jenis = 1 ";
					if ($filterDevice=="Connected") $query.=" and connection = 1 "; elseif($filterDevice=="Diconnected") $query.=" and connection = 0 ";
					if ($filterBattery=="Above 50%") $query.=" and battery >= 50 "; elseif($filterBattery=="Below 50%") $query.=" and battery < 50 ";
					if ($filterPower=="Plugged") $query.=" and power = 1 "; elseif($filterPower=="Unplugged") $query.=" and power = 0 ";
					if ($filterDevice=="Connected") $query.=" LIMIT $start, $perPage";
				} else {
					$query="SELECT pemilik, latitude, longitude, capture_path, sound_path, nama_device, egg_counting, larva_counting, SUBSTRING_INDEX(type_mosq,'&',1) as type_mosq, IF (connection='1', CONCAT('Battery: ', battery,'%, Power:', IF (power='1', 'Plug', 'Unplugged')), 'Device: Disconnect') as status_device FROM trx_device where activated = 1 and id_device_jenis = 1 LIMIT $start, $perPage";
				}
                $strq=mysql_query($query) or die(mysql_error());
                if(mysql_num_rows($strq)>0) {
                  for($i=0;$i<mysql_num_rows($strq);$i++){
                  $str=mysql_fetch_array($strq);
                    echo "<tr>";
                    for ($k=5;$k<mysql_num_fields($strq);$k++){
                      echo "  <td>".$str[$k]."</td>";
                    }
                    echo "<th><a data-photo-swipe-item='' data-size='768x1024' href='imagerotate.php?path=".$str[3]."'><span class='icon icon-sm mdi mdi-file-image'></span></a></th>";
                    // echo "<button class='open-button' onclick='openForm()'>Open Form</button>";
                    echo "<th><a><span class='icon icon-sm mdi mdi-speaker trigger_popup_fricc' onclick='openForm()'></span></a></th>";
                    // echo "<th><a href='".$str[4]."' download='filename'><span class='icon icon-sm mdi mdi-speaker'></span></a></th>";
                    if ($akses<5) echo "<th><a href='".$_SERVER["PHP_SELF"]."?menu=ControlDevice'><span class='icon icon-sm mdi mdi-settings-box'></span></a></th>";
					// Popup Sound //
                    echo "<div class='form-popup' id='myForm' style='width: 806px;'>";
                    echo "  <div class='rd-audio' data-rd-audio-playlist-name='audio-playlist' data-rd-volume-bar-type='horizontal'>";
                    echo "    <div class='rd-audio-controls'>";
                    echo "      <div class='rd-audio-controls-left'>";
                    echo "        <!-- Prev Button--><a class='rd-audio-prev mdi mdi-fast-forward rd-audio-icon' href='#'></a>";
                    echo "        <!-- Play\Pause button--><a class='rd-audio-play-pause mdi mdi-play rd-audio-icon has-controls' href='#'></a>";
                    echo "        <!-- Next Button--><a class='rd-audio-next mdi mdi-fast-forward rd-audio-icon' href='#'></a>";
                    echo "      </div>";
                    echo "      <div class='rd-audio-progress-bar-wrap'>";
                    echo "        <div class='rd-audio-progress-bar'></div>";
                    echo "        <div class='rd-audio-time'>";
                    echo "          <!-- currentTime--><span class='rd-audio-current-time'>00:00</span><span class='rd-audio-time-divider'>/</span>";
                    echo "          <!-- Track duration--><span class='rd-audio-duration'>00:00</span>";
                    echo "        </div>";
                    echo "        <div class='rd-audio-title-wrap'><span class='rd-audio-author'></span> <span class='rd-audio-title-divider'>- </span>  <span class='rd-audio-title'></span></div>";
                    echo "      </div>";
                    echo "      <!-- Volume button--><a class='rd-audio-volume mdi mdi-volume-high rd-audio-icon' href='#'></a>";
                    echo "      <div class='rd-audio-volume-bar'></div>";
                    echo "     <div class='rd-audio-controls-right'>";
                    echo "        <!-- Playlist button--><a class='rd-audio-playlist-button rd-audio-icon mdi mdi-dots-horizontal' href='#'></a>";
                    echo "      </div>";
                    echo "      <div>";
                    echo "        <button class='btn btn-danger' type='button' onclick='closeForm()'>Close</button>";
                    echo "      </div>";
                    echo "    </div>";
                    echo "    <div class='rd-audio-playlist-wrap'>";
                    echo "      <h6 class='rd-audio-playlist-title'>Playlist</h6>";
                    echo "      <ul class='rd-audio-playlist' data-rd-audio-playlist='audio-playlist' data-rd-audio-play-on='li'>";
                    echo "        <li data-rd-audio-src='".substr($str[4],30,55)."' data-rd-audio-title='Suara Nyamuk ".$str[5]."' data-rd-audio-author='OvTrap IoT'></li>";
                    echo "      </ul>";
                    echo "    </div>";
                    echo "  </div>";
                    echo "</div>";
                  }
                  echo "</tr>";
                  echo "</table>";
                } else{
					echo "Data tidak ditemukan !!";
				}
              ?>
            </div>
			<div class="offset-top-66 text-center">
			  <!-- Classic Pagination-->
			  <nav>
				<ul class="pagination-classic">
				  <li><a href="#">Prev</a></li>
				  <?php
					$queryt = "Select * From trx_device";
					$data = mysql_query($queryt) or die(mysql_error());
					$jmlBaris = mysql_num_rows($data);
					$halaman = ceil($jmlBaris/$perPage);
					for($i=1;$i<=$halaman;$i++){
					  echo "<li><a href='?pagedevice=$i''>$i</a></li>";
					}
				  ?>
				  <li><a href="#">Next</a></li>
				</ul>
			  </nav>
            </div>
          </div>
        </section>
		<!-- Skills-->
		<?php
		$dataq = "select point_name from trx_lokasi";
		$dataquery = mysql_query($dataq);
		$pn=mysql_fetch_array($dataquery);
		?>
        <section class="section-66 section-xl-110 bg-lighter" id="section-skills">
		  <div class="h2 text-uppercase text-spacing-60 text-bold">Weather Report for <?php echo $pn[0].' (Indonesia)';?></div>
          <div class="shell-wide">
            <div class="range range-xs-center grid-group-md">
              <div class="cell-xs-6 cell-sm-5 cell-md-3">
                        <!-- Counter type 2-->
                        <div class="counter-type-2"><img src="<?php echo $current->image;?>">
                          <div class="offset-xl-top-10">
							<div class="h3 text-uppercase text-spacing-60 text-bold"><?php echo $current->description;?></div>
                            <div class="h6 text-uppercase text-left text-spacing-60 text-bold"><strong>Wind Speed : </strong><?php echo $current->windspeed;?> <?php echo $current->windspeed_unit;?><br/><strong>Pressue : </strong><?php echo $current->pressure;?> <?php echo $current->pressure_unit;?><br/><strong>Visibility : </strong><?php echo $current->visibility;?> <?php echo $current->visibility_unit;?></div>
                          </div>
                        </div>
              </div>
			  <div class="cell-xs-6 cell-sm-5 cell-md-3">
                        <!-- Counter type 2--> 
                        <div class="counter-type-2"><span class="icon mdi mdi-oil-temperature text-malibu"></span>
                          <div class="offset-top-10"><span class="h1 text-bold counter" data-speed="1600" data-from="0" data-to="<?php $q =mysql_query("select result from trx_device where id_device_jenis = 3") or die(mysql_error()); if (mysql_num_rows($q)>0) { $k = mysql_fetch_array($q); echo $k[0];}?>"></span><span class="h1 text-bold"> °C</span>
                          </div>
                          <div class="offset-xl-top-10">
                            <div class="h6 text-uppercase text-spacing-60 text-bold">Temperature</div>
                          </div>
                        </div>
              </div>
              <div class="cell-xs-6 cell-sm-5 cell-md-3">
                        <!-- Counter type 2-->
                        <div class="counter-type-2"><span class="icon mdi fa-tachometer text-carrot"></span>
                          <div class="offset-top-10"><span class="h1 text-bold counter" data-speed="2000" data-from="0" data-to="<?php $q =mysql_query("select result from trx_device where id_device_jenis = 4") or die(mysql_error()); if (mysql_num_rows($q)>0) { $k = mysql_fetch_array($q); echo $k[0];}?>"></span></span><span class="h1 text-bold"> %</span>
                          </div>
                          <div class="offset-xl-top-10">
                            <div class="h6 text-uppercase text-spacing-60 text-bold">Humidity</div>
                          </div>
                        </div>
              </div>
              <div class="cell-xs-6 cell-sm-5 cell-md-3">
                        <!-- Counter type 2-->
                        <div class="counter-type-2"><span class="icon mdi mdi-weather-windy-variant text-red"></span>
                          <div class="offset-top-10"><span class="h1 text-bold counter" data-speed="2400" data-from="0" data-to="<?php $q =mysql_query("select result from trx_device where id_device_jenis = 2") or die(mysql_error()); if (mysql_num_rows($q)>0) { $k = mysql_fetch_array($q); echo $k[0];}?>"></span><span class="h1 text-bold"> ppm</span>
                          </div>
                          <div class="offset-xl-top-10">
                            <div class="h6 text-uppercase text-spacing-60 text-bold">Carbon Dioxide</div>
                          </div>
                        </div>
              </div>
			  <div class="row">
				<h3 class="title text-center bordered">5 Days Weather Forecast for <?php echo $pn[0].' (Indonesia)';?></h3>
				<?php $loop=0; foreach($forecast as $f){ $loop++;?>
				  <div class="single forecast-block bordered" style="color: white;">
					<h3><?php echo $f->day;?></h3>
					<p style="font-size:1em;" class="aqi-value"><?php echo convert2cen($f->low,$f->low_unit);?> °C - <?php echo convert2cen($f->high,$f->high_unit);?> °C</p>
					<hr style="border-bottom:1px solid #fff;">
					<img src="<?php echo $f->image;?>">
					<p><?php echo $f->phrase;?></p>
				  </div>
				<?php } ?>
			  </div>
            </div>
          </div>
        </section>
		<?php
		}
		?>
      </main>
      <!-- Default footer-->
      <footer class="section-relative section-top-66 section-bottom-34 page-footer bg-gray-base context-dark">
        <div class="shell">
          <div class="range range-sm-center text-lg-left">
            <div class="cell-sm-8 cell-md-12">
              <div class="range range-xs-center">
                <div class="cell-xs-7 text-xs-left cell-md-4 cell-lg-3 cell-lg-push-4">
                  <h6 class="text-uppercase text-spacing-60">Latest news</h6>
					<!-- Post Widget-->
					<article class="post widget-post text-left text-picton-blue"><a href="blog-classic-single-post.html">
						<div class="unit unit-horizontal unit-spacing-xs unit-middle">
						  <div class="unit-body">
							<div class="post-meta"><span class="icon-xxs mdi mdi-arrow-right"></span>
							  <time class="text-dark" datetime="2016-01-01">05/14/2015</time>
							</div>
							<div class="post-title">
							  <h6 class="text-regular">Let’s Change the world</h6>
							</div>
						  </div>
						</div></a>
					</article>
					<!-- Post Widget-->
					<article class="post widget-post text-left text-picton-blue"><a href="blog-classic-single-post.html">
						<div class="unit unit-horizontal unit-spacing-xs unit-middle">
						  <div class="unit-body">
							<div class="post-meta"><span class="icon-xxs mdi mdi-arrow-right"></span>
							  <time class="text-dark" datetime="2016-01-01">05/14/2015</time>
							</div>
							<div class="post-title">
							  <h6 class="text-regular">The meaning of Web Design</h6>
							</div>
						  </div>
						</div></a>
					</article>
					<!-- Post Widget-->
					<article class="post widget-post text-left text-picton-blue"><a href="blog-classic-single-post.html">
						<div class="unit unit-horizontal unit-spacing-xs unit-middle">
						  <div class="unit-body">
							<div class="post-meta"><span class="icon-xxs mdi mdi-arrow-right"></span>
							  <time class="text-dark" datetime="2016-01-01">05/14/2015</time>
							</div>
							<div class="post-title">
							  <h6 class="text-regular">Get Started with Wagglesys</h6>
							</div>
						  </div>
						</div></a>
					</article>
                </div>
                <div class="cell-xs-5 offset-top-41 offset-xs-top-0 text-xs-left cell-md-3 cell-lg-2 cell-lg-push-3">
                  <h6 class="text-uppercase text-spacing-60">Useful Links</h6>
                  <div class="reveal-block">
                    <div class="reveal-inline-block">
                      <ul class="list list-marked">
                        <li class="active"><a href="<?php echo $_SERVER["PHP_SELF"];?>?"><span>Dashboard</span></a></li>
						<li><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Analytics"><span>Analytics Data</span></a></li>
						<li><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Shcedule&sub=View"><span>Maintenance</span></a></li>
						<li><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Report&sub=View"><span>Report</span></a></li>
						<li><a href="<?php echo $_SERVER["PHP_SELF"];?>?menu=Option&submenu=ChangePass"><span>Change Password</span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="cell-xs-12 offset-top-41 cell-md-5 offset-md-top-0 text-md-left cell-lg-4 cell-lg-push-2">
                  <h6 class="text-uppercase text-spacing-60 text-center">Contact us</h6>
                  <div class="offset-top-30">
                          <!-- RD Mailform-->
                        <form class="rd-mailform offset-top-34 offset-md-top-0 text-left" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
                          <div class="form-group">
                            <label class="form-label form-label-sm" for="footer-v2-name">Name:</label>
                            <input class="form-control input-sm form-control-impressed" id="footer-v2-name" type="text" data-constraints="@Required" name="name">
                          </div>
                          <div class="form-group offset-top-20">
                            <label class="form-label form-label-sm" for="footer-v2-email">Your Email*:</label>
                            <input class="form-control input-sm form-control-impressed" id="footer-v2-email" type="email" data-constraints="@Required @Email" name="email">
                          </div>
                          <div class="form-group offset-top-20">
                            <label class="form-label form-label-sm" for="footer-v2-message">Message*:</label>
                            <textarea class="form-control input-sm form-control-impressed" id="footer-v2-message" name="message" data-constraints="@Required" style="height: 80px;"></textarea>
                          </div>
                          <div class="group offset-top-20">
                            <button class="btn btn-sm btn-primary" type="submit" style="padding-left: 30px; padding-right: 30px;">submit</button>
                          </div>
                        </form>
                  </div>
                </div>
                <div class="cell-xs-12 offset-top-66 cell-lg-3 cell-lg-push-1 offset-lg-top-0">
                  <!-- Footer brand-->
                  <div class="footer-brand"><a href="<?php echo $_SERVER["PHP_SELF"];?>"><img style='margin-top: -5px;margin-left: -15px;' width='150' height='31' src='<?php echo $PathLogoUtama; ?>' alt=''/></a></div>
                  <p class="text-malibu offset-top-4">Create . Innovate . Synergize</p>
                  <address class="contact-info offset-top-30 p">
                    <div>
                      <dl>
                        <dt class="text-white">Address:</dt>
                        <dd class="text-malibu reveal-lg-block"><a href="https://goo.gl/maps/XZYZaXafastTGy4Q9" target="_blank">Jalan Sidomukti No. 68 <span class="reveal-lg-block">Kec. Cibeunying Kaler, Kota Bandung</span> <span class="reveal-lg-block">Jawa Barat 40123</span></a></dd>
                      </dl>
                    </div>
                    <div>
                      <dl class="offset-top-0">
                        <dt class="text-white">Telephone:</dt>
                        <dd class="text-malibu"><a href="tel:<?php echo $PhoneNumber; ?>"><?php echo $PhoneNumber; ?></a></dd>
                      </dl>
                    </div>
                    <div>
                      <dl class="offset-top-0">
                        <dt class="text-white">E-mail:</dt>
                        <dd class="text-malibu"><a href="mailto: support@cinovasi.com">support@cinovasi.com</a></dd>
                      </dl>
                    </div>
                  </address>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="shell offset-top-50">
          <p class="small text-darker">Cinovasi &copy; <span class="copyright-year"></span> . <a href="privacy.php">Privacy Policy</a></p>
        </div>
      </footer>
    </div>
    <!-- Global RD Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- PhotoSwipe Gallery-->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <button class="pswp__button pswp__button--share" title="Share"></button>
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div>
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
          <div class="pswp__caption">
            <div class="pswp__caption__center"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- JavaScript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
	<script>
      function openForm() {
        document.getElementById("myForm").style.display = "block";
      }

      function closeForm() {
        document.getElementById("myForm").style.display = "none";
      }
	</script>
  </body>
</html>