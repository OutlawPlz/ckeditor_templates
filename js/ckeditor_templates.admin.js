/**
 * @file
 * CKEditor Templates admin behavior.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * Provides the summary for the "templates" plugin settings vertical tab.
   */
  Drupal.behaviors.ckeditorTemplatesSettingsSummary = {
    attach: function () {
      $('[data-ckeditor-plugin-id="templates"]').drupalSetSummary(function (context) {
        var templates = $('[data-drupal-selector="edit-editor-settings-plugins-templates-templates"]').val();

        if (templates.length === 0) {
          return Drupal.t('No templates configured');
        }
        else {
          return Drupal.t('Names: @templates', {'@templates': templates});
        }
      });
    }
  };

})(jQuery, Drupal, drupalSettings);
