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

<p>Some examples of using custom renderer functions:</p>
<table border="0">
<tr>
  <th>Renderer</th>
  <th>Example</th>
  <th>Display</th>
</tr>
<tr>
  <td><tt>date</tt></td>
  <td><tt>$timestamp->date('Y-m-d')</tt></td>
  <td><?= $vars->number->date('Y-m-d') ?></td>
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
  <td><?= $vars->number->date('Y-m-d')->json() ?></td>
</tr>
</table>

<p>Effect of the <tt>bytes</tt> renderer on <?= count($sizes) ?> different numbers:</p>
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

<p>Preventing HTML escaping of values (dangerous!):</p>
<table border="0">
<tr>
  <th>Example</th>
  <th>Display</th>
</tr>
<tr>
  <td><tt>$var</tt></td>
  <td><?= $vars->string ?></td>
</tr>
<tr>
  <td><tt>$var->raw()</tt></td>
  <td><?= $vars->string->raw() ?></td>
</tr>
</table>

<h2>II. Exceptions</h2>

<? if ($pleaseCrashMe->is_true()) { ?>
<p>This is what happens when a template calls a render function that View.php fails to find in the include path: It will throw an Exception.</p>
<pre>
<?= $vars->number->this_renderer_does_not_exist() ?>
</pre>
<? } ?>

<? include('footer.php') ?>
