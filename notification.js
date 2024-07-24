document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('notification-modal');
    const closeButton = document.querySelector('.closebutton');

    // Fetch notifications on page load
    fetchNotifications();

    // Open the modal
    document.getElementById('notification-btn').addEventListener('click', function () {
        modal.style.display = 'block';
    });

    // Close the modal
    closeButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Hide the modal if clicked outside of the content
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Handle notifications
    function handleNotification(action, booking_id, type, newTime = '', appointmentDate = '', appointmentTime = '', oldAppointmentTime = '') {
        fetch('Landlord_handle-notification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: action,
                booking_id: booking_id,
                type: type,
                newTime: newTime,
                appointmentDate: appointmentDate,
                appointmentTime: appointmentTime,
                oldAppointmentTime: oldAppointmentTime
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Display the response message
            modal.style.display = 'none'; // Hide the modal after action
            fetchNotifications(); // Update notifications after handling action
        })
        .catch(error => console.error('Error:', error));
    }

    // Check if the new time is available
    function isTimeAvailable(time) {
        // Dummy function to simulate time availability check
        return true; // Always return true for demo purposes
    }

    // Open modal with booking details
    function openModal(booking_id, email, date, time) {
        modal.innerHTML = `
            <div class="modal-content">
                <span class="closebutton">&times;</span>
                <h2>Manage Booking</h2>
                <p>Email: ${email}</p>
                <p>Date: ${date}</p>
                <p>Time: ${time}</p>
                <button id="approve-btn" data-id="${booking_id}">Approve</button>
                <button id="decline-btn" data-id="${booking_id}">Decline</button>
                <button id="reschedule-btn" data-id="${booking_id}">Reschedule</button>
            </div>
        `;
        modal.style.display = 'block';

        // Handle buttons
        document.getElementById('approve-btn').addEventListener('click', function () {
            handleNotification('approve', booking_id, 'booking'); // Adjust type if needed
        });
        document.getElementById('decline-btn').addEventListener('click', function () {
            handleNotification('decline', booking_id, 'booking', '', date, time);
        });
        document.getElementById('reschedule-btn').addEventListener('click', function () {
            const newTime = prompt('Please enter the new time:');
            if (newTime && isTimeAvailable(newTime)) {
                handleNotification('reschedule', booking_id, 'booking', newTime, date, time, 'oldAppointmentTime'); // Adjust oldAppointmentTime if needed
            } else {
                alert('The selected time is not available. Please choose another time.');
            }
        });
    }

    // Fetch and display notifications
    function fetchNotifications() {
        fetch('fetch-notifications.php')
            .then(response => response.json())
            .then(data => {
                const notificationsContainer = document.querySelector('.notification-list');
                notificationsContainer.innerHTML = '';
                data.notifications.forEach(notification => {
                    notificationsContainer.innerHTML += `
                        <div class="notification-item">
                            <p>New booking request from tenant: ${notification.tenant_name}</p>
                            <p>Booking Date: ${notification.booking_date}</p>
                            <p>Booking Time: ${notification.booking_time}</p>
                            <input type="checkbox" class="notification-checkbox" data-id="${notification.booking_id}" data-email="${notification.email}" data-date="${notification.booking_date}" data-time="${notification.booking_time}">
                            <button class="view-details-btn" data-id="${notification.booking_id}">View Details</button>
                        </div>
                    `;
                });
                // Attach event listeners to new buttons and checkboxes
                document.querySelectorAll('.notification-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        if (this.checked) {
                            const booking_id = this.getAttribute('data-id');
                            const email = this.getAttribute('data-email');
                            const date = this.getAttribute('data-date');
                            const time = this.getAttribute('data-time');
                            openModal(booking_id, email, date, time);
                        }
                    });
                });
                document.querySelectorAll('.view-details-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const booking_id = this.getAttribute('data-id');
                        window.location.href = `booking-details.php?id=${booking_id}`;
                    });
                });
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // Fetch notifications every 30 seconds (for example)
    setInterval(fetchNotifications, 30000);
});

  document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('notification-modal');
            const notificationBtn = document.getElementById('notification-btn');
            const closeButton = document.querySelector('.closebutton');
            const approveBtn = document.getElementById('approve-btn');
            const declineBtn = document.getElementById('decline-btn');
            const rescheduleBtn = document.getElementById('reschedule-btn');

            // Open the modal
            notificationBtn.addEventListener('click', function () {
                modal.style.display = 'block';
            });

            // Close the modal
            closeButton.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            // Hide the modal if clicked outside of the content
            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Handle approve button click
            approveBtn.addEventListener('click', function () {
                handleNotification('approve');
            });

            // Handle decline button click
            declineBtn.addEventListener('click', function () {
                handleNotification('decline');
            });

            // Handle reschedule button click
            rescheduleBtn.addEventListener('click', function () {
                const newTime = prompt('Please enter the new time:');
                handleNotification('reschedule', newTime);
            });

            function handleNotification(action, newTime = '') {
                fetch('Landlord_handle-notification.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: action,
                        id: notificationId, // Replace with actual ID
                        type: notificationType, // Replace with 'booking' or 'appointment'
                        newTime: newTime,
                        appointmentDate: appointmentDate,
                        appointmentTime: appointmentTime,
                        oldAppointmentTime: oldAppointmentTime
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Display the response message
                    modal.style.display = 'none'; // Hide the modal after action
                    fetchNotifications(); // Update notifications after handling action
                })
                .catch(error => console.error('Error:', error));
            }

            function fetchNotifications() {
                fetch('fetch-notifications.php')
                    .then(response => response.json())
                    .then(data => {
                        const notificationsContainer = document.querySelector('.notifications');
                        notificationsContainer.innerHTML = '';
                        data.notifications.forEach(notification => {
                            notificationsContainer.innerHTML += `
                                <div class="notification-item">
                                    <p>New booking request for property: ${notification.property_name}</p>
                                    <p>Booking Date: ${notification.booking_date}</p>
                                    <button class="view-details-btn" data-id="${notification.booking_id}">View Details</button>
                                </div>
                            `;
                        });
                        // Attach event listeners to new buttons
                        document.querySelectorAll('.view-details-btn').forEach(button => {
                            button.addEventListener('click', function () {
                                const bookingId = this.getAttribute('data-id');
                                openModal(bookingId);
                            });
                        });
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }

            function openModal(bookingId) {
                // Fetch booking details and update modal content
                fetch(`fetch-booking-details.php?id=${bookingId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('notification-message').innerText = `Booking details for ${data.property_name} on ${data.booking_date}`;
                        modal.style.display = 'block';
                    })
                    .catch(error => console.error('Error fetching booking details:', error));
            }

            // Fetch notifications on page load
            fetchNotifications();

            // Fetch notifications every 30 seconds
            setInterval(fetchNotifications, 30000);
        });