<?

/**
 * This is just an alias for the htmlentities renderer.
 */
function e_renderer($property, $encoder, $args) {
  $r = RendererLoader::get_renderer('htmlentities');
  return $r($property, $encoder, $args);
}

?>