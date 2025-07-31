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

-- 3. INSERTS PARA TABELA 'pessoa' (professores e administradores)
INSERT INTO pessoa (email, nome, linkedin, github, perfil) VALUES 
-- Administradores
('admin@adm.com', 'Administrador Sistema', NULL, NULL, 'adm'),

-- Professores
('joao.silva@senac.com', 'João Silva', 'linkedin.com/in/joaosilva', 'github.com/joaosilva', 'professor'),
('maria.souza@senac.com', 'Maria Souza', 'linkedin.com/in/mariasouza', 'github.com/mariasouza', 'professor'),
('carlos.santos@senac.com', 'Carlos Santos', 'linkedin.com/in/carlossantos', 'github.com/carlossantos', 'professor'),
('ana.costa@senac.com', 'Ana Costa', 'linkedin.com/in/anacosta', 'github.com/anacosta', 'professor');


-- 4. INSERTS PARA TABELA 'pessoa' (alunos)
INSERT INTO pessoa (email, nome, linkedin, github, perfil) VALUES 
-- Turma 144 - Desenvolvimento de Sistemas
('lucas.oliveira@aluno.senac.com', 'Lucas Oliveira', 'linkedin.com/in/lucasoliveira', 'github.com/lucasoliveira', 'aluno'),
('julia.santos@aluno.senac.com', 'Julia Santos', 'linkedin.com/in/juliasantos', 'github.com/juliasantos', 'aluno'),
('rafael.costa@aluno.senac.com', 'Rafael Costa', 'linkedin.com/in/rafaelcosta', 'github.com/rafaelcosta', 'aluno'),
('amanda.pereira@aluno.senac.com', 'Amanda Pereira', 'linkedin.com/in/amandapereira', 'github.com/amandapereira', 'aluno'),

-- Turma 145 - Desenvolvimento Web
('gabriel.rodrigues@aluno.senac.com', 'Gabriel Rodrigues', 'linkedin.com/in/gabrielrodrigues', 'github.com/gabrielrodrigues', 'aluno'),
('carolina.lima@aluno.senac.com', 'Carolina Lima', 'linkedin.com/in/carolinalima', 'github.com/carolinalima', 'aluno'),
('thiago.martins@aluno.senac.com', 'Thiago Martins', 'linkedin.com/in/thiagomartins', 'github.com/thiagomartins', 'aluno'),
('beatriz.fernandes@aluno.senac.com', 'Beatriz Fernandes', 'linkedin.com/in/beatrizfernandes', 'github.com/beatrizfernandes', 'aluno'),

-- Turma 146 - Redes de Computadores
('marcos.almeida@aluno.senac.com', 'Marcos Almeida', 'linkedin.com/in/marcosalmeida', 'github.com/marcosalmeida', 'aluno'),
('laura.gomes@aluno.senac.com', 'Laura Gomes', 'linkedin.com/in/lauragomes', 'github.com/lauragomes', 'aluno'),
('pedro.silva@aluno.senac.com', 'Pedro Silva', 'linkedin.com/in/pedrosilva', 'github.com/pedrosilva', 'aluno'),
('isabela.carvalho@aluno.senac.com', 'Isabela Carvalho', 'linkedin.com/in/isabelacarvalho', 'github.com/isabelacarvalho', 'aluno'),

-- Turma 147 - Administração
('daniel.oliveira@aluno.senac.com', 'Daniel Oliveira', 'linkedin.com/in/danieloliveira', 'github.com/danieloliveira', 'aluno'),
('sofia.rodrigues@aluno.senac.com', 'Sofia Rodrigues', 'linkedin.com/in/sofiarodrigues', 'github.com/sofiarodrigues', 'aluno'),
('matheus.costa@aluno.senac.com', 'Matheus Costa', 'linkedin.com/in/matheuscosta', 'github.com/matheuscosta', 'aluno'),
('valentina.lima@aluno.senac.com', 'Valentina Lima', 'linkedin.com/in/valentinalima', 'github.com/valentinalima', 'aluno');

