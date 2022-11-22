## How it works

The ONLYOFFICE integration follows the API documented [here](https://api.onlyoffice.com/editors/basic):

* When creating a new file, the user will be provided with Document, Spreadsheet or Presentation options in the `Create document` menu.

* The browser invokes the `index` method in the `/controllers/CreateController.php` controller.

* Or, when opening an existing file, the user will be provided with `View document` or `Edit document` depending on an extension.

* A popup is opened and the `index` method of the `/controllers/OpenController.php` controller is invoked.

* The app prepares a JSON object with the following properties:

  * **url** - the URL that ONLYOFFICE Document Server uses to download the document;
  * **callbackUrl** - the URL that ONLYOFFICE Document Server informs about status of the document editing;
  * **key** - the random MD5 hash to instruct ONLYOFFICE Document Server whether to download the document again or not;
  * **title** - the document Title (name);
  * **id** - the identification of the user;
  * **name** - the name of the user.

* HumHub takes this object and constructs a page from `views/open/index.php` template, filling in all of those values so that the client browser can load up the editor.

* The client browser makes a request for the javascript library from ONLYOFFICE Document Server and sends ONLYOFFICE Document Server the DocEditor configuration with the above properties.

* Then ONLYOFFICE Document Server downloads the document from HumHub and the user begins editing.

* ONLYOFFICE Document Server sends a POST request to the _callbackUrl_ to inform HumHub that a user is editing the document.

* When all users and client browsers are done with editing, they close the editing window.

* After [10 seconds](https://api.onlyoffice.com/editors/save#savedelay) of inactivity, ONLYOFFICE Document Server sends a POST to the _callbackUrl_ letting HumHub know that the clients have finished editing the document and closed it.

* HumHub downloads the new version of the document, replacing the old one.

