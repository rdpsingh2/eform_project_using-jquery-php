// ----------------------------------------------------line 42 in html file (dob & joining)--------------------------------------------------------------------------


$(document).ready(function () {




    // $('#dob, #joiningDate').on('change', function () {
    //     var dob = $('#dob').val();
    //     var joiningDate = $('#joiningDate').val();

    //     if (dob && joiningDate) {
    //         var dobDate = new Date(dob);
    //         var joiningDateDate = new Date(joiningDate);

    //         var yearsDiff = joiningDateDate.getFullYear() - dobDate.getFullYear();
    //         var monthsDiff = joiningDateDate.getMonth() - dobDate.getMonth();

    //         if (monthsDiff < 0 || (monthsDiff === 0 && joiningDateDate.getDate() < dobDate.getDate())) {
    //             yearsDiff--;
    //             monthsDiff += 12;
    //         }

    //         if (yearsDiff < 18) {
    //             alert("The person should be at least 18 years old.");
    //             $('#age').text('');
    //             $('#ageInput').val('');
    //         } else {
    //             $('#age').text(yearsDiff + ' years, ' + monthsDiff + ' months');
    //         }
    //     }
    // });


    // -----------------------------------------------------------------Qualification------------------------------------------------------------------
    // $(document).ready(function () {
    $('#qualification').change(function () {
        var selectedOption = $(this).val();
        var otherQualificationInput = $('#otherQualification');


        if (selectedOption === 'Other') {
            otherQualificationInput.show();
        } else {
            otherQualificationInput.hide();
            otherQualificationInput.val('');
        }
    });
    // });

    // --------------------------------------------------------Experience column-----------------------------------------------------------

    $(document).ready(function () {
        // Add options for years from 0 to 40
        for (var i = 0; i <= 40; i++) {
            $('#experience_years').append($('<option>', {
                value: i,
                text: i
            }));
        }

        // Add options for months from 0 to 11
        for (var i = 0; i <= 11; i++) {
            $('#experience_months').append($('<option>', {
                value: i,
                text: i
            }));
        }

        // Event listener for years select input
        $('#experience_years').on('change', updateExperienceLabel);

        // Event listener for months select input
        $('#experience_months').on('change', updateExperienceLabel);

        // Function to update the experience label
        function updateExperienceLabel() {
            var years = $('#experience_years').val();
            var months = $('#experience_months').val();
            var labelText = "Experience";
            if (years > 0 || months > 0) {
                labelText += ": ";
                if (years > 0) {
                    labelText += years + " years";
                    if (months > 0) {
                        labelText += " and ";
                    }
                }
                if (months > 0) {
                    labelText += months + " months";
                }
            }
            $('#experience_label').text(labelText);
        }
    });



    $(document).ready(function () {
        var languageDropdown = $('#languageDropdown');
        var inputCharacter = $('#inputCharacter');

        // Add change event listener to the language dropdown
        languageDropdown.change(function () {
            var selectedLanguage = $(this).val();

            // If "Other" is selected, show the input field
            if (selectedLanguage === 'Other') {
                inputCharacter.show();
            } else {
                inputCharacter.hide();
            }
        });
    });
    // -------------------------------------------------------------checkbox for (same as present address)------------------------------------------------------------


    $('#sameAsPresent').on('change', function () {
    if ($(this).is(':checked')) {
        console.log("Same as present address checked.");
        $('#permanentAddress').val($('#presentAddress').val());
        var presentState = $('#presentState').val();
        $('#permanentState').val(presentState).trigger('change');

        var presentCity = $('#presentCity').val();
        var checkCityInterval = setInterval(function() {
            if ($('#permanentCity option').length > 1) {
                $('#permanentCity').val(presentCity).trigger('change');
                console.log("Permanent city set to: " + presentCity);
                clearInterval(checkCityInterval);
            }
        }, 100);

        if (presentCity === 'Other') {
            $('#otherpermanentCity').val($('#otherCity').val()).show();
        } else {
            $('#otherpermanentCity').hide();
        }

        $('#permanentPincode').val($('#presentPincode').val());
    } else {
        console.log("Same as present address unchecked.");
        $('#permanentAddress').val('');
        $('#permanentCity').val('');
        $('#permanentState').val('');
        $('#permanentPincode').val('');
        $('#otherpermanentCity').hide();
    }
});
    


    

    // ----------------------------------------------------checkbox for primary no and alternative no------------------------------------------------------------------

    $('#sameAsPrimary').change(function () {
        if ($(this).is(':checked')) {
            $('#whatsappNumber').val($('#primary').val());
        } else {
            $('#whatsappNumber').val('');
        }
    });

    $('#sameAsAlternative').change(function () {
        if ($(this).is(':checked')) {
            $('#whatsappNumber').val($('#alternative').val());
        } else {
            $('#whatsappNumber').val('');
        }
    });
    // ----------------------------------------------------------------------------------ifsc code branch name-----------------------------------------------------------
    // $(document).ready(function () {
    $('#ifsc').on('input', function () {
        var ifscCode = $(this).val();
        if (ifscCode.length >= 11) { // Check if the IFSC code is complete
            $.ajax({
                url: 'https://ifsc.razorpay.com/' + ifscCode,
                method: 'GET',
                success: function (response) {
                    $('#branch').val(response.BRANCH);
                },
                error: function () {
                    console.log('Error fetching branch name');
                }
            });
        }
    });
    // });


});


//-------------------------------------------------------------------------------Present Address--------------------------------------------------------------------------- 


$(document).ready(function () {
    console.log("Document ready. Populating state dropdowns.");
    populateStateDropdown();
    populatePermanentStateDropdown();
});

