<?php
	$cssAnsScriptFilesModule = array(
		//Data helper
		'/js/dataHelpers.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
	$cssAnsScriptFilesTheme = array(
		// SHOWDOWN
		'/plugins/showdown/showdown.min.js',
		//MARKDOWN
		'/plugins/to-markdown/to-markdown.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);
?>
<style type="text/css">
	.valueAbout{
		border-left: inherit;
	}
	#shortDescriptionAbout{
		white-space: pre-line;
	}

	/*#descriptionAbout{
		padding-left : 10px;
	}*/

	.contentInformation{
		border-bottom: 1px solid #dbdbdb;
	}
	#ficheInfo{
		border:inherit !important;
	}
	.labelAbout span{
		width: 20px;
		padding-right: 5px;
		text-align: -moz-center;
		text-align: center;
		text-align: -webkit-center;
		float: left;
	}
	.labelAbout span i{
		font-size: 14px;
	}
	.panel-title{
		line-height:35px;
	}

	.md-preview{
		text-align:left;
		padding: 0px 10px;
	}

	.md-editor > textarea {
		padding: 10px;
	}

	.descriptiontextarea label{
		margin-left:10px;
	}


	@media (min-width: 1200px) {
		.no-ing{
			padding-left: 15px !important;
		}
	}
</style>

<div class='col-md-12 col-sm-12 margin-bottom-15 panel-heading'>
	<h4 class='panel-title text-dark pull-left' id='name-lbl-title'><i class="fa fa-info-circle fa-2x"></i> <?php echo Yii::t("common","My informations") ?></h4>
	<?php if($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ){?>
			<button class="btn-update-info btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Update general information") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		<?php } ?>
</div>
<div id="ficheInfo" class="panel panel-white col-lg-7 col-md-7 col-sm-7 no-padding">
	<div class="panel-body no-padding">
		<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
			<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
				<span><i class="fa fa-pencil"></i></span> <?php echo Yii::t("common", "Name") ?>
			</div>
			<div id="nameAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
				<span class="visible-xs pull-left margin-right-5"><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Name") ?> :</span> <?php echo $element["name"]; ?>
			</div>
		</div>


		<?php if( (	$type==Person::COLLECTION && 
				Preference::showPreference($element, $type, "email", Yii::app()->session["userId"]) ) || 
		  	$type == Organization::COLLECTION ) { ?>
		  	<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-envelope"></i></span> <?php echo Yii::t("common","E-mail"); ?>
				</div>
				<div id="emailAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-envelope"></i> <?php echo Yii::t("common","E-mail"); ?> :</span><?php echo (@$element["email"]) ? $element["email"]  : '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>
		<?php } ?>

		<?php if( $type==Service::COLLECTION ) { ?>
		  	<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-envelope"></i></span> <?php echo Yii::t("common","Price"); ?>
				</div>
				<div id="priceAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-envelope"></i> <?php echo Yii::t("common","Price"); ?> :</span><?php echo (@$element["price"]) ? $element["price"]  : '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>


			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-envelope"></i></span> <?php echo Yii::t("common","Open"); ?>
				</div>
				<div id="priceAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-envelope"></i> <?php echo Yii::t("common","Price"); ?> :</span>
					
					<span id="openingHours"></span>
				</div>
			</div>


		<?php } ?>


		<?php if($type==Person::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-desktop"></i></span> <?php echo Yii::t("common","Website URL"); ?>
				</div>
				<div id="webAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-desktop"></i> <?php echo Yii::t("common","Website URL"); ?> :</span>
				<?php 
					if(@$element["url"]){
						//If there is no http:// in the url
						$scheme = ( (!preg_match("~^(?:f|ht)tps?://~i", $element["url"]) ) ? 'http://' : "" ) ;
					 	echo '<a href="'.$scheme.$element['url'].'" target="_blank" id="urlWebAbout" style="cursor:pointer;">'.$element["url"].'</a>';
					}else
						echo '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>
		<?php } ?>

		<?php  if($type==Person::COLLECTION){ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-phone"></i></span> <?php echo Yii::t("common","Phone"); ?>
				</div>
				<div id="fixeAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5"><i class="fa fa-phone"></i> <?php echo Yii::t("common","Phone"); ?> :</span><?php
						$fixe = '<i>'.Yii::t("common","Not specified").'</i>';
						if( !empty($element["telephone"]["fixe"]))
							$fixe = ArrayHelper::arrayToString($element["telephone"]["fixe"]);
						
						echo $fixe;
					?>	
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-mobile"></i></span> <?php echo Yii::t("common","Mobile"); ?>
				</div>
				<div id="mobileAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5">
						<i class="fa fa-mobile"></i> <?php echo Yii::t("common","Mobile"); ?> :
					</span>
					<?php
						$mobile = '<i>'.Yii::t("common","Not specified").'</i>';
						if( !empty($element["telephone"]["mobile"]))
							$mobile = ArrayHelper::arrayToString($element["telephone"]["mobile"]);	
						echo $mobile;
					?>	
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
				<div class="col-md-4 col-sm-4 col-xs-4 hidden-xs labelAbout padding-10">
					<span><i class="fa fa-fax"></i></span> <?php echo Yii::t("common","Fax"); ?>
				</div>
				<div id="faxAbout" class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10">
					<span class="visible-xs pull-left margin-right-5">
						<i class="fa fa-fax"></i> <?php echo Yii::t("common","Fax"); ?> :
					</span>
					<?php
						$fax = '<i>'.Yii::t("common","Not specified").'</i>';
						if( !empty($element["telephone"]["fax"]) )
							$fax = ArrayHelper::arrayToString($element["telephone"]["fax"]);		
						echo $fax;
					?>
				</div>
			</div>
		<?php } ?>
	</div>
	
