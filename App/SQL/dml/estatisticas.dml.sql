-- insere a linha de dados com id=1, mas somente se ela ainda não existir
-- isso evita criar duplicatas se você executar o script mais de uma vez
INSERT INTO estatisticas (id, alunos, projetos, polos, horas)
SELECT 1, 0, 0, 0, 0 FROM DUAL
WHERE NOT EXISTS (SELECT id FROM estatisticas WHERE id = 1);