<?

/**
 * Sandboxes with a JsonEncoder instead of the $encoder that gets passed through.
 */
function json_list_renderer($list, $encoder, $args) {
  return Sandbox::wrap(json_encode($list->raw()), new JsonEncoder());
}

?>