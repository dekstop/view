<? include('header.php') ?>

<h1><?= $title ?></h1>

<h2>I. Renderers</h2>

<p>Default renderers for basic types:</p>
<table border="0">
<tr>
  <th>Type</th>
  <th>Display</th>
</tr>
<? foreach ($vars as $k => $v) { ?>
<tr>
  <td><?= $k ?></td>
  <td><?= $v ?></td>
</tr>
<? } ?>
</table>

<p>Some examples of using render functions:</p>
<table border="0">
<tr>
  <th>Renderer</th>
  <th>Example</th>
  <th>Display</th>
</tr>
<tr>
  <td><tt>default</tt></td>
  <td><tt>$empty_variable->default('Not provided')</tt></td>
  <td><?= $vars->null->default('Not provided') ?></td>
</tr>
<tr>
  <td><tt>truncate</tt></td>
  <td><tt>$string->truncate(10)</tt></td>
  <td><?= $vars->string->truncate(10) ?></td>
</tr>
<tr>
  <td><tt>format</tt></td>
  <td><tt>$float->format('%.2f')</tt></td>
  <td><?= $vars->float->format('%.2f') ?></td>
</tr>
<tr>
  <td><tt>date</tt></td>
  <td><tt>$timestamp->date('Y-m-d')</tt></td>
  <td><?= $vars->int->date('Y-m-d') ?></td>
</tr>
<tr>
  <td><tt>json</tt> on lists</td>
  <td><tt>$sizes->json()</tt></td>
  <td><?= $sizes->json() ?></td>
</tr>
<tr>
  <td><tt>json</tt> on maps</td>
  <td><tt>$vars->json()</tt></td>
  <td><?= $vars->json() ?></td>
</tr>
<tr>
  <td><tt>date</tt> + <tt>json</tt></td>
  <td><tt>$timestamp->date('Y-m-d')->json()</tt></td>
  <td><?= $vars->int->date('Y-m-d')->json() ?></td>
</tr>
</table>

<p>Effect of the <tt>bytes</tt> renderer on <?= $sizes->count() ?> different numbers:</p>
<table border="0">
<tr>
  <th><tt>Number</tt></th>
  <th><tt>$number->bytes()</tt></th>
</tr>
<? foreach ($sizes as $s) { ?>
<tr>
  <td><?= $s ?></td>
  <td><?= $s->bytes() ?></td>
</tr>
<? } ?>
</table>

<p>Handling HTML strings:</p>
<table border="0">
<tr>
  <th>Example</th>
  <th>Display</th>
</tr>
<tr>
  <td><tt>$html_string</tt></td>
  <td><?= $vars->string ?></td>
</tr>
<tr>
  <td><tt>$html_string->strip_tags()</tt></td>
  <td><?= $vars->string->strip_tags() ?></td>
</tr>
<tr>
  <td><tt>$html_string->raw()</tt> (dangerous!)</td>
  <td><?= $vars->string->raw() ?></td>
</tr>
</table>

<h2>II. Exceptions</h2>

<? if ($pleaseCrashMe->is_true()) { ?>
<p>This is what happens when a template calls a render function that View.php fails to find in the include path: It will throw an Exception.</p>
<pre>
<?= $vars->int->this_renderer_does_not_exist() ?>
</pre>
<? } else { ?>
<p>The Exception example is disabled.</p>
<? } ?>

<? include('footer.php') ?>
