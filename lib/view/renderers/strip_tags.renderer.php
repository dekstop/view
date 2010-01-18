<?

function strip_tags_renderer($property, $args) {
  if ($property->is_null()) return null;
  $v = mb_ereg_replace('<[^>]*>|<[^>]*$', '', $property->raw());
  return $v;
}

?>