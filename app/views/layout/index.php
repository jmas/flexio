<div class="page-header">
    <h3>Layouts</h3>
</div>

<p>
    <a href="<?php echo $this->controller->createUrl(array('add')); ?>" class="btn btn-primary">Create layout</a>
</p>

<?php if (count($this->models) > 0): ?>
<div class="list-group">
    <div class="list-group-item list-group-item-info">
        <div class="row">
            <div class="col-md-4">Name</div>
            <div class="col-md-3">Created</div>
            <div class="col-md-3">Updated</div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <?php foreach ($this->models as $model): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-4"><b><a href="<?php echo $this->controller->createUrl(array('edit', 'id'=>$model->id)); ?>"><?php echo htmlspecialchars($model->name); ?></a></b></div>
            <div class="col-md-3"><img src="<?php echo $model->createdBy->getGravatarUrl(); ?>" alt="" class="img-rounded" /> <a href="<?php echo $this->app->createUrl(array('user', 'edit', 'id'=>$model->create_user_id)); ?>"><?php echo htmlspecialchars($model->createdBy->name); ?></a> <?php echo htmlspecialchars($model->create_date); ?></div>
            <div class="col-md-3"><img src="<?php echo $model->updatedBy->getGravatarUrl(); ?>" alt="" class="img-rounded" /> <a href="<?php echo $this->app->createUrl(array('user', 'edit', 'id'=>$model->update_user_id)); ?>"><?php echo htmlspecialchars($model->updatedBy->name); ?></a> <?php echo htmlspecialchars($model->update_date); ?></div>
            <div class="col-md-2 text-center"><a href="<?php echo $this->controller->createUrl(array('delete', 'id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">Delete</a></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p class="text-muted">The list is empty.</p>
<?php endif; ?>