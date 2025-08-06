<?php

namespace App\Model;

enum ProjetoDiaEnum: string {
    case DiaI = "I";
    case DiaP = "P";
    case DiaE = "E";


    public function titulo(): string{
        return match ($this) {
             self::DiaI  => "Dia da Integração",
             self::DiaP => "Dia do Protótipo",
             self::DiaE => "Dia da Entrega Final"
        };
    }

    public function descricao(): string{
        return match ($this) {
             self::DiaI  => "Dia de entrevista com cliente",
             self::DiaP => "Dia entregando o MVP do front-end",
             self::DiaE => "Dia da entrega do projeto finalizado"
        };
    }
}