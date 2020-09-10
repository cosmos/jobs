=== Application Deadline ===
Contributors: mikejolley, drawmyface, jakeom, kraftbj
Requires at least: 5.0
Tested up to: 5.5
Stable tag: 1.2.3
Requires PHP: 7.0
License: GNU General Public License v3.0

Allows job listers to set a deadline via a new field on the job submission form. Once the deadline passes, the job listing is automatically ended (if enabled in settings)

= Documentation =

Usage instructions for this plugin can be found here: [https://wpjobmanager.com/document/application-deadline/](https://wpjobmanager.com/document/application-deadline/).

= Support Policy =

For support, please visit [https://wpjobmanager.com/support/](https://wpjobmanager.com/support/).

We will not offer support for:

1. Customisations of this plugin or any plugins it relies upon
2. Conflicts with "premium" themes from ThemeForest and similar marketplaces (due to bad practice and not being readily available to test)
3. CSS Styling (this is customisation work)

If you need help with customisation you will need to find and hire a developer capable of making the changes.

== Installation ==

To install this plugin, please refer to the guide here: [http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation)

== Changelog ==

= 1.2.3 =
* Fix issue with job expiration happening a day early.

= 1.2.2 =
* Fix issue with applications closed notice showing early.

= 1.2.1 =
* Use GMT offset time for all deadline expiration checks.
* Use WordPress date format setting for date display.
* Add filter to customize date display on the frontend.
* Use WP Job Manager Core datepicker functionality.

= 1.2.0 =
* Adds compatibility with WP Job Manager 1.29.0 and requires it for future updates.
* Make closing date column sortable.
* Fix issue with jobs not expiring.

= 1.1.5 =
* Set cron job to run midnight, local time.

= 1.1.4 =
* Expires column should show closing date if automatic expiry is set.
* Show closing date column on frontend.
* Correctly set firstday of week in datepicker.
* Improved check_application_deadlines query.

= 1.1.3 =
* Disable application when deadline passes.
* Fix CSS.

= 1.1.2 =
* Load translation files from the WP_LANG directory.
* Updated the updater class.

= 1.1.1 =
* Uninstaller.

= 1.1.0 =
* More orderby tweaks (for WP 4.0).
* Output date in job list (requries WP JM 1.17.1+ coming soon).

= 1.0.8 =
* Tweak orderby to sort by meta_value_num and ensure data meta is set.

= 1.0.7 =
* Translate jquery UI datepicker

= 1.0.6 =
* Fix JS error in admin.

= 1.0.5 =
* Allow translation of date format.

= 1.0.4 =
* Show datepicker in admin.

= 1.0.3 =
* Added POT file.

= 1.0.2 =
* Added new updater - This requires a licence key which should be emailed to you after purchase. Past customers (via Gumroad) will also be emailed a key - if you don't recieve one, email me.

= 1.0.1 =
* Update textdomain

= 1.0.0 =
* First release.
