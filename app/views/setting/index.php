<div class="page-header">
    <h3>Settings</h3>
</div>

<form class="form-horizontal" role="form" method="post" autocomplete="off" parsley-validate novalidate>

    <div class="form-group">
        <div class="col-md-3">
            <label for="data[name]">Site name</label>
            <small class="help-block">Site name that will be used in themes as title.</small>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="data[name]" value="" required>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[name]">Site description</label>
            <small class="help-block">Default site description that will be used in themes.</small>
        </div>
        <div class="col-md-3">
            <textarea rows="2" id="description" name="description" class="form-control"></textarea>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[name]">Keywords</label>
            <small class="help-block">Default keywords that will be used in themes.</small>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="data[name]" value="" required>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[name]">Default theme</label>
            <small class="help-block">Default theme that will be used in front-end.</small>
        </div>
        <div class="col-md-3">
            <select class="form-control">
                <option>Default</option>
                <option>SomeTheme</option>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="data[name]">Development mode</label>
            <small class="help-block">Disable caching, and show PHP errors.</small>
        </div>
        <div class="col-md-3">
        <label class="checkbox-switcher">
            <input type="checkbox">
            <span class="switch">
                <span class="btn btn-danger btn-xs">On</span>
                <span class="btn btn-default btn-xs">Off</span>	   
                <span></span>
            </span>
        </label>
        </div>
    </div>

    
    <div class="form-group">
        <div class="col-md-3">
            <input type="submit" class="btn btn-primary" value="Save" /> or <a href="<?php echo $this->controller->createUrl(array('index')); ?>">Cancel</a>
        </div>
    </div>
</form>