-- 5. INSERTS PARA TABELA 'usuario' (senhas criptografadas)
INSERT INTO usuario (pessoa_id, senha) VALUES 
-- Administradores
((SELECT pessoa_id FROM pessoa WHERE email = 'admin@adm.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),

-- Professores
((SELECT pessoa_id FROM pessoa WHERE email = 'joao.silva@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
((SELECT pessoa_id FROM pessoa WHERE email = 'maria.souza@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
((SELECT pessoa_id FROM pessoa WHERE email = 'carlos.santos@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC'),
((SELECT pessoa_id FROM pessoa WHERE email = 'ana.costa@senac.com'), '$2y$10$8tL6uFsbg4xzhYaoDU9JVeYDvJZtMXdd3jEsJppMSHis.atBmHutC');

-- 6. INSERTS PARA TABELA 'turma'
INSERT INTO turma (nome, descricao, data_inicio, data_fim, polo_id) VALUES 
('Turma 144', 'Desenvolvimento de Sistemas - Manhã', '2024-02-01', '2024-12-15', (SELECT polo_id FROM polo WHERE nome = 'SENAC Centro')),
('Turma 145', 'Desenvolvimento Web - Tarde', '2024-02-01', '2024-12-15', (SELECT polo_id FROM polo WHERE nome = 'SENAC Dourados')),
('Turma 146', 'Redes de Computadores - Noite', '2024-03-01', '2024-11-30', (SELECT polo_id FROM polo WHERE nome = 'SENAC Corumbá')),
('Turma 147', 'Administração de Sistemas - Manhã', '2024-04-01', '2024-10-31', (SELECT polo_id FROM polo WHERE nome = 'SENAC Três Lagoas'));

-- 7. INSERTS PARA TABELA 'docente_turma'
INSERT INTO docente_turma (pessoa_id, turma_id, data_associacao) VALUES 
((SELECT pessoa_id FROM pessoa WHERE email = 'joao.silva@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-15'),
((SELECT pessoa_id FROM pessoa WHERE email = 'maria.souza@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-15'),
((SELECT pessoa_id FROM pessoa WHERE email = 'carlos.santos@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-10'), 
((SELECT pessoa_id FROM pessoa WHERE email = 'ana.costa@senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-05');

-- 8. INSERTS PARA TABELA 'aluno_turma'
INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES 
-- Turma 144
((SELECT pessoa_id FROM pessoa WHERE email = 'lucas.oliveira@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-20'),
((SELECT pessoa_id FROM pessoa WHERE email = 'julia.santos@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-20'),
((SELECT pessoa_id FROM pessoa WHERE email = 'rafael.costa@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-21'),
((SELECT pessoa_id FROM pessoa WHERE email = 'amanda.pereira@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 144'), '2024-01-21'),

-- Turma 145
((SELECT pessoa_id FROM pessoa WHERE email = 'gabriel.rodrigues@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-22'),
((SELECT pessoa_id FROM pessoa WHERE email = 'carolina.lima@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-22'),
((SELECT pessoa_id FROM pessoa WHERE email = 'thiago.martins@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-23'),
((SELECT pessoa_id FROM pessoa WHERE email = 'beatriz.fernandes@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 145'), '2024-01-23'),

-- Turma 146
((SELECT pessoa_id FROM pessoa WHERE email = 'marcos.almeida@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-15'),
((SELECT pessoa_id FROM pessoa WHERE email = 'laura.gomes@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-15'),
((SELECT pessoa_id FROM pessoa WHERE email = 'pedro.silva@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-16'),
((SELECT pessoa_id FROM pessoa WHERE email = 'isabela.carvalho@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 146'), '2024-02-16'),

-- Turma 147
((SELECT pessoa_id FROM pessoa WHERE email = 'daniel.oliveira@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-10'),
((SELECT pessoa_id FROM pessoa WHERE email = 'sofia.rodrigues@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-10'),
((SELECT pessoa_id FROM pessoa WHERE email = 'matheus.costa@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-11'),
((SELECT pessoa_id FROM pessoa WHERE email = 'valentina.lima@aluno.senac.com'), (SELECT turma_id FROM turma WHERE nome = 'Turma 147'), '2024-03-11');

-- 9. INSERTS PARA TABELA 'projeto'
INSERT INTO projeto (nome, descricao, link, turma_id) VALUES 
-- Projetos Turma 144
('Sistema de Gestão Escolar', 'Sistema completo para gerenciamento de escolas, incluindo matrículas, notas e frequência', 'https://github.com/turma144/gestao-escolar', (SELECT turma_id FROM turma WHERE nome = 'Turma 144')),
('App de Delivery', 'Aplicativo mobile para delivery de alimentos com geolocalização e pagamento online', 'https://github.com/turma144/delivery-app', (SELECT turma_id FROM turma WHERE nome = 'Turma 144')),

-- Projetos Turma 145
('E-commerce Responsivo', 'Loja virtual completa com carrinho de compras, pagamento e painel administrativo', 'https://github.com/turma145/ecommerce', (SELECT turma_id FROM turma WHERE nome = 'Turma 145')),
('Portal de Notícias', 'Portal de notícias com sistema de categorias, busca e área de comentários', 'https://github.com/turma145/portal-noticias', (SELECT turma_id FROM turma WHERE nome = 'Turma 145')),

-- Projetos Turma 146
('Monitoramento de Rede', 'Sistema de monitoramento de redes locais com alertas e relatórios', 'https://github.com/turma146/monitoramento-rede', (SELECT turma_id FROM turma WHERE nome = 'Turma 146')),
('Sistema de Backup', 'Solução automatizada de backup para servidores e estações de trabalho', 'https://github.com/turma146/sistema-backup', (SELECT turma_id FROM turma WHERE nome = 'Turma 146')),

-- Projetos Turma 147
('Gestão de TI', 'Sistema de gestão de ativos de TI com controle de licenças e manutenção', 'https://github.com/turma147/gestao-ti', (SELECT turma_id FROM turma WHERE nome = 'Turma 147')),
('Help Desk', 'Sistema de suporte técnico com tickets e acompanhamento de chamados', 'https://github.com/turma147/help-desk', (SELECT turma_id FROM turma WHERE nome = 'Turma 147'));


