import { initThemeToggle } from '../helpers/theme.js';
import { initNotificationBadge } from '../helpers/notifications.js';

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initNotificationBadge();
});
