// Simulate cart
let cart = [];

function addToCart(productName, productPrice) {
    // Add the product to the cart
    cart.push({ name: productName, price: productPrice });

    // Store the cart in localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Alert the user that the item has been added
    alert(`${productName} has been added to your cart!`);
}

// Load cart on page load (for cart.html)
window.onload = function() {
    // Retrieve the cart from localStorage
    const savedCart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = savedCart;

    // Display the cart contents
    updateCartSummary();
};

function updateCartSummary() {
    const totalPrice = cart.reduce((total, item) => total + item.price, 0);
    const cartSummary = document.querySelector('.cart-summary p');
    if (cartSummary) {
        cartSummary.textContent = `Total: $${totalPrice.toFixed(2)}`;
    }
}

// Wishlist functionality
function addToWishlist(productName) {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    if (!wishlist.includes(productName)) {
        wishlist.push(productName);
        localStorage.setItem("wishlist", JSON.stringify(wishlist));
        alert(productName + " added to wishlist!");
    } else {
        alert(productName + " is already in your wishlist!");
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Hero Banner Slider
    const bannerWrapper = document.querySelector('.banner-wrapper');
    
    if (bannerWrapper) {
        const bannerSlides = [
            {
                imgSrc: 'images/banner.jpg', // Replace with your dynamic image paths
                caption: 'Step Into Style with SwooshX',
                description: 'Find the best shoes for every occasion.'
            },
            {
                imgSrc: 'images/banner2.jpg', // Another dynamic image path
                caption: 'Fresh Arrivals Just In',
                description: 'Be the first to rock the newest styles.'
            },
        ];

        bannerSlides.forEach(slide => {
            const slideDiv = document.createElement('div');
            slideDiv.classList.add('banner-slide');
            
            const imgElement = document.createElement('img');
            imgElement.src = slide.imgSrc;
            imgElement.alt = "Hero Banner";
            imgElement.classList.add('hero-image');
            
            const captionDiv = document.createElement('div');
            captionDiv.classList.add('banner-caption');
            
            const h1 = document.createElement('h1');
            h1.textContent = slide.caption;
            
            const p = document.createElement('p');
            p.textContent = slide.description;
            
            captionDiv.appendChild(h1);
            captionDiv.appendChild(p);
            
            slideDiv.appendChild(imgElement);
            slideDiv.appendChild(captionDiv);
            
            bannerWrapper.appendChild(slideDiv);
        });

        const prevButton = document.createElement('button');
        prevButton.classList.add('prev');
        prevButton.innerHTML = '&#10094;';
        prevButton.onclick = () => moveSlide(-1);
        
        const nextButton = document.createElement('button');
        nextButton.classList.add('next');
        nextButton.innerHTML = '&#10095;';
        nextButton.onclick = () => moveSlide(1);
        
        bannerWrapper.appendChild(prevButton);
        bannerWrapper.appendChild(nextButton);

        let currentSlide = 0;

        function moveSlide(step) {
            const slides = document.querySelectorAll('.banner-slide');
            currentSlide += step;

            if (currentSlide < 0) {
                currentSlide = slides.length - 1;
            } else if (currentSlide >= slides.length) {
                currentSlide = 0;
            }

            const offset = -currentSlide * 100;
            document.querySelector('.banner-wrapper').style.transform = `translateX(${offset}%)`;
        }
    }

    // Grid/List View Toggle
    $('#gridView').click(() => {
        $('.product-gallery').removeClass('list-view');
    });
    
    $('#listView').click(() => {
        $('.product-gallery').addClass('list-view');
    });

    // Handle sorting
    $('#sort').change(function() {
        const sort = $(this).val();
        window.location.href = `shop.php?sort_order=${sort}`;
    });

    // Product details modal handling
    $(document).on("click", ".view-details", function() {
        var productId = $(this).data("product-id");
        $.get("product_details.php", { id: productId }, function(data) {
            // Assuming the product details are returned as JSON
            if (data.error) {
                alert(data.error);
                return;
            }

            // Fill the form with product details
            $("#productImage").attr("src", data.image);
            $("#productName").val(data.name);
            $("#productBrand").val(data.brand);
            $("#productDescription").val(data.description);
            
            // Populate size options dynamically
            const sizeSelect = $("#productSizes");
            sizeSelect.empty(); // Clear existing sizes
            data.sizes.forEach(size => {
                sizeSelect.append(`<option value="${size}">${size}</option>`);
            });

            $("#productPrice").val('$' + data.price);
            $("#productModal").fadeIn();
        }).fail(function() {
            alert("Error fetching product details.");
        });
    });

    // Close the modal
    $(".close").click(function() {
        $("#productModal").fadeOut();
    });

    // Close the modal if clicked outside the modal content
    $(window).click(function(event) {
        if ($(event.target).is("#productModal")) {
            $("#productModal").fadeOut();
        }
    });
    
    // Switch to grid view
    $('#gridView').click(function() {
        $('.product-gallery').removeClass('list-view').addClass('grid-view');
        $(".view-btn").removeClass("active");
        $(this).addClass("active");
    });

    // Switch to list view
    $('#listView').click(function() {
        $('.product-gallery').removeClass('grid-view').addClass('list-view');
        $(".view-btn").removeClass("active");
        $(this).addClass("active");
    });

});
