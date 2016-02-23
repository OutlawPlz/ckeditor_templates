<?php
/**
 * @file
 * Definition of \Drupal\ckeditor_templates\Plugin\CKEditorPlugin\Templates.
 */

namespace Drupal\ckeditor_templates\Plugin\CKEditorPlugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Templates" plugin.
 *
 * @CKEditorPlugin(
 *   id = "templates",
 *   label = @Translation("Templates")
 * )
 */
class Templates extends PluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface, CKEditorPluginConfigurableInterface {

  /**
   * Returns the buttons that this plugin provides, along with metadata.
   *
   * The metadata is used by the CKEditor module to generate a visual CKEditor
   * toolbar builder UI.
   *
   * @return array
   *   An array of buttons that are provided by this plugin. This will
   *   only be used in the administrative section for assembling the toolbar.
   *   Each button should by keyed by its CKEditor button name, and should
   *   contain an array of button properties, including:
   *   - label: A human-readable, translated button name.
   *   - image: An image for the button to be used in the toolbar.
   *   - image_rtl: If the image needs to have a right-to-left version, specify
   *     an alternative file that will be used in RTL editors.
   *   - image_alternative: If this button does not render as an image, specify
   *     an HTML string representing the contents of this button.
   *   - image_alternative_rtl: Similar to image_alternative, but a
   *     right-to-left version.
   *   - attributes: An array of HTML attributes which should be added to this
   *     button when rendering the button in the administrative section for
   *     assembling the toolbar.
   *   - multiple: Boolean value indicating if this button may be added multiple
   *     times to the toolbar. This typically is only applicable for dividers
   *     and group indicators.
   */
  public function getButtons() {
    return array(
      'Templates' => array(
        'label' => t('Templates'),
        'image' => drupal_get_path('module', 'ckeditor_templates') . '/js/plugins/templates/icons/templates.png',
      )
    );
  }

  /**
   * Indicates if this plugin is part of the optimized CKEditor build.
   *
   * Plugins marked as internal are implicitly loaded as part of CKEditor.
   *
   * @return bool
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * Returns a list of plugins this plugin requires.
   *
   * @param \Drupal\editor\Entity\Editor $editor
   *   A configured text editor object.
   * @return array
   *   An unindexed array of plugin names this plugin requires. Each plugin is
   *   is identified by its annotated ID.
   */
  public function getDependencies(Editor $editor) {
    return array();
  }

  /**
   * Returns a list of libraries this plugin requires.
   *
   * These libraries will be attached to the text_format element on which the
   * editor is being loaded.
   *
   * @param \Drupal\editor\Entity\Editor $editor
   *   A configured text editor object.
   * @return array
   *   An array of libraries suitable for usage in a render API #attached
   *   property.
   */
  public function getLibraries(Editor $editor) {
    return array();
  }

  /**
   * Returns the Drupal root-relative file path to the plugin JavaScript file.
   *
   * Note: this does not use a Drupal library because this uses CKEditor's API,
   * see http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.resourceManager.html#addExternal.
   *
   * @return string|FALSE
   *   The Drupal root-relative path to the file, FALSE if an internal plugin.
   */
  public function getFile() {
    return drupal_get_path('module', 'ckeditor_templates') . '/js/plugins/templates/plugin.js';
  }

  /**
   * Returns the additions to CKEDITOR.config for a specific CKEditor instance.
   *
   * The editor's settings can be retrieved via $editor->getSettings(), but be
   * aware that it may not yet contain plugin-specific settings, because the
   * user may not yet have configured the form.
   * If there are plugin-specific settings (verify with isset()), they can be
   * found at
   * @code
   * $settings = $editor->getSettings();
   * $plugin_specific_settings = $settings['plugins'][$plugin_id];
   * @endcode
   *
   * @param \Drupal\editor\Entity\Editor $editor
   *   A configured text editor object.
   * @return array
   *   A keyed array, whose keys will end up as keys under CKEDITOR.config.
   */
  public function getConfig(Editor $editor) {
    $config = array();

    $settings = $editor->getSettings();

    $config['templates'] = str_replace(' ', '', $settings['plugins']['templates']['templates']);
    $config['templates_files'] = $this->generateTemplatesPath($settings['plugins']['templates']['templates_files']);
    $config['templates_replaceContent'] = $settings['plugins']['templates']['templates_replaceContent'];

    return $config;
  }

