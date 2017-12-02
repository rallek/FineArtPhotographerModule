'use strict';

function faphToggleShrinkSettings(fieldName) {
    var idSuffix = fieldName.replace('rkfineartphotographermodule_appsettings_', '');
    jQuery('#shrinkDetails' + idSuffix).toggleClass('hidden', !jQuery('#rkfineartphotographermodule_appsettings_enableShrinkingFor' + idSuffix).prop('checked'));
}

jQuery(document).ready(function () {
    jQuery('.shrink-enabler').each(function (index) {
        jQuery(this).bind('click keyup', function (event) {
            faphToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
        });
        faphToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
    });
});
