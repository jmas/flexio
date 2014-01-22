<div class="page-header">
    <h3>Layout add</h3>
</div>
<form role="form" method="post" autocomplete="off" parsley-validate novalidate>
<?php $file = file_get_contents('index.php'); ?>
    <div class="form-group col-md-3" style="line-height:34px">
        <input type="text" class="form-control" name="data[name]" placeholder="Template name..." required >
    </div>
    <div class="form-group col-md-12" style="line-height:34px">  
    <textarea class="form-control" name="editor" data-editor="php" style="height:0;padding:0;"><?php print($file); ?></textarea>
    </div>
    <div class="form-group col-md-2" style="line-height:34px">
        <button type="submit" class="btn btn-primary">Save</button> or <a href="<?php echo Flexio::app()->createUrl(array('controller'=>'user', 'action'=>'index')); ?>">Cancel</a>
    </div>
</form>
<?php //var_dump($_POST) ?>
