<?php

$this->app->assets->addCss(array(
    'http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css',
    $this->app->getAssetUrl('css/app.css'),
));

$this->app->assets->addJs(array(
    'http://code.jquery.com/jquery-1.10.2.min.js',
    'http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js',
    'http://cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.2/parsley.min.js',
));

$this->app->assets->addJs($this->app->getAssetUrl('js/app.js'), AssetManager::POS_BODY_BOTTOM);

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="<?php echo $this->app->getAssetUrl('images/flexio.ico'); ?>">

    <title><?php echo htmlspecialchars($this->app->name); ?></title>

    <!-- CSS/JS HEAD insertion point -->
    <?php echo $this->app->assets->render(AssetManager::TYPE_CSS, AssetManager::POS_HEAD); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_JS, AssetManager::POS_HEAD); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_CSS_PLAIN, AssetManager::POS_HEAD); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_JS_PLAIN, AssetManager::POS_HEAD); ?>
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="http://getbootstrap.com/docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- CSS/JS BODY TOP insertion point -->
    <?php echo $this->app->assets->render(AssetManager::TYPE_CSS, AssetManager::POS_BODY_TOP); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_JS, AssetManager::POS_BODY_TOP); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_CSS_PLAIN, AssetManager::POS_BODY_TOP); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_JS_PLAIN, AssetManager::POS_BODY_TOP); ?>

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
	      <a class="navbar-brand" href="<?php echo $this->app->createUrl($this->app->defaultRoute); ?>"><?php echo htmlspecialchars($this->app->name); ?></a>
	    </div>
	    <div class="navbar-collapse collapse">
			<?php echo $this->app->nav->render(); ?>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo $this->app->createUrl(array('controller'=>'user', 'action'=>'edit', 'id'=>$this->app->auth->getId())); ?>"><img src="<?php echo $this->app->auth->getRecord()->getGravatarUrl(); ?>" alt="" class="img-rounded" /> <?php echo htmlspecialchars($this->app->auth->getRecord()->name); ?></a></li>
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

    <!-- CSS/JS BOTTOM insertion point -->
    <?php echo $this->app->assets->render(AssetManager::TYPE_CSS, AssetManager::POS_BODY_BOTTOM); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_JS, AssetManager::POS_BODY_BOTTOM); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_CSS_PLAIN, AssetManager::POS_BODY_BOTTOM); ?>
    <?php echo $this->app->assets->render(AssetManager::TYPE_JS_PLAIN, AssetManager::POS_BODY_BOTTOM); ?>
  </body>
</html>