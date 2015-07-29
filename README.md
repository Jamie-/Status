# Linux Server Status Monitor #

### About ###
Little web app useable to check the status of services (out of your desired selection) on your Linux server (Debian based). Oh, and it's far from a nice 'finished' product - treat it as just for fun.

### Installation Requirements ###
- Debian based server
- Web Server (Apache2, LightTPD, Nginx)
- PHP Enabled

### Installation ###
1. Open a terminal.
2. Navigate to the installation location using `cd`.
3. Run `git clone https://github.com/Jamie-/Status.git`
4. (Only if using the GUI config panel) Run `sudo chmod 777 path/to/install/services.ini`.
5. Modify the config to your preference (the default config is adequate for use) using either a GUI text editor or using a command line based one like `vi` or `nano`.
6. Navigate to the install path in your browser! (example http://localhost/status)

### Security ###
At the moment, if you intend to put this on a live server with traffic going through it I would delete the `guiconf.php` file, the `save.php` file (this one is more important to delete) and the `services.ini` file. Then in `config.ini`, set `force_config` to `1` and select your required services to track also in that file under `services = "service1,service2,serviceN"`. I'll probably add a login form eventually..

### History ###
I have a server in my garage running various things I want access to so I installed ddclient to update DNS every time my house IP changes - all is good. However the ddclient daemon likes to stop itself running every now and again for whatever reason. I started this just as a simple way of easily and quickly being able to keep an eye on what services (of my choice) are running. Then after that I got a bit carried away and now have quite a few plans for it but only time will tell.

### Thanks ###
While searching to see if anyone had already made one of these sorts of things I stumbled upon this and quite liked the design and so made my own version of that style from scratch: http://xpaw.ru/mcstatus/
A big shoutout to those guys for their neat design!

### To Do ###
- Combine save.php and guiconf.php into one file.
- Make the updating refresh use AJAX so as not to reload the page.
- Ability to use themes.