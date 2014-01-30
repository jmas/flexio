<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo $this->app->getAssetUrl('images/flexio.ico'); ?>">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $this->app->getAssetUrl('css/app.css'); ?>" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <?php if (! empty($this->css)): ?> 
    <?php foreach ($this->css as $css): ?>
    <link href="<?php echo $css; ?>" rel="stylesheet" />
	<?php endforeach; ?>
	<?php endif; ?>
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="http://getbootstrap.com/docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  	<?php if ($this->isNavEnabled === true): ?>
  	<div class="navbar navbar-default navbar-static-top" role="navigation">
	  <div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="<?php echo $this->app->createUrl($this->app->defaultRoute); ?>"><?php echo $this->app->name; ?></a>
	    </div>
	    <div class="navbar-collapse collapse">
			<?php echo $this->app->nav->render(); ?>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo $this->app->createUrl(array('controller'=>'user', 'action'=>'edit', 'id'=>$this->app->auth->getId())); ?>"><?php echo $this->app->auth->getUserName(); ?></a></li>
				<li><a href="<?php echo $this->app->createUrl(array('controller'=>'auth', 'action'=>'logout')); ?>">Logout</a></li>
			</ul>
	    </div><!--/.nav-collapse -->
	  </div>
	</div>
	<?php endif; ?>

    <div class="container">

    	<?php $success=$this->app->flash->get('success'); ?>
    	<?php $error=$this->app->flash->get('error'); ?>

    	<?php if ($success !== null): ?>
    	<div class="alert alert-success">
			<?php echo $success; ?>
		</div>
    	<?php endif; ?>

    	<?php if ($error !== null): ?>
    	<div class="alert alert-danger">
			<?php echo $error; ?>
		</div>
    	<?php endif; ?>

		<?php echo $this->content; ?>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.2/parsley.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ace.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ext-emmet.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/mode-php.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->app->getAssetUrl('js/app.js'); ?>"></script>
  </body>
</html>