<?php $this->pageTitle=Yii::app()->name; ?>

<h1><?php echo Yii::t('bm', 'Welcome to'); ?> <i> <?php echo CHtml::encode(Yii::app()->name); ?></i>.</h1>

<p><?php echo Yii::t('bm', 'This web application is a bookmark with more options'); ?>.</p>

<?php
if (!Yii::app()->user->isGuest) {
?>
<div class="container">

    <div class="span-11 right-separator">
        <?php
        if ($dpArticle!=null) {
            $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dpArticle,
                'itemView'=>'//web/_view',
                'itemsCssClass'=>'grid-container',
                'emptyText'=>Yii::t('bm', 'There are not articles to read').'.',
            ));
        }
        else {
            echo Yii::t('bm', 'There are not articles to read').'.';
        }
        ?>
    </div>
    
    <div class="span-11 last">
        <?php
        if ($dpQueue!=null) {
            $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dpQueue,
                'itemView'=>'//resource/_view',
                'itemsCssClass'=>'grid-container',
                'emptyText'=>Yii::t('bm', 'There are not resources queued').'.',
            ));
        }
        else {
            echo Yii::t('bm', 'There are not resources queued').'.';
        }
        ?>
    </div>
    
</div>
<?php
}
?>