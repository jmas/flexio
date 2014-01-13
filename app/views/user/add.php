<div class="container">
    
  <div class="page-header">
    <h2>Add user</h2>
  </div>
  
  <form class="form-horizontal" role="form" method="post" autocomplete="off">
    <div class="form-group">
      <label for="data[name]" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="data[name]">
      </div>
    </div>
    <div class="form-group">
      <label for="data[username]" class="col-sm-2 control-label">Username</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="data[username]">
      </div>
    </div>
    <div class="form-group">
      <label for="data[email]" class="col-sm-2 control-label">E-mail</label>
      <div class="col-sm-4">
        <input type="email" class="form-control" name="data[email]" >
      </div>
    </div>
    <div class="form-group">
      <label for="data[name]" class="col-sm-2 control-label">Permission</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="data[permissions]" value="user">
      </div>
    </div>
    <div class="form-group">
      <label for="data[password]" class="col-sm-2 control-label">Password</label>
      <div class="col-sm-4">
        <input type="password" class="form-control" name="data[password]">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-4">
        <button type="submit" class="btn btn-default">Add</button>
      </div>
    </div>
  </form>
</div>