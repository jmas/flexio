<div class="page-header">
    <h3><?php echo $this->model->isNew() ? 'Create layout' : 'Edit layout'; ?></h3>
</div>
<form role="form" method="post" autocomplete="off" parsley-validate novalidate>
    <div class="col-md-9">
        <div class="form-group" style="line-height:34px"> 
            <textarea class="form-control" name="data[content_html]" data-editor="php" style="height:0;padding:0;" required parsley-error-message="Add some content"><?php echo $this->model->content_html; ?></textarea>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group" style="line-height:34px">
            <label for="data[name]">Layout name</label>
            <input type="text" class="form-control" name="data[name]" placeholder="" required parsley-error-message="Add name for layout" value="<?php echo $this->model->name; ?>">
        </div>
        <div class="form-group" style="line-height:34px">
            <button type="submit" class="btn btn-primary">Save</button> or <a href="<?php echo $this->app->createUrl(array('layout', 'index')); ?>">Cancel</a>
        </div>
    </div>
</form>