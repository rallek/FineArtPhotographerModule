/**
 * Initializes the plugin, this will be executed after the plugin has been created.
 * This call is done before the editor instance has finished it's initialization so use the onInit event
 * of the editor instance to intercept that event.
 *
 * @param {tinymce.Editor} ed Editor instance that the plugin is initialised in
 * @param {string} url Absolute URL to where the plugin is located
 */
tinymce.PluginManager.add('rkfineartphotographermodule', function(editor, url) {
    var icon;

    icon = Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/rkfineartphotographer/images/admin.png';

    editor.addButton('rkfineartphotographermodule', {
        //text: 'Fine art photographer',
        image: icon,
        onclick: function() {
            RKFineArtPhotographerModuleFinderOpenPopup(editor, 'tinymce');
        }
    });
    editor.addMenuItem('rkfineartphotographermodule', {
        text: 'Fine art photographer',
        context: 'tools',
        image: icon,
        onclick: function() {
            RKFineArtPhotographerModuleFinderOpenPopup(editor, 'tinymce');
        }
    });

    return {
        getMetadata: function() {
            return {
                title: 'Fine art photographer',
                url: 'http://k62.de'
            };
        }
    };
});
