User profile <?php var_dump($this->model); ?>
<div class="container">
  <form class="form-horizontal" role="form">
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
      <div class="col-sm-4">
        <p class="form-control-static"><?php echo $this->model->username; ?></p>
      </div>
    </div>
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-4">
        <input type="email" class="form-control" id="name" value="<?php echo $this->model->name; ?>">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-4">
        <div class="checkbox">
          <label>
            <input type="checkbox"> Remember me
          </label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" class="btn btn-default">Save</button>
      </div>
    </div>
  </form>
</div>