</div>
<div class="col-sm-5 col-md-5 center margin-top-20">
<?php 	if(@$element["profilMediumImageUrl"] && !empty($element["profilMediumImageUrl"]))
					 $images=array(
					 	"medium"=>$element["profilMediumImageUrl"],
					 	"large"=>$element["profilImageUrl"]
					 );
				else $images="";	
				
				$this->renderPartial('../pod/fileupload', 
								array("itemId" => (string) $element["_id"],
									  "itemName" => $element["name"],
									  "type" => $type,
									  "resize" => false,
									  "contentId" => Document::IMG_PROFIL,
									  "show" => true,
									  "editMode" => $edit,
									  "image" => $images,
									  "openEdition" => false) ); 
		?>
</div>
<?php if($type!=Person::COLLECTION){ ?>
<div id="mediaAbout" class="panel panel-white col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding contentInformation">
	<div class="panel-heading border-light col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #dee2e680;">
		<h4 class="panel-title text-dark pull-left">
			<i class="fa fa-image"></i> <?php echo Yii::t("common","Medias") ?>
		</h4>
		<?php if($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ){?>
		  	<button class="btn-update-medias btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Update medias") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		 <?php } ?>
	</div>
	<?php $images=Document::getListDocumentsWhere(array("id"=>(string)$element["_id"],"type"=>$type,"doctype"=>Document::DOC_TYPE_IMAGE),Document::DOC_TYPE_IMAGE);
	$this->renderPartial('../pod/sliderMedia', 
		array(
			  "medias"=>@$element["medias"],
			  "images" => @$images,
			  "onlyItem"=>true
		) ); 
	?>

