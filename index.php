<?php
date_default_timezone_set('UTC');

$configs = parse_ini_file("config.ini");

?>

<html>
    <head>
        <title>Server Status Monitor</title>
        <link href="core_style.css" rel="stylesheet"/>
        <?php
        if ($configs['theme_css'] != "none") {
            echo '<link href="' . $configs['theme_css'] . '" rel="stylesheet" />';
        }
        ?>
        <!--<link href='http://fonts.googleapis.com/css?family=Lato:100,300' rel='stylesheet' type='text/css'>-->
    </head>
    <body>

        <h1>Server Status Monitor</h1>

        <div id="statusArea"></div>

        <footer class="foot">Enable refresh? <input type="checkbox" name="refreshEnable" id="refreshEnable"> |
            Refreshing in: <span id="refreshTime">0</span> seconds | Go to the <a href="guiconf.php">interactive
                configurator</a>?
        </footer>

        <script type="text/javascript" src="jquery-2.0.2.js"></script>
        <script type="text/javascript">
            var refreshChk = document.getElementById("refreshEnable");
            refreshChk.checked = true;
            var pageTime = document.getElementById("refreshTime");
            var timeConst = <?php echo $configs['time'] ?>;
            var time = timeConst;
            pageTime.innerHTML = time.toString();

            function ajaxRefresh() {
                $.ajax({
                    url: 'refresh.php',
                    type: 'POST',
                    data: {
                        refresh: "TRUE"
                    },
                    success: function(response) {
                        $("#statusArea").html(response);
                    }
                });
            }

            ajaxRefresh();

            function decrease() {
                time = time - 1;
                pageTime.innerHTML = time.toString();
                if (time == 0) {
                    //location.reload();
                    ajaxRefresh();
                    time = timeConst + 1; // My OCD likes to see the value I want before it is decreased, remove the "+ 1" if you want.
                }
            }

            var timer = window.setInterval(decrease, 1000); // Starts repeat timer.

            // Listen for changes to the repeat control checkbox.
            $('input[name = refreshEnable]').change(function(){
                if($(this).is(':checked'))
                { // Checkbox is checked.
                    timer = window.setInterval(decrease, 1000); // Starts repeat timer.
                } else { // Checkbox is not checked.
                    clearInterval(timer); // Stops repeat timer.
                }

            });

        </script>

    </body>
</html>
