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
                }else{
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
        // Assuming you have a checkbox element with the id "myCheckbox"
            const myCheckbox = document.getElementById('shipping_details');

            if (myCheckbox.checked) {
       
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


 
 $("#shipping_zip ,#billing_zip").keypress(function (e){
        const regex = /(\d{5})(\d{4})/;
        let val ="#"+ e.currentTarget.id
        let  input =e.currentTarget.value;
        if($('#output').length > 0 ){
            $('#output').remove();
        }
        if ( input.length === 4  ) {
            $(val).after('<div id="output" class="text-red-500">Valid 5-digit zipcode.</div>');
        } else if ( input.length === 9 ) {
            $(val).after('<div id="output" class="text-red-500">$1-$2 is a valid zipcode.</div>');
            // Replace contents of text field
            document.getElementById(val).value = input.replace(/(\d{5})(\d{4})/, "$1-$2");
                  $(val).after('<div id="output" class="text-red-500">Please enter a valid zipcode.</div>');
        } else  {
          
            $(val).after('<div id="output" class="text-red-500">Please enter a valid zipcode.</div>');
        } 

});
       

$("#primary_phone , #alternate_phone ,#shipping_phone ,#billing_phone").keypress(function (e) {
        let val ="#"+ e.currentTarget.id
    if($('#output').length > 0 ){
        $('#output').remove();   
    }
    if ($(val).val().length > 9 ){
        $(val).after('<div id="output" class="text-red-500">Must be 10 Digits</div>');
        }
});
    
        
$('input[type="text"],textarea').keydown(function (e) {
    if(e.keyCode == 13){
        e.preventDefault();
    } 
});