</div>
<?php } ?>
<div id="adressesAbout" class="panel panel-white col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding contentInformation">
		<div class="panel-heading border-light padding-15" style="background-color: #dee2e680;">
			<h4 class="panel-title text-dark"> 
				<i class="fa fa-map-marker"></i> <?php echo Yii::t("common","Localitie(s)"); ?>
			</h4>
		</div>
		<div class="panel-body no-padding">		

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-home"></i></span> <?php echo Yii::t("common", "Main locality") ?>
				<?php if (!empty($element["address"]["codeInsee"]) && ( $edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ) ) { 
					echo '<a href="javascript:;" id="btn-remove-geopos" class="pull-right tooltips" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Remove Locality").'">
								<i class="fa text-red fa-trash-o"></i>
							</a> 
							<a href="javascript:;" class="btn-update-geopos pull-right tooltips margin-right-15" data-toggle="tooltip" data-placement="bottom" title="'.Yii::t("common","Update Locality").'" >
								<i class="fa text-red fa-map-marker"></i>
							</a> ';	
				} ?>
			</div>
			<div class="col-md-12 col-xs-12 valueAbout no-padding" style="padding-left: 25px !important">
			<?php 
				if( ($type == Person::COLLECTION && Preference::showPreference($element, $type, "locality", Yii::app()->session["userId"])) ||  $type!=Person::COLLECTION) {
					$address = "";
					$address .= '<span id="detailAddress"> '.
									(( @$element["address"]["streetAddress"]) ? 
										$element["address"]["streetAddress"]."<br/>": 
										((@$element["address"]["codeInsee"])?"":Yii::t("common","Unknown Locality")));
					$address .= (( @$element["address"]["postalCode"]) ?
									 $element["address"]["postalCode"].", " :
									 "")
									." ".(( @$element["address"]["addressLocality"]) ? 
											 $element["address"]["addressLocality"] : "") ;
					$address .= (( @$element["address"]["addressCountry"]) ?
									 ", ".OpenData::$phCountries[ $element["address"]["addressCountry"] ] 
					 				: "").
					 			'</span>';
					echo $address;
					if( empty($element["address"]["codeInsee"]) && Yii::app()->session["userId"] == (String) $element["_id"]) {
						echo '<br><a href="javascript:;" class="cobtn btn btn-danger btn-sm" style="margin: 10px 0px;">'.
								Yii::t("common", "Connect to your city").'</a> <a href="javascript:;" class="whycobtn btn btn-default btn-sm explainLink" style="margin: 10px 0px;" data-id="explainCommunectMe">'. 
								Yii::t("common", "Why ?").'</a>';
					}
			}else
				echo '<i>'.Yii::t("common","Not specified").'</i>';
			?>
			</div>
		</div>
		<?php if( !empty($element["addresses"]) ){ ?>
			<div class="col-md-12 col-xs-12 labelAbout padding-10">
				<span><i class="fa fa-map"></i></span> <?php echo Yii::t("common", "Others localities") ?>
			</div>
			<div class="col-md-12 col-xs-12 valueAbout no-padding" style="padding-left: 25px !important">
			<?php	foreach ($element["addresses"] as $ix => $p) { ?>			
				<span id="addresses_<?php echo $ix ; ?>">
					<span>
					<?php 
					$address = '<span id="detailAddress_'.$ix.'"> '.
									(( @$p["address"]["streetAddress"]) ? 
										$p["address"]["streetAddress"]."<br/>": 
										((@$p["address"]["codeInsee"])?"":Yii::t("common","Unknown Locality")));
					$address .= (( @$p["address"]["postalCode"]) ?
									 $p["address"]["postalCode"].", " :
									 "")
									." ".(( @$p["address"]["addressLocality"]) ? 
											 $p["address"]["addressLocality"] : "") ;
					$address .= (( @$p["address"]["addressCountry"]) ?
									 ", ".OpenData::$phCountries[ $p["address"]["addressCountry"] ] 
					 				: "").
					 			'</span>';
					echo $address;
					?>

					<?php if( $edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ) { ?>
						<a href='javascript:removeAddresses("<?php echo $ix ; ?>");'  class="addresses pull-right tooltips margin-right-15" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Remove Locality");?>"><i class="fa text-red fa-trash-o"></i></a>
						<a href='javascript:updateLocalityEntities("<?php echo $ix ; ?>", <?php echo json_encode($p);?>);' class=" pull-right pull-right tooltips margin-right-15" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t("common","Update Locality");?>"><i class="fa text-red fa-map-marker addresses"></i></a></span>
					<?php } ?>
				</span>
				<hr/>
			<?php 	} ?>
			</div>
		<?php } ?>
		<div class="text-right padding-10">
			<?php if(empty($element["address"]) && $type!=Person::COLLECTION && ($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) )){ ?>
				<b><a href="javascript:;" class="btn btn-default letter-blue margin-top-5 addresses btn-update-geopos">
					<i class="fa fa-map-marker"></i>
					<span class="hidden-sm"><?php echo Yii::t("common","Add a primary address") ; ?></span>
				</a></b>
			<?php	}
			if($type!=Person::COLLECTION && !empty($element["address"]) && ($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) )) { ?>
				<b><a href='javascript:updateLocalityEntities("<?php echo count(@$element["addresses"]) ; ?>");' id="btn-add-geopos" class="btn btn-default letter-blue margin-top-5 addresses" style="margin: 10px 0px;">
					<i class="fa fa-plus" style="margin:0px !important;"></i> 
					<span class="hidden-sm"><?php echo Yii::t("common","Add an address"); ?></span>
				</a></b>
			<?php } ?>						
		</div>
	</div>
