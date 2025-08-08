-- 1. INSERTS PARA TABELA 'cidade'
INSERT INTO cidade (nome) VALUES 
('Campo Grande'), ('Dourados'), ('Corumbá'), ('Três Lagoas'),
('Ponta Porã'), ('Naviraí'), ('Aquidauana'), ('Coxim');

-- 2. INSERTS PARA TABELA 'polo'
INSERT INTO polo (nome, cidade_id) VALUES 
('SENAC Centro', (SELECT cidade_id FROM cidade WHERE nome = 'Campo Grande')),
('SENAC Universitário', (SELECT cidade_id FROM cidade WHERE nome = 'Campo Grande')),
('SENAC Dourados', (SELECT cidade_id FROM cidade WHERE nome = 'Dourados')),
('SENAC Corumbá', (SELECT cidade_id FROM cidade WHERE nome = 'Corumbá')),
('SENAC Três Lagoas', (SELECT cidade_id FROM cidade WHERE nome = 'Três Lagoas')),
('SENAC Ponta Porã', (SELECT cidade_id FROM cidade WHERE nome = 'Ponta Porã')),
('SENAC Naviraí', (SELECT cidade_id FROM cidade WHERE nome = 'Naviraí')),
('SENAC Aquidauana', (SELECT cidade_id FROM cidade WHERE nome = 'Aquidauana')),
('SENAC Coxim', (SELECT cidade_id FROM cidade WHERE nome = 'Coxim'));

-- 3. INSERTS PARA TABELA 'imagem' (incluindo imagens genéricas para turmas e admin)
INSERT INTO imagem (url, data_upload) VALUES
-- Imagens de Perfil (Alunos e Professores)
('https://avatars.githubusercontent.com/u/172450001?v=4', NOW()), -- ID 1: Wellington Xavier
('https://avatars.githubusercontent.com/u/152044189?v=4', NOW()), -- ID 2: José Otávio
('https://avatars.githubusercontent.com/u/118494854?v=4', NOW()), -- ID 3: Luiz Oliveira
('https://avatars.githubusercontent.com/u/172449361?v=4', NOW()), -- ID 4: Jonatan Samuel
('https://avatars.githubusercontent.com/u/172449471?v=4', NOW()), -- ID 5: Anuar El
('https://avatars.githubusercontent.com/u/172452119?v=4', NOW()), -- ID 6: Rodrigo Santos
('https://avatars.githubusercontent.com/u/172451323?v=4', NOW()), -- ID 7: Sambegara Cristaldo
('https://avatars.githubusercontent.com/u/172449520?v=4', NOW()), -- ID 8: Matheus Corsine
('https://avatars.githubusercontent.com/u/173213330?v=4', NOW()), -- ID 9: Lucas Ajpert
('https://avatars.githubusercontent.com/u/172449651?v=4', NOW()), -- ID 10: Henrique Guisa
('https://avatars.githubusercontent.com/u/184676631?v=4', NOW()), -- ID 11: Carlos Eduardo
('https://avatars.githubusercontent.com/u/126524545?v=4', NOW()), -- ID 12: Bruno Ribeiro
('https://avatars.githubusercontent.com/u/173212118?v=4', NOW()), -- ID 13: Lourran
('https://avatars.githubusercontent.com/u/140553447?v=4', NOW()), -- ID 14: Manoel Oliveira
('https://avatars.githubusercontent.com/u/103645274?v=4', NOW()), -- ID 15: Gustavo Santos
('https://avatars.githubusercontent.com/u/172450074?v=4', NOW()), -- ID 16: João Pedro
('https://avatars.githubusercontent.com/u/175409953?v=4', NOW()), -- ID 17: Wendril Ferreira
('https://avatars.githubusercontent.com/u/175316341?v=4', NOW()), -- ID 18: Luis Cunha
('https://avatars.githubusercontent.com/u/175407904?v=4', NOW()), -- ID 19: Riquelme Gomes
('https://avatars.githubusercontent.com/u/175051829?v=4', NOW()), -- ID 20: João Heitor
('https://avatars.githubusercontent.com/u/172449485?v=4', NOW()), -- ID 21: Frederico Soares
('https://avatars.githubusercontent.com/u/44265771?v=4', NOW()),  -- ID 22: Mauricio de Souza
('https://avatars.githubusercontent.com/u/31439064?v=4', NOW()),  -- ID 23: Thiago Suzuqui
-- Imagens Genéricas
('avatar.png', NOW()), -- ID 24: Imagem para o Administrador
('turma-galeria.png', NOW());   -- ID 25: Imagem Padrão para Turmas

