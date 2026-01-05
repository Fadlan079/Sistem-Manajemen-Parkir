(function(){
    const html = document.documentElement;

    function applyTheme(mode){
        html.classList.remove('theme-light','theme-dark','theme-default');
        html.classList.add(`theme-${mode}`);
    }

    const storedTheme = localStorage.getItem('theme');

    if(storedTheme){
        applyTheme(storedTheme);
    } else {
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(systemDark ? 'dark' : 'light');
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if(!localStorage.getItem('theme')){
            applyTheme(e.matches ? 'dark' : 'light');
        }
    });

    window.setTheme = function(mode){
        applyTheme(mode);
        localStorage.setItem('theme', mode);
    }

    window.resetTheme = function(){
        localStorage.removeItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(systemDark ? 'dark' : 'light');
    }

    function initThemeToggle() {
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon   = document.getElementById('themeIcon');
        if (!themeToggle || !themeIcon) return;

        function getCurrentTheme(){
            return localStorage.getItem('theme')
                || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        }

        function updateThemeIcon(theme){
            const icons = {
                light: 'fa-sun',
                dark: 'fa-moon',
                cyan: 'fa-droplet'
            };
            themeIcon.className = 'fa-solid ' + (icons[theme] || 'fa-circle');
        }

        updateThemeIcon(getCurrentTheme());

        themeToggle.addEventListener('click', () => {
            const themes = ['light', 'dark', 'default'];
            const current = getCurrentTheme();
            const currentIndex = themes.indexOf(current);
            const nextIndex = (currentIndex + 1) % themes.length;
            const next = themes[nextIndex];

            setTheme(next);
            updateThemeIcon(next);
        });

    }

    document.addEventListener('DOMContentLoaded', () => {
        initThemeToggle();
    });

})();