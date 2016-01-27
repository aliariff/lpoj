This is legacy code, i help to develop it when i was in 3rd semester during my bachelor degree (2012). Sorry if the code is kind of ugly :D

This is online judge application for competitive programming. Developed use PHP (CodeIgniter), and compile thing handle by Python scripts. For now its supports C/C++ Language only. Hope it will support other language like Java, Python, Ruby, etc in near future.

Step Install:

1. Install Webserver (LAMP)

   Use Nginx or Apache Web Server to host this app, MySQL database, and PHP.
   You can googling how to install it.

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


to be continue...
