-- ======================
-- ALTERAÇÕES para chegar no modelo ATUAL
-- ======================

-- Criar nova tabela projeto_dia
CREATE TABLE IF NOT EXISTS projeto_dia (
    projeto_dia_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_dia ENUM('I', 'P', 'E') NOT NULL,
    descricao TEXT,
    projeto_id INT NOT NULL,
    FOREIGN KEY (projeto_id) REFERENCES projeto(projeto_id)
);

-- Restrição para garantir que não haja dias duplicados para o mesmo projeto
ALTER TABLE projeto_dia
ADD UNIQUE KEY unique_tipo_projeto (tipo_dia, projeto_id);

-- Renomear tabela imagem_projeto para imagem_projeto_dia
RENAME TABLE imagem_projeto TO imagem_projeto_dia;

-- Alterar tabela imagem_projeto_dia
ALTER TABLE imagem_projeto_dia DROP FOREIGN KEY imagem_projeto_dia_ibfk_2;

ALTER TABLE imagem_projeto_dia DROP COLUMN projeto_id;

ALTER TABLE imagem_projeto_dia DROP COLUMN url;

ALTER TABLE imagem_projeto_dia
  ADD COLUMN projeto_dia_id INT NOT NULL AFTER imagem_id,
  ADD KEY projeto_dia_id (projeto_dia_id),
  ADD CONSTRAINT imagem_projeto_dia_ibfk_2 FOREIGN KEY (projeto_dia_id) REFERENCES projeto_dia(projeto_dia_id);


/*
ALTERAÇÃO IMPORTANTE: 
Foi criada a tabela 'imagem_projeto_dia' para substituir a antiga 'imagem_projeto' na associação entre imagens e etapas (dias) do projeto.

- A tabela 'imagem_projeto_dia' relaciona imagens diretamente com os dias do projeto (projeto_dia_id).
- A coluna 'url' foi removida da tabela antiga, agora as imagens são referenciadas apenas pelo ID na tabela 'imagem'.
- Essa alteração visa melhorar a integridade referencial e organizar melhor o vínculo entre imagens e fases do projeto.
*/