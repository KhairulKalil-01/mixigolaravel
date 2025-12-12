// resources/js/progress.js

(function() {
    const progressBar = document.getElementById('global-progress-bar');
    let timeoutId;

    window.startProgressBar = () => {
        if (!progressBar) return;
        progressBar.style.width = '0%';
        progressBar.style.opacity = '1';
        clearTimeout(timeoutId);

        let width = 0;
        const increment = () => {
            if (width < 90) {
                width += Math.random() * 5; // Simulate gradual progress
                progressBar.style.width = width + '%';
                timeoutId = setTimeout(increment, 200); // Update every 200ms
            }
        };
        increment();
    };

    window.endProgressBar = () => {
        if (!progressBar) return;
        clearTimeout(timeoutId);
        progressBar.style.width = '100%';
        progressBar.style.opacity = '0';
        setTimeout(() => {
            progressBar.style.width = '0%'; // Reset for next use
        }, 500); // Wait for fade out to complete before resetting
    };

    window.setProgressBar = (percentage) => {
        if (!progressBar) return;
        clearTimeout(timeoutId);
        progressBar.style.width = percentage + '%';
        if (percentage >= 100) {
            window.endProgressBar();
        } else {
            progressBar.style.opacity = '1';
        }
    };
})();
