<? include('header.php') ?>

<h1><?= $title ?></h1>

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

<p>Some examples of user-defined renderers:</p>
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

<? if ($pleaseCrashMe->is_true()) { ?>
<p>And this is what it looks like when a render function is used in a template that View.php fails to find in the include path:</p>
<?= $item->number->undefined_renderer() ?>
<? } ?>

<? include('footer.php') ?>
