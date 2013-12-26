flexio
======

Awesome flexible CMS for simple tasks.

Folders structure
=================

<pre>
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
</pre>

App
===

Singleton

Class App contain configuration and bootstrap method run().

Configuration situated in config.php file.

Example of config.php:

<pre>
return array(
  'mailer'=>array(
    'class'=>'Mailer',
    'from'=>'myemail@example.com',
  ),
  'version'=>'1.0',
  'roles'=>array('guest', 'developer', 'admin'),
  'db'=>array(
    'dsn'=>'mysql:dbname=flexio;host=127.0.0.1',
  ),
);
</pre>

You can access to this properties through App class.

Examples:

<pre>
$mailer = App::instance()->mailer; // Instance of class 'Mailer'
$mailer->setBody('Message');
$mailer->setSubject('Test e-mail');
$mailer->setTo('customemail@example.com');
$mailer->submit();
</pre>

In this example we see that we have 'class' property that tald Flexio to use 'Mailer' class. Method getConfig() will return instance of class 'Mailer'. Note: when you trying to access config property through App::instance()->someProperty you automaticly calling getConfig('someProperty') method.

<pre>
echo App::instance()->version; // 1.0
</pre>

In this example we see that we have simple string value. Because we have't 'class' property in our config.php file.

<pre>
echo App::instance()->roles[0]; // guest
</pre>

Same as previouse example but now we have simple array as property 'roles' value.



<pre>
static instance()             Get app instance
__construct($config=array())  Constructor
__get($key)                   Getter. Wrap getConfig() method
getConfig($key, $defaultValue=null)
                              Get config value. Return config value or $defaultValue
run()                         Run application
</pre>

