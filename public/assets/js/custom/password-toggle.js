"use strict";

// Password Toggle Functionality
var KTPasswordToggle = function() {
    ////////////////////////////
    // ** Private variables  ** //
    ////////////////////////////

    ////////////////////////////
    // ** Private methods  ** //
    ////////////////////////////

    // Initialize
    var _init = function() {
        // Find all password toggle buttons (both new and existing systems)
        const toggleButtons = document.querySelectorAll('[data-kt-password-toggle="visibility"], [data-kt-password-meter-control="visibility"]');
        
        toggleButtons.forEach((button) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Find the associated password input
                const passwordField = button.parentElement.querySelector('input[type="password"], input[type="text"]');
                
                if (!passwordField) {
                    console.warn('Password field not found for toggle button');
                    return;
                }
                
                // Get the eye icons
                const eyeSlash = button.querySelector('.bi-eye-slash');
                const eye = button.querySelector('.bi-eye');
                
                if (!eyeSlash || !eye) {
                    console.warn('Eye icons not found for toggle button');
                    return;
                }
                
                // Toggle password visibility
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    eyeSlash.classList.add('d-none');
                    eye.classList.remove('d-none');
                } else {
                    passwordField.type = 'password';
                    eyeSlash.classList.remove('d-none');
                    eye.classList.add('d-none');
                }
                
                // Focus back to the input
                passwordField.focus();
            });
        });
    }

    ///////////////////////
    // ** Public API  ** //
    ///////////////////////

    return {
        init: function() {
            _init();
        }
    };
}();

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    KTPasswordToggle.init();
});

// Also initialize when new content is loaded (for modals, AJAX content, etc.)
document.addEventListener('DOMNodeInserted', function() {
    KTPasswordToggle.init();
});

// For modern browsers, use MutationObserver instead of DOMNodeInserted
if (typeof MutationObserver !== 'undefined') {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                // Check if any password toggle buttons were added
                const hasPasswordToggles = Array.from(mutation.addedNodes).some(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        return node.querySelector && (
                            node.querySelector('[data-kt-password-toggle="visibility"]') ||
                            node.querySelector('[data-kt-password-meter-control="visibility"]') ||
                            node.matches && (node.matches('[data-kt-password-toggle="visibility"]') || node.matches('[data-kt-password-meter-control="visibility"]'))
                        );
                    }
                    return false;
                });
                
                if (hasPasswordToggles) {
                    KTPasswordToggle.init();
                }
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}
