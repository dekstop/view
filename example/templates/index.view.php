<? include('header.php') ?>

<h1><?= $title ?></h1>

<h2>I. Renderers</h2>

<p>Default display renderers for basic types:</p>
<table border="0">
<tr>
  <th>Type</th>
  <th>Display</th>
</tr>
<tr>
  <td>Integer</td>
  <td><?= $vars->int ?></td>
</tr>
<tr>
  <td>Float</td>
  <td><?= $vars->float ?></td>
</tr>
<tr>
  <td>String</td>
  <td><?= $vars->string ?></td>
</tr>
<tr>
  <td>Boolean</td>
  <td><?= $vars->boolean ?></td>
</tr>
<tr>
  <td>Array</td>
  <td><?= $vars->list ?></td>
</tr>
<tr>
  <td>Map</td>
  <td><?= $vars ?></td>
</tr>
<tr>
  <td>null</td>
  <td><?= $vars->null ?></td>
</tr>
</table>

<p>Handling HTML strings:</p>
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

<p>Effect of the <tt>bytes</tt> renderer on <?= $vars->list->count() ?> different numbers:</p>
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
<pre>
<?= $vars->this_renderer_does_not_exist() ?>
</pre>
<? } ?>

<? include('footer.php') ?>
