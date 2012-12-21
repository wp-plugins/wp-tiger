=== Wordpress vTiger CRM Lead Capture Plugin ===
Contributors: Smackcoders
Tags: crm, admin, administration, automatic, contact, form, list, newsletter, plugin, shortcode, sidebar, widget, widgets, wordpress, crm, vtiger, lead, wptiger
Requires at least: 3.1
Tested up to: 3.4.2
Stable tag: 2.0.0
Version: 2.0.0
Author: [Smackcoders](http://profiles.wordpress.org/smackcoders/)
Donate link: http://www.smackcoders.com/donate.html
License: GPLv2 or later
 
An easy to use plugin integrates Word Press contact form with vtigerCRM.

== Description ==

Wp-tiger plugin helps to easily capture leads to vtigerCRM from your word press through a contact form. Short code can used in page, post and separate short code for widgets as well.

**Features**
 
*    Admin can fetch vtigerCRM lead/contact fields directly to wordpress forms.
*    Options to enable/disable and make fields mandatory.
*    Short code to integrate form in post / page.
*    Separate short code to integrate form even as widget in sidebar.
*    Capture WP members to vtigerCRM contacts.

**In [Pro version](http://store.smackcoders.com/connectors/wp-vtiger-pro.html) you can enjoy most advances features like**

*    Unlike free version, the pro version uses Web services to communicate with vtigerCRM.
*    Capture both lead and contacts from wordpress to vtigerCRM.
*    Change the position order of the fields from wp dashboard itself.
*    Change the display label of the fields
*    Set mandatory fields using wp-tiger pro options.
*    Add Captcha feature to reduce risk of spam bots.
*    Can generate shortcodes separately for page/post and mini widget forms to accommodate within any theme sidebar. So no design modification needed.
*    You can sync old registered members to vtigerCRM contacts.


**Additional Features for Free Version**
 
Feel free to request for the new features. Requested features will be added in next release based on the effort involved. Additional features are under development. Please check back again for updated version.

Support and Feature requests. 
---------------------------- 
Please visit http://www.smackcoders.com/category/free-wordpress-plugins/google-seo-author-snippet-plugin.html for guides and tutorials. 
For quick response and reply please create issues in our [support](http://code.smackcoders.com/wp-tiger/issues) instead of wordpress support forum. Support at wordpress is not possible for now.



== Installation ==
 
Wp-tiger is very easy to install like any other wordpress plugin. No need to edit or modify anything here.

1.    Unzip the file 'wp-tiger.zip'.
2.    Upload the ' wp-tiger ' directory to '/wp-content/plugins/' directory using ftp client or upload and install wp-tiger.zip through plugin install  wizard in wp admin panel.
3.    Activate the plugin through the 'Plugins' menu in WordPress.
4.    After activating, you will see an option for 'wp-tiger' in the admin menu (left navigation).

== Screenshots ==

1. The screenshot-1.png shows the vtiger settings configuration
2. The screenshot-2.png shows the vtiger lead fields to be shown in the contact form page or post.
3. The screenshot-3.png shows the vtiger lead fields to be shown in the widget area.
4. The screenshot-4.png shows the form which captures the vtiger leads.
5. The screenshot-5.png shows the form placed in widget area, which captures the vtiger leads.
 
== Changelog ==
 
= 2.0.0 =

 - Capture WP members to vtiger contacts
 - Major usability changes and updates to ease the over all process
 
= 1.1.0 =

 - Important security issue fixed.
 - Widget Design issue fixed.
 - Updated post method type.
 - No need to configure success / failure urls in vtiger.
 - Added success / failure messages in wp itself.

= 1.0.0 =

This is the basic version. Tested and found works well without any issues.


== Upgrade Notice ==

v2.0.0 Must upgrade to enjoy new features and usability changes.

v1.1.0 Must upgrade. Important security issue fix and major modifications.

v1.0.0 Initial release.


== Frequently Asked Questions ==

1. Why wp tiger free?

   This plugin helps you to capture leads using a from or widget directy to your vtiger crm. Also you can optionally catch or sync from wp members database to vtiger.


2. How to install wp-tiger?

   Like other plugins wp-tiger is easy to install. Upload the wp-tiger.zip file through plugin install page through wp admin. Everything will work fine with it.


32. How to configure wp-tiger?

   In plugin settings provide your vtiger crm db host name, db credentials, url path and Application key. Save it will redirect to form fields tab.


4. How to get vtiger crm Application key?

   You can get the application key from the vtiger crm config.inc.php file from the root.

   
5. How to create form in a page/post?

   After settings are configured, go to form fields menu. Choose the fields to display and save. Now you can copy & paste the shortcode [display_contact_page] in any page/post.


6. How to create form for widget?

   Go to widget fields menu. Choose the fields to display and save. Now you can copy & paste the shortcode [display_widget_area] for widget in any page/post.


7. Why i am getting "Failed to add entry in to vtiger CRM. Error Code: INVALID_USER_CREDENTIALS, Error Message: Invalid username or password"?

   This is because the access key is not same in Webforms.config.php as in my preferences. You need to get the correct access key from vtiger My preferences and replace it in "yourvtiger/modules/Webforms/Webforms.config.php".


8. How member capturing works?

   By default email, first name and last name are captured if available. In case of default wp member, last name will be username with email is captured as lead. This works well with any membership plugin. No even to worry about what type of member plugin are used.


For quick response and reply please create issues in our [support](http://code.smackcoders.com/wptiger/issues) instead of wordpress support forum.
Support at wordpress is not possible for now.

