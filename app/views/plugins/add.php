<div class="page-header">
    <h3>Add plugin</h3>
</div>

<?php if (count($this->plugins) > 0): ?>
<div class="list-group">
    <div class="list-group-item list-group-item-info">
        <div class="row">
            <div class="col-md-11">Name</div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <?php foreach ($this->plugins as $plugin): ?>
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-11"><?php echo $plugin['name']; ?></div>
            <div class="col-md-1"><a href="<?php echo $this->controller->createUrl(array('download', 'remoteUrl'=>$plugin['url'])); ?>" type="button" class="btn btn-primary btn-xs">Add</a></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p class="text-muted">The list is empty.</p>
<?php endif; ?>