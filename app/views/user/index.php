<div class="container">

  <div class="page-header">
    <h2>Users</h2>
  </div>

  <p>
    <a href="<?php echo App::instance()->createUrl(array('controller'=>'user', 'action'=>'add')); ?>" class="btn btn-primary">Add new user</a>
  </p>

  <div class="list-group">
    <?php foreach ($this->models as $model): ?>
    <div class="list-group-item">
      <div class="row" style="line-height: 40px;">
      <div class="col-md-1 text-center">
        <img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($model->email)))?>?s=40&d=mm&r=g" alt="" class="img-circle"></div>
      <div class="col-md-3 text-center">
      <a href="<?php echo App::instance()->createUrl(array('controller'=>'user', 'action'=>'edit', 'id'=>$model->id)); ?>"><?php echo $model->name; ?></a> <em><?php echo $model->username; ?></em></div>
      <div class="col-md-3 text-center"><?php echo $model->email; ?></div>
      <div class="col-md-3 text-center"><?php echo implode(', ', $model->getPermissions()); ?></div>
      <div class="col-md-2 text-center"><a href="<?php echo App::instance()->createUrl(array('controller'=>'user', 'action'=>'delete', 'id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-sm">Delete</a></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div> <!-- /container -->