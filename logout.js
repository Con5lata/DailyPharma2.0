
document.addEventListener('DOMContentLoaded', function() {
    // Get the logout button element
    var logoutButton = document.getElementById('logoutButton');
    
    // Attach a click event listener to the logout button
    logoutButton.addEventListener('click', function(event) {
        // Show a confirmation dialog
        var isConfirmed = confirm('Are you sure you want to log out?');
        
        // If the user clicks "Cancel", prevent the default action
        if (!isConfirmed) {
            event.preventDefault();
        }
    });
});

