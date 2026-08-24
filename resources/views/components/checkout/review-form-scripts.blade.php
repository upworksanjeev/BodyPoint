@props([
    'formId',
    'poFieldId' => 'customer-po-number',
    'duplicateBlockId' => 'duplicate-confirmation',
    'requirePo' => true,
])

@push('other-scripts')
<script>
    (function () {
        const formId = @json($formId);
        const poFieldId = @json($poFieldId);
        const duplicateBlockId = @json($duplicateBlockId);
        const requirePo = @json($requirePo);
        const sessionError = @json(session('error'));

        if (sessionError && typeof sessionError === 'string' && sessionError.includes('Duplicate Purchase Order')) {
            $('#error_alert_po').text(sessionError).show();
            $('#' + duplicateBlockId).show();
            const poField = document.getElementById(poFieldId);
            if (poField) {
                poField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function addCreditCardToForm(targetFormId) {
            const selectedCard = localStorage.getItem('selected_credit_card') || sessionStorage.getItem('selected_credit_card');
            if (!selectedCard) {
                return;
            }

            try {
                const cardData = JSON.parse(selectedCard);
                const form = $('#' + targetFormId);

                if (cardData.CreditCardLastFourDigit) {
                    if (!form.find('input[name="credit_card_last_four"]').length) {
                        form.append('<input type="hidden" name="credit_card_last_four" value="" />');
                    }
                    form.find('input[name="credit_card_last_four"]').val(cardData.CreditCardLastFourDigit);

                    if (!form.find('input[name="selected_credit_card"]').length) {
                        form.append('<input type="hidden" name="selected_credit_card" id="form_credit_card_data" value="" />');
                    }
                    form.find('input[name="selected_credit_card"]').val(selectedCard);
                }
            } catch (error) {
                console.error('Error parsing credit card data:', error);
            }
        }

        $('#' + formId).on('submit', function (event) {
            const poNumber = $('#' + poFieldId).val().trim();

            if (requirePo && poNumber === '') {
                event.preventDefault();
                if (typeof toastr !== 'undefined') {
                    toastr.error('Customer PO Number is Required');
                }
                $('#' + poFieldId).focus();
                return;
            }

            addCreditCardToForm(formId);
            $(this).find('button[type="submit"]').prop('disabled', true);
            $('#fullLoader').css('display', 'flex');
        });
    })();
</script>
@endpush
