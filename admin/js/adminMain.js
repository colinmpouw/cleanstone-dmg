
/* ==========================================================================
   alertBox.js
   Reusable alert function with CleanStone design.

   Usage:
   showAlert({
       type: 'success',  // 'success', 'error', 'warning', 'info'
       title: 'Gelukt!',
       message: 'Je order is opgeslagen.',
       buttons: [
           { text: 'OK', type: 'primary', action: () => {...} }
       ]
   });
   ========================================================================== */

function showAlert(options = {}) {
    const {
        type = 'info',              // 'success' | 'error' | 'warning' | 'info'
        title = 'Melding',
        message = '',
        buttons = [],
        onClose = null
    } = options;

    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'alert-overlay';
    overlay.id = 'alertOverlay';

    // Create alert box
    const alertBox = document.createElement('div');
    alertBox.className = 'alert-box';

    // Icons map
    const iconMap = {
        success: 'ti-circle-check',
        error: 'ti-circle-x',
        warning: 'ti-alert-circle',
        info: 'ti-info-circle'
    };

    // Create icon
    const iconEl = document.createElement('i');
    iconEl.className = `ti ${iconMap[type] || iconMap.info} alert-icon alert-${type}`;
    alertBox.append(iconEl);

    // Create title
    const titleEl = document.createElement('h2');
    titleEl.className = 'alert-title';
    titleEl.textContent = title;
    alertBox.append(titleEl);

    // Create message
    if (message) {
        const messageEl = document.createElement('p');
        messageEl.className = 'alert-message';
        messageEl.textContent = message;
        alertBox.append(messageEl);
    }

    // Create actions container
    const actionsEl = document.createElement('div');
    actionsEl.className = 'alert-actions';

    // Default button if none provided
    const buttonsToRender = buttons.length > 0
        ? buttons
        : [{ text: 'OK', type: 'primary' }];

    // Render buttons
    buttonsToRender.forEach(btn => {
        const button = document.createElement('button');
        button.className = `alert-btn alert-btn-${btn.type || 'primary'}`;
        button.textContent = btn.text || 'OK';

        button.addEventListener('click', () => {
            if (btn.action && typeof btn.action === 'function') {
                btn.action();
            }
            closeAlert();
        });

        actionsEl.append(button);
    });

    alertBox.append(actionsEl);
    overlay.append(alertBox);

    // Add to DOM
    document.body.append(overlay);

    // Close on overlay click
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            closeAlert();
        }
    });

    // Close on Escape key
    const closeOnEscape = (e) => {
        if (e.key === 'Escape') {
            closeAlert();
            document.removeEventListener('keydown', closeOnEscape);
        }
    };
    document.addEventListener('keydown', closeOnEscape);

    function closeAlert() {
        overlay.style.animation = 'fadeOut 0.2s ease';
        setTimeout(() => {
            overlay.remove();
            if (onClose && typeof onClose === 'function') {
                onClose();
            }
        }, 200);
    }

    // Return close function for manual control
    return closeAlert;
}

// Add fadeOut animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.append(style);