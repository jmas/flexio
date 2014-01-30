<div class="page-header">
    <h3>Layouts</h3>
</div>

<p>
    <a href="<?php echo $this->app->createUrl(array('layout', 'add')); ?>" class="btn btn-primary">Create new layout</a>
</p>

<div class="list-group">
<?php foreach ($this->models as $model): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-2 text-center"><a href="<?php echo $this->app->createUrl(array('layout', 'edit', 'id'=>$model->id)); ?>"><?php echo $model->name; ?></a></div>
            <div class="col-md-2">Created: <?php echo $model->create_date; ?></div>
            <div class="col-md-2">Last update: <?php echo $model->update_date; ?></div>
            <div class="col-md-2">Created by: <a href="<?php echo $this->app->createUrl(array('user', 'edit', 'id'=>$model->create_user_id)); ?>"><?php echo $model->createdBy->name; ?></a></div>
            <div class="col-md-2">Updated by: <a href="<?php echo $this->app->createUrl(array('user', 'edit', 'id'=>$model->create_user_id)); ?>"><?php echo $model->updatedBy->name; ?></a></div>
            <div class="col-md-2 text-center"><a href="<?php echo $this->app->createUrl(array('layout', 'delete', 'id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></div>
        </div>
    </div>
<?php endforeach; ?>
</div>