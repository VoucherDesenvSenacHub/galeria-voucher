document.addEventListener('DOMContentLoaded', function() {

    const canvas = document.getElementById('matrix-canvas');
    if (!canvas) {
        console.error("Elemento canvas com ID 'matrix-canvas' não foi encontrado.");
        return;
    }

    const ctx = canvas.getContext('2d');

    const setCanvasSize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    setCanvasSize();

    const matrixChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()_+-=[]{}|;:,.<>?";
    const alphabet = matrixChars.split('');

    const fontSize = 16;
    let columns = Math.ceil(canvas.width / fontSize);

    let drops = [];
    for (let x = 0; x < columns; x++) {
        drops[x] = 1;
    }

    function draw() {
        ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#0F0';
        ctx.font = fontSize + 'px monospace';

        for (let i = 0; i < drops.length; i++) {
            const text = alphabet[Math.floor(Math.random() * alphabet.length)];
            ctx.fillText(text, i * fontSize, drops[i] * fontSize);

            if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                drops[i] = 0;
            }
            
            drops[i]++;
        }
    }

    setInterval(draw, 33);

    window.addEventListener('resize', () => {
        setCanvasSize();
        columns = Math.ceil(canvas.width / fontSize);
        for (let x = 0; x < columns; x++) {
            drops[x] = 1;
        }
    });
});