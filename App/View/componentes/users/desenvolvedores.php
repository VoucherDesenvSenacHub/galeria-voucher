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
        'linkedin' => 'https://www.linkedin.com/in/joseotaviodayrots/',
        'foto' => 'https://avatars.githubusercontent.com/u/152044189?v=4'
    ],
    [
        'nome' => 'Luiz Oliveira',
        'funcao' => 'Desenvolvedor',
        'github' => '',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/118494854?v=4'
    ],
    [
        'nome' => 'Jonatan Samuel',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/samuelserri',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/172449361?v=4'
    ],
    [
        'nome' => 'Anuar El',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/AnuarRezz',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/172449471?v=4'
    ],
    [
        'nome' => 'Rodrigo Santos',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/rodrigo570282',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/172452119?v=4'
    ],
    [
        'nome' => 'Saambrc',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/Saambrc',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/172451323?v=4'
    ],
    [
        'nome' => 'Matheus Corsine',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/matheuscorsine',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/172449520?v=4'
    ],
    [
        'nome' => 'LucasAjpert',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/LucasAjpert',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/173213330?v=4'
    ],
    [
        'nome' => 'Henrique Guisa',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/henriguisatec',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/172449651?v=4'
    ],
    [
        'nome' => 'Carlos Eduardo',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/yonnnxr',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/184676631?v=4'

    ],
    [
        'nome' => 'Bruno Oliveira',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/brunoDevfull',
        'linkedin' => 'https://www.linkedin.com/in/bruno-ribeiro-553b27330',
        'foto' => 'https://avatars.githubusercontent.com/u/126524545?v=4'
    ],
    [
        'nome' => 'Lourran',
        'funcao' => 'Desenvolvedor',
        'github' => 'https://github.com/ribinha-code',
        'linkedin' => 'https://forms.gle/xsEzD6xCHFagFu3k6',
        'foto' => 'https://avatars.githubusercontent.com/u/173212118?v=4'
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
