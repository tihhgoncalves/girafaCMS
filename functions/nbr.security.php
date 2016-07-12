<?
function nbrSecurityCheck() {
  global $SITEKEY;

  $id = $_SESSION[base64_encode($SITEKEY . 'admin')]['ID'];
  return (!empty($id));
}
?>