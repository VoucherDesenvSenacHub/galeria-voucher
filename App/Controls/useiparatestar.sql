ALTER TABLE pessoa 
MODIFY COLUMN perfil ENUM('aluno', 'professor', 'adm', 'mentor') NOT NULL;
MODIFY COLUMN perfil ENUM('aluno', 'professor', 'adm') NOT NULL;
