var rkfineartphotographermodule = function(quill, options) {
    setTimeout(function() {
        var button;

        button = jQuery('button[value=rkfineartphotographermodule]');

        button
            .css('background', 'url(' + Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/rkfineartphotographer/images/admin.png) no-repeat center center transparent')
            .css('background-size', '16px 16px')
            .attr('title', 'Fine art photographer')
        ;

        button.click(function() {
            RKFineArtPhotographerModuleFinderOpenPopup(quill, 'quill');
        });
    }, 1000);
};
