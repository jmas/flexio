 <div class="container">

      <div class="page-header">
        <h2>Users</h2>
      </div>
      
      <p>
        <a class="btn btn-primary">Add new user</a>
      </p>
	  
      <div class="list-group">
        <?php foreach ($this->models as $model): ?>
        <?php var_dump($model); ?>
        <div class="list-group-item">
          <div class="row">
          <div class="col-md-3"><a href="<?php echo App::instance()->createUrl(array('controller'=>'user', 'action'=>'edit', 'id'=>$model->id)); ?>"><?php echo $model->username; ?></a></div>
          <div class="col-md-3"><?php echo $model->email; ?></div>
          <div class="col-md-3"><?php echo $model->permissions; ?></div>
          <div class="col-md-3"><a href="<?php echo App::instance()->createUrl(array('controller'=>'user', 'action'=>'delete', 'id'=>$model->id)); ?>" type="button" class="btn btn-danger btn-xs pull-right">Delete</a></div>
          </div>
        </div>
       <?php endforeach; ?>
      </div>
    </div> <!-- /container -->