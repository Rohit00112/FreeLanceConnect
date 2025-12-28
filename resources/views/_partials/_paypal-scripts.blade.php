<script src="https://www.paypal.com/sdk/js?client-id={{config('services.paypal.client_id')}}&currency=USD&disable-funding=credit,card"></script>
<script>
    let basicFormPaypal;
    let total_amount = @json($total);
    let serverErrorPaypal = "server_error_occurred_paypal";
    paypal.Buttons({
        createOrder: function(data, actions) {
            let paypalAmount = basicFormPaypal.get("total");
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency_code: 'USD',
                        value: paypalAmount
                    }
                }],
                application_context: {
                    shipping_preference: "NO_SHIPPING",
                }
            });
        },
        onCancel: function () {
            resetFieldsAfterPayFail();
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function (details){
                document.querySelector('#total_paypal').value = basicFormPaypal.get("total");
                document.querySelector('#transaction_paypal').value = details.purchase_units[0].payments.captures[0].id;
                let paypalForm = document.querySelector('#payment-form-paypal');
                paypalForm.submit();
            });
        },
        onClick: function(data, actions)
        {
            let termsAreChecked = checkTermsAcceptance("paypal");
            if(!termsAreChecked)
            {
                return actions.reject();
            }
            changeFieldsAfterPayStart();
            basicFormPaypal = new FormData();
            appendBasicData(basicFormPaypal);
            return fetch("{{route('clients.payment.pre-payment-validation')}}", {
                method: "POST",
                body: basicFormPaypal
            }).then(function(res){
                if(!res.ok)
                {
                    return serverErrorPaypal;
                }
                else
                {
                    return res.json();
                }
            }).then(function(data){
                if(data === serverErrorPaypal)
                {
                    showErrorAndScrollUp("Unknown error occurred during PayPal Smart payment");
                    return actions.reject();
                }
                else if(data.successful_validation)
                {
                    return actions.resolve();
                }
                else
                {
                    const beautifiedError = beautifyJson(JSON.stringify(data));
                    showErrorAndScrollUp(beautifiedError);
                    return actions.reject();
                }
            });
        }
    }).render('#paypal-card-element');
    function checkTermsAcceptance()
    {
        let isChecked =  $("#terms_checkbox").prop("checked");
        if(!isChecked){
            showErrorAndScrollUp("The terms and conditions and the privacy policy must be accepted before payment.");
            return false;
        }
        return true;
    }

    function showErrorAndScrollUp(errorText)
    {
        $("#paymentErrorAlert").hide();
        $("#validationErrorText").html(errorText);
        $("#validationErrorAlert").show();
        resetFieldsAfterPayFail();
        window.scrollTo(0, 0);
    }

    function resetFieldsAfterPayFail()
    {
        $("#terms_checkbox").prop("disabled", false);
    }

    function changeFieldsAfterPayStart()
    {
        $("#validationErrorAlert").hide();
        $("#validationErrorText").html("");
        $("#paymentErrorAlert").hide();
        $("#terms_checkbox").prop("disabled", true);
    }
    function appendBasicData(emptyForm)
    {
        emptyForm.append("_token", "{{ csrf_token() }}");
        emptyForm.append("total", "{{$total}}");
    }

    function beautifyJson(passedStr)
    {
        passedStr = passedStr.replace(/{/g, "");
        passedStr = passedStr.replace(/}/g, "");
        passedStr = passedStr.replace(/\[/g, "");
        passedStr = passedStr.replace(/]/g, "");
        passedStr = passedStr.replace(/,/g, "");
        passedStr = passedStr.replace(/"/g, "");
        passedStr = passedStr.replace(/:/g, ": ");
        passedStr = passedStr.replace(/\./g, ".</br>");
        return passedStr;
    }
</script>
