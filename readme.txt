=== SublimePlusV2 — Precast Al Turab ===
Contributors: bitandbytelab
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 8.1
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Theme for precastalturab.ae. Precast-specific features live in inc/precast/:
class-precast.php (core, registers every hook through Precast_Loader),
class-precast-loader.php, and one class per feature (Site, SEO, Meta, RFQ,
Settings, Sections). Template helper functions are in the matching
settings.php / seo.php / meta.php / rfq.php / site.php / sections.php files.

== Changelog ==

= 1.1.0 — 2026-11-07 =
* Refactor: all Precast hooks registered through Precast_Loader in the core
  class (define_shared_hooks / define_admin_hooks / define_public_hooks /
  define_shortcodes); every callback is a named method, no closures.
* Version constant PRECAST_VERSION.
* WhatsApp number +971 54 348 8946 everywhere; second phone number.
* Client About text, Why section, tagline and slogan.
* Factory location (Al Sajaa, Sharjah) in footer, contact page and schema.
* Quote form and contact page in the reference-site layout; sticky header;
  EN / Arabic switch; client logo and product images; 3D banner.

= 1.0.0 — 2026-11-06 =
* Precast Al Turab redesign: heavy-precast homepage, product and project
  templates, RFQ form with uploads, SEO and schema, new pages.
