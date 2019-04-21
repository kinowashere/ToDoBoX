<?php
function toaster($toast) {
  echo("<script> M.toast({html: '".$toast."'}); </script>");
}
?>