<?php return array (
  '58e6a6574f7fc2929bc0631cfb7016c2' => 
  array (
    'criteria' => 
    array (
      'name' => 'tinymce',
    ),
    'object' => 
    array (
      'name' => 'tinymce',
      'path' => '{core_path}components/tinymce/',
    ),
  ),
  '51d45ac38677903221a8b53d9e2d819d' => 
  array (
    'criteria' => 
    array (
      'name' => 'TinyMCE',
    ),
    'object' => 
    array (
      'id' => 1,
      'source' => 0,
      'property_preprocess' => 0,
      'name' => 'TinyMCE',
      'description' => 'TinyMCE 4.3.1-pl plugin for MODx Revolution',
      'editor_type' => 0,
      'category' => 0,
      'cache_type' => 0,
      'plugincode' => '/**
 * TinyMCE RichText Editor Plugin
 *
 * Events: OnRichTextEditorInit, OnRichTextEditorRegister,
 * OnBeforeManagerPageInit, OnRichTextBrowserInit
 *
 * @author Jeff Whitfield <jeff@collabpad.com>
 * @author Shaun McCormick <shaun@collabpad.com>
 *
 * @package tinymce
 * @subpackage build
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'TinyMCE\');
    return;
}
require_once $modx->getOption(\'tiny.core_path\',null,$modx->getOption(\'core_path\').\'components/tinymce/\').\'tinymce.class.php\';
$tiny = new TinyMCE($modx,$scriptProperties);

$useEditor = $modx->getOption(\'use_editor\',null,false);
$whichEditor = $modx->getOption(\'which_editor\',null,\'\');

/* Handle event */
switch ($modx->event->name) {
    case \'OnRichTextEditorInit\':
        if ($useEditor && $whichEditor == \'TinyMCE\') {
            unset($scriptProperties[\'chunk\']);
            if (isset($forfrontend) || $modx->context->get(\'key\') != \'mgr\') {
                $def = $modx->getOption(\'cultureKey\',null,$modx->getOption(\'manager_language\',null,\'en\'));
                $tiny->properties[\'language\'] = $modx->getOption(\'fe_editor_lang\',array(),$def);
                $tiny->properties[\'frontend\'] = true;
                unset($def);
            }
            /* commenting these out as it causes problems with richtext tvs */
            //if (isset($scriptProperties[\'resource\']) && !$resource->get(\'richtext\')) return;
            //if (!isset($scriptProperties[\'resource\']) && !$modx->getOption(\'richtext_default\',null,false)) return;
            $tiny->setProperties($scriptProperties);
            $html = $tiny->initialize();
            $modx->event->output($html);
            unset($html);
        }
        break;
    case \'OnRichTextBrowserInit\':
        if ($useEditor && $whichEditor == \'TinyMCE\') {
            $inRevo20 = (boolean)version_compare($modx->version[\'full_version\'],\'2.1.0-rc1\',\'<\');
            $modx->getVersionData();
            $source = $modx->getOption(\'default_media_source\',null,1);
            
            $modx->controller->addHtml(\'<script type="text/javascript">var inRevo20 = \'.($inRevo20 ? 1 : 0).\';MODx.source = "\'.$source.\'";</script>\');
            
            $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'jscripts/tiny_mce/tiny_mce_popup.js\');
            if (file_exists($tiny->config[\'assetsPath\'].\'jscripts/tiny_mce/langs/\'.$tiny->properties[\'language\'].\'.js\')) {
                $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'jscripts/tiny_mce/langs/\'.$tiny->properties[\'language\'].\'.js\');
            } else {
                $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'jscripts/tiny_mce/langs/en.js\');
            }
            $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'tiny.browser.js\');
            $modx->event->output(\'Tiny.browserCallback\');
        }
        return \'\';
        break;

   default: break;
}
return;',
      'locked' => 0,
      'properties' => 'a:39:{s:22:"accessibility_warnings";a:6:{s:4:"name";s:22:"accessibility_warnings";s:4:"desc";s:315:"If this option is set to true some accessibility warnings will be presented to the user if they miss specifying that information. This option is set to true by default, since we should all try to make this world a better place for disabled people. But if you are annoyed with the warnings, set this option to false.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:23:"apply_source_formatting";a:6:{s:4:"name";s:23:"apply_source_formatting";s:4:"desc";s:229:"This option enables you to tell TinyMCE to apply some source formatting to the output HTML code. With source formatting, the output HTML code is indented and formatted. Without source formatting, the output HTML is more compact. ";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:15:"button_tile_map";a:6:{s:4:"name";s:15:"button_tile_map";s:4:"desc";s:338:"If this option is set to true TinyMCE will use tiled images instead of individual images for most of the editor controls. This produces faster loading time since only one GIF image needs to be loaded instead of a GIF for each individual button. This option is set to false by default since it doesn\'t work with some DOCTYPE declarations. ";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:7:"cleanup";a:6:{s:4:"name";s:7:"cleanup";s:4:"desc";s:331:"This option enables or disables the built-in clean up functionality. TinyMCE is equipped with powerful clean up functionality that enables you to specify what elements and attributes are allowed and how HTML contents should be generated. This option is set to true by default, but if you want to disable it you may set it to false.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:18:"cleanup_on_startup";a:6:{s:4:"name";s:18:"cleanup_on_startup";s:4:"desc";s:135:"If you set this option to true, TinyMCE will perform a HTML cleanup call when the editor loads. This option is set to false by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:22:"convert_fonts_to_spans";a:6:{s:4:"name";s:22:"convert_fonts_to_spans";s:4:"desc";s:348:"If you set this option to true, TinyMCE will convert all font elements to span elements and generate span elements instead of font elements. This option should be used in order to get more W3C compatible code, since font elements are deprecated. How sizes get converted can be controlled by the font_size_classes and font_size_style_values options.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:23:"convert_newlines_to_brs";a:6:{s:4:"name";s:23:"convert_newlines_to_brs";s:4:"desc";s:128:"If you set this option to true, newline characters codes get converted into br elements. This option is set to false by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:12:"convert_urls";a:6:{s:4:"name";s:12:"convert_urls";s:4:"desc";s:495:"This option enables you to control whether TinyMCE is to be clever and restore URLs to their original values. URLs are automatically converted (messed up) by default because the built-in browser logic works this way. There is no way to get the real URL unless you store it away. If you set this option to false it will try to keep these URLs intact. This option is set to true by default, which means URLs will be forced to be either absolute or relative depending on the state of relative_urls.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:11:"dialog_type";a:6:{s:4:"name";s:11:"dialog_type";s:4:"desc";s:246:"This option enables you to specify how dialogs/popups should be opened. Possible values are "window" and "modal", where the window option opens a normal window and the dialog option opens a modal dialog. This option is set to "window" by default.";s:4:"type";s:4:"list";s:7:"options";a:2:{i:0;a:2:{s:4:"name";s:6:"Window";i:0;s:6:"window";}i:1;a:2:{s:4:"name";s:5:"Modal";i:0;s:5:"modal";}}s:5:"value";s:6:"window";s:7:"lexicon";N;}s:14:"directionality";a:6:{s:4:"name";s:14:"directionality";s:4:"desc";s:261:"This option specifies the default writing direction. Some languages (Like Hebrew, Arabic, Urdu...) write from right to left instead of left to right. The default value of this option is "ltr" but if you want to use from right to left mode specify "rtl" instead.";s:4:"type";s:4:"list";s:7:"options";a:2:{i:0;a:2:{s:4:"name";s:13:"Left to Right";s:5:"value";s:3:"ltr";}i:1;a:2:{s:4:"name";s:13:"Right to Left";s:5:"value";s:3:"rtl";}}s:5:"value";s:3:"ltr";s:7:"lexicon";N;}s:14:"element_format";a:6:{s:4:"name";s:14:"element_format";s:4:"desc";s:210:"This option enables control if elements should be in html or xhtml mode. xhtml is the default state for this option. This means that for example &lt;br /&gt; will be &lt;br&gt; if you set this option to "html".";s:4:"type";s:4:"list";s:7:"options";a:2:{i:0;a:2:{s:4:"name";s:5:"XHTML";s:5:"value";s:5:"xhtml";}i:1;a:2:{s:4:"name";s:4:"HTML";s:5:"value";s:4:"html";}}s:5:"value";s:5:"xhtml";s:7:"lexicon";N;}s:15:"entity_encoding";a:6:{s:4:"name";s:15:"entity_encoding";s:4:"desc";s:70:"This option controls how entities/characters get processed by TinyMCE.";s:4:"type";s:4:"list";s:7:"options";a:4:{i:0;a:2:{s:4:"name";s:4:"None";s:5:"value";s:0:"";}i:1;a:2:{s:4:"name";s:5:"Named";s:5:"value";s:5:"named";}i:2;a:2:{s:4:"name";s:7:"Numeric";s:5:"value";s:7:"numeric";}i:3;a:2:{s:4:"name";s:3:"Raw";s:5:"value";s:3:"raw";}}s:5:"value";s:0:"";s:7:"lexicon";N;}s:16:"force_p_newlines";a:6:{s:4:"name";s:16:"force_p_newlines";s:4:"desc";s:147:"This option enables you to disable/enable the creation of paragraphs on return/enter in Mozilla/Firefox. The default value of this option is true. ";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:22:"force_hex_style_colors";a:6:{s:4:"name";s:22:"force_hex_style_colors";s:4:"desc";s:277:"This option enables you to control TinyMCE to force the color format to use hexadecimal instead of rgb strings. It converts for example "color: rgb(255, 255, 0)" to "#FFFF00". This option is set to true by default since otherwice MSIE and Firefox would differ in this behavior.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:6:"height";a:6:{s:4:"name";s:6:"height";s:4:"desc";s:38:"Sets the height of the TinyMCE editor.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:5:"400px";s:7:"lexicon";N;}s:11:"indentation";a:6:{s:4:"name";s:11:"indentation";s:4:"desc";s:139:"This option allows specification of the indentation level for indent/outdent buttons in the UI. This defaults to 30px but can be any value.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:4:"30px";s:7:"lexicon";N;}s:16:"invalid_elements";a:6:{s:4:"name";s:16:"invalid_elements";s:4:"desc";s:163:"This option should contain a comma separated list of element names to exclude from the content. Elements in this list will removed when TinyMCE executes a cleanup.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:0:"";s:7:"lexicon";N;}s:6:"nowrap";a:6:{s:4:"name";s:6:"nowrap";s:4:"desc";s:212:"This nowrap option enables you to control how whitespace is to be wordwrapped within the editor. This option is set to false by default, but if you enable it by setting it to true editor contents will never wrap.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:15:"object_resizing";a:6:{s:4:"name";s:15:"object_resizing";s:4:"desc";s:148:"This option gives you the ability to turn on/off the inline resizing controls of tables and images in Firefox/Mozilla. These are enabled by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:12:"path_options";a:6:{s:4:"name";s:12:"path_options";s:4:"desc";s:119:"Sets a group of options. Note: This will override the relative_urls, document_base_url and remove_script_host settings.";s:4:"type";s:9:"textfield";s:7:"options";a:3:{i:0;a:2:{s:4:"name";s:17:"Document Relative";s:5:"value";s:11:"docrelative";}i:1;a:2:{s:4:"name";s:13:"Root Relative";s:5:"value";s:12:"rootrelative";}i:2;a:2:{s:4:"name";s:13:"Full Path URL";s:5:"value";s:11:"fullpathurl";}}s:5:"value";s:11:"docrelative";s:7:"lexicon";N;}s:28:"plugin_insertdate_dateFormat";a:6:{s:4:"name";s:28:"plugin_insertdate_dateFormat";s:4:"desc";s:53:"Formatting of dates when using the InsertDate plugin.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:8:"%Y-%m-%d";s:7:"lexicon";N;}s:28:"plugin_insertdate_timeFormat";a:6:{s:4:"name";s:28:"plugin_insertdate_timeFormat";s:4:"desc";s:53:"Formatting of times when using the InsertDate plugin.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:8:"%H:%M:%S";s:7:"lexicon";N;}s:12:"preformatted";a:6:{s:4:"name";s:12:"preformatted";s:4:"desc";s:231:"If you enable this feature, whitespace such as tabs and spaces will be preserved. Much like the behavior of a &lt;pre&gt; element. This can be handy when integrating TinyMCE with webmail clients. This option is disabled by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:13:"relative_urls";a:6:{s:4:"name";s:13:"relative_urls";s:4:"desc";s:231:"If this option is set to true, all URLs returned from the file manager will be relative from the specified document_base_url. If it is set to false all URLs will be converted to absolute URLs. This option is set to true by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:17:"remove_linebreaks";a:6:{s:4:"name";s:17:"remove_linebreaks";s:4:"desc";s:531:"This option controls whether line break characters should be removed from output HTML. This option is enabled by default because there are differences between browser implementations regarding what to do with white space in the DOM. Gecko and Safari place white space in text nodes in the DOM. IE and Opera remove them from the DOM and therefore the line breaks will automatically be removed in those. This option will normalize this behavior when enabled (true) and all browsers will have a white-space-stripped DOM serialization.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:18:"remove_script_host";a:6:{s:4:"name";s:18:"remove_script_host";s:4:"desc";s:221:"If this option is enabled the protocol and host part of the URLs returned from the file manager will be removed. This option is only used if the relative_urls option is set to false. This option is set to true by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:20:"remove_trailing_nbsp";a:6:{s:4:"name";s:20:"remove_trailing_nbsp";s:4:"desc";s:392:"This option enables you to specify that TinyMCE should remove any traling &nbsp; characters in block elements if you start to write inside them. Paragraphs are default padded with a &nbsp; and if you write text into such paragraphs the space will remain. Setting this option to true will remove the space. This option is set to false by default since the cursor jumps a bit in Gecko browsers.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:0;s:7:"lexicon";N;}s:4:"skin";a:6:{s:4:"name";s:4:"skin";s:4:"desc";s:330:"This option enables you to specify what skin you want to use with your theme. A skin is basically a CSS file that gets loaded from the skins directory inside the theme. The advanced theme that TinyMCE comes with has two skins, these are called "default" and "o2k7". We added another skin named "cirkuit" that is chosen by default.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:7:"cirkuit";s:7:"lexicon";N;}s:12:"skin_variant";a:6:{s:4:"name";s:12:"skin_variant";s:4:"desc";s:403:"This option enables you to specify a variant for the skin, for example "silver" or "black". "default" skin does not offer any variant, whereas "o2k7" default offers "silver" or "black" variants to the default one. For the "cirkuit" skin there\'s one variant named "silver". When creating a skin, additional variants may also be created, by adding ui_[variant_name].css files alongside the default ui.css.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:0:"";s:7:"lexicon";N;}s:20:"table_inline_editing";a:6:{s:4:"name";s:20:"table_inline_editing";s:4:"desc";s:231:"This option gives you the ability to turn on/off the inline table editing controls in Firefox/Mozilla. According to the TinyMCE documentation, these controls are somewhat buggy and not redesignable, so they are disabled by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:22:"theme_advanced_disable";a:6:{s:4:"name";s:22:"theme_advanced_disable";s:4:"desc";s:111:"This option should contain a comma separated list of controls to disable from any toolbar row/panel in TinyMCE.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:0:"";s:7:"lexicon";N;}s:19:"theme_advanced_path";a:6:{s:4:"name";s:19:"theme_advanced_path";s:4:"desc";s:331:"This option gives you the ability to enable/disable the element path. This option is only useful if the theme_advanced_statusbar_location option is set to "top" or "bottom". This option is set to "true" by default. Setting this option to "false" will effectively hide the path tool, though it still takes up room in the Status Bar.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:32:"theme_advanced_resize_horizontal";a:6:{s:4:"name";s:32:"theme_advanced_resize_horizontal";s:4:"desc";s:319:"This option gives you the ability to enable/disable the horizontal resizing. This option is only useful if the theme_advanced_statusbar_location option is set to "top" or "bottom" and when the theme_advanced_resizing is set to true. This option is set to true by default, allowing both resizing horizontal and vertical.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:23:"theme_advanced_resizing";a:6:{s:4:"name";s:23:"theme_advanced_resizing";s:4:"desc";s:216:"This option gives you the ability to enable/disable the resizing button. This option is only useful if the theme_advanced_statusbar_location option is set to "top" or "bottom". This option is set to false by default.";s:4:"type";s:13:"combo-boolean";s:7:"options";s:0:"";s:5:"value";b:1;s:7:"lexicon";N;}s:33:"theme_advanced_statusbar_location";a:6:{s:4:"name";s:33:"theme_advanced_statusbar_location";s:4:"desc";s:257:"This option enables you to specify where the element statusbar with the path and resize tool should be located. This option can be set to "top" or "bottom". The default value is set to "top". This option can only be used when the theme is set to "advanced".";s:4:"type";s:4:"list";s:7:"options";a:2:{i:0;a:2:{s:4:"name";s:3:"Top";s:5:"value";s:3:"top";}i:1;a:2:{s:4:"name";s:6:"Bottom";s:5:"value";s:6:"bottom";}}s:5:"value";s:6:"bottom";s:7:"lexicon";N;}s:28:"theme_advanced_toolbar_align";a:6:{s:4:"name";s:28:"theme_advanced_toolbar_align";s:4:"desc";s:187:"This option enables you to specify the alignment of the toolbar, this value can be "left", "right" or "center" (the default). This option can only be used when theme is set to "advanced".";s:4:"type";s:9:"textfield";s:7:"options";a:3:{i:0;a:2:{s:4:"name";s:6:"Center";s:5:"value";s:6:"center";}i:1;a:2:{s:4:"name";s:4:"Left";s:5:"value";s:4:"left";}i:2;a:2:{s:4:"name";s:5:"Right";s:5:"value";s:5:"right";}}s:5:"value";s:4:"left";s:7:"lexicon";N;}s:31:"theme_advanced_toolbar_location";a:6:{s:4:"name";s:31:"theme_advanced_toolbar_location";s:4:"desc";s:191:"
This option enables you to specify where the toolbar should be located. This option can be set to "top" or "bottom" (the defualt). This option can only be used when theme is set to advanced.";s:4:"type";s:4:"list";s:7:"options";a:2:{i:0;a:2:{s:4:"name";s:3:"Top";s:5:"value";s:3:"top";}i:1;a:2:{s:4:"name";s:6:"Bottom";s:5:"value";s:6:"bottom";}}s:5:"value";s:3:"top";s:7:"lexicon";N;}s:5:"width";a:6:{s:4:"name";s:5:"width";s:4:"desc";s:32:"The width of the TinyMCE editor.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:3:"95%";s:7:"lexicon";N;}s:33:"template_selected_content_classes";a:6:{s:4:"name";s:33:"template_selected_content_classes";s:4:"desc";s:234:"Specify a list of CSS class names for the template plugin. They must be separated by spaces. Any template element with one of the specified CSS classes will have its content replaced by the selected editor content when first inserted.";s:4:"type";s:9:"textfield";s:7:"options";s:0:"";s:5:"value";s:0:"";s:7:"lexicon";N;}}',
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => '',
      'content' => '/**
 * TinyMCE RichText Editor Plugin
 *
 * Events: OnRichTextEditorInit, OnRichTextEditorRegister,
 * OnBeforeManagerPageInit, OnRichTextBrowserInit
 *
 * @author Jeff Whitfield <jeff@collabpad.com>
 * @author Shaun McCormick <shaun@collabpad.com>
 *
 * @package tinymce
 * @subpackage build
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'TinyMCE\');
    return;
}
require_once $modx->getOption(\'tiny.core_path\',null,$modx->getOption(\'core_path\').\'components/tinymce/\').\'tinymce.class.php\';
$tiny = new TinyMCE($modx,$scriptProperties);

$useEditor = $modx->getOption(\'use_editor\',null,false);
$whichEditor = $modx->getOption(\'which_editor\',null,\'\');

/* Handle event */
switch ($modx->event->name) {
    case \'OnRichTextEditorInit\':
        if ($useEditor && $whichEditor == \'TinyMCE\') {
            unset($scriptProperties[\'chunk\']);
            if (isset($forfrontend) || $modx->context->get(\'key\') != \'mgr\') {
                $def = $modx->getOption(\'cultureKey\',null,$modx->getOption(\'manager_language\',null,\'en\'));
                $tiny->properties[\'language\'] = $modx->getOption(\'fe_editor_lang\',array(),$def);
                $tiny->properties[\'frontend\'] = true;
                unset($def);
            }
            /* commenting these out as it causes problems with richtext tvs */
            //if (isset($scriptProperties[\'resource\']) && !$resource->get(\'richtext\')) return;
            //if (!isset($scriptProperties[\'resource\']) && !$modx->getOption(\'richtext_default\',null,false)) return;
            $tiny->setProperties($scriptProperties);
            $html = $tiny->initialize();
            $modx->event->output($html);
            unset($html);
        }
        break;
    case \'OnRichTextBrowserInit\':
        if ($useEditor && $whichEditor == \'TinyMCE\') {
            $inRevo20 = (boolean)version_compare($modx->version[\'full_version\'],\'2.1.0-rc1\',\'<\');
            $modx->getVersionData();
            $source = $modx->getOption(\'default_media_source\',null,1);
            
            $modx->controller->addHtml(\'<script type="text/javascript">var inRevo20 = \'.($inRevo20 ? 1 : 0).\';MODx.source = "\'.$source.\'";</script>\');
            
            $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'jscripts/tiny_mce/tiny_mce_popup.js\');
            if (file_exists($tiny->config[\'assetsPath\'].\'jscripts/tiny_mce/langs/\'.$tiny->properties[\'language\'].\'.js\')) {
                $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'jscripts/tiny_mce/langs/\'.$tiny->properties[\'language\'].\'.js\');
            } else {
                $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'jscripts/tiny_mce/langs/en.js\');
            }
            $modx->controller->addJavascript($tiny->config[\'assetsUrl\'].\'tiny.browser.js\');
            $modx->event->output(\'Tiny.browserCallback\');
        }
        return \'\';
        break;

   default: break;
}
return;',
    ),
    'files' => 
    array (
      0 => 'c:/wamp/www/OHM/core/components',
    ),
  ),
  '48e85f4ff961ab35e54fd74218f8b345' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 1,
      'event' => 'OnRichTextBrowserInit',
    ),
    'object' => 
    array (
      'pluginid' => 1,
      'event' => 'OnRichTextBrowserInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '92d9d544a53e6859c8ae0488cad2f54a' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 1,
      'event' => 'OnRichTextEditorRegister',
    ),
    'object' => 
    array (
      'pluginid' => 1,
      'event' => 'OnRichTextEditorRegister',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '37e27494273422951fb7df0f6d12d193' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 1,
      'event' => 'OnRichTextEditorInit',
    ),
    'object' => 
    array (
      'pluginid' => 1,
      'event' => 'OnRichTextEditorInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '47e47cd924578b130ca8ecbab61b762c' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.base_url',
    ),
    'object' => 
    array (
      'key' => 'tiny.base_url',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '3f683a8754760adc416d50ae91ef3f54' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.convert_fonts_to_spans',
    ),
    'object' => 
    array (
      'key' => 'tiny.convert_fonts_to_spans',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'f8b16735449b554f6508c41727bb4633' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.convert_newlines_to_brs',
    ),
    'object' => 
    array (
      'key' => 'tiny.convert_newlines_to_brs',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'b8df18606e1f046a7b2127eaadbb4d46' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.css_selectors',
    ),
    'object' => 
    array (
      'key' => 'tiny.css_selectors',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'advanced-theme',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '21324f6b67315e7d0439aceb20040c04' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.custom_buttons1',
    ),
    'object' => 
    array (
      'key' => 'tiny.custom_buttons1',
      'value' => 'undo,redo,selectall,separator,pastetext,pasteword,separator,search,replace,separator,nonbreaking,hr,charmap,separator,image,modxlink,unlink,anchor,media,separator,cleanup,removeformat,separator,fullscreen,print,code,help',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'custom-buttons',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'a6ef793e1b2d61fae363a3c4acf83d38' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.custom_buttons2',
    ),
    'object' => 
    array (
      'key' => 'tiny.custom_buttons2',
      'value' => 'bold,italic,underline,strikethrough,sub,sup,separator,bullist,numlist,outdent,indent,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,styleselect,formatselect,separator,styleprops',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'custom-buttons',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '3b437400a786d50ae437ea6a996f202c' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.custom_buttons3',
    ),
    'object' => 
    array (
      'key' => 'tiny.custom_buttons3',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'custom-buttons',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '2c702596f428ef58d5e0b32854aabbf3' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.custom_buttons4',
    ),
    'object' => 
    array (
      'key' => 'tiny.custom_buttons4',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'custom-buttons',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'e7a822651096ae53965084a710bc5680' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.custom_buttons5',
    ),
    'object' => 
    array (
      'key' => 'tiny.custom_buttons5',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'custom-buttons',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'fe97c85062f4965fd35532121fb674f8' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.custom_plugins',
    ),
    'object' => 
    array (
      'key' => 'tiny.custom_plugins',
      'value' => 'style,advimage,advlink,modxlink,searchreplace,print,contextmenu,paste,fullscreen,noneditable,nonbreaking,xhtmlxtras,visualchars,media',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '977b1231de050fe5a31e11b32a415475' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.editor_theme',
    ),
    'object' => 
    array (
      'key' => 'tiny.editor_theme',
      'value' => 'advanced',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'ff59d5b3d96743a0b94db1463b834616' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.element_format',
    ),
    'object' => 
    array (
      'key' => 'tiny.element_format',
      'value' => 'xhtml',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '78f6f093491d5a553cbaa9edba55b311' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.entity_encoding',
    ),
    'object' => 
    array (
      'key' => 'tiny.entity_encoding',
      'value' => 'named',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'f6d62f31116ea8a0509eb22338b7ef97' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.fix_nesting',
    ),
    'object' => 
    array (
      'key' => 'tiny.fix_nesting',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '4e1fb262708700cb8e7960987511bded' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.fix_table_elements',
    ),
    'object' => 
    array (
      'key' => 'tiny.fix_table_elements',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '4198a71c3afde41b7477f3616db44282' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.font_size_classes',
    ),
    'object' => 
    array (
      'key' => 'tiny.font_size_classes',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '584e2822c95a21ed6b5314bdb9df6915' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.font_size_style_values',
    ),
    'object' => 
    array (
      'key' => 'tiny.font_size_style_values',
      'value' => 'xx-small,x-small,small,medium,large,x-large,xx-large',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '984a69018999b4e81a5308f37ca01318' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.forced_root_block',
    ),
    'object' => 
    array (
      'key' => 'tiny.forced_root_block',
      'value' => 'p',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '20eef7962ba739b196e0cbf28e668de0' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.indentation',
    ),
    'object' => 
    array (
      'key' => 'tiny.indentation',
      'value' => '30px',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '407f964fcb6e70bb002c5f435550ec48' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.invalid_elements',
    ),
    'object' => 
    array (
      'key' => 'tiny.invalid_elements',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '682cab10aed05e8edd5aac535c6d8cba' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.nowrap',
    ),
    'object' => 
    array (
      'key' => 'tiny.nowrap',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '52f0048e789a07a49e98ebf0aec08f7a' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.object_resizing',
    ),
    'object' => 
    array (
      'key' => 'tiny.object_resizing',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '48175163ae254832dc82444059f06540' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.path_options',
    ),
    'object' => 
    array (
      'key' => 'tiny.path_options',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '09f8d9f73ca9b1c85f096ad649ad9e29' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.remove_linebreaks',
    ),
    'object' => 
    array (
      'key' => 'tiny.remove_linebreaks',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'f39171c16a54efc4278d41e33646d089' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.remove_redundant_brs',
    ),
    'object' => 
    array (
      'key' => 'tiny.remove_redundant_brs',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '2cd56f0e18c8a1edebf7e22ac1398ac4' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.removeformat_selector',
    ),
    'object' => 
    array (
      'key' => 'tiny.removeformat_selector',
      'value' => 'b,strong,em,i,span,ins',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'cleanup-output',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'bcdf49dcb6e93dc708265b0092b9bce0' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.skin',
    ),
    'object' => 
    array (
      'key' => 'tiny.skin',
      'value' => 'cirkuit',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '58dce6895ecf1bbd5f74bde5be696c56' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.skin_variant',
    ),
    'object' => 
    array (
      'key' => 'tiny.skin_variant',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '5776102ac852e7f30b12cd4536b3f186' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.table_inline_editing',
    ),
    'object' => 
    array (
      'key' => 'tiny.table_inline_editing',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '83a12430847e3f5bbf26bc60d81b8b31' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.template_list',
    ),
    'object' => 
    array (
      'key' => 'tiny.template_list',
      'value' => '',
      'xtype' => 'textarea',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '7c775c56896bbd2e94d41423bf449b06' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.template_list_snippet',
    ),
    'object' => 
    array (
      'key' => 'tiny.template_list_snippet',
      'value' => '',
      'xtype' => 'textarea',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'd54e8474ec8f6cac4d7915b4e38bf29d' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.template_selected_content_classes',
    ),
    'object' => 
    array (
      'key' => 'tiny.template_selected_content_classes',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  'e257303571bc5534dfaa7cb842235fee' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.theme_advanced_blockformats',
    ),
    'object' => 
    array (
      'key' => 'tiny.theme_advanced_blockformats',
      'value' => 'p,h1,h2,h3,h4,h5,h6,div,blockquote,code,pre,address',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'advanced-theme',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '8eb1120c50030065efaa864b17d158f6' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.theme_advanced_font_sizes',
    ),
    'object' => 
    array (
      'key' => 'tiny.theme_advanced_font_sizes',
      'value' => '80%,90%,100%,120%,140%,160%,180%,220%,260%,320%,400%,500%,700%',
      'xtype' => 'textfield',
      'namespace' => 'tinymce',
      'area' => 'advanced-theme',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
  '8589589e4ae313681f00de1302290c2c' => 
  array (
    'criteria' => 
    array (
      'key' => 'tiny.use_uncompressed_library',
    ),
    'object' => 
    array (
      'key' => 'tiny.use_uncompressed_library',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'tinymce',
      'area' => 'general',
      'editedon' => '0000-00-00 00:00:00',
    ),
  ),
);