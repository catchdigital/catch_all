# Catch All Profile

## Setup
Install required modules with composer. I have removed these from the composer file to allow projects to take full long term ownership of their dependencies.
````
composer require \
  drupal/admin_toolbar:^2.3 \
  drupal/advagg:^4.1 \
  drupal/focal_point:^1.4 \
  drupal/field_group:^3.1 \
  drupal/imageapi_optimize:^4.0@beta \
  drupal/imageapi_optimize_resmushit:^2.0@beta \
  drupal/paragraphs:^1.12 \
  drupal/metatag:^1.14 \
  drupal/pathauto:^1.8 \
  drupal/rabbit_hole:^1.0@beta \
  drupal/redirect:^1.6 \
  drupal/roleassign:^1.0@beta \
  drupal/seckit:^1.2 \
  drupal/simple_sitemap:^3.7 \
  drupal/smart_trim:^1.3 \
  drupal/stage_file_proxy:^1.0 \
  drupal/eu_cookie_compliance:^1.9 \
  drupal/hook_event_dispatcher:^2.2 \
  drupal/username_enumeration_prevention:^1.1 \
  drupal/linkit:^6.0.0 \
  drupal/http2_server_push:^1.1 \
  drupal/google_tag:^1.4
````
## Install
The recommended way to install this is to use the drush site-install command.
`drush si catch_all -y`

Other parameters you should consider using are:
- `--account-name`
- `--account-pass`
- `--site-mail`
- `--site-name`

## What's in the profile
### Content types
- Basic Page
- Content Page

### Media Types
This also has focal point and image optimisation set up out of the box for crops.
- Image
- File

### User Roles
- Administrator
- Product Owner
- Content Editor

### Modules
- admin_toolbar
- admin_toolbar_search
- admin_toolbar_tools
- advagg
- advagg_css_minify
- advagg_js_minify
- big_pipe
- block
- breakpoint
- ckeditor
- config
- config_translation
- content_translation
- content_moderation
- contextual
- core_event_dispatcher
- crop
- ctools
- dynamic_page_cache
- dblog
- editor
- entity_reference_revisions
- field
- field_group
- field_ui
- file
- filter
- focal_point
- google_tag
- hook_event_dispatcher
- http2_server_push
- image
- imageapi_optimize
- imageapi_optimize_resmushit
- inline_form_errors
- language
- link
- linkit
- locale
- media
- media_library
- menu_link_content
- menu_ui
- metatag
- metatag_dc
- metatag_hreflang
- metatag_open_graph
- metatag_twitter_cards
- node
- options
- page_cache
- path
- path_alias
- preprocess_event_dispatcher
- quickedit
- rabbit_hole
- redirect
- redirect_404
- responsive_image
- rh_media
- rh_node
- roleassign
- seckit
- settings_tray
- simple_sitemap
- smart_trim
- syslog
- system
- text
- token
- toolbar
- update
- user
- username_enumeration_prevention
- views_ui
- workflows
- pathauto
- views
- paragraphs
- eu_cookie_compliance

## Updating the profile
More information on creating a profile can be found here: https://www.drupal.org/docs/distributions/creating-distributions/how-to-write-a-drupal-installation-profile

1. Export your configuration.
2. Copy your configuration over to the profile `cp config/sync/* docroot/profiles/custom/catch_all/config/install`
3. Remove all UUIDs `find docroot/profiles/custom/catch_all/config/install -type f -exec sed -i '' '/^uuid:/d' {} \;`
4. Remove all _core `find docroot/profiles/custom/catch_all/config/install -type f -exec sed -i '' '/_core:/{N;d;}' {} \;`
5. Remove unneeded files `rm docroot/profiles/custom/catch_all/config/install/system.site.yml docroot/profiles/custom/catch_all/config/install/core.extension.yml`
6. Update catch_all.info.yml with any modules you have installed
