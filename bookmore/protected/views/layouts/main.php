<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mygridview.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mydetailview.css" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <div class="header-container" id="header">
        <div class="container">
            <div class="span-6" id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
            <div class="span-17" id="menu">
                <div class="span-5" id="mainmenu">
                    <span id="menuheader"><?php echo Yii::t('bm','Information'); ?></span>
                    <?php $this->widget('zii.widgets.CMenu',array(
                    'items'=>array(
                        array('label'=>'Home', 'url'=>array('/site/index')),
                        array('label'=>Yii::t('bm', 'About'), 'url'=>array('/site/page', 'view'=>'about'))
                    ),
                    )); ?>
                </div><!-- menu block -->

                <div class="span-5" id="mainmenu">
                    <span id="menuheader"><?php echo Yii::t('bm','Bookmarks'); ?></span>
                    <?php $this->widget('zii.widgets.CMenu',array(
                    'items'=>array(
                        array('label'=>Yii::t('bm', 'Bookmarks'), 'url'=>array('/resource/index')),
                        array('label'=>Yii::t('bm', 'Webs'), 'url'=>array('/web/index')),
                        array('label'=>Yii::t('bm', 'Documents'), 'url'=>array('/document/index')),
                        array('label'=>Yii::t('bm', 'HowTo'), 'url'=>array('/myHowTo/index')),
                    ),
                    )); ?>
                </div><!-- menu block -->

                <div class="span-5 last" id="mainmenu">
                    <span id="menuheader"><?php echo Yii::t('bm','Connect'); ?></span>
                    <?php $this->widget('zii.widgets.CMenu',array(
                    'items'=>array(
                        array('label'=>Yii::t('bm', 'Contact'), 'url'=>array('/site/contact')),
                        array('label'=>Yii::t('bm', 'Register'), 'url'=>array('/user/create'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>Yii::t('bm', 'Your profile').' ('.Yii::app()->user->name.')', 'url'=>array('/user/'.Yii::app()->user->id), 'visible'=>!Yii::app()->user->isGuest),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>Yii::t('bm', 'Logout'), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                    ),
                    )); ?>
                </div><!-- menu block -->

                <div class="span-17" id="menusearch">
                  <form id="search-form" action="<?php echo Yii::app()->urlManager->createUrl('resource/search'); ?>" method="post">
                    <input class="searchtext" type="text" id="searchtext" name="searchtext" size="75" value="<?php echo Yii::t('bm', 'Search for a resource'); ?>" />
                  </form>
                </div><!-- search block -->
            </div><!-- menu -->
        </div><!-- container -->
        <div id="menu">&nbsp;</div>
    </div><!-- header -->

    <div class="container" id="page">
        <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
        <?php endif?>

        <?php echo $content; ?>

        <div class="clear"></div>
    </div><!-- page -->

    <div class="header-container" id="footer">
        <div id="menu">&nbsp;</div>
        <?php echo CHtml::encode (Yii::app () -> name); ?> by Román Ginés Martínez Ferrández
        &copy; <?php echo date('Y'); ?> is licensed under
        <a href="http://www.gnu.org/licenses/gpl-3.0.html">GPLv3</a>.<br/>
        <?php echo Yii::powered(); ?>
    </div><!-- footer -->

    <!-- This script manages the search input text -->
    <?php Yii::app()->clientScript->registerCoreScript('jquery');  ?>
    <script type="text/javascript">
        var typed = 0;
        var str;
        $(document).ready(function(){
            str = $("#searchtext").val();
            $("#searchtext").focusout(function(){
                text = $(this).val().replace(/^\s+|\s+$/g, '');
                if (text) {
                    $(this).val(text);
                    typed = 1;
                }
                else {
                    $(this).val(str);
                    typed = 0;
                }
            });
            $("#searchtext").focusin(function(){
                if (!typed)
                    $(this).val('');
            });
        })
    </script>
</body>
</html>
