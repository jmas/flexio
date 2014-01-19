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
<a class="btn btn-primary" href="<?php echo Flexio::app()->createUrl(array('controller'=>'page','action'=>'create')); ?>">Create</a>
</p>

<div class="list-group">
	<?php foreach ($this->models as $model): ?>
	<div class="list-group-item">
	  <div class="pull-right">
	    <a class="btn btn-danger" href="<?php echo Flexio::app()->createUrl(array('controller'=>'page','action'=>'delete','id'=>$model->id)); ?>">Delete</a>
	  </div>
	  <h4 class="list-group-item-heading"><a href="<?php echo Flexio::app()->createUrl(array('controller'=>'page','action'=>'edit','id'=>$model->id)); ?>"><?php echo $model->name; ?></a></h4>
	  <p class="list-group-item-text help-block small">
	    Created 10 Jan 2014. Last modified by Alex. <a href="#">40 comments</a>.
	  </p>
	</div>
	<?php endforeach; ?>
</div>