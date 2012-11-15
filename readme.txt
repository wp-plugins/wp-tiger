=== Wordpress vTiger CRM Lead Capture Plugin ===
Contributors: Smackcoders
Tags: crm, admin, administration, automatic,  contact, form, list, newsletter, plugin, shortcode, sidebar, widget, widgets, wordpress, crm, vtiger, lead, wptiger
Requires at least: 3.1
Tested up to: 3.31
Stable tag: 4.3
Version: 1.0.0
Author: [Smackcoders](http://profiles.wordpress.org/smackcoders/)
Donate link: http://www.smackcoders.com/donate.html
License: GPLv2 or later
 
An easy to use plugin integrates Word Press contact form with Vtiger CRM.
== Description ==

Wp-tiger plugin helps to easily capture leads to vtiger crm from your word press through a contact form. Short code can used in page, post and separate short code for widgets as well.

**Features**
 
*    Admin can fetch vtigerCRM lead/contact fields directly to wordpress forms.
*    Options to enable/disable and make fields mandatory.
*    Short code to integrate form in post / page.
*    Separate short code to integrate form even as widget in sidebar.
 

**In [Pro version](http://store.smackcoders.com/connectors/wp-vtiger-pro.html) you can enjoy most advances features like**

*    Unlike free version, the pro version uses Web services to communicate with vTiger CRM.
*    Capture both lead and contacts from wordpress to vTiger CRM.
*    Change the position order of the fields from wp dashboard itself.
*    Change the display label of the fields
*    Set mandatory fields using wp-tiger pro options.
*    Add Captcha feature to reduce risk of spam bots.
*    Can generate shortcodes separately for page/post and mini widget forms to accommodate within any theme sidebar. So no design modification needed.


**Additional Features for Free Version**
 
     Feel free to request for the new features. Requested features will be added in next release based on the effort involved. Additional features are under development. Please check back again for updated version.



== Installation ==
 
Wp-tiger is very easy to install like any other wordpress plugin. No need to edit or modify anything here.

1.    Unzip the file 'wp-tiger.zip'.
2.    Upload the ' wp-tiger ' directory to '/wp-content/plugins/' directory using ftp client or upload and install wp-tiger.zip through plugin install wizard in wp admin panel.
3.    Activate the plugin through the 'Plugins' menu in WordPress.
4.    After activating, you will see an option for 'wp-tiger' in the admin menu (left navigation).

== Screenshots ==

1. The screenshot-1.png shows the vtiger settings configuration
2. The screenshot-2.png shows the vtiger lead fields to be shown in the contact form page or post.
3. The screenshot-3.png shows the vtiger lead fields to be shown in the widget area.
4. The screenshot-4.png shows the form which captures the vtiger leads.
5. The screenshot-5.png shows the form placed in widget area, which captures the vtiger leads.
 
== Changelog ==
 
= 1.0.0 =

This is the basic version. Tested and found works well without any issues.
 
 
== Upgrade Notice ==
 
= 2.0.0 =

Updates are scheduled to release on November 2012.


== Frequently Asked Questions ==

1. How to install wp-tiger?
   Like other plugins wp-tiger is easy to install. Upload the wp-tiger.zip file through plugin install page through wp admin. Everything will work fine with it.

2. How to configure wp-tiger?
   In plugin settings provide your vtiger crm db host name, db credentials, url path and Application key. Save it will redirect to form fields tab.

3. How to get vtiger crm Application key?
   You can get the application key from the vtiger crm config.inc.php file from the root.

4. How to configure success/failure message?
   To get success/failure result, you need to add success and failure url's in vtiger "modules/Webforms/Webforms.config.php" file. Otherwise a error page may appear on failure.

Please use support section in wordpress itself for any further queries and feature request.
