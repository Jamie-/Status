<?php
date_default_timezone_set('UTC');

$configs = parse_ini_file("config.ini");

if ($configs['force_config'] == 1) {
    $services = explode(",", $configs['services']);
} else {
    $servicesIni = parse_ini_file("services.ini");
    $services = explode(",", $servicesIni['services']);
}

$status = array();
$uptime = array();

for ($i = 0; $i <= count($services) - 1; $i++) { // Grabs all the status' of all the services listed in the array
    $temp = shell_exec("service " . $services[$i] . " status");

    if ((strpos($temp, 'process') !== false) || (strpos($temp, 'stop/waiting') !== false)) {
        // It's a standard format response - proceed
        if (strpos($temp, 'start/running') !== false) {
            // Service running
            $status[$i] = "Running";
        } elseif (strpos($temp, 'stop/waiting') !== false) {
            // Service halted
            $status[$i] = "Halted";
        } else {
            // Unrecognised response...
            $status[$i] = "Error 1";
        }
    } elseif ((strpos($temp, 'apache2') !== false) || (strpos($temp, 'ddclient') !== false)) {
        // Deal with Apache2 and DDClient's special responses
        if (strpos($temp, 'is running') !== false) {
            // Service running
            $status[$i] = "Running";
        } elseif (strpos($temp, 'not running') !== false) {
            // Service halted
            $status[$i] = "Halted";
        } else {
            // Unrecognised response... (from service status)
            $status[$i] = "Error 1";
        }
    } else {
        // Unrecognised response... (from status call) - is the service an installed program?
        $status[$i] = "Error 2";
    }
    //$status[$i] = $temp;
}
//var_dump($status); //DEBUG


// Get Uptime Info
$temp = shell_exec("uptime");
$temp = str_replace(",", "", $temp);
$uptimeExplode = explode(" ", $temp);

$uptime[2] = $uptimeExplode[count($uptimeExplode) - 3]; // set 1 min average
$uptime[3] = $uptimeExplode[count($uptimeExplode) - 2]; // set 5 min average
$uptime[4] = $uptimeExplode[count($uptimeExplode) - 1]; // set 15 min average

if (array_search("user", $uptimeExplode) == FALSE) {
    $i = array_search("users", $uptimeExplode);
} else {
    $i = array_search("user", $uptimeExplode);
}
$uptime[0] = $uptimeExplode[$i - 1]; // set number of users

$i = array_search("up", $uptimeExplode);
$uptime[1] = $uptimeExplode[$i + 1] . " " . $uptimeExplode[$i + 2]; // set time up

?>

<table class="services">
    <tr>
        <?php
        for ($i = 0; $i <= count($services) - 1; $i++) {
            echo '<td><div class="circle" ';
            if ($status[$i] == "Running") {
                echo ' style="border: 3px solid #00FF00;"';
            } elseif ($status[$i] == "Halted") {
                echo ' style="border: 3px solid #FF0000;"';
            } else {
                echo ' style="border: 3px solid #FFDE00;"';
            }
            echo '><h4>' . $services[$i] . "</h4><h2";
            if ($status[$i] == "Running") {
                echo ' style="color: #00FF00;"';
            } elseif ($status[$i] == "Halted") {
                echo ' style="color: #FF0000;"';
            } else {
                echo ' style="color: #FFDE00;"';
            }
            echo ">" . $status[$i] . "</h2></div></td>";
        }
        ?>
    </tr>
</table>

<div class="foot">
    Last update: <?php echo date('G:i:s'); ?> UTC |
    Users: <?php echo $uptime[0]; ?> |
    Uptime: <?php echo $uptime[1]; ?>
    <?php
    if ($configs['load_one'] == 1) {
        echo " | Load (1 min): " . $uptime[2];
    }
    if ($configs['load_one'] == 1) {
        echo " | Load (5 min): " . $uptime[3];
    }
    if ($configs['load_one'] == 1) {
        echo " | Load (15 min): " . $uptime[4];
    }
    ?>

</div>
