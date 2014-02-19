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
<a class="btn btn-primary" href="<?php echo $this->app->createUrl(array('controller'=>'page','action'=>'create')); ?>">Create</a>
</p>


<div class="catalog">
	<div class="items closed-items">
		<div class="item primary-item">
			<div class="name"><a href="#">Main page</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 1</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 2</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 3</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 4</a></div>
			<div class="options-btn">&times;</div>
		</div>
	</div>
	<div class="items closed-items">
		<div class="item primary-item">
			<div class="name"><a href="#">Catalog</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 1</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 2</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 3</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Children 4</a></div>
			<div class="options-btn">&times;</div>
		</div>
	</div>
	<div class="items">
		<div class="item primary-item">
			<div class="name"><a href="#">Welding Tools</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Instrument 1</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item pack-item">
			<div class="name"><a href="#">Instrument 2</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Instrument 3</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item">
			<div class="name"><a href="#">Instrument 4</a></div>
			<div class="options-btn">&times;</div>
		</div>
		<div class="item create-item">
			<div class="name"><a href="#">+ Create page</a></div>
		</div>
	</div>
</div>


<?php /* <div class="list-group">
	<?php foreach ($this->models as $model): ?>
	<div class="list-group-item">
	  <div class="pull-right">
	    <a class="btn btn-danger" href="<?php echo $this->app->createUrl(array('controller'=>'page','action'=>'delete','id'=>$model->id)); ?>">Delete</a>
	  </div>
	  <h4 class="list-group-item-heading"><a href="<?php echo $this->app->createUrl(array('controller'=>'page','action'=>'edit','id'=>$model->id)); ?>"><?php echo $model->name; ?></a></h4>
	  <p class="list-group-item-text help-block small">
	    Created 10 Jan 2014. Last modified by Alex. <a href="#">40 comments</a>.
	  </p>
	</div>
	<?php endforeach; ?>
</div> */ ?>