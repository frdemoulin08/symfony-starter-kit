import { initThemeToggle } from '../helpers/theme.js';
import { initNotificationBadge } from '../helpers/notifications.js';
import { initTableAjax } from '../table-ajax.js';
import { initModalToggles } from '../helpers/modal.js';

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initNotificationBadge();
    initTableAjax();
    initModalToggles();
});
