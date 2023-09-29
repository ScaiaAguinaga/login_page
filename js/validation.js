// Create a new instance of JustValidate for form validation
const validation = new JustValidate("#signup");

// Define validation rules for form fields
validation
    .addField("#username", [
        {
            rule: "required", // Username is required
        },
    ])
    .addField("#email", [
        {
            rule: "required", // Email is required
        },
        {
            rule: "email", // Email must be in a valid email format
        },
        {
            // Custom validator to check email availability
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        return json.available; // Return whether the email is available
                    });
            },
            errorMessage: "Email already taken", // Error message if email is not available
        },
    ])
    .addField("#password", [
        {
            rule: "required", // Password is required
        },
        {
            rule: "password", // Password must meet certain password strength criteria
        },
    ])
    .addField("#password_confirmation", [
        {
            // Custom validator to check if password and password confirmation match
            validator: (value, fields) => {
                return value === fields["#password"].elem.value; // Compare with the password field
            },
            errorMessage: "Passwords should match", // Error message if passwords do not match
        },
    ])
    .onSuccess((event) => {
        // If form validation is successful, submit the form
        document.getElementById("signup").submit();
    });
