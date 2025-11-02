document.addEventListener("DOMContentLoaded", function() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = +counter.innerText;
        let count = 0;
        const speed = 50;
        const increment = Math.ceil(target / speed);

        const animate = () => {
            count += increment;
            if (count < target) {
                counter.innerText = count;
                requestAnimationFrame(animate);
            } else {
                counter.innerText = target;
            }
        };
        animate();
    });
});
