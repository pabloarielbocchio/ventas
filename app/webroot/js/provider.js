/**
 * Disaply a modal to confirm submission
 * 
 * Retrieve data from the form and append it to the HTML modal
 * in order to the user confirm the submission of the form
 * This functionality is not for all user roles
 * 
 * @returns void
 */
function confirmProviderFormSubmit(){
    //retrieve data from the form
    var clientName = $( '#UserFullname' ).val( );
    var companyName = $( '#ClientProviderCompanyId option:selected' ).html( );
    //use the retrieved data to fill the modal confirm
    $( '#fullname-confirm' ).html( clientName );
    $( '#company-confirm' ).html( companyName );
    //display the confirmation window
    $('#confirm-provider-form-submission').modal('show');
}

/**
 * Selects all clients on page for bulk actions 
 * 
 */
function selectAllProviders() {
    var status = $("#ProviderAll").is(':checked');
    $("#ProviderBulkActionForm").find(":checkbox").prop('checked', status );
}

/**
 * Binds the select of Jop Via with the textarea (and change the value on it)
 */
function bindSelectJobShipVia(defaultJobSelectShipVia) {
    $("select#JobShipVia").on('change', function() {
        var selectedOptionId = $("select#JobShipVia option:selected").attr('value');
        var $JobShippingAddress = $("textarea#JobShippingAddress");
        switch (selectedOptionId) {
            case 'blind_ship':
                $JobShippingAddress.removeAttr('disabled');
                break;
            default:
                $JobShippingAddress.attr('disabled', 'disabled');
                break;
        }
        
        if (selectedOptionId === '') {
            $JobShippingAddress.html(defaultJobSelectShipVia['empty']);
        } else {
            $JobShippingAddress.html(defaultJobSelectShipVia[selectedOptionId]);
        }
    });
}