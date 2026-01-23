import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'flowbite';

const themeToggleBtn = document.getElementById('theme-toggle');
const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
const storedTheme = localStorage.getItem('color-theme');
const isDarkTheme = storedTheme === 'dark' || (!storedTheme && prefersDark);

if (isDarkTheme) {
    document.documentElement.classList.add('dark');
    themeToggleLightIcon?.classList.remove('hidden');
} else {
    document.documentElement.classList.remove('dark');
    themeToggleDarkIcon?.classList.remove('hidden');
}

themeToggleBtn?.addEventListener('click', () => {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
    themeToggleDarkIcon?.classList.toggle('hidden', isDark);
    themeToggleLightIcon?.classList.toggle('hidden', !isDark);
});
