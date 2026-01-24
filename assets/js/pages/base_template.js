import { initThemeToggle } from '../helpers/theme.js';
import { initNotificationBadge } from '../helpers/notifications.js';
import { initTabulatorTables } from '../tabulator/init.js';

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initNotificationBadge();
    initTabulatorTables();
});
