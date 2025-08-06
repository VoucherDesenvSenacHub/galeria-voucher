-- exibir todos os alunos de uma turma

select p.nome, t.nome 
from turma t -- a tabela que vc quer ( a letra a frente é um apelido)
inner join aluno_turma at on at.turma_id = t.turma_id 
inner join pessoa p on p.pessoa_id = at.pessoa_id 
where t.turma_id =1;

-- exibir todos os docentes de uma turma
select p.nome, t.nome
from turma t 
inner join docente_turma dt on dt.turma_id = t.turma_id 
inner join pessoa p on p.pessoa_id =dt.pessoa_id 
where t.turma_id =1;


-- inserir aluno a uma turma

insert into aluno_turma 
(turma_id, pessoa_id,data_matricula)
values (1,15,'2024-01-25');

-- inserir docente a uma turma
insert into docente_turma 
(docente_turma_id,pessoa_id,turma_id,data_associacao)
values (7,5,1,'2024-02-01');



 -- exibir dados da turma
 select *
from turma t 
where t.turma_id =3; 


-- exibir dados da pessoa
select linkedin, nome 
from pessoa p
where p.pessoa_id =10;