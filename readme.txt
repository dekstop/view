2010-01-16 00:26:37

View.php: a simple PHP template engine

Requirements: 
* PHP 5.2

Caveats:
* Note that View.php sets mbstring.internal_encoding to UTF-8


 ================
 = Introduction =
 ================

This is probably too simple to fit your requirements. I mainly started it to
see if one can build nice DSLs in PHP, and I was also looking for an elegant 
HTML template mechanism for basic PHP applications.

The main design goal for this template engine was to made it hard to generate 
unsafe HTML. We do this by encapsulating all display variables in wrapper 
objects, and escaping HTML in the wrapper's __toString() method.

View.php uses PHP as a template language, so there's no compilation step. 
Additionally I liked Smarty's variable modifiers, so there's some of that in 
here in the shape of user-provided render functions which you can chain if 
needed.

Some features are still missing: fragments, caching, ... Not sure yet which of
these I'm going to address.

Other Smarty features will never be implemented. There's no need for Smarty's 
functions (we can use PHP functions) or a separate template language. There's
no built-in configuration mechanism.

To be frank I fully expect this project will be dead a few months from now 
after I moved on to something else; in the meantime I'm quite enjoying working 
on it, and am happy to discuss your patches/suggestions.

Martin Dittus, martin@dekstop.de


 ===========
 = Example =
 ===========

index.php:
  <?
  require_once('../lib/View.php');
  $ctx = new Context();
  $ctx->message = 'My Blog Post'; // set some properties
  $ctx->timestamp = time();
  $view = new View();
  $view->display('index', $ctx);
  ?>
  
index.view.php:
  <h1><?= $message ?></h1>
  <p>Today's date: <?= $timestamp->date('Y-m-d') ?></p>

... and that's already it. View.php will ensure that all properties get 
escaped, and it offers a simple rendering extension mechanism.

Refer to the code in /example/ for a more thorough treatment of features.

To view the example copy the entire project to somewhere under your your web 
root, or just create a symlink to <View.php root>/example/www, and then open 
<root path>/example/www/ in a browser.

Here's the full example on the interwebs:
* controller: http://github.com/dekstop/view/blob/master/example/www/index.php
* view: http://github.com/dekstop/view/blob/master/example/templates/index.view.php
* output: http://mardoen.textdriven.com/temp/view_php_basic_example.html


 ===========
 = Details =
 ===========

You hand data to your template by populating a map of named properties within
a Context object; these properties will be made available to the template as 
local variables. 

This more or less describes the entire mechanism; but of course there's also
a bit of magic involved.


1. View.php Will Wrap Property Objects Around All Your Values

All data passed to display templates via the Context class gets encapsulated in
implementations of the Property interface. This helps making sure that all 
output is always properly quoted for HTML display, and is used as dispatch 
mechanism for render function calls.

Your scalar properties get wrapped in instances of the ScalarProperty class. 
These can generally be regarded as escaped strings, independent of their 
encapsulated type.
  <?= $my_property ?>

Your array properties get wrapped in instances of the ListProperty class. These
can generally be regarded as arrays. They can be count()ed, iterated over, 
their elements addressed via array/map index or as object fields, but they're 
not actually native arrays.
  <ul>
  <? foreach ($my_items as $item) { ?>
    <li><?= $item->name ?></li>
  <? } ?>
  </ul>

Objects get wrapped in ObjectProperty instances. These can generally be 
treated just like the object they wrap. You can access public fields, and call 
public methods. It is assumed that you will never display your objects 
directly, only their properties and method return values.
  <? if ($my_object->has_result()) { ?>
    <?= $my_object->result ?>
    <?= $my_object->getValue($t) ?>
  <? } ?>

As you can see control flow is usually very close to native PHP.


Implementation detail:

Note that we assume that we will never display array keys, only their values. 
E.g. we ignore keys in ListProperty::__toString(), and the output of
array_keys($my_listproperty) is unsafe for display. List render functions are
obviously free to output keys, but it is their responsibility to ensure that 
this is safe. 

