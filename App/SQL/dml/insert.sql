-- 1. INSERTS PARA TABELA 'cidade'
INSERT INTO cidade (nome) VALUES 
('Campo Grande'),
('Dourados'),
('Corumbá'),
('Três Lagoas'),
('Ponta Porã'),
('Naviraí'),
('Aquidauana'),
('Coxim');

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

-- 3. INSERTS PARA TABELA 'turma'
INSERT INTO turma (nome, descricao, data_inicio, data_fim, polo_id) VALUES 
('Turma 144', 'Desenvolvimento de Sistemas - Manhã', '2024-02-01', '2024-12-15', (SELECT polo_id FROM polo WHERE nome = 'SENAC Centro')),
('Turma 145', 'Desenvolvimento Web - Tarde', '2024-02-01', '2024-12-15', (SELECT polo_id FROM polo WHERE nome = 'SENAC Dourados')),
('Turma 146', 'Redes de Computadores - Noite', '2024-03-01', '2024-11-30', (SELECT polo_id FROM polo WHERE nome = 'SENAC Corumbá')),
('Turma 147', 'Administração de Sistemas - Manhã', '2024-04-01', '2024-10-31', (SELECT polo_id FROM polo WHERE nome = 'SENAC Três Lagoas'));

-- 4. INSERTS PARA TABELA 'imagem' (com URLs reais dos perfis dos alunos e professores)
INSERT INTO imagem (url, data_upload) VALUES
('https://avatars.githubusercontent.com/u/172450001?v=4', NOW()), -- Wellington Xavier
('https://avatars.githubusercontent.com/u/152044189?v=4', NOW()), -- José Otávio
('https://avatars.githubusercontent.com/u/118494854?v=4', NOW()), -- Luiz Oliveira
('https://avatars.githubusercontent.com/u/172449361?v=4', NOW()), -- Jonatan Samuel
('https://avatars.githubusercontent.com/u/172449471?v=4', NOW()), -- Anuar El
('https://avatars.githubusercontent.com/u/172452119?v=4', NOW()), -- Rodrigo Santos
('https://avatars.githubusercontent.com/u/172451323?v=4', NOW()), -- Sambegara Cristaldo
('https://avatars.githubusercontent.com/u/172449520?v=4', NOW()), -- Matheus Corsine
('https://avatars.githubusercontent.com/u/173213330?v=4', NOW()), -- Lucas Ajpert
('https://avatars.githubusercontent.com/u/172449651?v=4', NOW()), -- Henrique Guisa
('https://avatars.githubusercontent.com/u/184676631?v=4', NOW()), -- Carlos Eduardo
('https://avatars.githubusercontent.com/u/126524545?v=4', NOW()), -- Bruno Ribeiro
('https://avatars.githubusercontent.com/u/173212118?v=4', NOW()), -- Lourran
('https://avatars.githubusercontent.com/u/140553447?v=4', NOW()), -- Manoel Oliveira
('https://avatars.githubusercontent.com/u/103645274?v=4', NOW()), -- Gustavo Santos
('https://avatars.githubusercontent.com/u/172450074?v=4', NOW()), -- João Pedro
('https://avatars.githubusercontent.com/u/175409953?v=4', NOW()), -- Wendril Ferreira
('https://avatars.githubusercontent.com/u/175316341?v=4', NOW()), -- Luis Cunha
('https://avatars.githubusercontent.com/u/175407904?v=4', NOW()), -- Riquelme Gomes
('https://avatars.githubusercontent.com/u/175051829?v=4', NOW()), -- João Heitor
('https://avatars.githubusercontent.com/u/172449485?v=4', NOW()), -- Frederico Soares
('https://avatars.githubusercontent.com/u/44265771?v=4', NOW()),  -- Mauricio de Souza
('https://avatars.githubusercontent.com/u/31439064?v=4', NOW());  -- Thiago Suzuqui


