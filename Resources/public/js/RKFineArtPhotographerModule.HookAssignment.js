'use strict';

/**
 * Adds a hook assignment for a certain object.
 */
function rKFineArtPhotographerAttachHookObject(attachLink, entityId) {
    jQuery.ajax({
        method: 'POST',
        url: Routing.generate('rkfineartphotographermodule_ajax_attachhookobject'),
        data: {
            owner: attachLink.data('owner'),
            areaId: attachLink.data('area-id'),
            objectId: attachLink.data('object-id'),
            url: attachLink.data('url'),
            assignedEntity: attachLink.data('assigned-entity'),
            assignedId: entityId
        },
        success: function (data) {
            window.location.reload();
        }
    });
}

/**
 * Removes a hook assignment for a certain object.
 */
function rKFineArtPhotographerDetachHookObject() {
    jQuery.ajax({
        method: 'POST',
        url: Routing.generate('rkfineartphotographermodule_ajax_detachhookobject'),
        data: {
            id: jQuery(this).data('assignment-id')
        },
        success: function (data) {
            window.location.reload();
        }
    });
}

jQuery(document).ready(function () {
    jQuery('.detach-rkfineartphotographermodule-object')
        .click(rKFineArtPhotographerDetachHookObject)
        .removeClass('hidden');
});
