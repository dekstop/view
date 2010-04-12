<?

function strip_tags_renderer($property, $encoder, $args) {
  if ($property->is_null()) return Sandbox::wrap(null, $encoder);
  $v = mb_ereg_replace('<[^>]*>|<[^>]*$', '', $property->raw());
  return Sandbox::wrap($v, $encoder);
}

?>