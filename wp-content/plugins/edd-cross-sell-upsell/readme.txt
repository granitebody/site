=== Easy Digital Downloads - Cross-sell & Upsell ===

Plugin URI: https://easydigitaldownloads.com/downloads/edd-cross-sell-and-upsell/
Author: Easy Digital Downloads
Author URI: https://easydigitaldownloads.com

Increase sales and customer retention by Cross-selling and Upselling to your customers

== Changelog ==

= 1.1.8 =

* Fix: Fatal error was being caused by incorrect number of parameters being passed to the edd_download_class filter.

= 1.1.7 =

* Fix: The checkout page will now be refreshed when cross-sell downloads are added to the cart

= 1.1.6 =

* Fix: Undefined variable during purchase if Test Mode is enabled
* Fix: Warning when refunding payments when using PHP 7.1

= 1.1.5 =

* Fix: Cross-sells and Upsells already in the cart should not be displayed

= 1.1.4 =
* Fix: Cross-sells/Upsells not showing reports
* Tweak: Extension settings moved to sub-section

= 1.1.3 =
* Fix: XSS vulnerability in query args

= 1.1.2 =
* Fix: Default Cross-sell heading was not showing at checkout when their was one trigger download and no per-download cross-sell heading defined

= 1.1.1 =

* New: Plugin activation script
* Fix: Plugin no longer deactivates itself when EDD is updated
* Fix: When no cross-sell/upsell heading is specified there is no longer empty heading tags in the HTML
* Tweak: Removed unnecessary EDD licensing files
* Tweak: Updated translation file/s

= 1.1 =

* Fix: Incorrect cross-sell heading being shown at checkout when two cross-sell trigger products had exactly the same cross-sells
* New: Cross-sell/Upsell Reporting via Downloads -> reports. Select either Cross-sells or Upsells from the select menu
* New: Cross-sell/Upsell Exporting via Downloads -> reports -> export. Export Cross-sell or Upsell history
* New: Cross-sell/Upsell Logging via Downloads -> reports -> Logs. Select either Cross-sells or Upsells from the select menu
* New: "View Order Details" page via Downloads -> Payment History now shows you whether the order had cross-sells or upsells included
* Tweak: Updated translations

= 1.0.2 =

* New: edd_csau_upsell_show_button filter which allows you to hide or show the add to cart buttons.
* Tweak: Added apply_filters to download class to better match shortcode

= 1.0.1 =

* Fix: Changed priority of custom metabox to "high" so the select menu does not get cut off when there are many downloads, making it difficult to select downloads

= 1.0 =

* First release.
