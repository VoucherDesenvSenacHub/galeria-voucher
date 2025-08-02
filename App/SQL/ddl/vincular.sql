-- vincular alunos a uma turma

select nome, data_matricula -- o que voce quer da tabela
from turma t -- a tabela que vc quer ( a letra a frente é um apelido)
inner join aluno_turma at on at.turma_id = t.turma_id 
inner join pessoa p on p.pessoa_id = at.pessoa_id 

select *
from turma t 
where t.turma_id =3; 

select linkedin, nome 
from pessoa p
where p.pessoa_id =10;

-- inserir aluno a uma turma

insert into aluno_turma 
(turma_id, pessoa_id,data_matricula)
values (1,15,'2024-01-25');