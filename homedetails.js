document.addEventListener("DOMContentLoaded", function() {
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const scrollAmount = 300; // Amount to scroll

    document.querySelector('.prev').addEventListener('click', () => {
        sliderWrapper.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });

    document.querySelector('.next').addEventListener('click', () => {
        sliderWrapper.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });
});

// APPLICATION POP-UP
 // Function to open the booking popup
 function OpenAppPopup() {
    document.getElementById("appmodal").style.display = "block";
}

// Function to close the booking popup
function CloseAppPopup() {
    document.getElementById("appmodal").style.display = "none";
}

// Function to go to the next step
function goToNextOrder(order) {
    var currentStep = document.getElementById('order' + order);
    var nextStep = document.getElementById('order' + (order + 1));
    if (currentStep && nextStep) {
        currentStep.style.display = 'none';
        nextStep.style.display = 'block';
    }
}

function goToPreviousOrder(order) {
    var currentStep = document.getElementById('order' + order);
    var previousStep = document.getElementById('order' + (order - 1));
    if (currentStep && previousStep) {
        currentStep.style.display = 'none';
        previousStep.style.display = 'block';
    }
}


 
// Close the pop-up if the user clicks anywhere outside of it
window.onclick = function(event) {
    var modal = document.getElementById("appmodal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Booking pop-up
    // Function to open the booking popup
    function OpenBookingPopup() {
        document.getElementById("bookingmodal").style.display = "block";
    }

    // Function to close the booking popup
    function CloseBookingPopup() {
        document.getElementById("bookingmodal").style.display = "none";
    }

    // Function to go to the next step
    function nextStep(step) {
        document.getElementById(`step${step}`).style.display = "none";
        document.getElementById(`step${step + 1}`).style.display = "block";
    }

    // Function to go to the previous step
    function previousStep(step) {
        document.getElementById(`step${step + 1}`).style.display = "none";
        document.getElementById(`step${step}`).style.display = "block";
    }

    // Close the modal when the user clicks outside of it
    window.onclick = function(event) {
        const modal = document.getElementById("bookingmodal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
 

   


