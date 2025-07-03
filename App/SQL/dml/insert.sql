
-- INSERT statements for 'cidade'
INSERT INTO cidade (nome) VALUES 
('Campo Grande'),
('Dourados'),
('Corumbá'),
('Três Lagoas'),
('Ponta Porã');

-- INSERT statements for 'polo'
INSERT INTO polo (nome, cidade_id) VALUES 
('SENAC Centro', 1),
('SENAC Universitário', 1),
('SENAC Dourados', 2),
('SENAC Corumbá', 3),
('SENAC Três Lagoas', 4),
('SENAC Ponta Porã', 5);

-- INSERT statements for 'turma'
INSERT INTO turma (nome, descricao, data_inicio, data_fim, polo_id) VALUES 
('Turma 144', 'Turma de Desenvolvimento de Sistemas - Manhã', '2023-02-01', '2023-12-15', 1),
('Turma 145', 'Turma de Desenvolvimento de Sistemas - Tarde', '2023-02-01', '2023-12-15', 2),
('Turma 146', 'Turma de Redes de Computadores', '2023-03-01', '2023-11-30', 3),
('Turma 147', 'Turma de Administração', '2023-04-01', '2023-10-31', 4);

-- INSERT statements for 'imagem' (profile pictures)
INSERT INTO imagem (url, text, descricao, data_upload) VALUES 
('https://example.com/profiles/default.jpg', 'Default profile', 'Imagem padrão de perfil', NOW()),
('https://example.com/profiles/teacher1.jpg', 'Teacher profile', 'Foto do professor João', NOW()),
('https://example.com/profiles/teacher2.jpg', 'Teacher profile', 'Foto da professora Maria', NOW());

-- INSERT statements for 'pessoa' (professores)
INSERT INTO pessoa (email, nome, linkedin, github, imagem_id, descricao, perfil) VALUES 
('joao.silva@senac.com', 'João Silva', 'linkedin.com/joaosilva', 'github.com/joaosilva', 2, 'Professor de Desenvolvimento de Sistemas', 'professor'),
('maria.souza@senac.com', 'Maria Souza', 'linkedin.com/mariasouza', 'github.com/mariasouza', 3, 'Professora de Redes de Computadores', 'professor'),
('admin@senac.com', 'Administrador', NULL, NULL, 1, 'Administrador do sistema', 'adm');

-- INSERT statements for 'pessoa' (alunos - biblical names)
INSERT INTO pessoa (email, nome, linkedin, github, imagem_id, descricao, perfil) VALUES 
('adão.silva@aluno.senac.com', 'Adão Silva', NULL, NULL, 1, 'Aluno da turma 144', 'aluno'),
('eva.souza@aluno.senac.com', 'Eva Souza', NULL, NULL, 1, 'Aluna da turma 144', 'aluno'),
('noe.pereira@aluno.senac.com', 'Noé Pereira', NULL, NULL, 1, 'Aluno da turma 144', 'aluno'),
('abraao.oliveira@aluno.senac.com', 'Abraão Oliveira', NULL, NULL, 1, 'Aluno da turma 145', 'aluno'),
('sara.costa@aluno.senac.com', 'Sara Costa', NULL, NULL, 1, 'Aluna da turma 145', 'aluno'),
('davi.santos@aluno.senac.com', 'Davi Santos', NULL, NULL, 1, 'Aluno da turma 145', 'aluno'),
('salomao.rodrigues@aluno.senac.com', 'Salomão Rodrigues', NULL, NULL, 1, 'Aluno da turma 146', 'aluno'),
('ester.martins@aluno.senac.com', 'Ester Martins', NULL, NULL, 1, 'Aluna da turma 146', 'aluno'),
('daniel.fernandes@aluno.senac.com', 'Daniel Fernandes', NULL, NULL, 1, 'Aluno da turma 146', 'aluno'),
('josue.almeida@aluno.senac.com', 'Josué Almeida', NULL, NULL, 1, 'Aluno da turma 147', 'aluno'),
('raquel.gomes@aluno.senac.com', 'Raquel Gomes', NULL, NULL, 1, 'Aluna da turma 147', 'aluno'),
('samuel.lima@aluno.senac.com', 'Samuel Lima', NULL, NULL, 1, 'Aluno da turma 147', 'aluno');

-- INSERT statements for 'usuario'
INSERT INTO usuario (pessoa_id, senha) VALUES 
(1, SHA2('joao123', 256)),
(2, SHA2('maria123', 256)),
(3, SHA2('admin123', 256)),
(4, SHA2('adao123', 256)),
(5, SHA2('eva123', 256)),
(6, SHA2('noe123', 256)),
(7, SHA2('abraao123', 256)),
(8, SHA2('sara123', 256)),
(9, SHA2('davi123', 256)),
(10, SHA2('salomao123', 256)),
(11, SHA2('ester123', 256)),
(12, SHA2('daniel123', 256)),
(13, SHA2('josue123', 256)),
(14, SHA2('raquel123', 256)),
(15, SHA2('samuel123', 256));

-- INSERT statements for 'docente_turma'
INSERT INTO docente_turma (pessoa_id, turma_id, data_associacao) VALUES 
(1, 1, '2023-01-15'),
(1, 2, '2023-01-15'),
(2, 3, '2023-02-10'),
(2, 4, '2023-03-05');

-- INSERT statements for 'aluno_turma'
INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES 
(4, 1, '2023-01-20'),
(5, 1, '2023-01-20'),
(6, 1, '2023-01-21'),
(7, 2, '2023-01-22'),
(8, 2, '2023-01-22'),
(9, 2, '2023-01-23'),
(10, 3, '2023-02-15'),
(11, 3, '2023-02-15'),
(12, 3, '2023-02-16'),
(13, 4, '2023-03-10'),
(14, 4, '2023-03-10'),
(15, 4, '2023-03-11');

-- INSERT statements for 'projeto'
INSERT INTO projeto (nome, descricao, link, turma_id) VALUES 
('Sistema de Biblioteca', 'Sistema para gerenciamento de bibliotecas escolares', 'https://github.com/turma144/biblioteca', 1),
('App de Turismo', 'Aplicativo para pontos turísticos de MS', 'https://github.com/turma145/turismo', 2),
('Monitoramento de Rede', 'Sistema de monitoramento de redes locais', 'https://github.com/turma146/rede', 3),
('Gestão Escolar', 'Sistema de gestão para escolas', 'https://github.com/turma147/escola', 4);

-- INSERT statements for 'imagem_projeto'
INSERT INTO imagem_projeto (imagem_id, url, projeto_id) VALUES 
(1, 'https://example.com/projects/biblioteca.jpg', 1),
(1, 'https://example.com/projects/turismo.jpg', 2),
(1, 'https://example.com/projects/rede.jpg', 3),
(1, 'https://example.com/projects/escola.jpg', 4);

-- INSERT statement for 'estatisticas'
-- insere a linha de dados com id=1, mas somente se ela ainda não existir
-- isso evita criar duplicatas se você executar o script mais de uma vez
INSERT INTO estatisticas (id, alunos, projetos, polos, horas)
SELECT 1, 0, 0, 0, 0 FROM DUAL
WHERE NOT EXISTS (SELECT id FROM estatisticas WHERE id = 1);