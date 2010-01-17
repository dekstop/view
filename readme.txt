2010-01-16 00:26:37

View.php: a simple PHP template engine

Requirements: 
- PHP 5.2

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
  $model = new Model();
  $model->message = 'My Blog Post'; // set some properties
  $model->timestamp = time();
  $view = new View();
  $view->display('index', $model);
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


 ===========
 = Details =
 ===========

You hand data to your template by populating a map of named properties within
a Model object; these properties will be made available to the template as 
local variables. 

This more or less describes the entire mechanism; but of course there's also
a bit of magic involved.

1. View.php Will Wrap Property and PropertyList Objects Around All Your Values

All data passed to display templates via the Model class gets encapsulated in
Property/PropertyList objects. This helps making sure that all output is always 
properly quoted for HTML display, and is used as dispatch mechanism for render 
function calls.

Property objects can generally be regarded as escaped strings, independent of 
their encapsulated type.
  <?= $my_property ?>

PropertyList objects can generally be regarded as arrays. They can be 
count()ed, iterated over, their elements addressed via array/map index or as 
object fields, but they're not native arrays.
  <ul>
  <? foreach ($my_items as $item) { ?>
    <li><?= $item->name ?></li>
  <? } ?>
  </ul>

As you can see control flow is usually very close to native PHP.

Note that we assume that we will never display array keys, only their values. 
E.g. we ignore keys in PropertyList::__toString(), and the output of
array_keys($my_propertylist) is unsafe for display. List render functions are
obviously free to output keys, but it is their responsibility to ensure that 
this is safe. 

I realise that this is not acceptable, and I violate this in one of my own 
examples. We might change this behaviour in the future, but I'm not convinced 
that it's actually possible. Cf. http://bugs.php.net/bug.php?id=45684

2. Render Functions Control the Display of Property Values

You call user-defined render functions to convert a property's encapsulated 
value into different representations. There are two kinds of render 
functions: Property renderers, and PropertyList renderers. 

Here's a Property renderer which displays a timestamp as date string:
  <?= $timestamp->date('Y-m-d') ?>

You can chain renderers:
  <?= $timestamp->date('Y-m-d')->json() ?>

Here's a PropertyList renderer which concatenates a list of items:
  <?= $tags->implode(', ') ?>

The default renderer will always implicitly be called last, and takes care
of HTML escaping. To prevent this you can call the 'raw' renderer: 
  <?= $item->raw() ?>

4. Checking for Specific Values in Your Display Logic is Slightly Inconvenient

Checking the value of a property requires a small detour. This is a direct 
effect of our main design goal (secure output via encapsulation of properties.)

For convenience properties have methods to check for boolean/null values:
  <?= $item.name.is_null() ? "Not provided" : $item.name ?>
  <?= $item.flag.is_true() ? "Yes" : "No" ?>

To compare with specific values use the 'raw' renderer for now:
  <? if ($name.raw()=="Jef") { ?>Hello Buddy!<? } ?>

In some cases you might be able to get away with treating properties as strings
in your comparisons and skipping the conversion to 'raw', but at minimum this 
will lead to some very confusing side-effects and edge cases, so I recommend 
that you avoid this.

5. User-Defined Render Functions Are Auto-Loaded By Name

Render functions are PHP functions that adhere to a couple of conventions.
You may already know the general approach from other frameworks. 

For a Property render function called 'date':
* Example use: <? $item->date('Y-m-d') ?>
* PHP function name: 'date_renderer'
* PHP filename: 'date.renderer.php'

For a PropertyList render function called 'implode':
* Example use: <? $list->implode(', ') ?>
* PHP function name: 'implode_list_renderer'
* PHP filename: 'implode.list_renderer.php'

The PHP file containing the render function must be accessible via the include 
path. If a renderer's PHP file cannot be loaded View.php will throw an 
Exception.

Render functions will receive two arguments:
* the Property or PropertyList object
* an array of all arguments of the render function call

Since render functions receive the encapsulated property, most of the time they 
will want to unwrap it first. E.g. from the implementation of 'date':
  return date($args[0], $property->raw());

The output of a render function will automatically be wrapped in a Property 
object before it is returned by the dispatcher; this allows us to chain render
method calls.

 ========
 = TODO =
 ========

TODO: more essential renderers: default, format (sprintf), strip_tags, strip, truncate, 
TODO: more useful renderers: capitalize, lower, upper, wordwrap, regex_replace, replace, 
TODO: plan a thorough approach to escaping: do we really want to call htmlentities on everything? is there malicious markup that we can't escape that way? -> write global customisable escaping function, with unit tests using misc malicious markup
TODO: implement functions/generators (smarty really only has two that we would like to have: counter, and cycle. both require a way to maintain state.)
TODO: implement fragments (like includes, but with no access to template vars, instead they get passed a map of variables to be imported in local scope)
TODO: implement block filters (which wrap around a block of HTML and process it, e.g. to format blocks of text.) doesn't seem too useful for HTML only, but might be interesting as a method to operate on blocks of HTML+PHP; e.g. filters that sanitise embedded markup from external sources
TODO: clean up View.php
TODO: make it easy to switch the default renderer to target different output formats with different sanitation rules.
FIXME: it's not nice that render functions are asymmetric in their interface: they receive properties, but emit raw values which then get wrapped into properties by the render dispatcher. This is somewhat convenient because renderer implementations don't need to explicitly wrap, but will likely confuse implementers because of its inconsistency.
FIXME: who takes care of escaping, render functions or the default renderer? E.g. compare json() (does no escaping) with implode() (escapes the separator string, and calls the default escaping renderer for each element; this makes it impossible to produce an un-escaped result.)
FIXME: we probably have no need to make a distinction between current PropertyList and Model classes -> merge them. Then rename 'Property*' to 'Field*', and have the Model take care of both namespace sandboxing and Field vs FieldList encapsulation of variables, depending on type
