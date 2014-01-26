<div class="container">

    <div class="page-header">
        <h2>Users</h2>
    </div>

    <p>
        <a href="<?php echo Flexio::app()->createUrl(array('user','add')); ?>" class="btn btn-primary">Add new user</a>
    </p>

    <div class="list-group">
        <?php foreach ($this->models as $model): ?>
            <div class="list-group-item">
                <div class="row" style="line-height:40px;">
                    <div class="col-md-4">
                        <img src="<?php echo $model->getGravatarUrl(); ?>" alt="" class="img-rounded" />
                        <b><a href="<?php echo Flexio::app()->createUrl(array('user','edit','id'=>$model->id)); ?>"><?php echo htmlspecialchars($model->name); ?></a></b>
                        <?php echo htmlspecialchars($model->username); ?>
                    </div>

                    <div class="col-md-3">
                        <?php echo htmlspecialchars(implode(', ', $model->getPermissions())); ?>
                    </div>

                    <div class="col-md-4">
                       <?php echo htmlspecialchars($model->email); ?>
                    </div>

                    <div class="col-md-1">
                        <a href="<?php echo Flexio::app()->createUrl(array('user','delete','id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

<?php /*
  <div class="list-group">
    <?php foreach ($this->models as $model): ?>
    <div class="list-group-item">
      <div class="row" style="line-height: 40px;">
      <div class="col-md-1 text-center">
        <img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($model->email)))?>?s=40&d=mm&r=g" alt="" class="img-circle"></div>
      <div class="col-md-3">
      <a href="<?php echo Flexio::app()->createUrl(array('controller'=>'user', 'action'=>'edit', 'id'=>$model->id)); ?>"><b><?php echo $model->name; ?></b></a> <em><?php echo $model->username; ?></em></div>
      <div class="col-md-3"><?php echo $model->email; ?></div>
      <div class="col-md-3"><?php echo implode(', ', $model->getPermissions()); ?></div>
      <div class="col-md-2 text-center"><a href="<?php echo Flexio::app()->createUrl(array('controller'=>'user', 'action'=>'delete', 'id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></div>
      </div>*/ ?>

    </div>
</div> <!-- /container -->