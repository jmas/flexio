 <div class="container">

      <div class="page-header">
        <h2>Users</h2>
      </div>
      
      <p>
        <a class="btn btn-primary">Add new user</a>
      </p>
	  
      <div class="list-group">
	  <?php foreach ($this->models as $model) {
		$deleteLink = App::instance()->createUrl(array('controller'=>'user','action'=>'delete', 'id'=>$model->id));
		echo '<div class="list-group-item">';
		  echo '<div class="row">';
			echo '<div class="col-md-3">' . $model->username .'</div>';
			echo '<div class="col-md-3">' . $model->permissions .'</div>';
			echo '<div class="col-md-3">site@site.com</div>';
			echo '<div class="col-md-3"><a href="' . $deleteLink . '" type="button" class="btn btn-danger btn-xs pull-right">Delete</a></div>';
		  echo '</div>';
        echo '</div>';
		}
	  ?>
      </div>

    </div> <!-- /container -->