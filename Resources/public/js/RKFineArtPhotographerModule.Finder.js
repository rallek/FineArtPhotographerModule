'use strict';

var currentRKFineArtPhotographerModuleEditor = null;
var currentRKFineArtPhotographerModuleInput = null;

/**
 * Returns the attributes used for the popup window. 
 * @return {String}
 */
function getRKFineArtPhotographerModulePopupAttributes() {
    var pWidth, pHeight;

    pWidth = screen.width * 0.75;
    pHeight = screen.height * 0.66;

    return 'width=' + pWidth + ',height=' + pHeight + ',location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes';
}

/**
 * Open a popup window with the finder triggered by an editor button.
 */
function RKFineArtPhotographerModuleFinderOpenPopup(editor, editorName) {
    var popupUrl;

    // Save editor for access in selector window
    currentRKFineArtPhotographerModuleEditor = editor;

    popupUrl = Routing.generate('rkfineartphotographermodule_external_finder', { objectType: 'album', editor: editorName });

    if (editorName == 'ckeditor') {
        editor.popup(popupUrl, /*width*/ '80%', /*height*/ '70%', getRKFineArtPhotographerModulePopupAttributes());
    } else {
        window.open(popupUrl, '_blank', getRKFineArtPhotographerModulePopupAttributes());
    }
}


var rKFineArtPhotographerModule = {};

rKFineArtPhotographerModule.finder = {};

rKFineArtPhotographerModule.finder.onLoad = function (baseId, selectedId) {
    var imageModeEnabled;

    if (jQuery('#rKFineArtPhotographerModuleSelectorForm').length < 1) {
        return;
    }

    imageModeEnabled = jQuery("[id$='onlyImages']").prop('checked');
    if (!imageModeEnabled) {
        jQuery('#imageFieldRow').addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=6]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=7]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=8]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=9]").addClass('hidden');
    } else {
        jQuery('#searchTermRow').addClass('hidden');
    }

    jQuery('input[type="checkbox"]').click(rKFineArtPhotographerModule.finder.onParamChanged);
    jQuery('select').not("[id$='pasteAs']").change(rKFineArtPhotographerModule.finder.onParamChanged);
    
    jQuery('.btn-default').click(rKFineArtPhotographerModule.finder.handleCancel);

    var selectedItems = jQuery('#rkfineartphotographermoduleItemContainer a');
    selectedItems.bind('click keypress', function (event) {
        event.preventDefault();
        rKFineArtPhotographerModule.finder.selectItem(jQuery(this).data('itemid'));
    });
};

rKFineArtPhotographerModule.finder.onParamChanged = function () {
    jQuery('#rKFineArtPhotographerModuleSelectorForm').submit();
};

rKFineArtPhotographerModule.finder.handleCancel = function (event) {
    var editor;

    event.preventDefault();
    editor = jQuery("[id$='editor']").first().val();
    if ('ckeditor' === editor) {
        rKFineArtPhotographerClosePopup();
    } else if ('quill' === editor) {
        rKFineArtPhotographerClosePopup();
    } else if ('summernote' === editor) {
        rKFineArtPhotographerClosePopup();
    } else if ('tinymce' === editor) {
        rKFineArtPhotographerClosePopup();
    } else {
        alert('Close Editor: ' + editor);
    }
};


function rKFineArtPhotographerGetPasteSnippet(mode, itemId) {
    var quoteFinder;
    var itemPath;
    var itemUrl;
    var itemTitle;
    var itemDescription;
    var imagePath;
    var pasteMode;

    quoteFinder = new RegExp('"', 'g');
    itemPath = jQuery('#path' + itemId).val().replace(quoteFinder, '');
    itemUrl = jQuery('#url' + itemId).val().replace(quoteFinder, '');
    itemTitle = jQuery('#title' + itemId).val().replace(quoteFinder, '').trim();
    itemDescription = jQuery('#desc' + itemId).val().replace(quoteFinder, '').trim();
    imagePath = jQuery('#imagePath' + itemId).length > 0 ? jQuery('#imagePath' + itemId).val().replace(quoteFinder, '') : '';
    pasteMode = jQuery("[id$='pasteAs']").first().val();

    // item ID
    if (pasteMode === '3') {
        return '' + itemId;
    }

    // relative link to detail page
    if (pasteMode === '1') {
        return mode === 'url' ? itemPath : '<a href="' + itemPath + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
    // absolute url to detail page
    if (pasteMode === '2') {
        return mode === 'url' ? itemUrl : '<a href="' + itemUrl + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }

    if (pasteMode === '6') {
        // relative link to image file
        return mode === 'url' ? imagePath : '<a href="' + imagePath + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
    if (pasteMode === '7') {
        // image tag
        return '<img src="' + imagePath + '" alt="' + itemTitle + '" width="300" />';
    }
    if (pasteMode === '8') {
        // image tag with relative link to detail page
        return mode === 'url' ? itemPath : '<a href="' + itemPath + '" title="' + itemTitle + '"><img src="' + imagePath + '" alt="' + itemTitle + '" width="300" /></a>';
    }
    if (pasteMode === '9') {
        // image tag with absolute url to detail page
        return mode === 'url' ? itemUrl : '<a href="' + itemUrl + '" title="' + itemTitle + '"><img src="' + imagePath + '" alt="' + itemTitle + '" width="300" /></a>';
    }


    return '';
}


// User clicks on "select item" button
rKFineArtPhotographerModule.finder.selectItem = function (itemId) {
    var editor, html;

    html = rKFineArtPhotographerGetPasteSnippet('html', itemId);
    editor = jQuery("[id$='editor']").first().val();
    if ('ckeditor' === editor) {
        if (null !== window.opener.currentRKFineArtPhotographerModuleEditor) {
            window.opener.currentRKFineArtPhotographerModuleEditor.insertHtml(html);
        }
    } else if ('quill' === editor) {
        if (null !== window.opener.currentRKFineArtPhotographerModuleEditor) {
            window.opener.currentRKFineArtPhotographerModuleEditor.clipboard.dangerouslyPasteHTML(window.opener.currentRKFineArtPhotographerModuleEditor.getLength(), html);
        }
    } else if ('summernote' === editor) {
        if (null !== window.opener.currentRKFineArtPhotographerModuleEditor) {
            html = jQuery(html).get(0);
            window.opener.currentRKFineArtPhotographerModuleEditor.invoke('insertNode', html);
        }
    } else if ('tinymce' === editor) {
        window.opener.currentRKFineArtPhotographerModuleEditor.insertContent(html);
    } else {
        alert('Insert into Editor: ' + editor);
    }
    rKFineArtPhotographerClosePopup();
};

function rKFineArtPhotographerClosePopup() {
    window.opener.focus();
    window.close();
}

jQuery(document).ready(function () {
    rKFineArtPhotographerModule.finder.onLoad();
});
