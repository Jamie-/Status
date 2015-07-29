<html>
<head>
    <title>Monitor Configuration</title>
    <link href="style.css" rel="stylesheet" />
    <!--<link href='http://fonts.googleapis.com/css?family=Lato:100,300' rel='stylesheet' type='text/css'>-->
</head>
<body class="config">

<h1>Server Status Monitor Configuration</h1>

<table id="services"></table>

<table>
  <tr>
    <td><input type="text" id="serviceInput" /></td>
    <td><input type="button" value="Add" onclick="addItem();" class="button" /></td>
    <td><input type="button" value="Remove" onclick="removeItem();" class="button" /></td>
  </tr>
  <tr>
    <td colspan="3"><input type="button" value="Save!" onclick="save();" class="button button-wide" /></td>
  </tr>
  <tr>
    <td colspan="3"><a href="index.php">Back?</a></td>
  </tr>
</table>

<script type="text/javascript">
var heading = "<b>Services to Track</b>";
var services = [];
var servicesTable = document.getElementById("services");
var serviceInput = document.getElementById("serviceInput");

<?php
  $servicesIni = parse_ini_file("services.ini");
  $services = explode(",", $servicesIni['services']);
  for ($i = 0; $i <= count($services) - 1; $i++) {
    echo "services.push(\"" . $services[$i] . "\");";
  }
?>

function updateTable() {
  var stringOut = "<tr><td>" + heading + "</td></tr>"; // Start with the table heading
  for (var i = 0; i <= services.length - 1; i++) {
    stringOut += "<tr><td>" + services[i] + "</td></tr>";
  }
  servicesTable.innerHTML = stringOut;
}
updateTable();

function addItem() {
  if (serviceInput.value != "") {
    services.push(serviceInput.value);
    services.sort();
    updateTable();
    serviceInput.value = "";
  }
}

function removeItem() {
  if ((serviceInput.value != "") && (services.indexOf(serviceInput.value) != -1)) {
    var removeIndex = services.indexOf(serviceInput.value);
    for (var i = removeIndex; i <= services.length - 1; i++) {
      services[i] = services[i + 1];
    }
    services[services.length - 1] = "";
    updateTable();
    serviceInput.value = "";
  }
}

function save() {
  var stringOut = services.join(",");

  // Clean up string start.
  do {
    if (stringOut.charAt(0) == ",") {
      stringOut = stringOut.substring(1); // Remove first char.
    }
  } while (stringOut.charAt(0) == ",");

  // Clean up string end.
  do {
    if (stringOut.charAt(stringOut.length - 1) == ",") {
      stringOut = stringOut.substring(0, stringOut.length - 1); // Remove last char.
    }
  } while (stringOut.charAt(stringOut.length - 1) == ",");

  window.location.href = "save.php?services=" + stringOut; // Initiate the file save.
}

</script>

</body>
</html>