  /**
   * Returns a settings form to configure this CKEditor plugin.
   *
   * If the plugin's behavior depends on extensive options and/or external data,
   * then the implementing module can choose to provide a separate, global
   * configuration page rather than per-text-editor settings. In that case, this
   * form should provide a link to the separate settings page.
   *
   * @param array $form
   *   An empty form array to be populated with a configuration form, if any.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The state of the entire filter administration form.
   * @param \Drupal\editor\Entity\Editor $editor
   *   A configured text editor object.
   *
   * @return array|FALSE
   *   A render array for the settings form, or FALSE if there is none.
   */
  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor) {
    $config = array();

    $config['name'] = 'default';
    $config['path'][] = '/' . drupal_get_path('module', 'ckeditor_templates') . '/js/plugins/templates/templates/default.js';
    $config['replace'] = TRUE;

    $settings = $editor->getSettings();

    if (isset($settings['plugins']['templates']['templates'])) {
      $config['name'] = $settings['plugins']['templates']['templates'];
    }

    $form['templates'] = array(
      '#title' => t('Name'),
      '#type' => 'textfield',
      '#default_value' => $config['name'],
      '#description' => t('Insert the <a href="http://docs.ckeditor.com/#!/api/CKEDITOR.config-cfg-templates">template\'s names</a> separated by comma.'),
      '#attached' => array(
        'library' => array('ckeditor_templates/ckeditor_templates.admin')
      )
    );

    if (isset($settings['plugins']['templates']['templates_files'])) {
      $config['path'] = $settings['plugins']['templates']['templates_files'];
    }

    $form['templates_files'] = array(
      '#title' => t('Path'),
      '#type' => 'textarea',
      '#default_value' => $config['path'],
      '#description' => t('Insert paths to your <a href="http://docs.ckeditor.com/#!/api/CKEDITOR.config-cfg-templates_files">templates files</a>, only one path per row.'),
      '#element_validate' => array(
        array($this, 'validateTemplatesPath')
      )
    );

    if (isset($settings['plugins']['templates']['templates_replaceContent'])) {
      $config['replace'] = $settings['plugins']['templates']['templates_replaceContent'];
    }

    $form['templates_replaceContent'] = array(
      '#title' => t('Replace content'),
      '#type' => 'checkbox',
      '#default_value' => $config['replace']
    );

    return $form;
  }

  /**
   * #element_validate handler for the "templates_path" element in settingsForm().
   */
  public function validateTemplatesPath(array $element, FormStateInterface $form_state) {
    if ($this->generateTemplatesPath($element['#value']) === FALSE) {
      $form_state->setError($element, t("The provided list of path doesn't exist."));
    }
  }

  /**
   * Builds the "templates_files" configuration.
   *
   * @see getConfig()
   *
   * @param string $paths
   *   The raw "templates_files" setting.
   * @return array|FALSE
   *   An array containing the "templates_files" configuration, or FALSE when
   *   the syntax is invalid.
   */
  protected function generateTemplatesPath($paths) {
    $paths_set = array();

    // The paths provided by the setting form are raw text, we should convert
    // them in an array and check they exist.
    $paths = trim($paths);
    $paths = str_replace(array("\r\n", "\r"), "\n", $paths);
    foreach (explode("\n", $paths) as $path) {
      $path = trim($path);

      // Ignore empty lines in between non-empty lines.
      if (empty($path)) {
        continue;
      }

      // Check if file exists.
      if (!file_exists(DRUPAL_ROOT . $path)) {
        return FALSE;
      }

      $paths_set[] = $path;
    }

    return $paths_set;
  }
}