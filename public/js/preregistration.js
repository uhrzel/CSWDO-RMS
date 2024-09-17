function toggleOtherNationality() {
    var nationalitySelect = document.getElementById("nationality");
    var otherNationalityDiv = document.getElementById("otherNationality");
    var otherNationalityInput = document.getElementById("other_nationality");

    if (nationalitySelect.value === "Other") {
        otherNationalityDiv.style.display = "block";
        otherNationalityInput.setAttribute("name", "other_nationality");
    } else {
        otherNationalityDiv.style.display = "none";
        otherNationalityInput.removeAttribute("name");
    }
}

function toggleOtherReligion() {
    var religionSelect = document.getElementById("religion");
    var otherReligionDiv = document.getElementById("otherReligion"); // Correct ID here
    var otherReligionInput = document.getElementById("other_religion");

    if (religionSelect.value === "Other") {
        otherReligionDiv.style.display = "block";
        otherReligionInput.setAttribute("name", "other_religion");
    } else {
        otherReligionDiv.style.display = "none";
        otherReligionInput.removeAttribute("name");
    }
}

function toggleOtherType() {
    var typeSelect = document.getElementById("type");
    var otherTypeDiv = document.getElementById("otherType");
    var otherTypeInput = document.getElementById("other_type");

    if (typeSelect.value === "Other") {
        otherTypeDiv.style.display = "block";
        otherTypeInput.setAttribute("name", "other_type");
    } else {
        otherTypeDiv.style.display = "none";
        otherTypeInput.removeAttribute("name");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("preRegistrationForm");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((response) => response.json())
            .then((data) => {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: data.message,
                    footer: `Control Number: ${data.control_number}`,
                }).then(() => {
                    form.reset(); // Reset form after successful submission
                });
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                });
            });
    });
});

document
    .getElementById("date_of_birth")
    .addEventListener("input", function (e) {
        var dateInput = e.target.value;
        var year = dateInput.split("-")[0];

        if (year.length > 4) {
            e.target.value = dateInput.slice(0, 4) + dateInput.slice(5);
            alert("Please enter a valid 4-digit year.");
        }
    });
