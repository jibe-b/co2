<?php 
    //header + menu
    $layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
    $this->renderPartial('../app/info/terla/infocommon', 
            array( "title"=> "FAQ : Foire aux questions", "layoutPath" => $layoutPath ));
?>

<style type="text/css">
</style>

<section class="padding-top-70">
    <div class="container main-apropos padding-top-15 padding-bottom-50">
	    Hello FAQ
    </div>
</section>

<?php $this->renderPartial($layoutPath.'footer',  array( "subdomain"=>"info" ) ); ?>
