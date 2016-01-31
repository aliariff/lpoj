This is legacy code, i help to develop it when i was in 3rd semester during my bachelor degree (2012). Sorry if the code is kind of ugly :D

This is online judge application for competitive programming. Developed using PHP (CodeIgniter), and compile thing handled by Python scripts. For now its supports C/C++, Java, Python, and Ruby.

Install Step:

1. Install Webserver (LAMP)

   Use Nginx or Apache Web Server to host this app, MySQL database, and PHP.
   You can googling how to install it.
   Config the root directory of Nginx/Apache to this apps folder `lpoj/lpoj`.

2. Install `fromdos`

   `sudo apt-get install tofrodos`

3. Change Folder inside `pclp` to permission 777

   `cd pclp/`
   
   `find . -type d -exec chmod 777 {} +`
   
4. Install Sandbox
   
   `sudo dpkg -i libsandbox_<version>_<platform>.deb`

   `sudo dpkg -i pysandbox_<version>_<platform>.deb`
   
5. Install Python MySQLdb

   `sudo apt-get install build-essential python-dev libmysqlclient-dev`
   
   `sudo apt-get install python-mysqldb`
   
6. Install All Compiler

   `install gcc, g++, ruby, python, java, just googling it :D`
   
7. Import Database Default Schema & Change Database Config

   Import file `schema.sql` to MySQL database.
   
   Change this config file `pclp/compilerDaemonMk4b/database.py`

   And also database config for the web app in `lpoj/application/config/database.php`

8. Run Compiler Daemon

   `bash pclp/starter.sh`
   
9. Try It!

   Open `localhost` in your browser.
   
   Default login for admin: username is `admin`, password `admin`.
   
   Default login for ordinary user: username is `user`, password `user`.
   
Finish, happy exploring.
