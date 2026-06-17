document.querySelectorAll(".quantity").forEach(q => {
    const minus = q.children[0];
    const value = q.children[1];
    const plus = q.children[2];

    plus.onclick = () => value.textContent++;
    minus.onclick = () => {
        if (value.textContent > 1) value.textContent--;
    };
});