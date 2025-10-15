import './bootstrap';

// Theme toggle with persistence
(() => {
    const storageKey = 'theme';
	const classList = document.documentElement.classList;

	function applyTheme(theme) {
		if (theme === 'dark') {
			classList.add('dark');
		} else {
			classList.remove('dark');
		}
	}
    if (localStorage.getItem(storageKey) == undefined){
        localStorage.setItem(storageKey, 'dark');
    }

	// Listen for toggle button clicks (delegated)
	window.addEventListener('click', (e) => {
		const btn = e.target.closest('[data-theme-toggle]');
		if (!btn) return;
        const isDark = localStorage.getItem(storageKey) == 'dark'
		const next = isDark ? 'light' : 'dark';
		localStorage.setItem(storageKey, next);
        applyTheme(next);
	});
})();
