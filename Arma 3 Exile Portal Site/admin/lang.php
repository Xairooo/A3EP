
<?php
 require('header.php');
 $error = '';
 ?>
<?php
if(isset($_POST['createform'])){
	$query = "
		INSERT INTO ".$tblpre."lang (
				lang_short,
				lang_title,
				lang_default
			) VALUES (
				:short,
				:title,
				:default
			)
		";
		$query_params = array(
			':short' => $_POST['lang_short'],
			':title' => $_POST['cLanguage'],
			':default' => $_POST['default_language']
		);
		try
		{
			$stmt = $db->prepare($query);
			$result = $stmt->execute($query_params);
		}
		catch(PDOException $ex)
		{
			die("Failed to run query: " . $ex->getMessage());
		}
		{
	$langfile = 'language/'.$_POST['cLanguage'].'.xml';
	$defaultfile = 'language/default/English.xml';
	if(!file_exists($langfile)) {
  $langname = $_POST['cLanguage'];
  $locale = $_POST['lang_short'];
  $oldContents = file_get_contents($defaultfile);
  $handle = fopen($langfile, 'w+') or die('Cannot open file:  '.$langfile .' - Check file permissions');
  $langinfo = '<language name="'.$langname.'" locale="'.$locale.'">
  ';
  if (!is_writable($langfile)) {
    die("Cannot write to file - ". $langfile .". Check write permissions.");
  }
  fwrite($handle, $langinfo);
fwrite($handle, $oldContents);
  fclose($handle);

 $xml = new XMLReader;
$xml->open( $langfile );
$xml->read();
$localeshort = $xml->getAttribute('locale');
	$query = "SELECT module_key FROM ".$tblpre."modules";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query2: " . $ex->getMessage());
    }

    $row = $stmt->fetchAll();
 $appKey = NULL;
$xml->read();
	while ( $xml->read() and $xml->name == 'app')
		{
		$appKey = $xml->getAttribute('key');

				$xml->read();
						while ( $xml->read() and $xml->name == 'word' )
						{

					$query3 = "
				INSERT INTO ".$tblpre."lang_words (
					lang_id,
					word_module,
					word_key,
					word_default
				) VALUES (
					:shorts,
					:modules,
					:keys,
					:default
				)
			";

			$query_params3 = array(
				':shorts' => $localeshort,
				':modules' => $appKey,
				':keys' => $xml->getAttribute('key'),
				':default' => $xml->readString()
			);

			try
			{
				$stmt3 = $db->prepare($query3);
				$result3 = $stmt3->execute($query_params3);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query3: " . $ex->getMessage());
			}

							$xml->next();
						}

	$xml->next();

		}

	header("location: lang.php");




?>


<?php
} else {
		echo "error";
	}

}

}
if(isset($_POST["uploadlang"])) {

		$target_dir = "language/";
$target_file = $target_dir . basename($_FILES["langfile"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file already exists
if (file_exists($target_file)) {
    $error = $langs->word($dlang,'language_exists');
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "xml" ) {
   $error = $langs->word($dlang,'lang_wrong_file_type');
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   $error = $langs->word($dlang,'not_uploaded');
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["langfile"]["tmp_name"], $target_file)) {
$xml = new XMLReader;
$xml->open( $target_file );
$xml->read();
$querya = "SELECT * FROM ".$tblpre."lang WHERE
					lang_short = :lang_short
			";

			$query_paramsa = array(
				':lang_short' => $xml->getAttribute('locale')
			);

			try
			{
				$stmta = $db->prepare($querya);
				$resulta = $stmta->execute($query_paramsa);
			}
			catch(PDOException $ex)
			{

				die("Failed to run query1: " . $ex->getMessage());
			}

			$rowa = $stmta->fetch();
			if($rowa)
			{
$error = "blah";
}else
{
$queryb = "SELECT * FROM ".$tblpre."lang
			";

			try
			{
				$stmtb = $db->prepare($queryb);
				$resultb = $stmtb->execute();
			}
			catch(PDOException $ex)
			{

				die("Failed to run query1: " . $ex->getMessage());
			}

			$count = $stmtb->fetchAll();
			if($count){
	$query2 = "
				INSERT INTO ".$tblpre."lang (
					lang_short,
					lang_title,
					lang_default
				) VALUES (
					:short,
					:title,
					:defaults
				)
			";

			$query_params2 = array(
				':short' => $xml->getAttribute('locale'),
				':title' => $xml->getAttribute('name'),
				':defaults' => '0'
			);

			try
			{
				$stmt2 = $db->prepare($query2);
				$result2 = $stmt2->execute($query_params2);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
			} else {
			  	$query2 = "
				INSERT INTO ".$tblpre."lang (
					lang_short,
					lang_title,
					lang_default
				) VALUES (
					:short,
					:title,
					:defaults
				)
			";

			$query_params2 = array(
				':short' => $xml->getAttribute('locale'),
				':title' => $xml->getAttribute('name'),
				':defaults' => '1'
			);

			try
			{
				$stmt2 = $db->prepare($query2);
				$result2 = $stmt2->execute($query_params2);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
			}

$localeshort = $xml->getAttribute('locale');
	$query = "SELECT module_key FROM ".$tblpre."modules";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query2: " . $ex->getMessage());
    }

    $row = $stmt->fetchAll();
 $appKey = NULL;
$xml->read();
	while ( $xml->read() and $xml->name == 'app')
		{
		$appKey = $xml->getAttribute('key');

				$xml->read();
						while ( $xml->read() and $xml->name == 'word' )
						{

					$query3 = "
				INSERT INTO ".$tblpre."lang_words (
					lang_id,
					word_module,
					word_key,
					word_default
				) VALUES (
					:shorts,
					:modules,
					:keys,
					:default
				)
			";

			$query_params3 = array(
				':shorts' => $localeshort,
				':modules' => $appKey,
				':keys' => $xml->getAttribute('key'),
				':default' => $xml->readString()
			);

			try
			{
				$stmt3 = $db->prepare($query3);
				$result3 = $stmt3->execute($query_params3);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query3: " . $ex->getMessage());
			}

							$xml->next();
						}

	$xml->next();

		}
}
    } else {
        echo $langs->word($dlang,'avatar_error');
    }
}
}
if(isset($_GET['do'])){
if (($_GET['do'] =='translate') && !empty($_GET['do']) AND isset($_GET['lang']) && !empty($_GET['lang'])){
	?>
	<script>
		$(document).ready(function() {

			$('#translatelist').DataTable({
				'paging': true,
				'lengthChange': true,
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				'searching': true,
				'ordering': true,
				'info': true,
				'autoWidth': true

			})
		})
	</script>
		<?php
                 $query = "SELECT * FROM `".$tblpre."lang` WHERE lang_short=:lshort;";
  	$query_params = array(
				':lshort' => $_GET['lang']
  		 );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $rows = $stmt->fetch();
 ?>
	<?php $langshort = $rows['lang_short'];?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
			<?php echo $rows['lang_title'];?>
			</h1>
			<small></small>
			<ol class="breadcrumb">
				<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Language</li>
				<li class="active">Translating 	<?php echo $rows['lang_title'];?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">

			<div class="row">
				<div class="col-xs-12">

<style>
.cTranslateTable textarea {
    height: 100%;
    min-height: 50px;
    min-width: 150px;
    white-space: pre-wrap;
    background-color: #ffffff;
    border-width: 1px;
    border-style: solid;
    border-color: rgba(0,0,0,0.2);
    border-radius: 3px;
    width: 100%;
    padding: 7px;
}
.cTranslateTable_field {
    position: relative;
}
.cTranslateTable_field a[data-action] {
display:none;
    position: absolute;
    height: 22px;
    bottom: -22px;
    z-index: 4000;
    line-height: 20px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.cTranslateTable_field a[data-action="saveWords"] {
    right: 0;
}
.btn{
	font-size: 12px;
    line-height: 28px;
    padding: 0 15px;
    vertical-align: middle;
}
</style>
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Translating 	<?php echo $rows['lang_title'];?></h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<table id="translatelist" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th style="width:80px">Module</th>
										<th style="width:190px">Key</th>
										<th style="width:350px">Default</th>
										<th style="width:414px">Custom</th>
										<th style="width:414px">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
                 $query = "SELECT * FROM ".$tblpre."lang_words WHERE lang_id='". $langshort. "'";


        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute();
        }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $row2 = $stmt->fetchAll();

?>
										<script>

											$(function() {
												$('[data-toggle="tooltip"]').tooltip()
											})
											$(function() {
												var options = {
													placement: function(context, source) {
														var position = $(source).position();

														if (position.left > 515) {
															return "left";
														}

														if (position.left < 515) {
															return "right";
														}

														if (position.top < 110) {
															return "bottom";
														}

														return "top";
													},
													html: true,
													content: function() {
														var id = $(this).attr('id')
														return $('#popover-content-' + id).html();
													}
												};
												$('[data-toggle="popover"]').popover(options)

											})

										</script>
										<?php  foreach($row2 as $row):?>

									<tr>
										<td><?php echo $row['word_module'];?></td>
										<td><?php echo $row['word_key'];?></td>
										<td><?php echo $row['word_default'];?></td>
										<td>

									<?php echo $row['word_custom'];?></td>
										<td> <button type="button" data-toggle="modal" data-target="#editcustom" class="btn btn-success"><i class="fa fa-pencil"></i><?php echo $langs->word($dlang,'edit');?></button>
             </td>
									</tr>
  <div class="modal fade" id="editcustom">
          <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" action="lang.php?do=translate&lang=<?php echo $langshort;?>">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $langs->word($dlang,'edit_custom'); ?></h4>
              </div>
              <div class="modal-body">
                  <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'custom_word'); ?></label>

                  <div class="col-sm-6">
                      <input type="hidden" value="<?php echo $row['word_default'];?>" name="word_default">
              <input name="custom_word" class="form-control" value="<?php echo $row['word_custom']; ?>"><br />
                  </div>
                </div>
              </div>

              <!-- /.box-body -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
                <button type="submit" name="customwordform" class="btn btn-primary"><?php echo $langs->word($dlang,'save'); ?></button>

              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
										<?php endforeach;?>
								</tbody>
								<tfoot>
									<tr>
										<th>Module</th>
										<th>Key</th>
										<th>Default</th>
										<th>Custom</th>
										<th>Action</th>
																		</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!--/Edit member page-->
<?php }
if (($_GET['do'] =='delete') && !empty($_GET['do']) AND isset($_GET['lang']) && !empty($_GET['lang'])){
    $id = $_GET['lang'];
	  $query = "SELECT * FROM `".$tblpre."lang` WHERE lang_short=:lshort;";
  	$query_params = array(
				':lshort' => $_GET['lang']
  		 );

        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $rows = $stmt->fetch();

    unlink("language/".$rows['lang_title'].".xml");
$query = "
				DELETE FROM ".$tblpre."lang
			";
			$query_params = array(
				':locale' => $id,
			);
			$query .= "
				WHERE
					lang_short = :locale
			";

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
			$query = "
				DELETE FROM ".$tblpre."lang_words
			";
			$query_params = array(
				':locale' => $id,
			);
			$query .= "
				WHERE
					lang_id = :locale
			";

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
	//needed from rc1 to rc2
		if (file_exists('language/English(1).xml')) {
			unlink('language/English(1).xml');
}

				header("location: lang.php");
}

} else { ?>
<div class="content-wrapper">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
   <?php echo $langs->word($dlang,'language');?>

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home');?></a></li>
        <li><?php echo $langs->word($dlang,'portal');?></li>
        <li class="active"><?php echo $langs->word($dlang,'language');?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-primary">
            <div class="box-header with-border">

              <?php if ($error ==''){ } else {
              echo $error;
              }?>
              <div class="box-tools pull-right">
              <button type="button" data-toggle="modal" data-target="#create" class="btn btn-success"><i class="fa fa-plus"></i><?php echo $langs->word($dlang,'create_new');?></button>
              	<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php echo $langs->word($dlang,'create_language');?></h4>
              </div>
              <div class="modal-body">

              <div class="box-body">

              	<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#createlang" data-toggle="tab" aria-expanded="true">Create New</a></li>
              <li class=""><a href="#upload" data-toggle="tab" aria-expanded="false">Upload</a></li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="createlang">
 <form class="form-horizontal" method="POST" action="">
               <div class="form-group">
                  <label class="col-sm-4 control-label">Language</label>

                  <div class="col-sm-6">
              <input name="cLanguage" class="form-control" value=""><br>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-4 control-label">Locale</label>


                  <div class="col-sm-6">
                  	<select name="lang_short" class="form-control" id="clocale">
			<option value="he_IL">(עברית (ישראל</option>
			<option value="ar_JO">(العربية (الأردن</option>
			<option value="ar_AE">(العربية (الامارات العربية المتحدة</option>
			<option value="ar_BH">(العربية (البحرين</option>
			<option value="ar_DZ">(العربية (الجزائر</option>
			<option value="ar_IQ">(العربية (العراق</option>
			<option value="ar_KW">(العربية (الكويت</option>
			<option value="ar_MA">(العربية (المغرب</option>
			<option value="ar_YE">(العربية (اليمن</option>
			<option value="ar_TN">(العربية (تونس</option>
			<option value="ar_SY">(العربية (سوريا</option>
			<option value="ar_OM">(العربية (عُمان</option>
			<option value="ar_QA">(العربية (قطر</option>
			<option value="ar_LB">(العربية (لبنان</option>
			<option value="ar_LY">(العربية (ليبيا</option>
			<option value="ar_EG">(العربية (مصر</option>
			<option value="ar_SA">(العربية المملكة العربية السعودية</option>
			<option value="fa_IR">(فارسی (ایران</option>
			<option value="ps_AF">(پښتو (افغانستان</option>
			<option value="af_ZA">Afrikaans (Suid-Afrika)</option>
			<option value="id_ID">Bahasa Indonesia (Indonesia)</option>
			<option value="ms_MY">Bahasa Melayu (Malaysia)</option>
			<option value="br_FR">Breton (France)</option>
			<option value="ca_ES">català (Espanya)</option>
			<option value="cy_GB">Cymraeg (Prydain Fawr)</option>
			<option value="da_DK">dansk (Danmark)</option>
			<option value="de_DE">Deutsch (Deutschland)</option>
			<option value="de_LU">Deutsch (Luxemburg)</option>
			<option value="de_CH">Deutsch (Schweiz)</option>
			<option value="de_AT">Deutsch (Österreich)</option>
			<option value="dv_MV">Divehi (Maldives)</option>
			<option value="et_EE">eesti (Eesti)</option>
			<option value="en_AU">English (Australia)</option>
			<option value="en_CA">English (Canada)</option>
			<option value="en_IN">English (India)</option>
			<option value="en_IE">English (Ireland)</option>
			<option value="en_NZ">English (New Zealand)</option>
			<option value="en_PH">English (Philippines)</option>
			<option value="en_SG">English (Singapore)</option>
			<option value="en_ZA">English (South Africa)</option>
			<option value="en_GB">English (United Kingdom)</option>
			<option value="en_US" selected="">English (United States)</option>
			<option value="en_ZW">English (Zimbabwe)</option>
			<option value="es_AR">español (Argentina)</option>
			<option value="es_BO">español (Bolivia)</option>
			<option value="es_CL">español (Chile)</option>
			<option value="es_CO">español (Colombia)</option>
			<option value="es_CR">español (Costa Rica)</option>
			<option value="es_EC">español (Ecuador)</option>
			<option value="es_SV">español (El Salvador)</option>
			<option value="es_ES">español (España)</option>
			<option value="es_US">español (Estados Unidos)</option>
			<option value="es_GT">español (Guatemala)</option>
			<option value="es_HN">español (Honduras)</option>
			<option value="es_MX">español (México)</option>
			<option value="es_NI">español (Nicaragua)</option>
			<option value="es_PA">español (Panamá)</option>
			<option value="es_PY">español (Paraguay)</option>
			<option value="es_PE">español (Perú)</option>
			<option value="es_PR">español (Puerto Rico)</option>
			<option value="es_DO">español (República Dominicana)</option>
			<option value="es_UY">español (Uruguay)</option>
			<option value="es_VE">español (Venezuela)</option>
			<option value="eu_ES">euskara (Espainia)</option>
			<option value="fil_PH">Filipino (Pilipinas)</option>
			<option value="fr_BE">français (Belgique)</option>
			<option value="fr_CA">français (Canada)</option>
			<option value="fr_FR">français (France)</option>
			<option value="fr_LU">français (Luxembourg)</option>
			<option value="fr_CH">français (Suisse)</option>
			<option value="fo_FO">føroyskt (Føroyar)</option>
			<option value="ga_IE">Gaeilge (Éire)</option>
			<option value="gl_ES">galego (España)</option>
			<option value="hr_HR">hrvatski (Hrvatska)</option>
			<option value="ig_NG">Igbo (Nigeria)</option>
			<option value="zu_ZA">isiZulu (iNingizimu Afrika)</option>
			<option value="it_IT">italiano (Italia)</option>
			<option value="it_CH">italiano (Svizzera)</option>
			<option value="kl_GL">kalaallisut (Kalaallit Nunaat)</option>
			<option value="rw_RW">Kinyarwanda (Rwanda)</option>
			<option value="ky_KG">Kirghiz (Kyrgyzstan)</option>
			<option value="sw_KE">Kiswahili (Kenya)</option>
			<option value="lo_LA">Lao (Laos)</option>
			<option value="lv_LV">latviešu (Latvija)</option>
			<option value="lt_LT">lietuvių (Lietuva)</option>
			<option value="lb_LU">Luxembourgish (Luxembourg)</option>
			<option value="hu_HU">magyar (Magyarország)</option>
			<option value="mt_MT">Malti (Malta)</option>
			<option value="mi_NZ">Maori (New Zealand)</option>
			<option value="mn_MN">Mongolian (Mongolia)</option>
			<option value="nl_BE">Nederlands (België)</option>
			<option value="nl_NL">Nederlands (Nederland)</option>
			<option value="nb_NO">norsk bokmål (Norge)</option>
			<option value="se_NO">Northern Sami (Norway)</option>
			<option value="nso_ZA">Northern Sotho (South Africa)</option>
			<option value="nn_NO">nynorsk (Noreg)</option>
			<option value="oc_FR">Occitan (France)</option>
			<option value="pl_PL">polski (Polska)</option>
			<option value="pt_BR">português (Brasil)</option>
			<option value="pt_PT">português (Portugal)</option>
			<option value="ro_RO">română (România)</option>
			<option value="sa_IN">Sanskrit (India)</option>
			<option value="gd_GB">Scottish Gaelic (United Kingdom)</option>
			<option value="sq_AL">shqipe (Shqipëria)</option>
			<option value="sk_SK">slovenčina (Slovenská republika)</option>
			<option value="sl_SI">slovenščina (Slovenija)</option>
			<option value="fi_FI">suomi (Suomi)</option>
			<option value="sv_FI">svenska (Finland)</option>
			<option value="sv_SE">svenska (Sverige)</option>
			<option value="tt_RU">Tatar (Russia)</option>
			<option value="ur_PK">THIS ONE(اردو (پاکستان)</option>
			<option value="vi_VN">Tiếng Việt (Việt Nam)</option>
			<option value="tn_ZA">Tswana (South Africa)</option>
			<option value="tk_TM">Turkmen (Turkmenistan)</option>
			<option value="tr_TR">Türkçe (Türkiye)</option>
			<option value="ug_CN">Uighur (China)</option>
			<option value="hsb_DE">Upper Sorbian (Germany)</option>
			<option value="fy_NL">Western Frisian (Netherlands)</option>
			<option value="wo_SN">Wolof (Senegal)</option>
			<option value="xh_ZA">Xhosa (South Africa)</option>
			<option value="kok_IN">कोंकणी (भारत)</option>
			<option value="ne_NP">नेपाली (नेपाल)</option>
			<option value="mr_IN">मराठी (भारत)</option>
			<option value="hi_IN">हिन्दी (भारत)</option>
			<option value="as_IN">অসমীয়া (ভাৰত)</option>
			<option value="bn_BD">বাংলা (বাংলাদেশ)</option>
			<option value="bn_IN">বাংলা (ভারত)</option>
			<option value="pa_IN">ਪੰਜਾਬੀ (ਭਾਰਤ)</option>
			<option value="gu_IN">ગુજરાતી (ભારત)</option>
			<option value="or_IN">ଓଡ଼ିଆ (ଭାରତ)</option>
			<option value="ta_IN">தமிழ் (இந்தியா)</option>
			<option value="te_IN">తెలుగు (భారత దేశం)</option>
			<option value="kn_IN">ಕನ್ನಡ (ಭಾರತ)</option>
			<option value="ml_IN">മലയാളം (ഇന്ത്യ)</option>
			<option value="si_LK">සිංහල (ශ්&zwj;රී ලංකාව)</option>
			<option value="th_TH">ไทย (ไทย)</option>
			<option value="bo_CN">���ོད་སྐད་ (རྒྱ་ནག)</option>
			<option value="ka_GE">ქართული (საქართველო)</option>
			<option value="am_ET">አማርኛ (ኢትዮጵያ)</option>
			<option value="km_KH">ភាសាខ្មែរ (កម្ពុជា)</option>
			<option value="yo_NG">Èdè Yorùbá (Orílẹ́ède Nàìjíríà)</option>
			<option value="is_IS">íslenska (Ísland)</option>
			<option value="cs_CZ">čeština (Česká republika)</option>
			<option value="zh_HK">中文 (中華人民共和國香港特別行政區)</option>
			<option value="zh_TW">中文 (台灣)</option>
			<option value="zh_CN">中文（中国）</option>
			<option value="zh_SG">中文（新加坡）</option>
			<option value="ja_JP">日本語(日本)</option>
			<option value="ko_KR">한국어(대한민국)</option>
			<option value="el_GR">Ελληνικά (Ελλάδα)</option>
			<option value="be_BY">Беларуская (Беларусь)</option>
			<option value="bg_BG">Български (България)</option>
			<option value="mk_MK">Македонски (Македонија)</option>
			<option value="ru_RU">Русский (Россия)</option>
			<option value="uk_UA">Українська (Україна)</option>
			<option value="kk_KZ">Қазақ (Қазақстан)</option>
			<option value="hy_AM">Հայերէն (Հայաստանի Հանրապետութիւն)</option>
			<option value="x" data-control="toggle" data-toggles="locale_custom">- My locale is not listed -</option>
</select>
<script>
$("select").change(function(){
    alert($.trim($("#clocale").children("option:selected").text()));
});
</script>
                  </div>
                </div>
                <div class="form-group">
									<label class="col-sm-4 control-label">Default Language</label>

									<div class="col-sm-6">
										<input type="hidden" name="default_language" value="0" />
										<input type="checkbox" data-size="small" data-toggle="toggle" id="default_language" name="default_language" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>">
							<br>	Use if a member has not specifically set a language.

								<br>
									<br>	<br>
									 <button type="submit" name="createform" class="btn btn-primary">Create</button>	</div>
								</div>
								</form>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="upload">
              	 <form action="" method="post" enctype="multipart/form-data">

<div class="custom-file">
	<input type="file" accept=".xml" class ="custom-file-input" name="langfile" id="langfile">
	</div>

    						<input type="submit" value="<?php echo $langs->word($dlang,'upload'); ?>" name="uploadlang">
						</form>
              </div>
              <!-- /.tab-pane -->


            </div>
            <!-- /.tab-content -->
          </div>
 </div>
              <!-- /.box-body -->

             </div>

            </div>
            <!-- /.modal-content -->
          </div>

											</div>

</div>  </div>
	<?php
                 $query = "SELECT * FROM ".$tblpre."lang;";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $rows = $stmt->fetchAll();

?>	<script>
											$(function() {
												$('[data-toggle="tooltip"]').tooltip()
											})
											$(function() {
												var options = {
													placement: function(context, source) {
														var position = $(source).position();

														if (position.left > 515) {
															return "left";
														}

														if (position.left < 515) {
															return "right";
														}

														if (position.top < 110) {
															return "bottom";
														}

														return "top";
													},
													html: true,
													content: function() {
														var id = $(this).attr('id')
														return $('#popover-content-' + id).html();
													}
												};
												$('[data-toggle="popover"]').popover(options)

											})
										</script>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                  <?php  foreach($rows as $row): ?>
                <li class="item">
                  <div class="product-info">
                    <span class="product-title"><?php echo $row['lang_title'];?></span>
                      <div class="pull-right">	<a href="lang.php?do=translate&lang=<?php echo $row['lang_short'];?>" role="button" data-toggle="tooltip" title="Translate" class="btn btn-default"><i class="fa fa-globe"></i></a>
<a tabindex="<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" class="btn btn-default" data-html="true" role="button" data-toggle="popover" data-trigger="focus" data-container="body">
                        <i class="fa fa-angle-down fa-lg"></i></a>

											<div id="popover-content-<?php echo $row['id'];?>" class="hide">

												<ul class="nav nav-stacked">
													<li><a href="lang.php?do=delete&lang=<?php echo $row['lang_short'];?>"><?php echo $langs->word($dlang,'delete');?></a></li>
	<li><a href="langdownload.php?do=download&lang=<?php echo $row['lang_title'];?>"><?php echo $langs->word($dlang,'download');?></a></li>

												</ul>
											</div>

                  </div>
                </li>
                <!-- /.item -->
                           	<div class="modal fade" id="edit<?php echo $row['lang_short'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="POST" action="">
              <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-4 control-label">Language</label>

                  <div class="col-sm-6">
              <input name="Language" class="form-control" value=""><br>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-4 control-label">Locale</label>


                  <div class="col-sm-6">
                  	<select name="lang_short" class="form-control" id="locale">
			<option value="he_IL">(עברית (ישראל</option>
			<option value="ar_JO">(العربية (الأردن</option>
			<option value="ar_AE">(العربية (الامارات العربية المتحدة</option>
			<option value="ar_BH">(العربية (البحرين</option>
			<option value="ar_DZ">(العربية (الجزائر</option>
			<option value="ar_IQ">(العربية (العراق</option>
			<option value="ar_KW">(العربية (الكويت</option>
			<option value="ar_MA">(العربية (المغرب</option>
			<option value="ar_YE">(العربية (اليمن</option>
			<option value="ar_TN">(العربية (تونس</option>
			<option value="ar_SY">(العربية (سوريا</option>
			<option value="ar_OM">(العربية (عُمان</option>
			<option value="ar_QA">(العربية (قطر</option>
			<option value="ar_LB">(العربية (لبنان</option>
			<option value="ar_LY">(العربية (ليبيا</option>
			<option value="ar_EG">(العربية (مصر</option>
			<option value="ar_SA">(العربية المملكة العربية السعودية</option>
			<option value="fa_IR">(فارسی (ایران</option>
			<option value="ps_AF">(پښتو (افغانستان</option>
			<option value="af_ZA">Afrikaans (Suid-Afrika)</option>
			<option value="id_ID">Bahasa Indonesia (Indonesia)</option>
			<option value="ms_MY">Bahasa Melayu (Malaysia)</option>
			<option value="br_FR">Breton (France)</option>
			<option value="ca_ES">català (Espanya)</option>
			<option value="cy_GB">Cymraeg (Prydain Fawr)</option>
			<option value="da_DK">dansk (Danmark)</option>
			<option value="de_DE">Deutsch (Deutschland)</option>
			<option value="de_LU">Deutsch (Luxemburg)</option>
			<option value="de_CH">Deutsch (Schweiz)</option>
			<option value="de_AT">Deutsch (Österreich)</option>
			<option value="dv_MV">Divehi (Maldives)</option>
			<option value="et_EE">eesti (Eesti)</option>
			<option value="en_AU">English (Australia)</option>
			<option value="en_CA">English (Canada)</option>
			<option value="en_IN">English (India)</option>
			<option value="en_IE">English (Ireland)</option>
			<option value="en_NZ">English (New Zealand)</option>
			<option value="en_PH">English (Philippines)</option>
			<option value="en_SG">English (Singapore)</option>
			<option value="en_ZA">English (South Africa)</option>
			<option value="en_GB">English (United Kingdom)</option>
			<option value="en_US" selected="">English (United States)</option>
			<option value="en_ZW">English (Zimbabwe)</option>
			<option value="es_AR">español (Argentina)</option>
			<option value="es_BO">español (Bolivia)</option>
			<option value="es_CL">español (Chile)</option>
			<option value="es_CO">español (Colombia)</option>
			<option value="es_CR">español (Costa Rica)</option>
			<option value="es_EC">español (Ecuador)</option>
			<option value="es_SV">español (El Salvador)</option>
			<option value="es_ES">español (España)</option>
			<option value="es_US">español (Estados Unidos)</option>
			<option value="es_GT">español (Guatemala)</option>
			<option value="es_HN">español (Honduras)</option>
			<option value="es_MX">español (México)</option>
			<option value="es_NI">español (Nicaragua)</option>
			<option value="es_PA">español (Panamá)</option>
			<option value="es_PY">español (Paraguay)</option>
			<option value="es_PE">español (Perú)</option>
			<option value="es_PR">español (Puerto Rico)</option>
			<option value="es_DO">español (República Dominicana)</option>
			<option value="es_UY">español (Uruguay)</option>
			<option value="es_VE">español (Venezuela)</option>
			<option value="eu_ES">euskara (Espainia)</option>
			<option value="fil_PH">Filipino (Pilipinas)</option>
			<option value="fr_BE">français (Belgique)</option>
			<option value="fr_CA">français (Canada)</option>
			<option value="fr_FR">français (France)</option>
			<option value="fr_LU">français (Luxembourg)</option>
			<option value="fr_CH">français (Suisse)</option>
			<option value="fo_FO">føroyskt (Føroyar)</option>
			<option value="ga_IE">Gaeilge (Éire)</option>
			<option value="gl_ES">galego (España)</option>
			<option value="hr_HR">hrvatski (Hrvatska)</option>
			<option value="ig_NG">Igbo (Nigeria)</option>
			<option value="zu_ZA">isiZulu (iNingizimu Afrika)</option>
			<option value="it_IT">italiano (Italia)</option>
			<option value="it_CH">italiano (Svizzera)</option>
			<option value="kl_GL">kalaallisut (Kalaallit Nunaat)</option>
			<option value="rw_RW">Kinyarwanda (Rwanda)</option>
			<option value="ky_KG">Kirghiz (Kyrgyzstan)</option>
			<option value="sw_KE">Kiswahili (Kenya)</option>
			<option value="lo_LA">Lao (Laos)</option>
			<option value="lv_LV">latviešu (Latvija)</option>
			<option value="lt_LT">lietuvių (Lietuva)</option>
			<option value="lb_LU">Luxembourgish (Luxembourg)</option>
			<option value="hu_HU">magyar (Magyarország)</option>
			<option value="mt_MT">Malti (Malta)</option>
			<option value="mi_NZ">Maori (New Zealand)</option>
			<option value="mn_MN">Mongolian (Mongolia)</option>
			<option value="nl_BE">Nederlands (België)</option>
			<option value="nl_NL">Nederlands (Nederland)</option>
			<option value="nb_NO">norsk bokmål (Norge)</option>
			<option value="se_NO">Northern Sami (Norway)</option>
			<option value="nso_ZA">Northern Sotho (South Africa)</option>
			<option value="nn_NO">nynorsk (Noreg)</option>
			<option value="oc_FR">Occitan (France)</option>
			<option value="pl_PL">polski (Polska)</option>
			<option value="pt_BR">português (Brasil)</option>
			<option value="pt_PT">português (Portugal)</option>
			<option value="ro_RO">română (România)</option>
			<option value="sa_IN">Sanskrit (India)</option>
			<option value="gd_GB">Scottish Gaelic (United Kingdom)</option>
			<option value="sq_AL">shqipe (Shqipëria)</option>
			<option value="sk_SK">slovenčina (Slovenská republika)</option>
			<option value="sl_SI">slovenščina (Slovenija)</option>
			<option value="fi_FI">suomi (Suomi)</option>
			<option value="sv_FI">svenska (Finland)</option>
			<option value="sv_SE">svenska (Sverige)</option>
			<option value="tt_RU">Tatar (Russia)</option>
			<option value="ur_PK">THIS ONE(اردو (پاکستان)</option>
			<option value="vi_VN">Tiếng Việt (Việt Nam)</option>
			<option value="tn_ZA">Tswana (South Africa)</option>
			<option value="tk_TM">Turkmen (Turkmenistan)</option>
			<option value="tr_TR">Türkçe (Türkiye)</option>
			<option value="ug_CN">Uighur (China)</option>
			<option value="hsb_DE">Upper Sorbian (Germany)</option>
			<option value="fy_NL">Western Frisian (Netherlands)</option>
			<option value="wo_SN">Wolof (Senegal)</option>
			<option value="xh_ZA">Xhosa (South Africa)</option>
			<option value="kok_IN">कोंकणी (भारत)</option>
			<option value="ne_NP">नेपाली (नेपाल)</option>
			<option value="mr_IN">मराठी (भारत)</option>
			<option value="hi_IN">हिन्दी (भारत)</option>
			<option value="as_IN">অসমীয়া (ভাৰত)</option>
			<option value="bn_BD">বাংলা (বাংলাদেশ)</option>
			<option value="bn_IN">বাংলা (ভারত)</option>
			<option value="pa_IN">ਪੰਜਾਬੀ (ਭਾਰਤ)</option>
			<option value="gu_IN">ગુજરાતી (ભારત)</option>
			<option value="or_IN">ଓଡ଼ିଆ (ଭାରତ)</option>
			<option value="ta_IN">தமிழ் (இந்தியா)</option>
			<option value="te_IN">తెలుగు (భారత దేశం)</option>
			<option value="kn_IN">ಕನ್ನಡ (ಭಾರತ)</option>
			<option value="ml_IN">മലയാളം (ഇന്ത്യ)</option>
			<option value="si_LK">සිංහල (ශ්&zwj;රී ලංකාව)</option>
			<option value="th_TH">ไทย (ไทย)</option>
			<option value="bo_CN">པོད་སྐད་ (རྒྱ་ནག)</option>
			<option value="ka_GE">ქართული (საქართველო)</option>
			<option value="am_ET">አማርኛ (ኢትዮጵያ)</option>
			<option value="km_KH">ភាសាខ្មែរ (កម្ពុជា)</option>
			<option value="yo_NG">Èdè Yorùbá (Orílẹ́ède Nàìjíríà)</option>
			<option value="is_IS">íslenska (Ísland)</option>
			<option value="cs_CZ">čeština (Česká republika)</option>
			<option value="zh_HK">中文 (中華人民共和國香港特別行政區)</option>
			<option value="zh_TW">中文 (台灣)</option>
			<option value="zh_CN">中文（中国）</option>
			<option value="zh_SG">中文（新加坡）</option>
			<option value="ja_JP">日本語(日本)</option>
			<option value="ko_KR">한국어(대한민국)</option>
			<option value="el_GR">Ελληνικά (Ελλάδα)</option>
			<option value="be_BY">Беларуская (Беларусь)</option>
			<option value="bg_BG">Български (България)</option>
			<option value="mk_MK">Македонски (Македонија)</option>
			<option value="ru_RU">Русский (Россия)</option>
			<option value="uk_UA">Українська (Україна)</option>
			<option value="kk_KZ">Қазақ (Қазақстан)</option>
			<option value="hy_AM">Հայերէն (Հայաստանի Հանրապետութիւն)</option>
			<option value="x" data-control="toggle" data-toggles="locale_custom">- My locale is not listed -</option>
</select>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->

              </form></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" name="edit<?php echo $row['lang_short'];?>" class="btn btn-primary">Save</button>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>

											</div>
	<?php endforeach;?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>


        </section>

</div>

<?php
}
		require('footer.php');
?>
