<div class="page-header">
    <h3>Layout add</h3>
</div>
<form role="form" method="post" autocomplete="off" parsley-validate novalidate>
    <div class="form-group col-md-3" style="line-height:34px">
        <input type="text" class="form-control" name="data[name]" placeholder="Template name..." required parsley-error-message="Add name for layout" value="<?php echo $this->name; ?>">
    </div>
    <div class="form-group col-md-12" style="line-height:34px">  
        <textarea class="form-control" name="data[content]" data-editor="php" style="height:0;padding:0;" required parsley-error-message="Add some content"><?php echo $this->content; ?></textarea>
    </div>
    <div class="form-group col-md-2" style="line-height:34px">
        <button type="submit" class="btn btn-primary">Save</button> or <a href="<?php echo Flexio::app()->createUrl(array('controller'=>'layout', 'action'=>'index')); ?>">Cancel</a>
    </div>
</form>