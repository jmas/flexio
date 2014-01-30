<div class="page-header">
    <h3>Layouts</h3>
</div>

<p>
    <a href="<?php echo $this->app->createUrl(array('layout', 'add')); ?>" class="btn btn-primary">Create new layout</a>
</p>

<div class="list-group">
    <div class="list-group-item list-group-item-info">
        <div class="row">
            <div class="col-md-2">Layout name</div>
            <div class="col-md-2">Create date</div>
            <div class="col-md-2">Last update</div>
            <div class="col-md-2">Created by</div>
            <div class="col-md-2">Updated by</div>
            <div class="col-md-2"></div>
        </div>
    </div>
<?php foreach ($this->models as $model): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-2"><b><a href="<?php echo $this->app->createUrl(array('layout', 'edit', 'id'=>$model->id)); ?>"><?php echo $model->name; ?></a></b></div>
            <div class="col-md-2"><?php echo $model->create_date; ?></div>
            <div class="col-md-2"><?php echo $model->update_date; ?></div>
            <div class="col-md-2"><img src="<?php echo $model->createdBy->getGravatarUrl(); ?>" alt="" class="img-rounded" /> <a href="<?php echo $this->app->createUrl(array('user', 'edit', 'id'=>$model->create_user_id)); ?>"><?php echo $model->createdBy->name; ?></a></div>
            <div class="col-md-2"><img src="<?php echo $model->updatedBy->getGravatarUrl(); ?>" alt="" class="img-rounded" /> <a href="<?php echo $this->app->createUrl(array('user', 'edit', 'id'=>$model->update_user_id)); ?>"><?php echo $model->updatedBy->name; ?></a></div>
            <div class="col-md-2 text-center"><a href="<?php echo $this->app->createUrl(array('layout', 'delete', 'id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">Delete</a></div>
        </div>
    </div>
<?php endforeach; ?>
</div>