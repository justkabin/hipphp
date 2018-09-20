

HipPhp documentation
==================================

.. toctree::
   :maxdepth: 2
   :caption: Contents:
hipPhp® is a PHP framework designed to help developers create Object Oriented Applications, with little code.

*************
Requirements:
*************

1. Apache web server with PHP5.6 or higher.
2. MySQL 

************
Installation
************

1.  Download hipPhp
2.  Extract and upload files to your webserver.
3.  Rename htaccess.txt to .htaccess.
4.  Create a folder outside your public html to store site data.
5.  Edit /engine/settings.php

.. code-block:: php

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

6.  SSH into your server and run "yarn" in your project root folder. Learn about yarn here. https://yarnpkg.com/en/
7.  While SSH'd into your server, run "composer install" in your project root folder.

*******
Classes
*******


AccessHandler
^^^^^^^^^^^^^
Creates a system Access Handler.
Example:


new AccessHandler("public");

            
            
Cache
^^^^^

Used to store a variable in the system Cache.

Example:


$variable = "name"; // The name of the variable to save
$value = "Shane"; // The value to save in the variable
$storage = "file";  // Where to save the variable ("page", "site", "session")

new Cache($variable,$value,$storage);


When saved to "page", the variable is lost on the next page load, and is only available in the current session<br/>
When saved to "site", the variable is saved to memcache (if available), and is available to all browser sessions.  If memcache is not available, variable is saved to "file"<br/>
When saved to "file", the variable is saved to the filesystem, and is available to all browser sessions.

            
            
CSS
^^^

Adds CSS to the site.

Example:


$name = "bootstrap"; // An arbitrary name used to identify the CSS element.
$location = "http://www.bootstrap.com/style.css"; // Location of the CSS.  When using local CSS, point to the file using getSitePath()
$weight = 10; // Higher weights load later.
$combine = true;  // Whether or not to combine the CSS into one file.

new CSS($name,$location,$weight,$combine);

            
            
FooterJS
^^^^^^^^

Adds Javascript to the site footer.

Example:


$name = "bootstrap"; // An arbitrary name used to identify the Javascript element.
$location = "http://www.bootstrap.com/script.js"; // Location of the Javascript.
$weight = 10; // Higher weights load later.
$init = true; // When set to true, the system runs an itit function after page load.  See example below:

new FooterJS($name,$location,$weight,$init);

Example:
<pre class="prettyprint linenums lang-javascript">
var javascript = {
    init:function(){
        // This runs after page load.
    }
};

            
            
HeaderJS
^^^^^^^^

Adds Javascript to the site header.

Example:


$name = "bootstrap"; // An arbitrary name used to identify the Javascript element
$location = "http://www.bootstrap.com/javascript.js"; // Location of the Javascript.
$weight = 10; // Higher weights load later.

new HeaderJS($name,$location,$weight);

            
            
MenuItem
^^^^^^^^

Adds an link to a menu.

Example:


$params = array(
    "name"=&gt;"home", // An arbitrary name used to identify the menu item
    "page"=&gt;"home", // The page to visit when the url is clicked
    "menu"=&gt;"header_left",  // The menu where the link will be placed
    "weight"=&gt;0 // Higher weights load later.
);

new MenuItem($params);

            
            
          
SystemMessage
^^^^^^^^^^^^^

Create a new system message.

Example


$message = "Your profile has been updated."; // The system message to display
$type = "success"; // The class of the message popup.

new SystemMessage($message,$type);

            
            
ViewExtension
^^^^^^^^^^^^^

Extend a view with another view.

Example:


$target = "page_elements/header"; // The view to be extended.
$source = "new_theme/header"; // The view that is extended to the target.

new ViewExtension($target,$source);

            
        </ul>
        
            Functions
        
        <ul>
            
getEntities
^^^^^^^^^^^

Creates an array of entities based on certain criteria.

Example:


$params = array(
    "type"=&gt;"User", // The type of entity you want to return
    "metadata_name"=&gt;"first_name", // Optional:  Key to filter by
    "metadata_value"=&gt;"Shane", // Optional:  Value to filter by
    "operand"=&gt;"=", // Optional:  Operand to compare key/value combinations
    "metadata_name_value_pairs"=&gt;array( // Optional:  Used if multiple combinations are required
        array(
            "name"=&gt;"first_name", // Key to filter by
            "value"=&gt;"Shane", // Value to filter by
            "operand"=&gt;"=" // Optional:  Operand to compare key/value combinations
        ),
        array(
            "name"=&gt;"last_name", // Key to filter by
            "value"=&gt;"Barron", // Value to filter by
            "operand"=&gt;"=" // Optional: Operand to compare key/value combinations
        )
    ),
    "metadata_name_value_pairs_operand"=&gt;"OR" // Optional:  Operand to compare name value pairs
);

getEntities($params);

            
            
getEntity
^^^^^^^^^

Retrieves an entity from the database based on guid or other parameters.

Example:


getEntity($guid);


Can pass a guid, or params as in GetEntities();

            
            
notifyUser
^^^^^^^^^^

Creates a notification entity used for notifying a user of an action.

            
            
drawPage
^^^^^^^^

Generates an Boostrap formatted version of passed paramaters.

            
            
getInput
^^^^^^^^

Used to get input values from forms.

            
            
removeViewExtension
^^^^^^^^^^^^^^^^^^^

Unextends a view.

            
            
removeMenuItem
^^^^^^^^^^^^^^

Removes a link from a menu.

            
            
gateKeeper
^^^^^^^^^^

Prevents non logged in users from viewing a page.

            
            
reverseGateKeeper
^^^^^^^^^^^^^^^^^

Prevents logged in users from viewing a page.

            
            
classGateKeeper
^^^^^^^^^^^^^^^

Used in action handlers to make sure that an object is of a certain class.

            
            
adminGateKeeper
^^^^^^^^^^^^^^^

Prevents non admin users from viewing a page.

            
            
removeCSS
^^^^^^^^^

Removes CSS from the site.

            
            
removeFooterJS
^^^^^^^^^^^^^^

Removes Javascript from the footer.

            
            
removeHeaderJS
^^^^^^^^^^^^^^

Removes Javascript from the header.

            
            
pageArray
^^^^^^^^^

Used to return parts of the current URL.

            
            
forward
^^^^^^^

Redirects the site to a certain page.

            
            
sendEmail
^^^^^^^^^

Sends an email.

            
            
display
^^^^^^^

Renders HTML from a view.

            
            
drawForm
^^^^^^^^

Renders a form.

            
            
listEntities
^^^^^^^^^^^^

Renders an HTML list of entities based on paramaters.

            
            
getSiteURL()

Returns the site's base URL.

            
            
getSiteName()

Returns the site's name.

            
            
getSiteEmail()

Returns the site's email.

            
            
getDataPath()

Returns the path to the site's data folder.

            
            
getSitePath()

Returns the path to site's html base.

            
            
loggedIn()

Returns true if current user is logged in.  False otherwise.

            
            
getLoggedInUser()

Returns the current logged in user object.

            
            
getLoggedInUserGuid()

Returns the current logged in user guid.

            
            
adminLoggedIn()

Returns true if admin logged in.  False otherwise.

            
            
Vars()

Used to retrieve variables passed to views.

            
            
addTokenToURL()

Adds a security token to an action URL.

            
            
isAdmin()

Checks if a user is an admin.

            
            
currentURL()

Returns the current site url.

            