-- 4. INSERTS PARA TABELA 'turma' (agora com 'imagem_id' obrigatório)
INSERT INTO turma (nome, descricao, data_inicio, data_fim, imagem_id, polo_id) VALUES 
('Turma 144', 'Desenvolvimento de Sistemas - Manhã', '2024-02-01', '2024-12-15', 25, (SELECT polo_id FROM polo WHERE nome = 'SENAC Centro')),
('Turma 145', 'Desenvolvimento Web - Tarde', '2024-02-01', '2024-12-15', 25, (SELECT polo_id FROM polo WHERE nome = 'SENAC Dourados')),
('Turma 146', 'Redes de Computadores - Noite', '2024-03-01', '2024-11-30', 25, (SELECT polo_id FROM polo WHERE nome = 'SENAC Corumbá')),
('Turma 147', 'Administração de Sistemas - Manhã', '2024-04-01', '2024-10-31', 25, (SELECT polo_id FROM polo WHERE nome = 'SENAC Três Lagoas'));

-- 5. INSERTS PARA TABELA 'pessoa' (alunos, professores, administradores)
INSERT INTO pessoa (email, nome, linkedin, github, imagem_id, perfil) VALUES
-- Alunos
('wellington.xavier@example.com', 'Wellington Xavier', 'https://www.linkedin.com/in/wellington-xavier-90a004300/', 'https://github.com/Xavier-sa', 1, 'aluno'),
('jose.otavio@example.com', 'José Otávio', 'https://www.linkedin.com/in/joseotaviodayrots/', 'https://github.com/OtavioDayrots', 2, 'aluno'),
('luiz.oliveira@example.com', 'Luiz Oliveira', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/LuizzOliveira', 3, 'aluno'),
('jonatan.samuel@example.com', 'Jonatan Samuel', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/samuelserri', 4, 'aluno'),
('anuar.el@example.com', 'Anuar El', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/AnuarRezz', 5, 'aluno'),
('rodrigo.santos@example.com', 'Rodrigo Santos', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/rodrigo570282', 6, 'aluno'),
('sambegara.cristaldo@example.com', 'Sambegara Cristaldo', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/Saambrc', 7, 'aluno'),
('matheus.corsine@example.com', 'Matheus Corsine', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/matheuscorsine', 8, 'aluno'),
('lucas.ajpert@example.com', 'LucasAjpert', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/LucasAjpert', 9, 'aluno'),
('henrique.guisa@example.com', 'Henrique Guisa', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/henriguisatec', 10, 'aluno'),
('carlos.eduardo@example.com', 'Carlos Eduardo', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/yonnnxr', 11, 'aluno'),
('bruno.ribeiro@example.com', 'Bruno Ribeiro', 'https://www.linkedin.com/in/bruno-ribeiro-553b27330', 'https://github.com/brunoDevfull', 12, 'aluno'),
('lourran@example.com', 'Lourran', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/ribinha-code', 13, 'aluno'),
('manoel.oliveira@example.com', 'Manoel Oliveira', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/Tewdric', 14, 'aluno'),
('gustavo.santos@example.com', 'Gustavo Santos', 'https://forms.gle/xsEzD6xCHFagFu3k6', 'https://github.com/sntosz', 15, 'aluno'),
('joao.pedro@example.com', 'João Pedro', 'https://forms.gle/xsEzD6xCHFag', 'https://github.com/jeipe', 16, 'aluno'),
('wendril.ferreira@example.com', 'Wendril Ferreira', 'https://www.linkedin.com/in/wendril-ferreira-394417315', 'https://github.com/WendrilSFS', 17, 'aluno'),
('luis.cunha@example.com', 'Luis Cunha', 'https://forms.gle/xsEzD6xCHFag', 'https://github.com/LuisCunha05', 18, 'aluno'),
('riquelme.gomes@example.com', 'Riquelme Gomes', 'https://forms.gle/xsEzD6xCHFag', 'https://github.com/RiquelmeG22', 19, 'aluno'),
('joao.heitor@example.com', 'joao heitor', 'https://forms.gle/xsEzD6xCHFag', 'https://github.com/joaoheitoror', 20, 'aluno'),
('frederico.soares@example.com', 'Frederico Soares', 'https://forms.gle/xsEzD6xCHFag', 'https://github.com/Fred-Curso-Do-Senac-2024-Tc-ADS', 21, 'aluno'),
-- Professores
('mauricio.souza@example.com', 'Mauricio de Souza', 'https://www.linkedin.com/in/mauricioestevam/', 'https://github.com/Mauriiicio', 22, 'professor'),
('thiago.suzuqui@example.com', 'Thiago Suzuqui', 'https://www.linkedin.com/in/thszk/', 'https://github.com/thszk', 23, 'professor'),
-- Administrador (com imagem_id próprio)
('admin@adm.com', 'Administrador Sistema', NULL, NULL, 24, 'adm');

-- 6. INSERTS PARA TABELA 'usuario' (senhas criptografadas)
INSERT INTO usuario (pessoa_id, senha) VALUES 
((SELECT pessoa_id FROM pessoa WHERE email = 'admin@adm.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
((SELECT pessoa_id FROM pessoa WHERE email = 'mauricio.souza@example.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
((SELECT pessoa_id FROM pessoa WHERE email = 'thiago.suzuqui@example.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC');

-- 7. INSERTS PARA TABELA 'aluno_turma'
INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES
((SELECT pessoa_id FROM pessoa WHERE email = 'wellington.xavier@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'jose.otavio@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'luiz.oliveira@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'jonatan.samuel@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'anuar.el@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'rodrigo.santos@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'sambegara.cristaldo@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'matheus.corsine@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'lucas.ajpert@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'henrique.guisa@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'carlos.eduardo@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'bruno.ribeiro@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'lourran@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'manoel.oliveira@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'gustavo.santos@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'joao.pedro@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'wendril.ferreira@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'luis.cunha@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'riquelme.gomes@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'joao.heitor@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'frederico.soares@example.com'), 1, NOW());

-- 8. INSERTS PARA TABELA 'docente_turma'
INSERT INTO docente_turma (pessoa_id, turma_id, data_associacao) VALUES
((SELECT pessoa_id FROM pessoa WHERE email = 'mauricio.souza@example.com'), 1, NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'thiago.suzuqui@example.com'), 1, NOW());

-- 9. INSERIR PROJETO
INSERT INTO projeto (nome, descricao, link, turma_id)
VALUES (
  'Galeria Web - Projeto Integrador',
  'Projeto desenvolvido pelos alunos da Turma 144 no curso de Desenvolvimento de Sistemas.',
  'https://github.com/VoucherDesenvSenacHub/galeria-voucher',
  1
);

-- 10. INSERIR IMAGENS BASE DO PROJETO
INSERT INTO imagem (url, text, descricao, data_upload) VALUES
('turma-galeria.png', 'Início do projeto', 'Imagem representando o início do projeto', NOW()),
('turma-galeria.png', 'Desenvolvimento', 'Imagem representando o processo de desenvolvimento', NOW()),
('turma-galeria.png', 'Entrega final', 'Imagem representando a entrega final', NOW());

-- 11. INSERIR REGISTROS NA TABELA 'projeto_dia'
INSERT INTO projeto_dia (tipo_dia, descricao, projeto_id)
VALUES 
('I', 'Início do projeto: definição de escopo e tecnologias.', 1),
('P', 'Processo de desenvolvimento: criação de layout e funcionalidades.', 1),
('E', 'Entrega final e apresentação do projeto.', 1);

-- 12. ASSOCIAR IMAGENS AOS DIAS DO PROJETO (SINTAXE CORRIGIDA PARA MYSQL)
-- Usar variáveis para armazenar IDs e evitar subqueries complexas
SET @id_projeto = (SELECT projeto_id FROM projeto WHERE nome = 'Galeria Web - Projeto Integrador');

SET @img_inicio_id = (SELECT imagem_id FROM imagem WHERE text = 'Início do projeto' AND url = 'turma-galeria.png' ORDER BY imagem_id DESC LIMIT 1);
SET @img_desenvolvimento_id = (SELECT imagem_id FROM imagem WHERE text = 'Desenvolvimento' AND url = 'turma-galeria.png' ORDER BY imagem_id DESC LIMIT 1);
SET @img_entrega_id = (SELECT imagem_id FROM imagem WHERE text = 'Entrega final' AND url = 'turma-galeria.png' ORDER BY imagem_id DESC LIMIT 1);

SET @dia_inicio_id = (SELECT projeto_dia_id FROM projeto_dia WHERE tipo_dia = 'I' AND projeto_id = @id_projeto);
SET @dia_desenvolvimento_id = (SELECT projeto_dia_id FROM projeto_dia WHERE tipo_dia = 'P' AND projeto_id = @id_projeto);
SET @dia_entrega_id = (SELECT projeto_dia_id FROM projeto_dia WHERE tipo_dia = 'E' AND projeto_id = @id_projeto);

-- Inserir na tabela de associação
INSERT INTO imagem_projeto_dia (imagem_id, projeto_dia_id)
VALUES 
(@img_inicio_id, @dia_inicio_id),
(@img_desenvolvimento_id, @dia_desenvolvimento_id),
(@img_entrega_id, @dia_entrega_id);
