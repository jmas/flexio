<div class="container">

  <div class="page-header">
    <h2>Edit user: <?php echo $this->model->username; ?></h2>
  </div>
  <form class="form-horizontal" role="form" method="post">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
      <div class="col-sm-4">
        <p class="form-control-static"><?php echo $this->model->username; ?></p>
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="name" value="<?php echo $this->model->name; ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Permissions</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="name" value="<?php echo $this->model->permissions; ?>">
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Email</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="name" value="<?php echo $this->model->email; ?>">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" class="btn btn-default">Save</button>
      </div>
    </div>
    
  </form>
</div>