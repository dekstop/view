<?

function truncate_renderer($property, $encoder, $args) {
  if (count($args)<1 || count($args)>2) throw new Exception('Function requires one or two parameters. Provided: ' . count($args));
  $str = $property->raw();
  $len = $args[0];
  $sep = (count($args)==2 ? $args[1] : '...');
  if (mb_strlen($str, 'UTF-8') > $len) {
    $str = mb_substr($str, 0, $len-mb_strlen($sep, 'UTF-8'), 'UTF-8');
    return Sandbox::wrap($str . $sep, $encoder);
  }
  return Sandbox::wrap($str, $encoder);
}

?>