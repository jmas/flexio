<div class="page-header">
    <h3><?php echo $this->model->isNew() ? 'Create user' : 'Edit user'; ?></h3>
</div>

<form class="form-horizontal" role="form" method="post" autocomplete="off" parsley-validate novalidate>

    <div class="form-group">
        <div class="col-md-4">
            <label for="data[name]">Name</label>
            <small class="help-block">Your name that users will see.</small>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="data[name]" value="<?php echo $this->model->name; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[email]">E-mail</label>
            <small class="help-block">Your e-mail address for receiving notifications.</small>
        </div>
        <div class="col-md-4">
            <input type="email" class="form-control" name="data[email]" value="<?php echo $this->model->email; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[username]">Username</label>
            <small class="help-block">Your username that you will use for login. At least 3 characters.</small>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="data[username]" value="<?php echo $this->model->username; ?>" parsley-minlength="3" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[password]"><?php echo $this->model->isNew() ? 'Password' : 'New password'; ?></label>
            <small class="help-block">At least 3 characters.</small>
        </div>
        <div class="col-md-4">
            <input type="password" class="form-control" name="data[password]" value="<?php echo $this->model->isNew() ? $this->model->password : ''; ?>" parsley-minlength="3" <?php echo $this->model->isNew() ? 'required' : '';?>>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[permission]">Permissions</label>
            <small class="help-block">Roles restrict user privileges and turn parts of the administrative interface on or off.</small>
        </div>
        <div class="col-md-4"> 
            <?php foreach($this->permissions as $permission): ?>
                <label class="checkbox">
                    <input type="checkbox" name="data[permissions][]" value="<?php echo $permission; ?>" <?php echo ($this->model->hasPermission($permission) ? 'checked' : ''); ?> parsley-group="permissions" parsley-mincheck="1">
                    <?php echo $permission; ?>
                </label>
            <?php endforeach; ?> 
        </div>
    </div>   
    <div class="form-group">
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary"><?php echo $this->model->isNew() ? 'Create user' : 'Save changes'; ?></button> or <a href="<?php echo Flexio::app()->createUrl(array('controller'=>'user', 'action'=>'index')); ?>">Cancel</a>
        </div>
    </div>
</form>

