{* Purpose of this template: edit view of generic item list content type *}
<div class="form-group">
    {gt text='Object type' domain='rkfineartphotographermodule' assign='objectTypeSelectorLabel'}
    {formlabel for='rKFineArtPhotographerModuleObjectType' text=$objectTypeSelectorLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {rkfineartphotographermoduleObjectTypeSelector assign='allObjectTypes'}
        {formdropdownlist id='rKFineArtPhotographerModuleObjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes cssClass='form-control'}
        <span class="help-block">{gt text='If you change this please save the element once to reload the parameters below.' domain='rkfineartphotographermodule'}</span>
    </div>
</div>

{if $featureActivationHelper->isEnabled(constant('RK\\FineArtPhotographerModule\\Helper\\FeatureActivationHelper::CATEGORIES'), $objectType)}
{formvolatile}
{if $properties ne null && is_array($properties)}
    {nocache}
    {foreach key='registryId' item='registryCid' from=$registries}
        {assign var='propName' value=''}
        {foreach key='propertyName' item='propertyId' from=$properties}
            {if $propertyId eq $registryId}
                {assign var='propName' value=$propertyName}
            {/if}
        {/foreach}
        <div class="form-group">
            {assign var='hasMultiSelection' value=$categoryHelper->hasMultipleSelection($objectType, $propertyName)}
            {gt text='Category' domain='rkfineartphotographermodule' assign='categorySelectorLabel'}
            {assign var='selectionMode' value='single'}
            {if $hasMultiSelection eq true}
                {gt text='Categories' domain='rkfineartphotographermodule' assign='categorySelectorLabel'}
                {assign var='selectionMode' value='multiple'}
            {/if}
            {formlabel for="rKFineArtPhotographerModuleCatIds`$propertyName`" text=$categorySelectorLabel cssClass='col-sm-3 control-label'}
            <div class="col-sm-9">
                {formdropdownlist id="rKFineArtPhotographerModuleCatIds`$propName`" items=$categories.$propName dataField="catids`$propName`" group='data' selectionMode=$selectionMode cssClass='form-control'}
                <span class="help-block">{gt text='This is an optional filter.' domain='rkfineartphotographermodule'}</span>
            </div>
        </div>
    {/foreach}
    {/nocache}
{/if}
{/formvolatile}
{/if}

<div class="form-group">
    {gt text='Sorting' domain='rkfineartphotographermodule' assign='sortingLabel'}
    {formlabel text=$sortingLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formradiobutton id='rKFineArtPhotographerModuleSortRandom' value='random' dataField='sorting' group='data' mandatory=true}
        {gt text='Random' domain='rkfineartphotographermodule' assign='sortingRandomLabel'}
        {formlabel for='rKFineArtPhotographerModuleSortRandom' text=$sortingRandomLabel}
        {formradiobutton id='rKFineArtPhotographerModuleSortNewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {gt text='Newest' domain='rkfineartphotographermodule' assign='sortingNewestLabel'}
        {formlabel for='rKFineArtPhotographerModuleSortNewest' text=$sortingNewestLabel}
        {formradiobutton id='rKFineArtPhotographerModuleSortDefault' value='default' dataField='sorting' group='data' mandatory=true}
        {gt text='Default' domain='rkfineartphotographermodule' assign='sortingDefaultLabel'}
        {formlabel for='rKFineArtPhotographerModuleSortDefault' text=$sortingDefaultLabel}
    </div>
</div>

<div class="form-group">
    {gt text='Amount' domain='rkfineartphotographermodule' assign='amountLabel'}
    {formlabel for='rKFineArtPhotographerModuleAmount' text=$amountLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formintinput id='rKFineArtPhotographerModuleAmount' dataField='amount' group='data' mandatory=true maxLength=2 cssClass='form-control'}
    </div>
</div>

<div class="form-group">
    {gt text='Template' domain='rkfineartphotographermodule' assign='templateLabel'}
    {formlabel for='rKFineArtPhotographerModuleTemplate' text=$templateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {rkfineartphotographermoduleTemplateSelector assign='allTemplates'}
        {formdropdownlist id='rKFineArtPhotographerModuleTemplate' dataField='template' group='data' mandatory=true items=$allTemplates cssClass='form-control'}
    </div>
</div>

<div id="customTemplateArea" class="form-group"{* data-switch="rKFineArtPhotographerModuleTemplate" data-switch-value="custom"*}>
    {gt text='Custom template' domain='rkfineartphotographermodule' assign='customTemplateLabel'}
    {formlabel for='rKFineArtPhotographerModuleCustomTemplate' text=$customTemplateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='rKFineArtPhotographerModuleCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='rkfineartphotographermodule'}: <em>itemlist_[objectType]_display.html.twig</em></span>
    </div>
</div>

<div class="form-group">
    {gt text='Filter (expert option)' domain='rkfineartphotographermodule' assign='filterLabel'}
    {formlabel for='rKFineArtPhotographerModuleFilter' text=$filterLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='rKFineArtPhotographerModuleFilter' dataField='filter' group='data' mandatory=false maxLength=255 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='rkfineartphotographermodule'}: <em>tbl.age >= 18</em></span>
    </div>
</div>

<script>
    (function($) {
    	$('#rKFineArtPhotographerModuleTemplate').change(function() {
    	    $('#customTemplateArea').toggleClass('hidden', $(this).val() != 'custom');
	    }).trigger('change');
    })(jQuery)
</script>
