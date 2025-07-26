<?php
$senhaDigitada = 'usuarios';
$senhaHashBanco = '$2y$10$zrsMv03aNlW0X6pJ4NVkq.HMk6T8IPX9nBgyvk7eD8Wn0JdyH7GYW';

if (password_verify($senhaDigitada, $senhaHashBanco)) {
    echo "Senha correta!";
} else {
    echo "Senha incorreta!";
}
