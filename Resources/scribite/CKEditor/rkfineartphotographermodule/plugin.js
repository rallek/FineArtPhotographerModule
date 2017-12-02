CKEDITOR.plugins.add('rkfineartphotographermodule', {
    requires: 'popup',
    init: function (editor) {
        editor.addCommand('insertRKFineArtPhotographerModule', {
            exec: function (editor) {
                RKFineArtPhotographerModuleFinderOpenPopup(editor, 'ckeditor');
            }
        });
        editor.ui.addButton('rkfineartphotographermodule', {
            label: 'Fine art photographer',
            command: 'insertRKFineArtPhotographerModule',
            icon: this.path.replace('scribite/CKEditor/rkfineartphotographermodule', 'images') + 'admin.png'
        });
    }
});
