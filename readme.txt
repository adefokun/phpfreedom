Thank you for choosing PHP Freedom Framework – The Rapid Web Development Technology from Africa.

To use the framework, you need a working web server that is running php5, and MySQL database.

First create your database and run /phpfreedom.sql against it to setup the database for your project.

Then edit the configuration file at /application/config/freedom.ini to your local environment, which includes the directory paths and database settings.

If you want to run your project outside the htdocs or www directory of your webserver, then check the /.htaccess file and follow the instructions therein.

First, we need to start by securing your application... All the backend functionalities of your application shall reside in the /application folder. This folder contains and will contain your application modules. In order to ensure some security, this folder should not be accessible from a url! Therefore, 

1. Move this folder out of your web server. 
2. Open /index.php and set $path_to_application_directory = /new/path/to/application and save 

These done, Login as the application administrator using the credentials below

Username: administrator
Password: administrator

You are advised to change this password after logging in for the first time. To manage user accounts go to administrator > Manage Users

To develop a basic database content driven website, you do not need to write a single line of code, but your CSS skills is required to deliver a great look and feel. Make a copy of any theme in /themes e.g. default, and give it a name of your choice, e.g. “mytheme”. It will automatically be available in the list. Keep all your frontend stuffs, e.g. images, style sheets, flash, javascript files etc. in this folder. This is useful for portability.

To manage the content go to administrator > content manager, there you can create pages and edit page and do everything that has to do with content management.

To manage navigation, go to administrator > manage menu. You may add new item or edit the existing ones.

For example, to render a page from content with the Content Category or Page Name "names" set:

URL = index/pages/display/?page=names
In this case, the module is index, the controller is pages and the action is display.

If you want to render content from the same category but with subcategory name "firstname" set:

URL = index/pages/display/?page=names&subsection=firstname

We are working towards providing a comprehensive documentation for the project, but for now, we hope that you find the skeletal documentation provided useful and please feel free to contact me for any question.

ADEFOKUN Tomiwa Michael

Email: tomiwa.adefokun@gmail.com
Phone: +234 805 305 0903

