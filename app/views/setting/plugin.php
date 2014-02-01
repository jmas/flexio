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
            <div class="col-md-4">Name</div>
            <div class="col-md-2">Author</div>
            <div class="col-md-2">Version</div>
            <div class="col-md-2">Last update</div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <?php foreach ($this->plugins as $plugin): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-4"><?php echo basename($plugin); ?></div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-2"></div>
            <div class="col-md-2"><a href="<?php echo $this->app->createUrl(array('setting', 'plugin', $this->app->plugins->isInstalled(basename($plugin)) ?  'uninstall' : 'install'=>basename($plugin) )); ?>" type="button" class="btn btn-danger btn-xs"><?php echo $this->app->plugins->isInstalled(basename($plugin)) ?  'Uninstall' : 'Install'; ?></a></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p class="text-muted">The list is empty.</p>
<?php endif; ?>