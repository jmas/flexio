<div class="page-header">
    <h3><?php echo ($this->model->isNew() ? 'Create snippet' : 'Edit snippet'); ?></h3>
</div>

<?php if ($this->model->haveErrors()): ?>
    <div class="alert alert-danger">
        <?php echo $this->model->getErrorsFormatted(); ?>
    </div>
<?php endif; ?>

<form role="form" method="post" autocomplete="off" parsley-validate novalidate>
    <div class="col-md-9">
        <div class="form-group" style="line-height:34px"> 
            <textarea class="form-control" name="data[content]" data-editor="php" style="height:0;padding:0;" required parsley-error-message="Add some content"><?php echo $this->model->content; ?></textarea>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group" style="line-height:34px">
            <label for="data[name]">Name</label>
            <input type="text" class="form-control" name="data[name]" placeholder="" required parsley-error-message="Add name for snippet" value="<?php echo htmlspecialchars($this->model->name); ?>">
        </div>
        <div class="form-group" style="line-height:34px">
            <input type="submit" class="btn btn-primary" value="<?php echo ($this->model->isNew() ? 'Create': 'Save'); ?>" /> or <a href="<?php echo $this->app->createUrl(array('snippet', 'index')); ?>">Cancel</a>
        </div>
    </div>
</form>