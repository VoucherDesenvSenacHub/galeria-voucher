document.addEventListener('DOMContentLoaded', function() {

    const canvas = document.getElementById('matrix-canvas');
    if (!canvas) {
        console.error("Elemento canvas com ID 'matrix-canvas' não foi encontrado.");
        return;
    }

    const ctx = canvas.getContext('2d');

    // Função para definir o tamanho do canvas
    const setCanvasSize = () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    };
    setCanvasSize();

    // Usamos um conjunto de caracteres completo para um efeito mais rico
    const alphabet = '01';

    const fontSize = 15;
    let columns = Math.ceil(canvas.width / fontSize);

    // Array para guardar a posição Y de cada "gota"
    let rainDrops = [];
    
    // Inicializa todas as gotas no topo para criar a cascata
    for (let x = 0; x < columns; x++) {
        rainDrops[x] = 1;
    }

    // A função principal de desenho
    function draw() {
        // Usamos um gradiente para criar o fundo e o efeito de desvanecer
        const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        
        // A maior parte do fundo (85%) é preto semi-transparente
        gradient.addColorStop(0, 'rgba(0, 0, 0, 0.087)');
        gradient.addColorStop(0.73, 'rgba(0, 0, 0, 0.087)');
        
        // Nos últimos 15%, ele transita para o verde do seu tema
        gradient.addColorStop(1, 'rgba(13, 156, 13,  0.1)');
        
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Cor das letras
        ctx.fillStyle = '#0d9c0d';

        ctx.font = fontSize + 'px "Poppins", sans-serif';

        for (let i = 0; i < rainDrops.length; i++) {
            const text = alphabet.charAt(Math.floor(Math.random() * alphabet.length));
            ctx.fillText(text, i * fontSize, rainDrops[i] * fontSize);

            if (rainDrops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                rainDrops[i] = 0;
            }
            
            rainDrops[i]++;
        }
    }

    // Inicia o loop e faz o controle da velocidade da animação
    setInterval(draw, 40);

    // Adapta a animação se a janela for redimensionada
    window.addEventListener('resize', () => {
        setCanvasSize();
        columns = Math.ceil(canvas.width / fontSize);
        for (let x = 0; x < columns; x++) {
            rainDrops[x] = 1;
        }
    });
});