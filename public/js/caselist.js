

    function populateFilledData() {

        var fullName = document.getElementById('fullName').value;
        var age = document.getElementById('age').value;
        var sex = document.getElementById('sex').value;
        var dateOfBirth = document.getElementById('date_of_birth').value;
        var placeOfBirth = document.getElementById('pob').value;
        var educationalAttainment = document.getElementById('educational_attainment').value;
        var civilStatus = document.getElementById('civil_status').value;
        var religion = document.getElementById('religion').value;
        var otherReligion = document.getElementById('other_religion').value;
        var nationality = document.getElementById('nationality').value;
        var otherNationality = document.getElementById('other_nationality').value;
        var occupation = document.getElementById('occupation').value;
        var monthlyIncome = document.getElementById('monthly_income').value;
        var address = document.getElementById('address').value;
        var contactNumber = document.getElementById('contact_number').value;
        var sourceOfReferral = document.getElementById('source_of_referral').value;
        var circumstancesOfReferral = document.getElementById('circumstances_of_referral').value;
        var familyBackground = document.getElementById('family_background').value;
        var healthHistory = document.getElementById('health_history').value;
        var economicSituation = document.getElementById('economic_situation').value;
        var houseStructure = document.getElementById('house_structure').value;
        var floor = document.getElementById('floor').value;
        var type = document.getElementById('type').value;
        var numberOfRooms = document.getElementById('number_of_rooms').value;
        var appliances = document.getElementById('appliances').value;
        var monthlyExpenses = document.getElementById('monthly_expenses').value;
        var indicate = document.getElementById('indicate').value;
        var assessment = document.getElementById('assessment').value;
        var recommendation = document.getElementById('recommendation').value;

        // Construct HTML to display filled data
        var filledDataHtml = `
            <p><strong>Full Name:</strong> ${fullName}</p>
            <p><strong>Age:</strong> ${age}</p>
            <p><strong>Sex:</strong> ${sex}</p>
            <p><strong>Date of Birth:</strong> ${dateOfBirth}</p>
            <p><strong>Place of Birth:</strong> ${placeOfBirth}</p>
            <p><strong>Educational Attainment:</strong> ${educationalAttainment}</p>
            <p><strong>Civil Status:</strong> ${civilStatus}</p>
            <p><strong>Religion:</strong> ${religion}</p>
            <p><strong>Other Religion:</strong> ${other_religion}</p>
            <p><strong>Nationality:</strong> ${nationality}</p>
            <p><strong>Other Nationality:</strong> ${other_nationality}</p>
            <p><strong>Occupation:</strong> ${occupation}</p>
            <p><strong>Monthly Income:</strong> ${monthlyIncome}</p>
            <p><strong>Address:</strong> ${address}</p>
            <p><strong>Contact Number:</strong> ${contactNumber}</p>
            <p><strong>Source of Referral:</strong> ${sourceOfReferral}</p>
            <p><strong>Circumstances of Referral:</strong> ${circumstancesOfReferral}</p>
            <p><strong>Family Background:</strong> ${familyBackground}</p>
            <p><strong>Health History:</strong> ${healthHistory}</p>
            <p><strong>Economic Situation:</strong> ${economicSituation}</p>
            <p><strong>House Structure:</strong> ${houseStructure}</p>
            <p><strong>Floor:</strong> ${floor}</p>
            <p><strong>Type:</strong> ${type}</p>
            <p><strong>Number of Rooms:</strong> ${numberOfRooms}</p>
            <p><strong>Appliances:</strong> ${appliances}</p>
            <p><strong>Monthly Expenses:</strong> ${monthlyExpenses}</p>
            <p><strong>Indicate:</strong> ${indicate}</p>
            <p><strong>Assessment:</strong> ${assessment}</p>
            <p><strong>Recommendation:</strong> ${recommendation}</p>
        `;

        // Set the HTML to the filledData div
        document.getElementById('filledData').innerHTML = filledDataHtml;
    }

    // Event listener for modal shown event
    $('#dataEntryModal').on('shown.bs.modal', function () {
        populateFilledData();
    });

        // Initial options for each service
        var serviceOptions = {
            "Burial": ["Option 1 for Burial", "Option 2 for Burial"],
            "Funeral": ["Option 1 for Funeral", "Option 2 for Funeral"],
            "Financial": ["Option 1 for Financial", "Option 2 for Financial"],
            // Add options for other services if needed
        };
    
        function toggleOtherServices() {
            var servicesSelect = document.getElementById("Services");
            var otherServicesDiv = document.getElementById("otherServices");
            var otherServicesDropdown = document.getElementById("other_services");
    
            if (servicesSelect.value !== "") {
                // Display the second dropdown for selected services
                otherServicesDiv.style.display = "block";
    
                // Clear existing options
                otherServicesDropdown.innerHTML = "";
    
                // Add options based on the selected service
                switch (servicesSelect.value) {
                    case "Burial":
                        addOption(otherServicesDropdown, "Option 1 for Burial Services", "Option1_Burial_Services");
                        addOption(otherServicesDropdown, "Option 2 for Burial Services", "Option2_Burial_Services");
                        // Add more options for Burial as needed
                        break;
                    case "Funeral":
                        addOption(otherServicesDropdown, "Option 1 for Funeral Services", "Option1_Funeral_Services");
                        addOption(otherServicesDropdown, "Option 2 for Funeral Services", "Option2_Funeral_Services");
                        // Add more options for Funeral as needed
                        break;
                    case "Financial":
                        addOption(otherServicesDropdown, "Option 1 for Financial Services", "Option1_Financial_Services");
                        addOption(otherServicesDropdown, "Option 2 for Financial Services", "Option2_Financial_Services");
                        // Add more options for Financial as needed
                        break;
                    // Add cases for other services
                }
            } else {
                // Hide the second dropdown if no service is selected
                otherServicesDiv.style.display = "none";
            }
        }
    
        function addOption(selectElement, text, value) {
            var option = document.createElement("option");
            option.text = text;
            option.value = value;
            selectElement.appendChild(option);
        }
        function confirmDelete(form) {
            if (confirm("Are you sure you want to delete this?")) {
                return true;
            } else {
                return false;
            }
        }