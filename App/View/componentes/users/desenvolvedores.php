<?php
$desenvolvedores = [
    [
        'nome' => 'Wellington Xavier',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/Xavier-sa',
        'linkedin' => 'https://www.linkedin.com/in/wellington-xavier-90a004300/',
        'foto' => 'https://avatars.githubusercontent.com/u/172450001?s=400&u=9fa664c5274e0a6dbc33a05c2f039450169659e0&v=4'
    ],
    [
        'nome' => 'José Otávio',
        'funcao' => 'Desenvolvedor',    
        'github' => 'https://github.com/OtavioDayrots',
        'linkedin' => 'https://dontpad.com/turma146dados',
        'foto' => 'https://avatars.githubusercontent.com/u/152044189?v=4'
    ],
    [
        'nome' => 'Luiz Oliveira',
        'funcao' => 'Desenvolvedora',
        'github' => '',
        'linkedin' => 'https://dontpad.com/turma146dados',
        'foto' => 'https://avatars.githubusercontent.com/u/118494854?v=4'   
    ],
    [
        'nome' => 'Jonatan Samuel',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/samuelserri',
        'linkedin' => 'https://dontpad.com/turma146dados',
        'foto' => 'https://avatars.githubusercontent.com/u/172449361?v=4'
    ],
    [
        'nome' => 'Anuar El',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/AnuarRezz',
        'linkedin' => 'https://dontpad.com/turma146dados', 
        'foto' => 'https://avatars.githubusercontent.com/u/172449471?v=4'
    ],
    [
        'nome' => 'Rodrigo Santos',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/rodrigo570282',
        'linkedin' => 'https://dontpad.com/turma146dados',  
        'foto' => 'https://avatars.githubusercontent.com/u/172452119?v=4'
    ],  
    [
        'nome' => 'Saambrc',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/Saambrc',
        'linkedin' => 'https://dontpad.com/turma146dados',  
        'foto' => 'https://avatars.githubusercontent.com/u/172451323?v=4'
    ],
    [   
        'nome' => 'Matheus Corsine',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/matheuscorsine',    
        'linkedin' => 'https://dontpad.com/turma146dados',  
        'foto' => 'https://avatars.githubusercontent.com/u/172449520?v=4'   
    ],
    [
        'nome' => 'LucasAjpert',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/LucasAjpert',
        'linkedin' => 'https://dontpad.com/turma146dados',  
        'foto' => 'https://avatars.githubusercontent.com/u/173213330?v=4'
    ],
    [
        'nome' => 'Henrique Guisa',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/henriguisatec',
        'linkedin' => 'https://dontpad.com/turma146dados',  
        'foto' => 'https://avatars.githubusercontent.com/u/172449651?v=4'
    ]   
];

usort($desenvolvedores, function ($a, $b) {
    return strcasecmp($a['nome'], $b['nome']);
});
?>

<?php
$orientadores = [
    [
        'nome' => 'Mauricio de Souza',
        'funcao' => 'Orientador',
        'github' => 'https://github.com/Mauriiicio',
        'linkedin' => 'https://www.linkedin.com/in/mauricioestevam/',
        'foto' => 'https://avatars.githubusercontent.com/u/44265771?v=4'
    ],
    [
        'nome' => 'Thiago Suzuqui',
        'funcao' => 'Orientador',
        'github' => 'https://github.com/thszk',
        'linkedin' => 'https://www.linkedin.com/in/thszk/',
        'foto' => 'https://avatars.githubusercontent.com/u/31439064?v=4'
    ]
];

usort($orientadores, function ($a, $b) {
    return strcasecmp($a['nome'], $b['nome']);
});
?>
