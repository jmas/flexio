flexio
======

Awesome flexible CMS for simple tasks.

Principles
==========

<ul>
<li>Simple and smart</li>
<li>Flexible and extendable</li>
<li>Lightweight and fast</li>
</ul>

Requirements
============

<ul>
<li>PHP 5.3 or greater</li>
<li>MySQL 5.0 or greater</li>
<li>1 Mb free space</li>
</ul>

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

<b>Singleton</b>

<b>Methods:</b>

<pre>
static instance()             Get app instance
__construct($config=array())  Constructor
__get($key)                   Getter. Wrap getConfig() method
getConfig($key, $defaultValue=null)
                              Get config value. Return config value or $defaultValue
run()                         Run application
</pre>

<b>Description:</b>

Class <code>App</code> contain configuration and bootstrap method <code>run()</code>.

Configuration situated in <code>config.php</code> file.

Example of <code>config.php</code>:

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

You can access this properties through <code>App</code> class.

<b>Examples:</b>

<pre>
$mailer = App::instance()->mailer; // Instance of class 'Mailer'
$mailer->setBody('Message');
$mailer->setSubject('Test e-mail');
$mailer->setTo('customemail@example.com');
$mailer->submit();
</pre>

In this example we see that we have <code>class</code> property that told <code>App</code> to use <code>Mailer</code> class. Method <code>getConfig()</code> will return instance of class <code>Mailer</code>.

Note: When you trying to access config property through <code>App::instance()->someProperty</code> you automaticly calling <code>getConfig('someProperty')</code> method.

<pre>
echo App::instance()->version; // 1.0
</pre>

In this example we see that we have simple string value. Because we have't <code>class</code> property in our <code>config.php</code> file.

<pre>
echo App::instance()->roles[0]; // guest
</pre>

Same as previouse example but now we have simple array as property <code>roles</code>.

<pre>
echo App::instance()->db; // Object
</pre>

But some properties are already defined in <code>App</code> class. They are: <code>request</code>, <code>observer</code>, <code>loader</code>, <code>router</code>, <code>db</code>, <code>models</code>, <code>plugins</code>. And when we trying to access this properties as simple array - we will get error. This properties are objects.

Router
======

<b>Methods:</b>

<pre>
__construct($config=array())  Constructor
route($path)                  Convert path to 'params' by 'routes' rulles
createPath($params=array())   Create 'path' by 'params'
</pre>

<b>Description:</b>

Class <code>Router</code> is using for extracting different <code>params</code> from <code>path</code> by <code>routes</code> rulles.

For example we need several params <code>constructor</code>, <code>action</code> and sometimes <code>plugin</code> for run some part of code.

<code>Router</code> get <code>path</code> and extract <code>params</code> from it by <code>route()</code> method. We can do reverse operation: convert <code>params</code> to <code>path</code> by <code>createPath()</code> method.

<b>Examples:</b>

<pre>
$router = new Router(array(
  'routes'=>array(
    'plugin/&lt;plugin:\w+&gt;/&lt;controller:\w+&gt;',
    'plugin/&lt;plugin:\w+&gt;/&lt;controller:\w+&gt;/&lt;action:\w+&gt;',
    '&lt;controller:\w+&gt;/&lt;action:\w+&gt;/&lt;id:\d+&gt;',
    '&lt;controller:\w+&gt;/&lt;action:\w+&gt;',
  ),
  'defaultController'=>'page',
  'defaultAction'=>'index',
));

$params = $router->route('layout/show'); // array('controller'=>'layout', 'action'=>'show')
</pre>

In this example we created new instance of <code>Router</code> and then convert <code>path</code> to <code>params</code> array.

<pre>
$params = $router->route('layout'); // array('controller'=>'layout', 'action'=>'index')
</pre>

In this example we passed <code>path</code> with only one segment <code>layout</code> and then in result we got <code>params</code> array with two properties. It was two properties becouse we have <code>defaultController</code> and <code>defaultAction</code> in class configuration. If <code>Router</code> can't find <code>controller</code> or <code>action</code> it takes this properties from config defaults.

Controller
==========

