<?php
  $iniFile = 'services.ini';
  $serviceString = $_GET['services'];

  file_put_contents($iniFile, "services = \"" . $serviceString . "\"");

  // Redirect user back to GUI config page
  echo '<html><script type="text/javascript">window.location.href = "guiconf.php";</script></html>';
?>
