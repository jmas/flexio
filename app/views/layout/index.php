<div class="page-header">
    <h3>Layouts</h3>
</div>

<p>
    <a href="<?php echo Flexio::app()->createUrl(array('controller'=>'layout', 'action'=>'add')); ?>" class="btn btn-primary">Create new layout</a>
</p>

<div class="list-group">
<?php foreach ($this->layouts as $layout): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-1 text-center"><?php echo str_replace('.php', '', str_replace(LAYOUTS_PATH . DIRECTORY_SEPARATOR, '', $layout)); ?></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
            <div class="col-md-2 text-center"><a href="" type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></div>
        </div>
    </div>
<?php endforeach; ?>
</div>