<div id="ficheInfo" class="panel panel-white col-lg-12 col-md-12 col-sm-12 no-padding contentInformation">
	
	<div class="panel-heading border-light col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: #dee2e680;">
		<h4 class="panel-title text-dark pull-left">
			<i class="fa fa-paraph"></i> <?php echo Yii::t("common","Description") ?>
		</h4>
		<?php if($edit==true || ( $openEdition==true && Yii::app()->session["userId"] != null ) ){?>
		  	<button class="btn-update-descriptions btn btn-default letter-blue pull-right tooltips" 
				data-toggle="tooltip" data-placement="top" title="" alt="" data-original-title="<?php echo Yii::t("common","Update description") ?>">
				<b><i class="fa fa-pencil"></i> <?php echo Yii::t("common", "Edit") ?></b>
			</button>
		 <?php } ?>
	</div>
	<div class="panel-body no-padding">
		<div class="col-md-12 col-sm-12 col-xs-12 contentInformation no-padding">
			<div class="col-md-8 col-sm-8 col-xs-12 valueAbout padding-10" 
					style="word-wrap: break-word; overflow:hidden;">
				<span id="descriptionMarkdown" name="descriptionMarkdown"  class="hidden" ><?php echo (!empty($element["description"])) ? $element["description"] : ""; ?></span>
				<div id="descriptionAbout"><?php echo (@$element["description"]) ? $element["description"] : '<i>'.Yii::t("common","Not specified").'</i>'; ?>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
<?php	$cssAnsScriptFilesModule = array(
		'/js/default/profilSocial.js',
	);
	HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, $this->module->assetsUrl);
?>

