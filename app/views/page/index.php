<!-- Main component for a primary marketing message or call to action -->
<div class="page-header">
<h2>Pages</h2>
</div>

<form class="form-inline pull-right" role="form">
<div class="form-group">
  <label class="sr-only" for="exampleInputEmail2">Search</label>
  <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Search">
</div>
</form>

<p>
<a class="btn btn-primary" href="<?php echo App::instance()->createUrl(array('controller'=>'page','action'=>'create')); ?>">Create</a>
</p>

<div class="list-group">
<div class="list-group-item">
  <div class="pull-right">
    <button type="button" class="btn btn-danger">Delete</button>
  </div>
  <h4 class="list-group-item-heading"><a href="#">Home page</a></h4>
  <p class="list-group-item-text help-block small">
    Created 10 Jan 2014. Last modified by Alex. <a href="#">40 comments</a>.
  </p>
</div>
<div class="list-group-item">
  <div class="pull-right">
    <button type="button" class="btn btn-danger">Delete</button>
  </div>
  <h4 class="list-group-item-heading"><a href="#">Products</a></h4>
  <p class="list-group-item-text help-block small">
    Created 10 Jan 2014. Last modified by Alex. <a href="#">40 comments</a>.
  </p>
</div>
<div class="list-group-item">
  <div class="pull-right">
    <button type="button" class="btn btn-danger">Delete</button>
  </div>
  <h4 class="list-group-item-heading"><a href="#">Product One</a></h4>
  <p class="list-group-item-text help-block small">
    Created 10 Jan 2014. Last modified by Alex. <a href="#">40 comments</a>.
  </p>
</div>
<div class="list-group-item">
  <div class="pull-right">
    <button type="button" class="btn btn-danger">Delete</button>
  </div>
  <h4 class="list-group-item-heading"><a href="#">Contacts</a></h4>
  <p class="list-group-item-text help-block small">
    Created 10 Jan 2014. Last modified by Alex. <a href="#">40 comments</a>.
  </p>
</div>
</div>