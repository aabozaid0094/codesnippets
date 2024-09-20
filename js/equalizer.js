class HeightEqualizer {
    constructor(groupClass, itemClass, autoTrigger = false) {
        this.groupClass = groupClass;
        this.itemClass = itemClass;

        if (autoTrigger) {
            window.addEventListener('load', () => this.equalizeHeights());
        }
    }

    equalizeHeights() {
        const parents = document.querySelectorAll(`.${this.groupClass}`);
        parents.forEach(parent => {
            const children = parent.querySelectorAll(`.${this.itemClass}`);
            let highest = 0;

            children.forEach(child => {
                const childHeight = child.offsetHeight;
                if (childHeight > highest) {
                    highest = childHeight;
                }
            });

            children.forEach(child => {
                child.style.height = `${highest}px`;
            });
        });
    }
}
