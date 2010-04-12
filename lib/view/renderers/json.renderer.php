<?

/**
 * Sandboxes with a JsonEncoder instead of the $encoder that gets passed through.
 */
function json_renderer($property, $encoder, $args) {
  return Sandbox::wrap(json_encode($property->raw()), new JsonEncoder());
}

?>