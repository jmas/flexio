flexio
======

Awesome flexible CMS for simple tasks.

Folders structure
=================

app                           Application
  controllers                 Controllers
    SomeController.php
  models                      Models
    Some.php
  views                       Views
    layouts                   Layout views
      default.php
    some                      Controller views
      index.php
  plugins                     Plugins
  	some                      Plugin 'Some'
  	  controllers             Plugin controllers
  	  	SomeController.php
  	  models                  Plugin models
  	    Some.php
  	  views                   Plugin views
  	  	some                  Plugin controller views
  	  	  index.php
  	  	view.php
  	  SomePlugin.php
  config.php                  Application config
  plugins.php                 Plugins manager config
classes                       Classes
  ...
index.php                     Start point