'use strict';

var rKFineArtPhotographerModule = {};

rKFineArtPhotographerModule.itemSelector = {};
rKFineArtPhotographerModule.itemSelector.items = {};
rKFineArtPhotographerModule.itemSelector.baseId = 0;
rKFineArtPhotographerModule.itemSelector.selectedId = 0;

rKFineArtPhotographerModule.itemSelector.onLoad = function (baseId, selectedId) {
    rKFineArtPhotographerModule.itemSelector.baseId = baseId;
    rKFineArtPhotographerModule.itemSelector.selectedId = selectedId;

    // required as a changed object type requires a new instance of the item selector plugin
    jQuery('#rKFineArtPhotographerModuleObjectType').change(rKFineArtPhotographerModule.itemSelector.onParamChanged);

    jQuery('#' + baseId + '_catidMain').change(rKFineArtPhotographerModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + '_catidsMain').change(rKFineArtPhotographerModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'Id').change(rKFineArtPhotographerModule.itemSelector.onItemChanged);
    jQuery('#' + baseId + 'Sort').change(rKFineArtPhotographerModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'SortDir').change(rKFineArtPhotographerModule.itemSelector.onParamChanged);
    jQuery('#rKFineArtPhotographerModuleSearchGo').click(rKFineArtPhotographerModule.itemSelector.onParamChanged);
    jQuery('#rKFineArtPhotographerModuleSearchGo').keypress(rKFineArtPhotographerModule.itemSelector.onParamChanged);

    rKFineArtPhotographerModule.itemSelector.getItemList();
};

rKFineArtPhotographerModule.itemSelector.onParamChanged = function () {
    jQuery('#ajaxIndicator').removeClass('hidden');

    rKFineArtPhotographerModule.itemSelector.getItemList();
};

rKFineArtPhotographerModule.itemSelector.getItemList = function () {
    var baseId;
    var params;

    baseId = rKFineArtPhotographerModule.itemSelector.baseId;
    params = {
        ot: baseId,
        sort: jQuery('#' + baseId + 'Sort').val(),
        sortdir: jQuery('#' + baseId + 'SortDir').val(),
        q: jQuery('#' + baseId + 'SearchTerm').val()
    }
    if (jQuery('#' + baseId + '_catidMain').length > 0) {
        params[catidMain] = jQuery('#' + baseId + '_catidMain').val();
    } else if (jQuery('#' + baseId + '_catidsMain').length > 0) {
        params[catidsMain] = jQuery('#' + baseId + '_catidsMain').val();
    }

    jQuery.getJSON(Routing.generate('rkfineartphotographermodule_ajax_getitemlistfinder'), params, function (data) {
        var baseId;

        baseId = rKFineArtPhotographerModule.itemSelector.baseId;
        rKFineArtPhotographerModule.itemSelector.items[baseId] = data;
        jQuery('#ajaxIndicator').addClass('hidden');
        rKFineArtPhotographerModule.itemSelector.updateItemDropdownEntries();
        rKFineArtPhotographerModule.itemSelector.updatePreview();
    });
};

rKFineArtPhotographerModule.itemSelector.updateItemDropdownEntries = function () {
    var baseId, itemSelector, items, i, item;

    baseId = rKFineArtPhotographerModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id');
    itemSelector.length = 0;

    items = rKFineArtPhotographerModule.itemSelector.items[baseId];
    for (i = 0; i < items.length; ++i) {
        item = items[i];
        itemSelector.get(0).options[i] = new Option(item.title, item.id, false);
    }

    if (rKFineArtPhotographerModule.itemSelector.selectedId > 0) {
        jQuery('#' + baseId + 'Id').val(rKFineArtPhotographerModule.itemSelector.selectedId);
    }
};

rKFineArtPhotographerModule.itemSelector.updatePreview = function () {
    var baseId, items, selectedElement, i;

    baseId = rKFineArtPhotographerModule.itemSelector.baseId;
    items = rKFineArtPhotographerModule.itemSelector.items[baseId];

    jQuery('#' + baseId + 'PreviewContainer').addClass('hidden');

    if (items.length === 0) {
        return;
    }

    selectedElement = items[0];
    if (rKFineArtPhotographerModule.itemSelector.selectedId > 0) {
        for (var i = 0; i < items.length; ++i) {
            if (items[i].id == rKFineArtPhotographerModule.itemSelector.selectedId) {
                selectedElement = items[i];
                break;
            }
        }
    }

    if (null !== selectedElement) {
        jQuery('#' + baseId + 'PreviewContainer')
            .html(window.atob(selectedElement.previewInfo))
            .removeClass('hidden');
        rKFineArtPhotographerInitImageViewer();
    }
};

rKFineArtPhotographerModule.itemSelector.onItemChanged = function () {
    var baseId, itemSelector, preview;

    baseId = rKFineArtPhotographerModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id').get(0);
    preview = window.atob(rKFineArtPhotographerModule.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    jQuery('#' + baseId + 'PreviewContainer').html(preview);
    rKFineArtPhotographerModule.itemSelector.selectedId = jQuery('#' + baseId + 'Id').val();
    rKFineArtPhotographerInitImageViewer();
};

jQuery(document).ready(function () {
    var infoElem;

    infoElem = jQuery('#itemSelectorInfo');
    if (infoElem.length == 0) {
        return;
    }

    rKFineArtPhotographerModule.itemSelector.onLoad(infoElem.data('base-id'), infoElem.data('selected-id'));
});
