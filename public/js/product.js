// Product Detail Page JavaScript

// Quantity Control
function increaseQty() {
    const input = document.getElementById('quantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Change Main Image
function changeImage(thumbnail) {
    const mainImage = document.getElementById('mainImage');
    const src = thumbnail.querySelector('img').src;
    mainImage.src = src;

    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
    thumbnail.classList.add('active');
}

// Add to Cart
function addToCart(productId) {
    const quantity = parseInt(document.getElementById('quantity').value);
    
    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Product toegevoegd aan winkelwagen', 'success');
            // Optional: Update cart count in header
            updateCartCount();
        } else {
            showNotification('Fout bij toevoegen aan winkelwagen', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Fout bij toevoegen aan winkelwagen', 'error');
    });
}

// Toggle Wishlist
function toggleWishlist(productId) {
    const btn = event.target.closest('.btn-wishlist');
    
    fetch('/api/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.classList.toggle('active', data.added);
            const message = data.added ? 'Toegevoegd aan favorieten' : 'Verwijderd uit favorieten';
            showNotification(message, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Fout bij bijwerken favoriet', 'error');
    });
}

// Show Notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Update Cart Count
function updateCartCount() {
    // This would update the cart count in the header
    // Implementation depends on your cart system
}

// Add slide animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Check if product is in wishlist (if user is logged in)
    // This would require checking from backend
});
