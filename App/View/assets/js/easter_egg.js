document.addEventListener('DOMContentLoaded', () => {

    const devHint = () => {
        console.log("%c▲ ▲ M A U M A U", "background: #000; color: #aeff40; font-size: 24px; padding: 10px;");
        console.log("%c... ou talvez ▲ ▲ T H I A G O?", "background: #000; color: #aeff40; font-size: 18px; padding: 8px;");
    };
    devHint();

    // --- LÓGICA CORRIGIDA DOS EASTER EGGS ---
    const codes = {
        mau: ['ArrowUp', 'ArrowUp', 'm', 'a', 'u', 'm', 'a', 'u'],
        thiago: ['ArrowUp', 'ArrowUp', 't', 'h', 'i', 'a', 'g', 'o']
    };
    let codeIndexMau = 0;
    let codeIndexThiago = 0;

    document.addEventListener('keydown', (e) => {
        if (document.activeElement.id === 'player-name') return;
        const key = e.key.toLowerCase();

        // Checa código "maumau" de forma independente
        if (key === codes.mau[codeIndexMau].toLowerCase()) {
            codeIndexMau++;
        } else {
            // Reinicia a contagem do "maumau", mas verifica se a tecla atual é o início da sequência
            codeIndexMau = (key === codes.mau[0].toLowerCase()) ? 1 : 0;
        }

        // Checa código "thiago" de forma independente
        if (key === codes.thiago[codeIndexThiago].toLowerCase()) {
            codeIndexThiago++;
        } else {
            // Reinicia a contagem do "thiago", mas verifica se a tecla atual é o início da sequência
            codeIndexThiago = (key === codes.thiago[0].toLowerCase()) ? 1 : 0;
        }

        // Verifica se algum código foi completado
        if (codeIndexMau === codes.mau.length) {
            if (!gameRunning) showGame();
            // Reseta ambos os contadores para evitar ativações acidentais
            codeIndexMau = 0;
            codeIndexThiago = 0;
        }

        if (codeIndexThiago === codes.thiago.length) {
            showThiagoLetter();
            // Reseta ambos os contadores
            codeIndexMau = 0;
            codeIndexThiago = 0;
        }
    });
    
    // --- CARTA PARA O THIAGO ---
    const thiagoLetterModal = document.getElementById('thiago-letter-modal');
    const closeLetterBtn = document.getElementById('close-letter-btn');
    function showThiagoLetter() { if(thiagoLetterModal) thiagoLetterModal.style.display = 'flex'; }
    function hideThiagoLetter() { if(thiagoLetterModal) thiagoLetterModal.style.display = 'none'; }
    if(closeLetterBtn) closeLetterBtn.addEventListener('click', hideThiagoLetter);


    // --- JOGO DA COBRINHA (PROF. MAURICIO) ---
    // (O restante do código do jogo permanece o mesmo)
    let audioContext;
    let musicNode, sfxGainNode;
    let audioInitialized = false;

    function initAudio() { /* ... código de áudio ... */ }
    function playSound(type) { /* ... código de áudio ... */ }
    function playMusic() { /* ... código de áudio ... */ }
    function stopMusic() { /* ... código de áudio ... */ }
    
    const gameOverlay = document.getElementById('game-overlay');
    const canvas = document.getElementById('gameCanvas');
    if(!canvas) return; // Se não estiver na página certa, para aqui.
    
    const ctx = canvas.getContext('2d');
    const scoreBoard = document.getElementById('score-board');
    const startScreen = document.getElementById('start-screen');
    const gameOverScreen = document.getElementById('game-over-screen');
    const finalScoreEl = document.getElementById('final-score');
    const playerNameInput = document.getElementById('player-name');
    const saveScoreBtn = document.getElementById('save-score-btn');
    const highScoresList = document.getElementById('high-scores-list');
    const touchControls = document.getElementById('touch-controls');
    const gridSize = 20;
    canvas.width = 400; canvas.height = 400;
    let snake, coffee, score, direction, gameLoopId, gameRunning = false;
    
    function initGame() { /* ... */ }
    function spawnCoffee() { /* ... */ }
    function update() { /* ... */ }
    function draw() { /* ... */ }
    function gameLoop() { update(); draw(); }
    function updateScore() { /* ... */ }
    function gameOver() { /* ... */ }
    function handleKeyPress(e) { /* ... */ }
    document.getElementById('btn-up').addEventListener('click', () => { if (direction.y === 0) direction = { x: 0, y: -1 }; });
    document.getElementById('btn-down').addEventListener('click', () => { if (direction.y === 0) direction = { x: 0, y: 1 }; });
    document.getElementById('btn-left').addEventListener('click', () => { if (direction.x === 0) direction = { x: -1, y: 0 }; });
    document.getElementById('btn-right').addEventListener('click', () => { if (direction.x === 0) direction = { x: 1, y: 0 }; });
    function updateLeaderboard() { /* ... */ }
    saveScoreBtn.addEventListener('click', () => { /* ... */ });
    function restartGame() { /* ... */ }
    startScreen.addEventListener('click', () => { initAudio(); startScreen.style.display = 'none'; restartGame(); }, { once: true });

    function showGame() {
        const isMobile = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        if (isMobile && touchControls) touchControls.style.display = 'block';
        if(gameOverlay) gameOverlay.style.display = 'flex';
        if(startScreen) startScreen.style.display = 'flex';
        updateLeaderboard();
        document.addEventListener('keydown', handleKeyPress);
    }
    
    function hideGame() {
        stopMusic();
        if(gameOverlay) gameOverlay.style.display = 'none';
        gameRunning = false;
        clearInterval(gameLoopId);
        document.removeEventListener('keydown', handleKeyPress);
    }

    // Funções completas do jogo
    initAudio = function() {
        if (audioInitialized) return;
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        sfxGainNode = audioContext.createGain(); sfxGainNode.gain.value = 0.5; sfxGainNode.connect(audioContext.destination);
        musicGainNode = audioContext.createGain(); musicGainNode.gain.value = 0.2; musicGainNode.connect(audioContext.destination);
        audioInitialized = true;
    }
    playSound = function(type) {
        if (!audioInitialized) return;
        const osc = audioContext.createOscillator(); osc.connect(sfxGainNode);
        if (type === 'eat') {
            osc.type = 'square'; osc.frequency.setValueAtTime(440, audioContext.currentTime);
            osc.frequency.linearRampToValueAtTime(880, audioContext.currentTime + 0.1);
        } else { osc.type = 'sine'; osc.frequency.setValueAtTime(200, audioContext.currentTime); }
        osc.start(); osc.stop(audioContext.currentTime + 0.05);
    }
    playMusic = function() {
        if (!audioInitialized) return;
        const notes = [261.63, 293.66, 329.63, 349.23]; let noteIndex = 0;
        musicLoopId = setInterval(() => {
            const osc = audioContext.createOscillator(); osc.connect(musicGainNode);
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(notes[noteIndex % notes.length], audioContext.currentTime);
            osc.start(); osc.stop(audioContext.currentTime + 0.1);
            noteIndex++;
        }, 200);
    }
    stopMusic = function() { clearInterval(musicLoopId); }
    initGame = function() {
        snake = [{ x: 10, y: 10 }]; direction = { x: 0, y: 0 }; score = 0;
        spawnCoffee(); updateScore(); if(gameOverScreen) gameOverScreen.style.display = 'none';
    }
    spawnCoffee = function() {
        coffee = { x: Math.floor(Math.random() * (canvas.width / gridSize)), y: Math.floor(Math.random() * (canvas.height / gridSize)) };
        if (snake.some(s => s.x === coffee.x && s.y === coffee.y)) spawnCoffee();
    }
    update = function() {
        if (!gameRunning) return;
        const head = { x: snake[0].x + direction.x, y: snake[0].y + direction.y };
        if (head.x < 0 || head.x >= canvas.width / gridSize || head.y < 0 || head.y >= canvas.height / gridSize) return gameOver();
        if (snake.length > 1 && snake.some(s => s.x === head.x && s.y === head.y)) return gameOver();
        snake.unshift(head);
        if (head.x === coffee.x && head.y === coffee.y) {
            score++; playSound('eat'); updateScore(); spawnCoffee();
        } else { snake.pop(); }
        if (direction.x !== 0 || direction.y !== 0) playSound('move');
    }
    draw = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#aeff40';
        snake.forEach(s => ctx.fillRect(s.x * gridSize, s.y * gridSize, gridSize - 1, gridSize - 1));
        ctx.fillStyle = '#ffae42'; ctx.font = `${gridSize}px sans-serif`;
        ctx.fillText('☕️', coffee.x * gridSize, coffee.y * gridSize + gridSize - 4);
    }
    updateScore = function() { if(scoreBoard) scoreBoard.textContent = `PONTOS: ${score}`; }
    gameOver = function() {
        stopMusic(); gameRunning = false; clearInterval(gameLoopId);
        if(finalScoreEl) finalScoreEl.textContent = score; 
        if(gameOverScreen) gameOverScreen.style.display = 'flex'; 
        if(playerNameInput) playerNameInput.focus();
    }
    handleKeyPress = function(e) {
        if (e.key === 'ArrowUp' && direction.y === 0) direction = { x: 0, y: -1 };
        else if (e.key === 'ArrowDown' && direction.y === 0) direction = { x: 0, y: 1 };
        else if (e.key === 'ArrowLeft' && direction.x === 0) direction = { x: -1, y: 0 };
        else if (e.key === 'ArrowRight' && direction.x === 0) direction = { x: 1, y: 0 };
        else if (e.key === 'Escape') hideGame();
    }
    updateLeaderboard = function() {
        const highScores = JSON.parse(localStorage.getItem('snakeHighScores')) || [];
        if(highScoresList) highScoresList.innerHTML = highScores.map(s => `<li><span>${s.name} ..... ${s.score}</span><span>${s.date}</span></li>`).join('');
    }
    if(saveScoreBtn) saveScoreBtn.addEventListener('click', () => {
        let name = playerNameInput.value.trim().toUpperCase();
        if (name.length > 0 && name.length <= 3) {
            const highScores = JSON.parse(localStorage.getItem('snakeHighScores')) || [];
            highScores.push({ name, score, date: new Date().toLocaleDateString('pt-BR') });
            highScores.sort((a, b) => b.score - a.score);
            highScores.splice(3);
            localStorage.setItem('snakeHighScores', JSON.stringify(highScores));
            updateLeaderboard(); restartGame();
        } else { alert('Por favor, digite um nome com até 3 letras.'); }
    });
    restartGame = function() {
        clearInterval(gameLoopId); initGame(); gameRunning = true;
        playMusic();
        gameLoopId = setInterval(gameLoop, 120);
    }
});