document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('contactForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Get form data
        const formData = new FormData(form);

        // Validate data
        const fullName = formData.get('full_name');
        const policyNumber = formData.get('policy_number');
        const dob = formData.get('dob');
        const carRegNumber = formData.get('car_reg_number');
        const postcode = formData.get('postcode');
        const message = formData.get('message');

        if (!fullName || !policyNumber || !dob || !carRegNumber || !postcode || !message) {
            alert('Please fill in all the required fields.');
            return;
        }

        // If all fields are filled, proceed with sending data
        sendData(formData);
    });

    function sendData(formData) {
        fetch('submit_form.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                alert('Form submitted successfully!');
                form.reset();
            } else {
                alert('Failed to submit form. Please try again later.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    }
});
