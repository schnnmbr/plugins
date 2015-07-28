### 1.3.6

**Changes and fixes**

- 3rd level menu fix
- Page title and sub title update for 3.8

---------------

### 1.3.5

**Changes and fixes**

- Fix for javascript block id now a string with Headway 3.7
- Updated to use legacy block id for 3.7
- Styling updated for 3.7

---------------

### 1.3.4

**Changes and fixes**

- Added on before show to menu
- Fixed menu JS to not return false if no child items
- Replaced tinynav with selectnav
- Removed callbacks for css updates that were causing errors in Headway 3.5.10
- Changed block variable to work correctly with 3.5
- Increased social icons to 10
- Adjusted menu selected element class to include page_ancestor class
- Registered drop down link as an element to style
- Fixed issues with hide element options, elements now hide correctly.
- Fixed position from right on the menu

---------------

### 1.3.3

**Notes**

Please follow these instructions to upgrade. Due to a change in the folder structure this process needs to be followed just once:
- Login to Wordpress and go to plugins page.
- Delete the Utility Block plugin completely.
- Re install the Utility Block from the file or extend and activate.

If you do just upgrade you will likely get an error saying the Utility Block does not exist. Go to the plugins page and re activate it but make sure you have only 1Utility Block Plugin.

**Improvements**
- On mobile screens the menu now changes to a select.
- Added a responsive tab with options to better control utilities on smaller screens.
- Set a break point (screen width eg: 480px) where the utilities positioning will be removed so elements stack on top of each other.
- Auto center all utilities at specified break point.
- Set bottom spacing between utilities.

**Bug Fixes**
- Fixed potential IE7 issue causing browser to crash on some systems.
- Fixed issue with potential js conflict.
- Re packaged block with nested folder to keep utility block folder name the same when upgrading.
- Added array check to prevent no array error.

**Changes**
- Removed no follow from links.
- Added if block check on some methods.
- Set elements to not support new instances because of our own custom solution to handle this.

---------------
### 1.3.2

*January 29, 2013*

Note: Version number structure has changed from 1.0.x to 1.x.y

** Changes**
- Added default overlay property to be visible to fix menu drop downs hiding issue.
- Menu selector changed to avoid lost styling in the latest update.
- Added menu item element with default padding and removed it from the css. This is to style the list item.
- Changed name of Top Level Menu to Top Level Menu Link.
- Fixed and re-added the Clicked state.
- Added default background color for the top level hover and drop downs.
- Changed Active to Selected so its the same as Headway.
- Removed padding and font colour from menu css.

---------------

### 1.3.1

*January 25, 2013*

Note: Version number structure has changed from 1.0.x to 1.x.y

**Bug Fixes**
- Fixed warning with invalid array on design defaults.
- Fixed social spacing issue on multiple instances.

---------------

### 1.0.3

*January 23, 2013*

**Improvements**
- Improved menu design options to make it easier to style the menu states from the Design Editor.
- Added open in new window to social links.
- Added alternate logo url option.
- Re worked how defaults are added paving the way for more defaults in the future.

**Bug Fixes**
- Changed how css is added to attempt to fix when it breaks with other plugins.
- Fixed positioning issue with headway 3.4.4
- Changed page title to an h1 to match the default value.

**Changes**
- Removed blogname short-code
- Added block description

---------------------------------------

### 1.0.2

*October 8, 2012*

**Bug Fixes**
- Fixed date format
- Removed vertical align JS causing issues
- Fixed search field not working on all pages
- Fix for headway 3.3 compatability

---------------------------------------

### 1.0.1 - Initial release