This clearly is not acceptable, so we might change this behaviour in the 
future, but I'm not convinced that it's actually possible. Cf. 
http://bugs.php.net/bug.php?id=45684


2. Render Functions Control the Display of Property Values

You call user-defined render functions to convert a property's encapsulated 
value into different representations. There are two kinds of render 
functions: ScalarProperty renderers, and ListProperty renderers. 

Here's a ScalarProperty renderer which displays a timestamp as date string:
  <?= $timestamp->date('Y-m-d') ?>

You can chain renderers:
  <?= $timestamp->date('Y-m-d')->json() ?>

Here's a ListProperty renderer which concatenates a list of items:
  <?= $tags->implode(', ') ?>

The default renderer will always implicitly be called last, and takes care
of HTML escaping. To prevent this you can call the 'raw' renderer: 
  <?= $item->raw() ?>


3. Checking for Specific Values in Your Display Logic is Slightly Inconvenient

Checking the value of a property requires a small detour. This is a direct 
effect of our main design goal (secure output via encapsulation of properties.)

For convenience properties have methods to check for boolean/null values:
  <?= $item->name->is_null() ? "Not provided" : $item->name ?>
  <?= $item->flag->is_true() ? "Yes" : "No" ?>

To compare with specific values use the 'equals' renderer:
  <? if ($name->equals("Jef")) { ?>Hello Buddy!<? } ?>

In some cases you might be able to get away with treating properties as strings
in your comparisons and skipping the conversion to 'raw', but at minimum this 
will lead to some very confusing side-effects and edge cases, so I recommend 
that you avoid this.


4. User-Defined Render Functions Are Auto-Loaded By Name

Render functions are PHP functions that adhere to a couple of conventions.
You may already know the general approach from other frameworks. 

For a ScalarProperty render function called 'date':
* Example use: <?= $item->date('Y-m-d') ?>
* PHP function name: 'date_renderer'
* PHP filename: 'date.renderer.php'

For a ListProperty render function called 'implode':
* Example use: <?= $list->implode(', ') ?>
* PHP function name: 'implode_list_renderer'
* PHP filename: 'implode.list_renderer.php'

The PHP file containing the render function must be accessible via the include 
path. If a renderer's PHP file cannot be loaded View.php will throw an 
Exception.

Render functions will receive two arguments:
* the ScalarProperty or ListProperty object that is being rendered
* an array of all arguments of the render function call

Since render functions receive the encapsulated property, most of the time they 
will want to unwrap it first. E.g. from the implementation of 'date':
  return date($args[0], $property->raw());

The output of a render function will automatically be wrapped in a Property 
instance, if it isn't already; this allows us to chain render method calls.

 ========
 = TODO =
 ========

TODO: finish fragments, then document them.
TODO: more useful renderers: strip, capitalize, lower, upper, wordwrap, regex_replace, replace, 
TODO: plan a thorough approach to escaping: do we really want to call htmlentities on everything? is there malicious markup that we can't escape that way? how can we prevent escaping of sanitised HTML strings? -> write global customisable escaping function, with unit tests using misc malicious markup
TODO: implement functions/generators (smarty really only has two that we would like to have: counter, and cycle. both require a way to maintain state.)
TODO: implement block filters (which wrap around a block of HTML and process it, e.g. to format blocks of text.) doesn't seem too useful for HTML only, but might be interesting as a method to operate on blocks of HTML+PHP; e.g. filters that sanitise embedded markup from external sources
TODO: make it easy to switch the default renderer to target different output formats with different sanitation rules.
FIXME: who takes care of escaping, render functions or the default renderer? E.g. compare json() (does no escaping) with implode() (escapes the separator string, and calls the default escaping renderer for each element; this makes it impossible to produce an un-escaped imploded result.)
