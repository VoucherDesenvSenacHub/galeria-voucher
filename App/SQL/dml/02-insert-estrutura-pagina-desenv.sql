
UPDATE turma
set exibir_pagina_dev = 1
WHERE turma_id = (select turma_id from turma where nome = 'turma 146');
