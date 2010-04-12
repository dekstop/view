<?

function htmlentities_renderer($property, $encoder, $args) {
  if ($property->is_null()) return Sandbox::wrap(null, $encoder);
  return Sandbox::wrap(htmlentities($property->raw(), ENT_QUOTES, 'UTF-8'), $encoder);
}

?>