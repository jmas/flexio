<div class="page-header">
    <h3>Users</h3>
</div>

<p>
    <a href="<?php echo $this->app->createUrl(array('user','add')); ?>" class="btn btn-primary">Create user</a>
</p>

<?php if (count($this->models) > 0): ?>
<div class="list-group">
    <div class="list-group-item list-group-item-info">
        <div class="row">
            <div class="col-md-4">Name / Username</div>
            <div class="col-md-3">Permissions</div>
            <div class="col-md-4">E-mail</div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <?php foreach ($this->models as $model): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $model->getGravatarUrl(); ?>" alt="" class="img-rounded" />
                <b><a href="<?php echo $this->app->createUrl(array('user','edit','id'=>$model->id)); ?>"><?php echo htmlspecialchars($model->name); ?></a> </b>
                <?php echo htmlspecialchars($model->username); ?>
            </div>
            <div class="col-md-3">
                <?php echo htmlspecialchars(implode(', ', $model->getPermissions())); ?>
            </div>
            <div class="col-md-4">
               <?php echo htmlspecialchars($model->email); ?>
            </div>
            <div class="col-md-1">
                <a href="<?php echo $this->app->createUrl(array('user','delete','id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?');">Delete</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p class="text-muted">The list is empty.</p>
<?php endif; ?>
