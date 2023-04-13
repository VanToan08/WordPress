=== App Builder - Create Native Android & iOS Apps On The Flight ===
Contributors: appcheap, rnlab
Donate link: https://1.envato.market/x9JBRR
Tags: app builder, woocommerce app, news app, flutter, mobile builder, appcheap
Requires at least: 5.6
Tested up to: 6.0.3
Stable tag: 3.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 7.4

The most advanced drag & drop app builder. Create multi templates and app controls.

== Description ==

App builder works the same popular Page Builder in WordPress but it has a special UI/UX for your easy configuration/previews mobile app.

[App source code](https://1.envato.market/x9JBRR)

= Features =

* **Import pre design templates**

### Enable PHP HTTP Authorization Header

#### Shared Hosts

Most shared hosts have disabled the **HTTP Authorization Header** by default.

To enable this option you'll need to edit your **.htaccess** file by adding the following:

`
    RewriteEngine on
    RewriteCond %{HTTP:Authorization} ^(.*)
    RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]
`

#### WPEngine

To enable this option you'll need to edit your **.htaccess** file by adding the following (see https://github.com/Tmeister/wp-api-jwt-auth/issues/1):

`
    SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
`

== Installation ==

1. Install using the WordPress built-in Plugin installer, or Extract the zip file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to App Builder > Create New Template
4. Press the 'Configure' button.
5. Now you can drag and drop components from the left panel onto the mobile editor area.

== Upgrade Notice ==

Read carefully changelogs before upgrade plugin.

== Frequently Asked Questions ==

** Will App Builder work with RTL or other languages? **

Yeah! The app support multi languages

== Screenshots ==

1. List templates
2. App mode config
3. Layout config
4. Style config
5. Custom screen
6. Sidebar config
7. Theme config
8. Product list screen
9. Category screen
10. Product detail builder
11. Post single
12. Multiple page

== Changelog ==

= 3.3.0 - 09-Feb-2023 =
* Hotfix: Product list did not display if the site install AFC plugin

= 3.3.0 - 08-Feb-2023 =
* Add: Fields scale banner in category page
* Add: Sticky banner in general config
* Add: Show sub category screen
* Add: Block Divider and Product item in product detail
* Add: Chat GPT widget
* Improved: Config Appbar title
* Fix: Adding to cart
* Fix: Validate first name and last name to one character

= 3.2.2 - 16-Jan-2023 =
* Fix: Login Apple
* Fix: API REQUEST_DENIED get vendors

= 3.2.1 - 12-Dec-2022 =
* Fix: Get geolocation in vendor

= 3.2.0 - 06-Dec-2022 =
* Add: Razorpay confirm payment
* Fix: Conflict Google Ads Listing, REST AUTH API plugin
* Fix: Undefined property: AppBuilder\Vendor\DokanStore: :$base
* Feat: Support WooCommerce Booking
* Feat: add filter app_builder_register_user_data and action after register insert user to database
* Feat: Conditional product block by categories, acf, meta, isLogin
* Feat: Shopping video addon widget

= 3.1.0 - 23-Aug-2022 =
* Add: Api confirm payment gateway

= 3.0.2 - 16-Aug-2022 =
* Fixed: Get billing and shipping with Checkout Field Manager plugin

= 3.0.1 - 16-Aug-2022 =
* Add: Option on/off captcha
* Add: Query vendor store by name and categories

= 3.0.0 - 15-Aug-2022 =
* Add: Show ACF custom field on post item default
* Add: Show progress bar on post item detail
* Add: Captcha login, register, post, comment
* Add: API get course
* Add: API get quiz
* Add: Support query param with taxonomy name
* Add: filter nearby products
* Add: Show distance, duration in store
* Add: Validate captcha
* Improve: Check constant AUTH_KEY not defined
* Improve: Ensure roles data return as array
* Improve: Delete the persistent cart permanently.
* Chore: Rename post_types_to_delete_with_user => app_builder_post_types_to_delete_with_user
* Chore: sanitize_title add-ons label
* Chore: Only logged in customers who have purchased this product may write review

= 2.9.0 - 05-Jul-2022 =
* Add: API delete user
* Add: Login thought webview
* Add: Config Advanced Custom Fields in post
* Add: Block SKU in product detail screen
* Add: Add percent status type
* Add: Handle redirect on Webview
* Add: Enable Barcode and Qrcode on widget search product
* Add: Filter hide Ads and support Paid memberships pro plugin
* Support: CURCY – Multi Currency for WooCommerce PREMIUM version

= 2.8.0 - 26-Feb-2022 =
* Add: Select widget in App mode
* Add: Config auto play video, disable swiper slideshow, play video inline
* Add: Config type stock status ( Text, Progress bar)
* Add: Disable rating in widget vendor and vendor detail page
* Support: get local plugin avatar and default avatar

= 2.7.0 - 26-Feb-2022 =
* Support: API Flutter Store Manager

= 2.6.2 - 26-Feb-2022 =
* Chore: Update some wrong typo
* Improved: Check Woo multi currency active

= 2.6.1 - 25-Feb-2022 =
* Support: Get currencies CURCY - WooCommerce Multi Currency - Currency Switcher plugin
* Add: On/Off Custom flow checkout on App builder

= 2.6.0 - 23-Feb-2022 =
* Fix: Crash on WordPress 5.9.0
* Add: Config Size Admod block and Shortcode
* feat: Support Global Add-ons

= 2.5.2 - 14-Feb-2022 =
* Add: API Delivery app
* Improved: Login/Register Firebase phone number
* Chore: Config render blocks

= 2.5.1 - 11-Feb-2022 =
* Add: Shortcode ADS
* Add: Block ADS
* Chore: add price html in product variable

= 2.5.0 - 09-Feb-2022 =
* Feat: Get category vendor store WCFM, Dokan
* Improved: Config social widget and social in profile page
* Added: Config post related

= 2.4.1 - 25-Jan-2022 =
* Fixed: Get dokan vendor with status
* Chore: Test up to WordPress 5.9

= 2.4.0 - 25-Jan-2022 =
* Support: Digits plugin
* Feat: Update Requires PHP to 7.4
* Feat: Support cached categories
* Feat: Support cached settings
* Feat: Load awesome icon's data
* Add: filter app_builder_pre_categories_response
* Add: filter app_builder_prepare_userdata

= 2.2.2 - 09-Jan-2022 =
* Fixed: function WC() not exits

= 2.2.1 - 07-Jan-2022 =
* Support: Multi-Currency with WooCommerce Payments
* Fixed: Change currency via URL

= 2.2.0 - 07-Jan-2022 =
* Chore: update default layout category page
* Chore: Default off input quantity on product list
* Support: Select thumb size for product list
* Add: Set Currency with URL-Parameter

= 2.1.0 - 06-Jan-2022 =
* Support: Product photo review

= 2.0.2 - 03-Jan-2022 =
* Add: Add filter app_builder_prepare_address_fields_response (Prepare address fields before response)

= 2.0.1 - 22-Dec-2021 =
* Fixed: Convert currency

= 2.0.0 - 22-Dec-2021 =
* Improved: Get template data

= 1.2.2 - 12-Dec-2021 =
* Fixed: Get attribute image

= 1.2.1 - 07-Dec-2021 =
* Chore: Show app version

= 1.2.0 - 03-Dec-2021 =
* Fixed: Add to cart with product variable
* Fixed: Token expired

= 1.1.9 - 25-Nov-2021 =
* Fixed: Change currency in product variable
* Fixed: Token expired

= 1.1.8 - 01-Nov-2021 =
* Support: Define currencies

= 1.1.6 - 01-Nov-2021 =
* Support: Define support languages

= 1.1.5 - 20-Seb-2021 =
* Fix: Banner, avatar vendor did not display in WCMp plugin

= 1.1.4 - 19-Seb-2021 =
* Docs: wp-content/plugins/app-builder/vendor/symfony/polyfill-mbstring/bootstrap80.php.sample => wp-content/plugins/app-builder/vendor/symfony/polyfill-mbstring/bootstrap80.php

= 1.1.3 - 19-Seb-2021 =
* Fixed: Memory size exhausted on PHP Version 8.0.9

= 1.1.1 - 19-Seb-2021 =
* Chore: Update contribute
* Chore: Test up WordPress 5.8.1

= 1.1.0 - 28-Aug-2021 =
* Improved: Get product variation

= 1.0.31 - 20-Aug-2021 =
* add: API clean cart
* fix: navigate user logged in Arabic to check out page

= 1.0.30 - 19-Aug-2021 =
* fix: Translate attribute label
* fix: Product image not exist

= 1.0.29 =
* Improved: make integer value for vendor store id

= 1.0.27 =
* Add: Sync Auth Webview
* Add: Contact default layout without Map
* Add: Force login Add To Cart
* Add: On/Off Quick view
* Add: Screen Quick View builder
* Add: Config Featured Product In Layout product builder

= 1.0.26 =
* Add: Add action register success `app_builder_register_success`

= 1.0.25 =
* Fix: product variation return empty array

= 1.0.23 =
* Feature: Add image, color attribute type to API
* Feature: Restore Country, State, City, Postcode to billing and shipping when checkout

= 1.0.22 =
* Chore: Update caption image

= 1.0.21 =
* Add: API get country locate
* Chore: Test up version Wordpress

= 1.0.20 =
* Feature: Support custom post types

= 1.0.19 =
* Chore: define role and manage option

= 1.0.18 =
* Update: set default role for user register

= 1.0.17 =
* Add: API update customer info
* Add: class to body in checkout page
* Add: API login via token

= 1.0.16 =
* Add-ons: Working together "JWT Authentication for WP REST API" plugin

= 1.0.15 =
* Add: API get vendor WCMp
* Fix: Illegal string offset banner

= 1.0.14 =
* Add: Get products by vendor id

= 1.0.13 =
* Improvement: Get Apple public key
* Add: API get vendor Dokan
* Add: API get vendor WCFM

= 1.0.12 =
* Chore: Get all thumbs size registered

= 1.0.11 =
* Add: Support Content Egg plugin

= 1.0.10 =
* Fix: Get JWT config
* Add: Login via Token

= 1.0.9 =
* Add: Update style checkout page

= 1.0.8 =
* Add: API lost password

= 1.0.7 =
* Fixed: Exhausted memory on PHP8

= 1.0.6 =
* Improved: Ensure attribute turn return in array

= 1.0.5 =
* Improved: List language for site only single language => Help fix issue on app

= 1.0.4 =
* Chore: remove download build when active to reduce time setup
* Added: Prepare currency for product object
* Added: Get default Wc currency

= 1.0.3 =
* Fixed: Download build app

= 1.0.2 =
* Fixed: Decode token

= 1.0.1 =
* Fixed: PHP Notice - Undefined property $plugin_name
* Fixed: Url placeholder image

= 1.0.0 =
* Initial release.