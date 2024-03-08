$(document).ready(function () {
    const $form = $('#registrationForm');
    const $steps = $form.find('.step');
    const $prevButton = $form.find('.prev-button');
    const $nextButton = $form.find('.next-button');

    let currentStep = 1;
     const totalSteps = $steps.length; // Pass the total steps from your controller
     

        // Function to validate the current step
        function validateStep() {
            const $currentStep = $steps.filter(':visible');
            const $requiredFields = $currentStep.find('[required]');
            let isValid = true;

            $requiredFields.each(function () {
                var $field = $(this);
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $field.addClass('border-red-600');
                    $field.removeClass('border-gray-300');
                }else{
                    isValid = true;
                    $field.addClass('border-gray-300 ');
                    $field.removeClass('border-red-600');
                }
            });

            return isValid;
        }
    $steps.not(':first').hide();

    if(currentStep === 1){
        $prevButton.hide();  
        $('.submit-button').hide();
    }
    
    $nextButton.click(function (e) {
            e.preventDefault();

            // Check if the current step is valid
            if (validateStep()) {
                const $currentStep = $steps.filter(':visible');
                const $nextStep = $currentStep.next('.step');
                $currentStep.hide();
                $prevButton.show();
                $nextStep.show();
                currentStep++;
                
                // Hide "Next" button on the last step and display "Register"
                if (currentStep === totalSteps) {
                    $nextButton.hide();
                    $('.submit-button').show();
                }
            } else {
        
            }
        });

        $prevButton.click(function (e) {
            e.preventDefault();
            const $currentStep = $steps.filter(':visible');
            const $prevStep = $currentStep.prev('.step');
            $currentStep.hide();
            $prevStep.show();
            currentStep--;

            // Show "Next" button when moving back to a previous step
            if (currentStep < totalSteps) {

                if(currentStep === 1){
                console.log(currentStep)
                $prevButton.hide();
                }else{
                    $nextButton.show();
                $prevButton.show();
                $('.submit-button').hide();
                }
               
            }
        });

        $('.submit-button').click(function (e) {
            e.preventDefault();
            if (validateStep()) {
                $form.submit();
            }else{
                return false;
            }
        })
        // Assuming you have a checkbox element with the id "myCheckbox"
            const myCheckbox = document.getElementById('shipping_details');

            if (myCheckbox && myCheckbox.checked) {
       
            } else {
                const $billingFields = $('.step[data-step="3"]').find('[name^="billing_"]');
                $billingFields.val('');
            }

        
        $('#shipping_details').change(function () {

            const $billingFields = $('.step[data-step="3"]').find('[name^="billing_"]');
            const $shippingFields = $('.step[data-step="3"]').find('[name^="shipping_"]');

            if (this.checked) {
                // Checkbox is checked, copy values from Shipping Information to Billing Information
                $billingFields.each(function (index, element) {
                    const billingFieldName = $(element).attr('name').replace('billing_', '');
                    const shippingField = $shippingFields.filter('[name="shipping_' + billingFieldName + '"]');
                    $(element).val(shippingField.val());
                });
            } else {
                // Checkbox is unchecked, clear Billing Information fields
                $billingFields.val('');
            }
        });

       
    
});



function validateUSZipCode(zipCode) {
    // US ZIP code format (5 digits or 5+4 digits)
    var usZipRegex = /^\d{5}([ \-]\d{4})?$/;
    return usZipRegex.test(zipCode);
}
 

// Validate ZIP code on input blur (for the United States)
$('#shipping_zip ,#billing_zip').on('blur', function(e) {
    var zipCode = $(this).val();
    let val ="#"+ e.currentTarget.id
    if($('#output').length > 0 ){
        $('#output').remove();   
    }
    if (validateUSZipCode(zipCode)) {
        $("button.inline-flex").attr("disabled",false);
    } else {
        $(val).after('<div id="output" class="text-red-500">Please enter a valid zipcode.</div>');
        $("button.inline-flex").attr("disabled",true);
    }
});


$("#primary_phone , #alternate_phone ,#shipping_phone ,#billing_phone").keypress(function (e) {
        let val ="#"+ e.currentTarget.id
    if($('#output').length > 0 ){
        $('#output').remove();   
    }
    if ($(val).val().length > 9 ){
        $(val).after('<div id="output" class="text-red-500">Please enter a valid phone number.</div>');
        }
});
    


$('input[type="text"],textarea').keydown(function (e) {
    if(e.keyCode == 13){
        e.preventDefault();
    } 
});