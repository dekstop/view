<? include('header.php') ?>

<h1><?= $title ?></h1>

<p><a href="http://github.com/dekstop/view/">View.php</a> is a simple and safe PHP template engine. It uses PHP instead of a custom markup language, and attempts to make it easier to display sanitised strings than unsanitised ones.</p>

<p>This example page illustrates View.php's approach to rendering page content. Check out the project on GitHub for the controller and template <a href="http://github.com/dekstop/view/tree/master/example/">source code</a> for this document.</p>

<p><small>View.php was created by <a href="http://dekstop.de/">martind</a>. This page was rendered at <?= $now->date('Y-m-d H:i e') ?></small></p>

<!--

Note: The aim of this document is to demonstrate some of View.php's inner 
workings. As a result we're doing some things here that we would never do in a 
real-world template, like calling print_r($var) and displaying raw HTML string 
variables.

-->

<h2>I. Renderers</h2>

<p>View.php has default display renderers for basic types:</p>
<table border="0">
<tr>
  <th>Type</th>
  <th>Value</th>
  <th>Display</th>
</tr>
<tr>
  <td>Integer</td>
  <td><pre><? print_r($vars->int->raw()) ?></pre></td>
  <td><?= $vars->int ?></td>
</tr>
<tr>
  <td>Float</td>
  <td><pre><? print_r($vars->float->raw()) ?></pre></td>
  <td><?= $vars->float ?></td>
</tr>
<tr>
  <td>String</td>
  <td><pre><? print_r($vars->string->raw()) ?></pre></td>
  <td><?= $vars->string ?></td>
</tr>
<tr>
  <td>Boolean</td>
  <td><pre><? print_r($vars->boolean->raw()) ?></pre></td>
  <td><?= $vars->boolean ?></td>
</tr>
<tr>
  <td>Array</td>
  <td><pre><? print_r($vars->list->raw()) ?></pre></td>
  <td><?= $vars->list ?></td>
</tr>
<tr>
  <td>Map</td>
  <td><pre><? print_r($vars->raw()) ?></pre></td>
  <td><?= $vars ?></td>
</tr>
<tr>
  <td>null</td>
  <td><pre><? print_r($vars->null->raw()) ?></pre></td>
  <td><?= $vars->null ?></td>
</tr>
</table>

<p>View.php ships with a number of render functions to handle HTML strings. (Of course it is also easy to add your own.) By default it will always escape HTML entities:</p>
<table border="0">
<tr>
  <th>Example Template Code</th>
  <th>Display</th>
</tr>
<tr>
  <td><tt>&lt;?= $html_string ?&gt;</tt></td>
  <td><?= $vars->string ?></td>
</tr>
<tr>
  <td><tt>&lt;?= $html_string->strip_tags() ?&gt;</tt></td>
  <td><?= $vars->string->strip_tags() ?></td>
</tr>
<tr>
  <td><tt>&lt;?= $html_string->raw() ?&gt;</tt> <span class="unsafe">This is unsafe!</span></td>
  <td><?= $vars->string->raw() ?></td>
</tr>
</table>

<p>Some more examples of using render functions:</p>
<table border="0">
<tr>
  <th style="width:50%">Example Template Code</th>
  <th>Display</th>
</tr>
<tr>
  <td><tt>&lt;?= $string->strip_tags()->truncate(35) ?&gt;</tt></td>
  <td><?= $vars->string->strip_tags()->truncate(35) ?></td>
</tr>
<tr>
  <td><tt>&lt;?= $float->format('%.2f') ?&gt;</tt></td>
  <td><?= $vars->float->format('%.2f') ?></td>
</tr>
<tr>
  <td><tt>&lt;?= $int->date('Y-m-d') ?&gt;</tt></td>
  <td><?= $vars->int->date('Y-m-d') ?></td>
</tr>
<tr>
  <td><tt>&lt;?= $null->default('-') ?&gt;</tt></td>
  <td><?= $vars->null->default('-') ?></td>
</tr>
<tr>
  <td><tt>&lt;?= $list->json() ?&gt;</tt></td>
  <td><tt><?= $vars->list->json() ?></tt></td>
</tr>
<tr>
  <td><tt>&lt;?= $map->json() ?&gt;</tt></td>
  <td><tt><?= $vars->json() ?></tt></td>
</tr>
</table>

<p>Effect of the <tt>bytes</tt> render function on <?= $vars->list->count() ?> different numbers:</p>
<table border="0">
<tr>
  <th>Number</th>
  <th><tt>$int->bytes()</tt></th>
</tr>
<? foreach ($vars->list as $s) { ?>
<tr>
  <td><?= $s ?></td>
  <td><?= $s->bytes() ?></td>
</tr>
<? } ?>
</table>

<? if ($pleaseCrashMe->is_true()) { ?>
<h2>II. Exceptions</h2>

<p>This is what happens when a template calls a render function that View.php fails to find in the include path: It will throw an Exception.</p>
<p>Example template code: <tt>&lt;?= $vars->this_renderer_does_not_exist() ?&gt;</tt></p>
<pre class="error">
<?= $vars->this_renderer_does_not_exist() ?>
</pre>
<? } ?>

<? include('footer.php') ?>
