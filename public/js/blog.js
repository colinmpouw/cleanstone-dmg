document.addEventListener('DOMContentLoaded', () => {
    const filters = document.querySelectorAll('.filters .pill[data-filter]');
    const cards = document.querySelectorAll('.post-card[data-themes]');
    const noPosts = document.querySelector('.no-posts');

    filters.forEach((filter) => {
        filter.addEventListener('click', () => {
            const selectedTheme = filter.dataset.filter;
            let visibleCount = 0;

            filters.forEach((item) => item.classList.remove('active'));
            filter.classList.add('active');

            cards.forEach((card) => {
                const cardThemes = (card.dataset.themes || '').split('|');
                const isVisible = selectedTheme === 'Alles' || cardThemes.includes(selectedTheme);
                card.hidden = !isVisible;

                if (isVisible) {
                    visibleCount++;
                }
            });

            if (noPosts) {
                noPosts.hidden = visibleCount > 0;
            }
        });
    });
});
