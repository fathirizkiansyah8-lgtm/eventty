/* Frontend-only icon normalization. Keeps charts intact and upgrades UI icons to Iconify. */
(function () {
    const classMap = [
        ['calendar', 'calendar-days'], ['clock', 'clock-3'], ['map-marker', 'map-pin'], ['location', 'map-pin'],
        ['search', 'search'], ['trash', 'trash-2'], ['download', 'download'], ['eye', 'eye'],
        ['certificate', 'badge-check'], ['award', 'award'], ['id-card', 'contact'], ['check', 'check'],
        ['times', 'x'], ['close', 'x'], ['arrow-left', 'arrow-left'], ['arrow-right', 'arrow-right'],
        ['chevron-left', 'chevron-left'], ['chevron-right', 'chevron-right'], ['user', 'user-round'],
        ['users', 'users-round'], ['bell', 'bell'], ['message', 'message-circle'], ['send', 'send'],
        ['logout', 'log-out'], ['sign-out', 'log-out'], ['cog', 'settings'], ['gear', 'settings'],
        ['info', 'info'], ['warning', 'triangle-alert'], ['exclamation', 'circle-alert'],
        ['plus', 'plus'], ['edit', 'pencil'], ['home', 'house'], ['dashboard', 'layout-dashboard']
    ];

    function iconFromClass(value) {
        const classes = String(value || '').toLowerCase();
        const match = classMap.find(([needle]) => classes.includes(needle));
        return match ? `lucide:${match[1]}` : 'lucide:circle';
    }

    function createIcon(icon, source) {
        const element = document.createElement('iconify-icon');
        element.setAttribute('icon', icon);
        const width = source.getAttribute('width');
        const height = source.getAttribute('height');
        if (width) element.setAttribute('width', width);
        if (height) element.setAttribute('height', height);
        if (source.className && typeof source.className === 'string') element.className = source.className;
        if (source.getAttribute('aria-hidden')) element.setAttribute('aria-hidden', 'true');
        if (source.getAttribute('title')) element.setAttribute('title', source.getAttribute('title'));
        if (source.getAttribute('style')) element.setAttribute('style', source.getAttribute('style'));
        return element;
    }

    function upgrade(root) {
        if (!root || !window.customElements || !customElements.get('iconify-icon')) return;
        root.querySelectorAll('svg:not([viewBox="0 0 100 100"]):not([data-preserve-svg])').forEach(function (svg) {
            const markup = svg.outerHTML.toLowerCase();
            let icon = 'lucide:circle';
            if (markup.includes('line x1="3" y1="12"') || markup.includes('hamburger')) icon = 'lucide:menu';
            else if (markup.includes('line x1="12" y1="5"') && markup.includes('line x1="5" y1="12"')) icon = 'lucide:plus';
            else if (markup.includes('circle cx="11"') && markup.includes('line x1="21"')) icon = 'lucide:search';
            else if (markup.includes('circle cx="12" cy="12"') && markup.includes('polyline points="12 6 12 12 16 14"')) icon = 'lucide:clock-3';
            else if (markup.includes('path d="m17 21v-2"') || markup.includes('path d="m17 21v-2"')) icon = 'lucide:users-round';
            else if (markup.includes('polyline points="20 6 9 17 4 12"')) icon = 'lucide:check';
            else if (markup.includes('polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"')) icon = 'lucide:zap';
            else if (markup.includes('polyline points="15 18 9 12 15 6"')) icon = 'lucide:chevron-left';
            else if (markup.includes('polyline points="12 5 19 12 12 19"')) icon = 'lucide:arrow-right';
            else if (markup.includes('circle cx="12" cy="8"') && markup.includes('polyline')) icon = 'lucide:badge-check';
            else if (markup.includes('rect x="3" y="4"') && markup.includes('line x1="16"')) icon = 'lucide:calendar-days';
            else if (markup.includes('path d="m20 20-4-4"')) icon = 'lucide:search';
            else if (markup.includes('path d="m19 6-14 14"')) icon = 'lucide:x';
            const replacement = createIcon(icon, svg);
            svg.replaceWith(replacement);
        });

        root.querySelectorAll('i[class*="fa-"]').forEach(function (fontIcon) {
            const replacement = createIcon(iconFromClass(fontIcon.className), fontIcon);
            fontIcon.replaceWith(replacement);
        });
    }

    function start() {
        upgrade(document);
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (node) {
                    if (node.nodeType === Node.ELEMENT_NODE) upgrade(node);
                });
            });
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', start);
    else start();
})();