<script type="text/javascript">

	var formatDateView = "DD MMMM YYYY à HH:mm" ;
	var formatDatedynForm = "DD/MM/YYYY HH:mm" ;

	jQuery(document).ready(function() {
		bindDynFormEditableTerla();
		initDate();
		initDescs();
		initOpeningHours();
		//changeHiddenFields();
		//bindAboutPodElement();

		$("#small_profil").html($("#menu-name").html());
		$("#menu-name").html("");

		$(".cobtn").click(function () {
			communecterUser();				
		});

		$(".btn-update-geopos").click(function(){
			updateLocalityEntities();
		});

		$("#btn-add-geopos").click(function(){
			updateLocalityEntities();
		});

		$("#btn-update-organizer").click(function(){
			updateOrganizer();
		});
		$("#btn-add-organizer").click(function(){
			updateOrganizer();
		});

		$("#btn-remove-geopos").click(function(){
			removeAddress();	
		});

		$("#btn-update-geopos-admin").click(function(){
			findGeoPosByAddress();
		});

		//console.log("contextDatacontextData", contextData, contextData.type,contextData.id);
		//buildQRCode(contextData.type,contextData.id.$id);		
		
	});

	function initDate() {//DD/mm/YYYY hh:mm
		//moment.locale('fr');
		if( (typeof contextData.allDay != "undefined" && contextData.allDay == true) || contextData.type == "<?php //echo Project::COLLECTION; ?>" ) {
			formatDateView = "DD MMMM YYYY" ;
			formatDatedynForm = "DD/MM/YYYY" ;
		}else{
			formatDateView = "DD MMMM YYYY à HH:mm" ;
			formatDatedynForm = "DD/MM/YYYY HH:mm" ;
		}

		if( typeof contextData.startDate != "undefined" && contextData.startDate != "" ){
			$("#divStartDate").removeClass("hidden");
			$("#divNoDate").addClass("hidden");
		}
		else{
			$("#divStartDate").addClass("hidden");
			$("#divNoDate").removeClass("hidden");
		}

		if( typeof contextData.endDate != "undefined" && contextData.endDate != "" )
			$("#divEndDate").removeClass("hidden");
		else
			$("#divEndDate").addClass("hidden");
		mylog.log("formatDateView", formatDateView);
		if($("#startDateAbout").html() != "")
	    	$("#startDateAbout").html(moment(contextData.startDateDB).local().locale(mainLanguage).format(formatDateView));
	    if($("#endDateAbout").html() != "")
	    	$("#endDateAbout").html(moment( contextData.endDateDB).local().locale(mainLanguage).format(formatDateView));

	    if($("#birthDate").html() != "")
	    	$("#birthDate").html(moment($("#birthDate").html()).local().locale(mainLanguage).format("DD/MM/YYYY"));
	    $('#dateTimezone').attr('data-original-title', "Fuseau horaire : GMT " + moment().local().format("Z"));
	}


	function initDescs() {
		mylog.log("initDescs");
		if(edit == true || openEdition== true)
			descHtmlToMarkdown();
		mylog.log("after");
		mylog.log("initDescs", $("#descriptionMarkdown").html());
		var descHtml = "<i>"+trad.notSpecified+"</i>";
		if($("#descriptionMarkdown").html().length > 0){
			descHtml = dataHelper.markdownToHtml($("#descriptionMarkdown").html()) ;
		}
		
		$("#descriptionAbout").html(descHtml);
		$("#descProfilsocial").html(descHtml);
		mylog.log("descHtml", descHtml);
	}

	function initOpeningHours() {
		mylog.log("initOpeningHours");
		var html = "" ;
		mylog.log("initOpeningHours contextData.openingHours", contextData.openingHours);
		if(notNull(contextData.openingHours) ){

			$.each(contextData.openingHours, function(i,data){
				mylog.log("initOpeningHours data", data, data.allDay, notNull(data));
				mylog.log("initOpeningHours notNull data", notNull(data), typeof data, data.length);
				if( (typeof data == "object" && notNull(data) ) || (typeof data == "string" && data.length > 0) ) {
					var day = "" ;
					if(data.allDay == "true"){
						day = moment().day(i).local().locale(mainLanguage).format("dddd")+" : "+trad.allDay+"<br/>";
					}else {
						mylog.log("initOpeningHours data.hours", data.hours);
						day = moment().day(i).local().locale(mainLanguage).format("dddd")+" : <br/>";
						day += "<ul>";
						$.each(data.hours, function(i,hours){
							mylog.log("initOpeningHours hours", hours);
							day += "<li>"+hours.opens+" : "+hours.closes+"</li>";
						});
						day += "</ul>";
					}

					if( moment().format("dd") == data.dayOfWeek )
						html += "<b>"+day+"</b>";
					else
						html += day;
				}
				
			});

		} else 
			html = '<i>'+trad.notSpecified+'</i>'; 

		$("#openingHours").html(html);
	}

	

</script>