function populateStateDropdown() {
    var stateDropdown = $('#presentState');
    stateDropdown.empty();
    stateDropdown.append($('<option>', {
        value: "",
        text: "Select your state",
        selected: true,
        disabled: true
    }));

    $.getJSON('state_city.json', function (data) {
        $.each(data, function (state, cities) {
            stateDropdown.append($('<option>', {
                value: state,
                text: state
            }));
        });
        console.log("Present state dropdown populated.");
    }).fail(function (jqxhr, textStatus, error) {
        console.error("Request Failed: " + textStatus + ", " + error);
    });
}

function updateCityDropdown(state, cityDropdown, callback) {
    cityDropdown.empty();
    cityDropdown.append($('<option>', {
        value: "",
        text: "Select your city",
        selected: true,
        disabled: true
    }));

    $.getJSON('state_city.json', function (data) {
        var cities = data[state] || [];
        $.each(cities, function (index, city) {
            cityDropdown.append($('<option>', {
                value: city,
                text: city
            }));
        });
        cityDropdown.append($('<option>', {
            value: 'Other',
            text: 'Other'
        }));
        console.log("City dropdown for state " + state + " populated.");
        if (callback) callback();
    }).fail(function (jqxhr, textStatus, error) {
        console.error("Request Failed: " + textStatus + ", " + error);
    });
}

$('#presentState').on('change', function () {
    var state = $(this).val();
    if (state) {
        console.log("Present state changed to: " + state);
        updateCityDropdown(state, $('#presentCity'));
    } else {
        $('#presentCity').empty();
    }
});

$('#presentCity').on('change', function () {
    var selectedCity = $(this).val();
    if (selectedCity === 'Other') {
        $('#otherCity').show();
    } else {
        $('#otherCity').hide();
    }
    console.log("Present city changed to: " + selectedCity);
});



// -----------------------------------------------------------------permanent address-----------------------------------------------------------------------------



function populatePermanentStateDropdown() {
    var stateDropdown = $('#permanentState');
    stateDropdown.empty();
    stateDropdown.append($('<option>', {
        value: "",
        text: "Select your state",
        selected: true,
        disabled: true
    }));

    $.getJSON('state_city.json', function (data) {
        $.each(data, function (state, cities) {
            stateDropdown.append($('<option>', {
                value: state,
                text: state
            }));
        });
        console.log("Permanent state dropdown populated.");
    }).fail(function (jqxhr, textStatus, error) {
        console.error("Request Failed: " + textStatus + ", " + error);
    });
}

$('#permanentState').on('change', function () {
    var state = $(this).val();
    if (state) {
        console.log("Permanent state changed to: " + state);
        updateCityDropdown(state, $('#permanentCity'));
    } else {
        $('#permanentCity').empty();
    }
});

$('#permanentCity').on('change', function () {
    var selectedCity = $(this).val();
    if (selectedCity === 'Other') {
        $('#otherpermanentCity').show();
    } else {
        $('#otherpermanentCity').hide();
    }
    console.log("Permanent city changed to: " + selectedCity);
});

// ----------------------------------------------------------------Ajax method---------------------------------------------------------------------------------------------

$(document).ready(function(){
    $('#simpleForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: 'submit_form.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#result').html('&lt;div class="alert alert-success"&gt;' + response + '&lt;/div&gt;');
            },
            error: function () {
                $('#result').html('&lt;div class="alert alert-danger"&gt;There was an error processing your request.&lt;/div&gt;');
            }
        });
    });
});



// -----------------------------------------------------------------------------dob,joining_date,age-----------------------------------------------------------------------
$(document).ready(function () {
    $('#dob, #joining_date').on('change', function () {
        calculateJoiningAge();
    });

    function calculateJoiningAge() {
        const dobInput = $('#dob').val();
        const joiningDateInput = $('#joining_date').val();

        if (dobInput && joiningDateInput) {
            const dob = new Date(dobInput);
            const joiningDate = new Date(joiningDateInput);

            const joiningAge = calculateAge(dob, joiningDate);

            $('#joining_age').val(joiningAge);

            if (joiningAge < 18) {
                alert('The person should be 18 years or older at the time of joining.');
            }
        } else {
            $('#joining_age').val('');
        }
    }

    function calculateAge(dob, date) {
        let age = date.getFullYear() - dob.getFullYear();
        const monthDiff = date.getMonth() - dob.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && date.getDate() < dob.getDate())) {
            age--;
        }
        return age;
    }

});

// ----------------------------------------------------------------------------Button of the images-------------------------------------------

$(document).ready(function(){
  // Attach click event handler to the button
  $('button[data-toggle="modal"]').click(function() {
    // Get the image ID from the button's data-image attribute
    var imageUrl = '';
      var img_folder = $(this).data('xyz');
      
      if ($(this).data('image')) {
        var imageId = $(this).data('image');
        imageUrl = 'uploads/' + img_folder + '/' + imageId + '.png';
        $('#imageModalLabel').text('Image ' + imageId);
      } else if ($(this).data('other_id_image')) {
        var otherIdImageId = $(this).data('other_id_image');
        imageUrl = 'uploads/' + img_folder + '/' + otherIdImageId + '.png';
        $('#imageModalLabel').text('Other ID Image ' + otherIdImageId);
      } else if ($(this).data('signature')) {
        var signatureId = $(this).data('signature');
        imageUrl = 'uploads/' + img_folder + '/' + signatureId + '.png';
        $('#imageModalLabel').text('Signature ' + signatureId);
      }



    // Update the src attribute of the modal image
    $('#modalImage').attr('src', imageUrl);

    // Optionally, update the modal title or other attributes if needed
    $('#imageModalLabel').text('Image ' + imageId);

    // Open the modal
    $('#imageModal').modal('show');
  });
});




