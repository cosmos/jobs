// main.js

// import validate from "jquery-validation";

// Sends the Claim a Project emaill to the Cosmos Job Board admin
(function ($) {
    'use strict';
    var form = $('#claim_this_project_form'),
        message = $('.contact__msg'),
        form_data;
    // Success function
    function done_func(response) {
        message.fadeIn().removeClass('alert-danger').addClass('alert-success');
        message.text(response);
        setTimeout(function () {
            message.fadeOut();
        }, 5000);
        //form.find('input:not([type="submit"]), textarea').val('');
    }
    // fail function
    function fail_func(data) {
        message.fadeIn().removeClass('alert-success').addClass('alert-success');
        message.text(data.responseText);
        setTimeout(function () {
            message.fadeOut();
        }, 5000);
    }
    
    form.submit(function (e) {
        e.preventDefault();
        form_data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form_data
        })
        .done(done_func)
        .fail(fail_func);
    });
})(jQuery);

jQuery(function() {
    var createAllErrors = function() {
        var form = $(this);
        var errorList = $('ul.errorMessages', form);
        
        var showAllErrorMessages = function() {
            errorList.empty();
            
            //Find all invalid fields within the form.
            form.find(':invalid').each(function(index, node) {

                //Find the field's corresponding label
                var label = $('label[for=' + node.id + ']');

                //Opera incorrectly does not fill the validationMessage property.
                var message = node.validationMessage || 'Invalid value.';
                errorList
                    .show()
                    .append('<li><span>' + label.html() + '</span> ' + message + '</li>');
            });
        };
        
        jQuery('input[type=submit], button', form).on('click', showAllErrorMessages);
        jQuery('input[type=text]', form).on('keypress', function(event) {
            //keyCode 13 is Enter
            if (event.keyCode == 13) {
                showAllErrorMessages();
            }
        });
    };
    
    jQuery('form').each(createAllErrors);
});

// // Wait for the DOM to be ready
// jQuery(function() {
//   // Initialize form validation on the registration form.
//   // It has the name attribute "registration"
//   jQuery("form[id='submit-resume-form']").validate({
//     // Specify validation rules
//     rules: {
//       // The key name on the left side is the name attribute
//       // of an input field. Validation rules are defined
//       // on the right side
//       candidate_website: {
//         url: true,
//       },
//       candidate_other: {
//         url: true,
//       },
//       candidate_twitter: {
//         url: true,
//       },
//       candidate_facebook: {
//         url: true,
//       },
//       candidate_github: {
//         url: true,
//       },
//       candidate_stackexchange: {
//         url: true,
//       },
//     },
//     // Specify validation error messages
//     messages: {
//       candidate_website: "Please enter a valid URL",
//       candidate_other: "Please enter a valid URL",
//       candidate_twitter: "Please enter a valid URL",
//       candidate_facebook: "Please enter a valid URL",
//       candidate_github: "Please enter a valid URL",
//       candidate_stackexchange: "Please enter a valid URL",
//     },
//     // Make sure the form is submitted to the destination defined
//     // in the "action" attribute of the form when valid
//     submitHandler: function(form) {
//       form.submit();
//     }
//   });
// });
