<?

function date_renderer($property, $args) {
  if ($property->is_null()) return null;
  $timestamp = $property->raw();
  if (!is_numeric($timestamp)) return null;
  if (count($args)!=1) throw new Exception('Function requires one parameter. Provided: ' . count($args));
  return date($args[0], $timestamp);
}

?>