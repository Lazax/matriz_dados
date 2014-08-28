CREATE DATABASE  IF NOT EXISTS `matriz_dados`;
USE `matriz_dados`;

CREATE TABLE IF NOT EXISTS `cargo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `turma` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `participante` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `participanteid` int(11) NOT NULL,
  `cpf` int(11) NOT NULL,
  `nome_razao_social` varchar(255) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `fk_cargo` int(10) unsigned NULL,
  `fk_turma_curso_amarelo` int(10) unsigned,
  `fk_turma_curso_verde` int(10) unsigned,
  `fk_turma_curso_vermelho` int(10) unsigned,
  `fk_turma_curso_azul` int(10) unsigned,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_participante_cargo` FOREIGN KEY (`fk_cargo`) REFERENCES `cargo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participante_turma_curso_amarelo` FOREIGN KEY (`fk_turma_curso_amarelo`) REFERENCES `turma` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participante_turma_curso_verde` FOREIGN KEY (`fk_turma_curso_verde`) REFERENCES `turma` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participante_turma_curso_vermelho` FOREIGN KEY (`fk_turma_curso_vermelho`) REFERENCES `turma` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participante_turma_curso_azul` FOREIGN KEY (`fk_turma_curso_azul`) REFERENCES `turma` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
