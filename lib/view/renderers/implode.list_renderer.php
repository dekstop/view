<?

function implode_list_renderer($list, $encoder, $args) {
  return Sandbox::wrap(implode(Sandbox::wrap($args[0], $encoder), $list->values()), $encoder);
}

?>