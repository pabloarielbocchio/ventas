/**
 * jQuery AJAX callback to treat AJAX errors
 * 
 * @param {type} param
 */
$(document).ajaxError(function(jqXHR, ajaxResponse, thrownError ) {
    var errorMessage;
    switch (ajaxResponse.status) {
        case 404:
            errorMessage = 'You are tryng to get acces to a non existent location';
            break;
        case 403:
            errorMessage = 'You are not allowed to do that or your session has expire';
            break;
        case 500:
            errorMessage = 'Some internal error on server has occur. Notify administrator';
            break;
        default:
            errorMessage = 'An error has ocurr with your AJAX action';
            break;
    }
    
    $('#ajax-error-alert').html(errorMessage);
    $('#ajax-error-alert').show();
    scrollToTop();
});

/**
 * Action used for instance on all datepickers with class .datepicker
 */
function instanceDatePicker() {
    //All DatePicker instances
    $('.datepicker').datepicker({
        'format' : 'yyyy-mm-dd'
    }).on('changeDate', function(ev){
        $(this).datepicker('hide');
    });    
}

/**
 * Action used for instance all jQuery Validation Engine Forms that when
 * validates, if error adds Bootstrap class to mark error fields
 */
function instanceFormValidateWithAddStyle() {
    //Validate and add Bootstrap classs for errors
    $('form.validateAddStyle').validationEngine(
        'attach',
        {
            validateNonVisibleFields: false,
            addFailureCssClassToField: 'field-error',
            addSuccessCssClassToField: 'field-success',
            scroll: false,
            onValidationComplete: function(form, status){ 
                $('.field-success').parent().removeClass('has-error');   

                if (!status) {  
                    $('.field-error').parent().addClass('has-error');
                    onValidateErrorScrollToTop();
                } 

                return status;
            }
        }
    );    
}

/**
 * Function called when Validate gives an Error
 * 
 * It searches the first Error input and scroll
 * to that minus the size of the Top Nav Bar
 */
function onValidateErrorScrollToTop() {
    var firstErrorField = $('.field-error').first();
    var topNavBarHeight = getTopNavBarHeight();
    //Scroll to element
    $('html, body').animate({
        scrollTop: firstErrorField.offset().top - topNavBarHeight - 20
    }, 1000);    
}

/**
 * Returns the height of the Top Nav Bar
 * 
 * @returns {int}
 */
function getTopNavBarHeight() {
    return $('#top-nav-bar').outerHeight(true);
}

/**
 * This script allows you to set a limit on the number of characters a user can enter into a textarea
 * 
 * http://www.mediacollege.com/internet/javascript/form/limit-characters.html
 * @param {Obj} limitField
 * @param {Obj} limitCount
 * @param {int} limitNum
 * @returns {void}
 */
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.innerHTML = limitNum - limitField.value.length;
	}
}

/**
 * Opens a Bootstrap modal instead Javascript common alert
 * 
 * 
 * Receives a customconfig json object with data as:
 *      title: title of the modal
 *      body: Body content of the modal. Could be simply text or html
 *      closetext: Text of the button to close the modal
 *      
 * If does not receive a value it uses a default one
 * 
 * @param {json} customconfig
 * @returns {undefined}
 */
function alertModal(customconfig) {
    var defaultConfig = {
        title : "Javascript Error",
        body : "Something go wrong with the APP",
        closetext : "Close"
    };
    
    if (typeof(customconfig) === 'undefined') {
        customconfig = defaultConfig;
    }
    
    //Replace the values on the modal
    $('#alertmodal h4.modal-title').html((customconfig.title) ?  customconfig.title : defaultConfig.title);
    $('#alertmodal div.modal-body').html((customconfig.body) ?  customconfig.body : defaultConfig.body);
    $('#alertmodal button.modal-closebutton').html((customconfig.closetext) ?  customconfig.closetext : defaultConfig.closetext);
    //Show the modal
    $('#alertmodal').modal();
}

// Overwrite the alert function
var alert = function(text) {
	alertModal( { title: 'Alert', body: text } );
}

/**
 * Check password strength by input ID
 * @author Leandro leandro@serfe.com
 * @param string id
 */
function initPasswordStrength(id){
    $('#'+id).on(
        'keyup',
        function() {
            var pswdValue = $.trim($('#' + id).val());
            var pswdScore = 0;
            var pswddesc = new Array();
            pswddesc[0] = "Very Weak";
            pswddesc[1] = "Weak";
            pswddesc[2] = "Better";
            pswddesc[3] = "Medium";
            pswddesc[4] = "Strong";
            var pswdlabel = new Array();
            pswdlabel[0] = "danger";
            pswdlabel[1] = "danger";
            pswdlabel[2] = "warning";
            pswdlabel[3] = "warning";
            pswdlabel[4] = "success";

            if (pswdValue.length >= 9) {
                pswdScore++;
            }

            if (pswdValue.match(/[a-z]{2}/)) {
                pswdScore++;
            }

            if (pswdValue.match(/[A-Z]+/)) {
                pswdScore++;
            }

            if (pswdValue.match(/[0-9]{2}/)) {
                pswdScore++;
            }

            $('#pswdSrength').html('<i class="glyphicon "></i>' + pswddesc[pswdScore]);
            $('#pswdSrength').removeClass('label-danger label-warning label-success');
            $('#pswdSrength').addClass('label-' + pswdlabel[pswdScore]);

        });
}

/**
 * Scroll user to top of page
 * @returns {undefined}
 */
function scrollToTop() {
    window.scrollTo(0, 0);
}

/**
 * 
 * @param string msg
 * @param function callback
 * @returns {undefined}
 */
function confirm( msg, callback ) {
    var defaultConfig = {
        title : "¿Are you sure?",
        body : "Some question in here"
    };
    
    //Replace the values on the modal
    $('#confirmationmodal h4.modal-title').html( defaultConfig.title );
    $('#confirmationmodal div.modal-body').html( (msg) ?  msg : defaultConfig.body);
    $("#confirmationmodal button.modal-confirmbutton").unbind( "click");
    $("#confirmationmodal button.modal-confirmbutton").bind( "click", function() { 
        callback();
        $('#confirmationmodal').modal('hide');
    });
    //Show the modal
    $('#confirmationmodal').modal('show');
}


/**
 * This functions is usefull to use it when we need select country and state
 * 
 * Swithc between fomr elements depende of the values selected by the user
 * 
 * 
 * @param string countrySelectElId Element id of the Country selector
 * @param string inputStatesWrappersClass
 * @param string stateInputName The name of the field that will be submitted. Ex: data[Client][billingstate]
 * @returns void
 */
function onCountrySelect(countrySelectElId , inputStatesWrappersClass , stateInputName){
    var selectedCountry = $('#' + countrySelectElId ).val();
    var targetEl = '';    
    $('.' + inputStatesWrappersClass ).addClass('dnone');
    $('.' + inputStatesWrappersClass + ' input' ).attr('name','temp_name');
    $('.' + inputStatesWrappersClass + ' select' ).attr('name','temp_name');    
    switch( selectedCountry ){
        case 'United States':
                targetEl = 'select-eeuu-states';                
            break;
        case 'Canada':
                targetEl = 'select-canada-states';                
            break;        
        default:
                targetEl = 'input-state-manual';            
            break;
    }
    $('#' + targetEl).parents('div.state-input-wrapper').first().removeClass('dnone');
    $('#' + targetEl ).attr('name',stateInputName);    
}