<div class="page-header">
    <h3>Plugins</h3>
</div>

<p>
    <a href="<?php echo $this->app->createUrl(array('setting', 'plugin')); ?>" class="btn btn-primary">Add plugin</a>
</p>

<?php if (count($this->plugins) > 0): ?>
<div class="list-group">
    <div class="list-group-item list-group-item-info">
        <div class="row">
            <div class="col-md-10">Name</div>
        </div>
    </div>
    <?php foreach ($this->plugins as $plugin): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-11"><?php echo $plugin->getName(); ?></div>
            <div class="col-md-1"><a href="<?php echo $this->app->createUrl(array('setting', $this->app->plugins->isInstalled($plugin->getName()) ?  'uninstall' : 'install', 'pluginName'=>$plugin->getName())); ?>" type="button" class="btn <?php echo $this->app->plugins->isInstalled($plugin->getName()) ? 'btn-danger': 'btn-success'; ?> btn-xs"><?php echo $this->app->plugins->isInstalled($plugin->getName()) ?  'Uninstall' : 'Install'; ?></a></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p class="text-muted">The list is empty.</p>
<?php endif; ?>