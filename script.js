document.addEventListener('DOMContentLoaded', () => {
    // Your existing code here
    function animatePlaceholder() {
        // Placeholder 动画逻辑
    }
    
    animatePlaceholder();

    let slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("demo");
        let captionText = document.getElementById("caption");
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        captionText.innerHTML = dots[slideIndex - 1].alt;
    }
});






$(document).ready(function() {
    function fetchProperties() {
        var taman = $('#search-input').val();
        var propertyType = $('#residentialBtn').data('value') || 'all'; // Renamed for clarity
        var price = $('#priceBtn').data('value') || 'any';
        var bedroom = $('#bedroomBtn').data('value') || 'any';
        var userType = $('#usertype').val(); // 获取用户类型

        // 构建不同的URL基于用户类型
        var baseUrl = '';
        if (userType === 'Guest') {
            baseUrl = 'Guest_Catalogue.php';
        } else if (userType === 'Tenant') {
            baseUrl = 'Tenant_Catalogue.php';
        } else if (userType === 'Landlord') {
            baseUrl = 'Landlord_Catalogue.php';
        }

        // Construct the URL with query parameters
        var url = baseUrl + '?taman=' + encodeURIComponent(taman) +
                  '&propertyType=' + encodeURIComponent(propertyType) +
                  '&price=' + encodeURIComponent(price) +
                  '&bedroom=' + encodeURIComponent(bedroom);

        // Redirect to the URL
        window.location.href = url;
    }

    function displaySelectedFilters() {
        var propertyTypeText = $('.residential-option.selected').text() || 'All Residential'; // Renamed for clarity
        var priceText = $('.price-option.selected').text() || 'Any Price';
        var bedroomText = $('.bedroom-option.selected').text() || 'Bedroom';

        $('#residentialBtn').text(propertyTypeText); // Update button text
        $('#priceBtn').text(priceText);
        $('#bedroomBtn').text(bedroomText);
    }

    $('.apply-button').on('click', function(event) {
        event.preventDefault();
        var filterType = $(this).closest('.dropdown-content').attr('id').replace('Dropdown', '');
        $('#' + filterType + 'Btn').data('value', $('.' + filterType + '-option.selected').data('value'));
        displaySelectedFilters();
    });

    $('.search-button').on('click', function(event) {
        event.preventDefault();
        fetchProperties();
    });

    $('#search-input').on('input', function() {
        const input = $(this).val();
        const suggestions = $('#suggestions');
        suggestions.empty();
        if (input.length > 0) {
            const filteredNames = tamanNames.filter(name => name.toLowerCase().includes(input.toLowerCase()));
            filteredNames.forEach(name => {
                const suggestion = $('<div>').addClass('suggestion').text(name);
                suggestion.on('click', function() {
                    $('#search-input').val(name);
                    suggestions.empty();
                });
                suggestions.append(suggestion);
            });
        }
    });

    $('.residential-option, .price-option, .bedroom-option').on('click', function() {
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
    });

    $('.clear-button').on('click', function() {
        var filterType = $(this).closest('.dropdown-content').attr('id').replace('Dropdown', '');
        $('#' + filterType + 'Btn').text(filterType.charAt(0).toUpperCase() + filterType.slice(1)).data('value', filterType === 'price' ? 'any' : 'all');
        $('.' + filterType + '-option').removeClass('selected');
    });
});