-- 5. INSERTS PARA TABELA 'pessoa' (alunos, professores, administradores)
-- OBS: Aqui o campo imagem_id deve refletir o id das imagens inseridas acima (de 1 a 23).
INSERT INTO pessoa (email, nome, linkedin, github, imagem_id, perfil) VALUES
-- Alunos (23 registros)
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

-- Administrador
('admin@adm.com', 'Administrador Sistema', NULL, NULL, 23, 'adm');

-- 6. INSERTS PARA TABELA 'usuario' (senhas criptografadas)
INSERT INTO usuario (pessoa_id, senha) VALUES 
-- Administrador
((SELECT pessoa_id FROM pessoa WHERE email = 'admin@adm.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),

-- Professores
((SELECT pessoa_id FROM pessoa WHERE email = 'mauricio.souza@example.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
((SELECT pessoa_id FROM pessoa WHERE email = 'thiago.suzuqui@example.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC');

-- 7. INSERTS PARA TABELA 'aluno_turma' (associando alunos à turma 1)
INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES
((SELECT pessoa_id FROM pessoa WHERE email = 'wellington.xavier@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'jose.otavio@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'luiz.oliveira@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'jonatan.samuel@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'anuar.el@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'rodrigo.santos@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'sambegara.cristaldo@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'matheus.corsine@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'lucas.ajpert@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'henrique.guisa@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'carlos.eduardo@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'bruno.ribeiro@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'lourran@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'manoel.oliveira@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'gustavo.santos@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'joao.pedro@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'wendril.ferreira@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'luis.cunha@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'riquelme.gomes@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'joao.heitor@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'frederico.soares@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW());

-- 8. INSERTS PARA TABELA 'docente_turma' (associando professores à turma 1)
INSERT INTO docente_turma (pessoa_id, turma_id, data_associacao) VALUES
((SELECT pessoa_id FROM pessoa WHERE email = 'mauricio.souza@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW()),
((SELECT pessoa_id FROM pessoa WHERE email = 'thiago.suzuqui@example.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), NOW());

-- 9. Inserir projeto
INSERT INTO projeto (nome, descricao, link, turma_id)
VALUES (
  'Galeria Web - Projeto Integrador',
  'Projeto desenvolvido pelos alunos da Turma 144 no curso de Desenvolvimento de Sistemas.',
  'https://github.com/seu-repositorio/galeria-web',
  (SELECT turma_id FROM turma WHERE nome = 'Turma 144')
);

-- 10. Inserir imagens base do projeto (com url 'turma-galeria.png')
INSERT INTO imagem (url, text, descricao, data_upload) VALUES
('turma-galeria.png', 'Início do projeto', 'Imagem representando o início do projeto', NOW()),
('turma-galeria.png', 'Desenvolvimento', 'Imagem representando o processo de desenvolvimento', NOW()),
('turma-galeria.png', 'Entrega final', 'Imagem representando a entrega final', NOW());

-- 11. Inserir registros na tabela projeto_dia
INSERT INTO projeto_dia (tipo_dia, descricao, projeto_id)
VALUES 
('I', 'Início do projeto: definição de escopo e tecnologias.', (SELECT projeto_id FROM projeto WHERE nome = 'Galeria Web - Projeto Integrador')),
('P', 'Processo de desenvolvimento: criação de layout e funcionalidades.', (SELECT projeto_id FROM projeto WHERE nome = 'Galeria Web - Projeto Integrador')),
('E', 'Entrega final e apresentação do projeto.', (SELECT projeto_id FROM projeto WHERE nome = 'Galeria Web - Projeto Integrador'));

-- 12. Usar variáveis para armazenar IDs e evitar erro de subquery múltipla
-- Pegar IDs das imagens
SET @img_inicio = (SELECT TOP 1 imagem_id FROM imagem WHERE text = 'Início do projeto' AND url = 'turma-galeria.png');
SET @img_desenvolvimento = (SELECT TOP 1 imagem_id FROM imagem WHERE text = 'Desenvolvimento' AND url = 'turma-galeria.png');
SET @img_entrega = (SELECT TOP 1 imagem_id FROM imagem WHERE text = 'Entrega final' AND url = 'turma-galeria.png');

-- Pegar IDs dos dias do projeto
SET @dia_inicio = (SELECT TOP 1 projeto_dia_id FROM projeto_dia WHERE tipo_dia = 'I' AND projeto_id = (SELECT projeto_id FROM projeto WHERE nome = 'Galeria Web - Projeto Integrador'));
SET @dia_desenvolvimento = (SELECT TOP 1 projeto_dia_id FROM projeto_dia WHERE tipo_dia = 'P' AND projeto_id = (SELECT projeto_id FROM projeto WHERE nome = 'Galeria Web - Projeto Integrador'));
SET @dia_entrega = (SELECT TOP 1 projeto_dia_id FROM projeto_dia WHERE tipo_dia = 'E' AND projeto_id = (SELECT projeto_id FROM projeto WHERE nome = 'Galeria Web - Projeto Integrador'));

-- Inserir nas imagens do projeto_dia
INSERT INTO imagem_projeto_dia (imagem_id, projeto_dia_id)
VALUES 
(@img_inicio, @dia_inicio),
(@img_desenvolvimento, @dia_desenvolvimento),
(@img_entrega, @dia_entrega);










-- -- 1. INSERTS PARA TABELA 'cidade'
-- INSERT INTO cidade (nome) VALUES 
-- ('Campo Grande'),
-- ('Dourados'),
-- ('Corumbá'),
-- ('Três Lagoas'),
-- ('Ponta Porã'),
-- ('Naviraí'),
-- ('Aquidauana'),
-- ('Coxim');

-- -- 2. INSERTS PARA TABELA 'polo'
-- INSERT INTO polo (nome, cidade_id) VALUES 
-- ('SENAC Centro', (SELECT cidade_id FROM cidade WHERE nome = 'Campo Grande')),
-- ('SENAC Universitário', (SELECT cidade_id FROM cidade WHERE nome = 'Campo Grande')),
-- ('SENAC Dourados', (SELECT cidade_id FROM cidade WHERE nome = 'Dourados')),
-- ('SENAC Corumbá', (SELECT cidade_id FROM cidade WHERE nome = 'Corumbá')),
-- ('SENAC Três Lagoas', (SELECT cidade_id FROM cidade WHERE nome = 'Três Lagoas')),
-- ('SENAC Ponta Porã', (SELECT cidade_id FROM cidade WHERE nome = 'Ponta Porã')),
-- ('SENAC Naviraí', (SELECT cidade_id FROM cidade WHERE nome = 'Naviraí')),
-- ('SENAC Aquidauana', (SELECT cidade_id FROM cidade WHERE nome = 'Aquidauana')),
-- ('SENAC Coxim', (SELECT cidade_id FROM cidade WHERE nome = 'Coxim'));

-- -- 3. INSERTS PARA TABELA 'pessoa' (professores e administradores)
-- INSERT INTO pessoa (email, nome, linkedin, github, perfil) VALUES 
-- -- Administradores
-- ('admin@adm.com', 'Administrador Sistema', NULL, NULL, 'adm'),

-- -- Professores
-- ('joao.silva@senac.com', 'João Silva', 'linkedin.com/in/joaosilva', 'github.com/joaosilva', 'professor'),
-- ('maria.souza@senac.com', 'Maria Souza', 'linkedin.com/in/mariasouza', 'github.com/mariasouza', 'professor'),
-- ('carlos.santos@senac.com', 'Carlos Santos', 'linkedin.com/in/carlossantos', 'github.com/carlossantos', 'professor'),
-- ('ana.costa@senac.com', 'Ana Costa', 'linkedin.com/in/anacosta', 'github.com/anacosta', 'professor');


-- -- 4. INSERTS PARA TABELA 'pessoa' (alunos)
-- INSERT INTO pessoa (email, nome, linkedin, github, perfil) VALUES 
-- -- Turma 144 - Desenvolvimento de Sistemas
-- ('lucas.oliveira@aluno.senac.com', 'Lucas Oliveira', 'linkedin.com/in/lucasoliveira', 'github.com/lucasoliveira', 'aluno'),
-- ('julia.santos@aluno.senac.com', 'Julia Santos', 'linkedin.com/in/juliasantos', 'github.com/juliasantos', 'aluno'),
-- ('rafael.costa@aluno.senac.com', 'Rafael Costa', 'linkedin.com/in/rafaelcosta', 'github.com/rafaelcosta', 'aluno'),
-- ('amanda.pereira@aluno.senac.com', 'Amanda Pereira', 'linkedin.com/in/amandapereira', 'github.com/amandapereira', 'aluno'),

-- -- Turma 145 - Desenvolvimento Web
-- ('gabriel.rodrigues@aluno.senac.com', 'Gabriel Rodrigues', 'linkedin.com/in/gabrielrodrigues', 'github.com/gabrielrodrigues', 'aluno'),
-- ('carolina.lima@aluno.senac.com', 'Carolina Lima', 'linkedin.com/in/carolinalima', 'github.com/carolinalima', 'aluno'),
-- ('thiago.martins@aluno.senac.com', 'Thiago Martins', 'linkedin.com/in/thiagomartins', 'github.com/thiagomartins', 'aluno'),
-- ('beatriz.fernandes@aluno.senac.com', 'Beatriz Fernandes', 'linkedin.com/in/beatrizfernandes', 'github.com/beatrizfernandes', 'aluno'),

-- -- Turma 146 - Redes de Computadores
-- ('marcos.almeida@aluno.senac.com', 'Marcos Almeida', 'linkedin.com/in/marcosalmeida', 'github.com/marcosalmeida', 'aluno'),
-- ('laura.gomes@aluno.senac.com', 'Laura Gomes', 'linkedin.com/in/lauragomes', 'github.com/lauragomes', 'aluno'),
-- ('pedro.silva@aluno.senac.com', 'Pedro Silva', 'linkedin.com/in/pedrosilva', 'github.com/pedrosilva', 'aluno'),
-- ('isabela.carvalho@aluno.senac.com', 'Isabela Carvalho', 'linkedin.com/in/isabelacarvalho', 'github.com/isabelacarvalho', 'aluno'),

-- -- Turma 147 - Administração
-- ('daniel.oliveira@aluno.senac.com', 'Daniel Oliveira', 'linkedin.com/in/danieloliveira', 'github.com/danieloliveira', 'aluno'),
-- ('sofia.rodrigues@aluno.senac.com', 'Sofia Rodrigues', 'linkedin.com/in/sofiarodrigues', 'github.com/sofiarodrigues', 'aluno'),
-- ('matheus.costa@aluno.senac.com', 'Matheus Costa', 'linkedin.com/in/matheuscosta', 'github.com/matheuscosta', 'aluno'),
-- ('valentina.lima@aluno.senac.com', 'Valentina Lima', 'linkedin.com/in/valentinalima', 'github.com/valentinalima', 'aluno');

-- -- 5. INSERTS PARA TABELA 'usuario' (senhas criptografadas)
-- INSERT INTO usuario (pessoa_id, senha) VALUES 
-- -- Administradores
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'admin@adm.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),

-- -- Professores
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'joao.silva@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'maria.souza@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'carlos.santos@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'ana.costa@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC');

-- -- 6. INSERTS PARA TABELA 'turma'
-- INSERT INTO turma (nome, descricao, data_inicio, data_fim, polo_id) VALUES 
-- ('Turma 144', 'Desenvolvimento de Sistemas - Manhã', '2024-02-01', '2024-12-15', (SELECT polo_id FROM polo WHERE nome = 'SENAC Centro')),
-- ('Turma 145', 'Desenvolvimento Web - Tarde', '2024-02-01', '2024-12-15', (SELECT polo_id FROM polo WHERE nome = 'SENAC Dourados')),
-- ('Turma 146', 'Redes de Computadores - Noite', '2024-03-01', '2024-11-30', (SELECT polo_id FROM polo WHERE nome = 'SENAC Corumbá')),
-- ('Turma 147', 'Administração de Sistemas - Manhã', '2024-04-01', '2024-10-31', (SELECT polo_id FROM polo WHERE nome = 'SENAC Três Lagoas'));

-- -- 7. INSERTS PARA TABELA 'docente_turma'
-- INSERT INTO docente_turma (pessoa_id, turma_id, data_associacao) VALUES 
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'joao.silva@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-15'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'maria.souza@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-15'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'carlos.santos@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-10'), 
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'ana.costa@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-05');

-- -- 8. INSERTS PARA TABELA 'aluno_turma'
-- INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES 
-- -- Turma 144
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'lucas.oliveira@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-20'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'julia.santos@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-20'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'rafael.costa@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-21'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'amanda.pereira@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-21'),

-- -- Turma 145
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'gabriel.rodrigues@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-22'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'carolina.lima@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-22'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'thiago.martins@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-23'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'beatriz.fernandes@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-23'),

-- -- Turma 146
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'marcos.almeida@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-15'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'laura.gomes@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-15'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'pedro.silva@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-16'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'isabela.carvalho@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-16'),

-- -- Turma 147
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'daniel.oliveira@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-10'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'sofia.rodrigues@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-10'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'matheus.costa@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-11'),
-- ((SELECT pessoa_id FROM pessoa WHERE email = 'valentina.lima@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-11');

-- -- -- 9. INSERTS PARA TABELA 'projeto'
-- -- INSERT INTO projeto (nome, descricao, link, turma_id) VALUES 
-- -- -- Projetos Turma 144
-- -- ('Sistema de Gestão Escolar', 'Sistema completo para gerenciamento de escolas, incluindo matrículas, notas e frequência', 'https://github.com/turma144/gestao-escolar', (SELECT turma_id FROM turma WHERE nome = 'Turma 144')),
-- -- ('App de Delivery', 'Aplicativo mobile para delivery de alimentos com geolocalização e pagamento online', 'https://github.com/turma144/delivery-app', (SELECT turma_id FROM turma WHERE nome = 'Turma 144')),

-- -- -- Projetos Turma 145
-- -- ('E-commerce Responsivo', 'Loja virtual completa com carrinho de compras, pagamento e painel administrativo', 'https://github.com/turma145/ecommerce', (SELECT turma_id FROM turma WHERE nome = 'Turma 145')),
-- -- ('Portal de Notícias', 'Portal de notícias com sistema de categorias, busca e área de comentários', 'https://github.com/turma145/portal-noticias', (SELECT turma_id FROM turma WHERE nome = 'Turma 145')),

-- -- -- Projetos Turma 146
-- -- ('Monitoramento de Rede', 'Sistema de monitoramento de redes locais com alertas e relatórios', 'https://github.com/turma146/monitoramento-rede', (SELECT turma_id FROM turma WHERE nome = 'Turma 146')),
-- -- ('Sistema de Backup', 'Solução automatizada de backup para servidores e estações de trabalho', 'https://github.com/turma146/sistema-backup', (SELECT turma_id FROM turma WHERE nome = 'Turma 146')),

-- -- -- Projetos Turma 147
-- -- ('Gestão de TI', 'Sistema de gestão de ativos de TI com controle de licenças e manutenção', 'https://github.com/turma147/gestao-ti', (SELECT turma_id FROM turma WHERE nome = 'Turma 147')),
-- -- ('Help Desk', 'Sistema de suporte técnico com tickets e acompanhamento de chamados', 'https://github.com/turma147/help-desk', (SELECT turma_id FROM turma WHERE nome = 'Turma 147'));



