**hipPhp&reg; is a PHP framework designed to help developers create Object Oriented Applications, with little code.**

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hipphp/hipphp/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hipphp/hipphp/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/hipphp/hipphp/badges/build.png?b=master)](https://scrutinizer-ci.com/g/hipphp/hipphp/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/hipphp/hipphp/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

## Requirements:

 - Apache web server with PHP5.6 or higher.
 - MySQL

## Installation:

 - Download hipPhp
 - Extract and upload files to your webserver.
 - Rename htaccess.txt to .htaccess.
 - Create a folder outside your public html to store site data.
 - Edit /engine/settings.php
 - SSH into your server and run "yarn" in your project root folder.  Learn about yarn here.  [https://yarnpkg.com/en/](https://yarnpkg.com/en/)
 - While SSH'd into your server, run "composer install" in your project root folder.  Learn about composer here.  [https://getcomposer.org/](https://getcomposer.org/)



```php
define('SITENAME', '');		//      Enter the name of your site here.
define('SITEURL', '');		//      This will be the URL to your site followed by a /
define('SITEPATH', '');		//	The path to your index.php file.  (ex. /home/public_html/)
define('SITEDATAPATH', '');	//	The path to your external data folder.  (ex. /home/data/)
define('SITEEMAIL','');		//	This is the email address that system emails will be sent from.
define('SITESECRET','');	//	Create a unique key.  Key will be used to identify your site.
define('SITELANGUAGE','en');    //	This configures the language of your site.  Defaults to English.
define('DBHOST', 'localhost');	//	Your database host.  Defaults to localhost.
define('DBNAME', '');		//	Your database name.
define('DBUSER', '');		//	Your database user name.
define('DBPASS', '');		//	Your database password.
```


 - Once this information is complete, you can visit your site.  
 - Register your first user.  This will be your site admin.

To learn more about this project, visit [http://hipphp.com](http://hipphp.com)
