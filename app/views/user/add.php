<div class="page-header">
    <h3>Create user</h3>
</div>

<form class="form-horizontal" role="form" method="post" autocomplete="off" parsley-validate>

    <div class="form-group">
        <div class="col-md-4">
            <label for="data[name]">Name</label>
            <small class="help-block">Your name that users will see.</small>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="data[name]" value="<?php echo $this->model->name; ?>" required >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[email]">E-Mail</label>
            <small class="help-block"></small>
        </div>
        <div class="col-md-4">
            <input type="email" class="form-control" name="data[email]" value="<?php echo $this->model->email; ?>" required >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[username]">Username</label>
            <small class="help-block">Your username that you will use for login. At least 3 characters.</small>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="data[username]" value="<?php echo $this->model->username; ?>" parsley-minlength="3">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[password]">Password</label>
            <small class="help-block">At least 3 characters.</small>
        </div>
        <div class="col-md-4">
            <input type="password" class="form-control" name="data[password]" value="<?php echo $this->model->password; ?>" parsley-minlength="3" required >
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <label for="data[permission]">Permissions</label>
            <small class="help-block">Roles restrict user privileges and turn parts of the administrative interface on or off.</small>
        </div>
        <div class="col-md-4"> 
            <div class="checkbox">Administrator
                <input type="checkbox" name="data[permissions][administrator]" value="administrator" <?php echo (strpos($this->model->permissions, 'administrator') !== false ? 'checked' : ''); ?> parsley-group="permissions">
            </div>
            <div class="checkbox">Developer
                <input type="checkbox" name="data[permissions][developer]" value="developer" <?php echo (strpos($this->model->permissions, 'developer') !== false ? 'checked' : ''); ?> parsley-group="permissions">
            </div>
            <div class="checkbox">Editor
                <input type="checkbox" name="data[permissions][editor]" value="editor" <?php echo (strpos($this->model->permissions, 'editor') !== false ? 'checked' : ''); ?> parsley-group="permissions" parsley-mincheck="1">
            </div>  
        </div>
    </div>   
    <div class="form-group">
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Create user</button> or <a href="<?php echo App::instance()->createUrl(array('controller'=>'user', 'action'=>'index')); ?>">Cancel</a>
        </div>
    </div>
</form>

