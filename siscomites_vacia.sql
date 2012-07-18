-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2012 a las 20:15:48
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `siscomites_vacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas`
--

CREATE TABLE IF NOT EXISTS `actas` (
  `id` varchar(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  `tipo_id` int(11) DEFAULT '1',
  `hora` varchar(20) DEFAULT NULL,
  `horafin` varchar(20) DEFAULT NULL,
  `lugar` varchar(80) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `introduccion` text,
  `estado` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `tipo_id` (`tipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `actas`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administracion`
--

CREATE TABLE IF NOT EXISTS `administracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `correo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `administracion`
--

INSERT INTO `administracion` (`id`, `nombre`, `correo`) VALUES
(1, 'Edna Yuvery Patiño Gómez', 'ednita_1987@misena.edu.co');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendices`
--

CREATE TABLE IF NOT EXISTS `aprendices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identificacion` bigint(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `id_tipo` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Volcar la base de datos para la tabla `aprendices`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE IF NOT EXISTS `asistentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `rol` varchar(70) NOT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `entidad` varchar(150) DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `asistio` varchar(10) NOT NULL DEFAULT 'Si',
  `acta_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `acta_id` (`acta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `asistentes`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos`
--

CREATE TABLE IF NOT EXISTS `casos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` tinyint(4) NOT NULL DEFAULT '1',
  `pruebas` text NOT NULL,
  `descripcion` text NOT NULL,
  `tipificaciones` varchar(300) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `quejoso_id` int(11) NOT NULL,
  `aprendiz_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `grupo_id` (`grupo_id`),
  KEY `quejoso_id` (`quejoso_id`),
  KEY `aprendiz_id` (`aprendiz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `casos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros`
--

CREATE TABLE IF NOT EXISTS `centros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` bigint(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `subdirector_nombre` varchar(200) NOT NULL,
  `subdirector_id` varchar(30) NOT NULL,
  `subdirector_id_tipo` varchar(10) NOT NULL,
  `direccion_y_telefono` varchar(150) NOT NULL,
  `regional_id` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `regional` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `regional_id` (`regional_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Volcar la base de datos para la tabla `centros`
--

INSERT INTO `centros` (`id`, `codigo`, `nombre`, `subdirector_nombre`, `subdirector_id`, `subdirector_id_tipo`, `direccion_y_telefono`, `regional_id`, `ciudad`, `regional`) VALUES
(23, 11, 'Comercio Y Turismo', 'Hernan Hoyos Walteros', '7554040', 'CC', 'Cra 18 # 7 - 58 Sena Barrio Galán - Tel 7461417', 21, 'Armenia', 'Quindio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compromisos`
--

CREATE TABLE IF NOT EXISTS `compromisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `responsables` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `acta_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `acta_id` (`acta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `compromisos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `decisiones`
--

CREATE TABLE IF NOT EXISTS `decisiones` (
  `id` int(11) NOT NULL,
  `descargo` text NOT NULL,
  `existencia` varchar(20) NOT NULL,
  `constituye` varchar(20) NOT NULL,
  `probable` varchar(20) NOT NULL,
  `responsabilidad` varchar(20) NOT NULL,
  `danos` varchar(20) NOT NULL,
  `participacion` varchar(20) NOT NULL,
  `antecedente` varchar(50) NOT NULL,
  `rendimiento` varchar(20) NOT NULL,
  `confeso` varchar(20) NOT NULL,
  `procuro` varchar(20) NOT NULL,
  `reparo` varchar(20) NOT NULL,
  `calificacion` varchar(20) NOT NULL,
  `incluir` varchar(20) NOT NULL,
  `amerita` varchar(20) NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `reglamentos` varchar(200) NOT NULL,
  `duracion` varchar(30) NOT NULL,
  `sancion_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sancion_id` (`sancion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `decisiones`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `director_nombre` varchar(250) NOT NULL,
  `director_correo` varchar(250) NOT NULL,
  `vocero_nombre` varchar(250) NOT NULL,
  `vocero_correo` varchar(250) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '1',
  `titulacion_id` int(11) NOT NULL,
  `programa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `titulacion_id` (`titulacion_id`),
  KEY `programa_id` (`programa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Volcar la base de datos para la tabla `grupos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informes`
--

CREATE TABLE IF NOT EXISTS `informes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `identificacion` varchar(50) NOT NULL,
  `identificacion_tipo` varchar(10) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `grupo_id` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `informes`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrantes`
--

CREATE TABLE IF NOT EXISTS `integrantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `rol` varchar(250) NOT NULL,
  `entidad` varchar(150) DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `correo` varchar(150) NOT NULL,
  `programa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `programa_id` (`programa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `integrantes`
--

INSERT INTO `integrantes` (`id`, `nombre`, `rol`, `entidad`, `numero`, `correo`, `programa_id`) VALUES
(1, 'Jose Samuel Arbelaez Zuleta', 'Coordinador Académico', 'Sena', '62543', 'jarbelaez@misena.edu.co', 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE IF NOT EXISTS `procesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acta_id` varchar(20) NOT NULL,
  `programacion_id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `programacion_id` (`programacion_id`),
  KEY `acta_id` (`acta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `procesos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programaciones`
--

CREATE TABLE IF NOT EXISTS `programaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hora` time NOT NULL,
  `caso` int(11) DEFAULT '0',
  `informe` int(11) DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT '1',
  `grupo_id` int(11) NOT NULL,
  `sesion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sesion_id` (`sesion_id`),
  KEY `grupo_id` (`grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

--
-- Volcar la base de datos para la tabla `programaciones`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE IF NOT EXISTS `programas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` bigint(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `coordinador_nombre` varchar(200) NOT NULL,
  `coordinador_id` varchar(50) NOT NULL,
  `coordinador_id_tipo` varchar(10) NOT NULL,
  `correo_envio` varchar(100) DEFAULT NULL,
  `correo_envio_pass` varchar(50) DEFAULT NULL,
  `correo_host` varchar(100) NOT NULL,
  `correo_auth` varchar(20) NOT NULL,
  `ambiente_comites` varchar(100) NOT NULL,
  `informacion` text,
  `centro_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `centro_id` (`centro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Volcar la base de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `codigo`, `nombre`, `coordinador_nombre`, `coordinador_id`, `coordinador_id_tipo`, `correo_envio`, `correo_envio_pass`, `correo_host`, `correo_auth`, `ambiente_comites`, `informacion`, `centro_id`) VALUES
(34, 111, 'Comercio Y Servicios', 'José Samuel Arbeláez Zuleta', '7521460', 'CC', 'senacomites@inMail24.com', 'andres', 'smtp.inMail24.com', 'No', 'Ambiente 4', 'La aprendiz Irene manifiesta: Con Juan Camilo por las faltas injustificadas y con Manuel porque no presente una exposición.  Yo he faltado varias veces, primero porque tuve una infección renal, yo presenté excusa, cuando ya me patrocinaron a mi me pidieron en la empresa, que me saliera del seguro para firmar, luego me llamaron a firmar contrato y ya llegue otra vez y luego viaje a Cali.  Si a mi si me gusta lo que estoy estudiando.  Yo tuve un accidente el domingo, pero yo si quiero continuar.  Dure un mes sin afiliarme a salud.  Yo me comprometo a cumplir con las actividades y recuperar los planes, y en la empresa  a tener mejor comportamiento y a desempeñarme bien en la empresa y cumplir con las actividades que se les asigne.\r\n\r\nEl ingeniero Hoover manifiesta:  Me preocupa su situación, y el posible de', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quejosos`
--

CREATE TABLE IF NOT EXISTS `quejosos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identificacion` bigint(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `id_tipo` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Volcar la base de datos para la tabla `quejosos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reglamentos`
--

CREATE TABLE IF NOT EXISTS `reglamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `reglamentos`
--

INSERT INTO `reglamentos` (`id`, `nombre`, `tipo`, `texto`) VALUES
(1, 'Condicionamiento Caso 1', 'Sanción', 'Cuando la gravedad de la(s) falta(s) lo amerite con base en los criterios de calificación señalados en los numerales 1 a 7 del artículo 21 de este reglamento'),
(2, 'Condicionamiento Caso 2', 'Sanción', 'Por incumplimiento del plan de mejoramiento acordado como consecuencia de un (1) llamado de atención escrito'),
(3, 'Condicionamiento Caso 3', 'Sanción', 'Cuando los antecedentes del aprendiz a sancionar evidencien dos (2) llamados de atención escritos durante su proceso de formación'),
(4, 'Condicionamiento Caso 4', 'Sanción', 'Cuando el aprendiz ha tenido incumplimiento injustificados en la entrega de las evidencias de aprendizaje o valoración deficiente de los resultados de aprendizaje, que sobrepasen el treinta por ciento (30%) del total del programa de formación'),
(5, 'Condicionamiento Caso 5', 'Sanción', 'Por terminar unilateralmente el contrato de aprendizaje sin autorización previa del SENA'),
(6, 'Cancelación Caso 1', 'Sanción', 'Cuando la gravedad de la(s) falta(s) lo amerite, con base en los criterios de calificación señalados en los numerales 1 a 7 del artículo 21 de este reglamento'),
(7, 'Cancelación Caso 2', 'Sanción', 'Por incumplimiento del plan de mejoramiento acordado, como consecuencia de un condicionamiento de matrícula'),
(8, 'Cancelación Caso 3', 'Sanción', 'Cuando los antecedentes del aprendiz a sancionar evidencien que ya tuvo un condicionamiento de matrícula durante su proceso de formación'),
(9, 'Cancelación Caso 4', 'Sanción', 'Cuando el aprendiz ha tenido faltas injustificadas en la entrega de las evidencias de aprendizaje o valoración deficiente de los resultados de aprendizaje, que sobrepasen el cincuenta por ciento (50%) del total del programa de formación'),
(10, 'Cancelación Caso 5', 'Sanción', 'Realizar o apoyar actos que limiten o afecten el derecho a la educación o la locomoción de la comunidad educativa del SENA'),
(11, 'Cancelación Caso 6', 'Sanción', 'Hurtar, estafar o abusar de la confianza de cualquier integrante de la comunidad educativa, o amenazarlo, sobornarlo, coaccionarlo o agredirlo verbal o físicamente, o ser cómplice o coparticipe de delitos contra ellos o contra la institución'),
(12, 'Cancelación Caso 7', 'Sanción', 'Destruir, sustraer o dañar instalaciones físicas, equipos, materiales, software, elementos y dotación en general del SENA o de instituciones, empresas u otras entidades donde se desarrollen actividades de aprendizaje, culturales, recreativas, deportivas y sociales o intercambios estudiantiles nacionales o internacionales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sanciones`
--

CREATE TABLE IF NOT EXISTS `sanciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `sanciones`
--

INSERT INTO `sanciones` (`id`, `nombre`) VALUES
(1, 'Ninguna'),
(2, 'Llamado de atención escrito'),
(3, 'Condicionamiento'),
(4, 'Cancelación'),
(5, 'Citar caso nuevamente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE IF NOT EXISTS `sesiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '1',
  `programa_id` int(11) NOT NULL,
  `trimestre_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `programa_id` (`programa_id`),
  KEY `trimestre_id` (`trimestre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `sesiones`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipificaciones`
--

CREATE TABLE IF NOT EXISTS `tipificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `tipo_falta` varchar(50) NOT NULL,
  `nivel` varchar(50) NOT NULL,
  `reglamento_aplicado` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcar la base de datos para la tabla `tipificaciones`
--

INSERT INTO `tipificaciones` (`id`, `nombre`, `tipo_falta`, `nivel`, `reglamento_aplicado`) VALUES
(1, 'Bajo rendimiento académico', 'Académica', 'Grave', 'Capitulo 3,  deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución.  a) De carácter académico, a1) Cumplir con todas las actividades propias de su proceso de aprendizaje o del plan de mejoramiento, definidas durante su proceso de aprendizaje.  Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. a) De carácter académico, a3) Incumplir las actividades de aprendizaje acordadas en su proceso de formación  y los compromisos adquiridos como aprendiz SENA, sin justa causa'),
(2, 'Agresión verbal', 'Disciplinaria', 'Leve', 'Capitulo 3,  deberes del Aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b5) Actuar siempre teniendo como base los principios y valores para la convivencia; obrar con honestidad, respeto, responsabilidad, lealtad, justicia, compañerismo y solidaridad con la totalidad de los integrantes de la comunidad educativa y  expresarse con respeto, cultura y educación, en forma directa o a través de medios impresos o electrónicos (como foros de discusión, chat, correo electrónico, blogs, etc.). Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. b) De carácter disciplinario, b5) Hurtar, estafar o abusar de la confianza de cualquier integrante de la comunidad educativa, o  amenazarlo, sobornarlo, coaccionarlo o agredirlo verbal o físicamente, o ser cómplice o coparticipe de delitos contra ellos o contra la institución. b15) Incumplir las normas de convivencia establecidas en cada Centro de Formación o internado. b20) Propiciar conductas, propuestas o actos inmorales hacia cualquier miembro de la comunidad educativa, que atenten contra la integridad física, moral y/o psicológica'),
(3, 'Hurto', 'Disciplinaria', 'Grave', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b1) Conocer y asumir las políticas y directrices institucionales establecidas, así como el reglamento del aprendiz SENA, y convivir en comunidad de acuerdo con ellos. b5) Actuar siempre teniendo como base los principios y valores para la convivencia; obrar con honestidad, respeto, responsabilidad, lealtad, justicia, compañerismo y solidaridad con la totalidad de los integrantes de la comunidad educativa y  expresarse con respeto, cultura y educación, en forma directa o a través de medios impresos o electrónicos (como foros de discusión, chat, correo electrónico, blogs, etc.). b8) Respetar la dignidad, intimidad e integridad de los miembros de la comunidad educativa SENA. Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. b) De carácter disciplinario, b10)Realizar acciones proselitistas de carácter político o religioso dentro de las instalaciones del SENA y demás ambientes donde se desarrollen actividades formativas, así como propiciar actos indecorosos, de acoso, maltrato físico y/o mental, o conductas que puedan afectar a cualquier miembro de la comunidad educativa. b20) Propiciar conductas, propuestas o actos inmorales hacia cualquier miembro de la comunidad educativa, que atenten contra la integridad física, moral y/o psicológica'),
(4, 'Agresión fisica', 'Disciplinaria', 'Grave', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b1) Conocer y asumir las políticas y directrices institucionales establecidas, así como el reglamento del aprendiz SENA, y convivir en comunidad de acuerdo con ellos. b5) Actuar siempre teniendo como base los principios y valores para la convivencia; obrar con honestidad, respeto, responsabilidad, lealtad, justicia, compañerismo y solidaridad con la totalidad de los integrantes de la comunidad educativa y  expresarse con respeto, cultura y educación, en forma directa o a través de medios impresos o electrónicos (como foros de discusión, chat, correo electrónico, blogs, etc.). b8) Respetar la dignidad, intimidad e integridad de los miembros de la comunidad educativa SENA. Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. b) De carácter disciplinario, b10)Realizar acciones proselitistas de carácter político o religioso dentro de las instalaciones del SENA y demás ambientes donde se desarrollen actividades formativas, así como propiciar actos indecorosos, de acoso, maltrato físico y/o mental, o conductas que puedan afectar a cualquier miembro de la comunidad educativa. b20) Propiciar conductas, propuestas o actos inmorales hacia cualquier miembro de la comunidad educativa, que atenten contra la integridad física, moral y/o psicológica'),
(6, 'Pérdida de plan de mejoramiento como sanción de comité', 'Académica', 'Gravísima', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, Se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. a) De carácter académico, a1) Cumplir con todas las actividades propias de su proceso de aprendizaje o del plan de mejoramiento, definidas durante su proceso de aprendizaje. a2) Participar activamente en las actividades complementarias o de profundización, relacionadas con el programa de formación, con el fin de gestionar su proceso de formación. a9) Ser responsable de gestionar los recursos de información a través de las diferentes fuentes de conocimiento, que garantice el logro de los resultados de aprendizaje establecidos en el programa de formación. Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA.  a) De carácter académico, a3) Incumplir las actividades de aprendizaje acordadas en su proceso de formación  y los compromisos adquiridos como aprendiz SENA, sin justa causa'),
(7, 'Porte inadecuado del uniforme', 'Disciplinaria', 'Leve', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b1) Conocer y asumir las políticas y directrices institucionales establecidas, así como el reglamento del aprendiz SENA, y convivir en comunidad de acuerdo con ellos. b2)Portar permanentemente y en lugar visible el carné que lo identifica como aprendiz SENA, durante su proceso de formación, renovarlo de acuerdo con las disposiciones vigentes y devolverlo al finalizar el programa o cuando se presente retiro, aplazamiento o cancelación de la matrícula. b3) Utilizar la indumentaria y los elementos de protección personal dispuestos en los ambientes de aprendizaje, observando las condiciones de prevención señaladas por el Instructor o tutor  y organizarlos para ser utilizados exclusivamente en el ambiente de aprendizaje requerido. Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. b) De carácter disciplinario, b15) Incumplir las normas de convivencia establecidas en cada Centro de Formación o internado'),
(8, 'Incumplimiento en etapa productiva', 'Académica', 'Grave', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. a) De carácter académico, a2) Participar activamente en las actividades complementarias o de profundización, relacionadas con el programa de formación, con el fin de gestionar su proceso de formación. a7) Asumir con responsabilidad y participar en las actividades programadas como salidas, pasantías técnicas, intercambios de aprendices a nivel nacional e internacional, así como en las demás de carácter pedagógico. Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. a) De carácter académico, a2) Terminar unilateralmente el contrato de aprendizaje, sin el debido proceso y autorización del responsable del seguimiento al mismo. a3) Incumplir las actividades de aprendizaje acordadas en su proceso de formación  y los compromisos adquiridos como aprendiz SENA, sin justa causa'),
(9, 'Plagio', 'Académica', 'Grave', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, Se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. a) De carácter académico, a11) Respetar los derechos de autor en los materiales, trabajos, proyectos y demás documentos generados por los grupos de trabajo o compañeros, y que hayan sido compartidos al interior de la Plataforma. Sin embargo, con la autorización de los creadores se puede hacer uso de cualquier material publicado, dando el crédito a quien generó la idea, a la fuente que se consultó o al recurso en el que se basó la información. Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA.  a) De carácter académico, a1) Plagiar materiales, trabajos y demás documentos generados en los grupos de trabajo o producto del trabajo en equipo institucional, así como las fuentes bibliográficas consultadas en los diferentes soportes'),
(10, 'Indisciplina', 'Disciplinaria', 'Grave', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b1) Conocer y asumir las políticas y directrices institucionales establecidas, así como el Reglamento del aprendiz SENA, y convivir en comunidad de acuerdo con ellos. b5) Actuar siempre teniendo como base los principios y valores para la convivencia; obrar con honestidad, respeto, responsabilidad, lealtad, justicia, compañerismo y solidaridad con la totalidad de los integrantes de la comunidad educativa y  expresarse con respeto, cultura y educación, en forma directa o a través de medios impresos o electrónicos (como foros de discusión, chat, correo electrónico, blogs, etc.). Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. b) De carácter disciplinario, b15) Incumplir las normas de convivencia establecidas en cada Centro de formación o internado. b20) Propiciar conductas, propuestas o actos inmorales hacia cualquier miembro de la comunidad educativa, que atenten contra la integridad física, moral y/o psicológica'),
(11, 'Violación A La Intimidad', 'Disciplinaria', 'Grave', 'Capitulo 3, Deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b1) Conocer y asumir las políticas y directrices institucionales establecidas, así como el reglamento del aprendiz SENA, y convivir en comunidad de acuerdo con ellos. b8) Respetar la dignidad, intimidad e integridad de los miembros de la comunidad educativa SENA. Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. b) De carácter disciplinario, b5) Hurtar, estafar o abusar de la confianza de cualquier integrante de la comunidad educativa, o  amenazarlo, sobornarlo, coaccionarlo o agredirlo verbal o físicamente, o ser cómplice o coparticipe de delitos contra ellos o contra la institución. b20) Propiciar conductas, propuestas o actos inmorales hacia cualquier miembro de la comunidad educativa, que atenten contra la integridad física, moral y/o psicológica'),
(14, 'Alterar Adulterar Falsificar O Sustraer Documentos', 'Disciplinaria', 'Gravísima', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b1) Conocer y asumir las políticas y directrices institucionales establecidas, así como el reglamento del aprendiz SENA, y convivir en comunidad de acuerdo con ellos. b5) Actuar siempre teniendo como base los principios y valores para la convivencia; obrar con honestidad, respeto, responsabilidad, lealtad, justicia, compañerismo y solidaridad con la totalidad de los integrantes de la comunidad educativa y  expresarse con respeto, cultura y educación, en forma directa o a través de medios impresos o electrónicos (como foros de discusión, chat, correo electrónico, blogs, etc.). Capitulo 4, prohibiciones, artículo 5, se considerarán prohibiciones para los aprendices del SENA. b) De carácter disciplinario, b18) Alterar, adulterar, falsificar o sustraer documentos oficiales, calificaciones, evaluaciones o firmas correspondientes al SENA o emitidos por ella.'),
(15, 'Uso inadecuado de información digital o física', 'Disciplinaria', 'Grave', 'Capitulo 3, deberes del aprendiz SENA, articulo 4, se entiende por deber, la obligación legal, social y moral que compromete a la persona a cumplir con determinada actuación, asumiendo con responsabilidad todos sus actos, para propiciar la armonía, el respeto, la integración, el bienestar común y la seguridad de las personas y de los bienes de la institución. b) De carácter disciplinario, b1) Conocer y asumir las políticas y directrices institucionales establecidas, así como el reglamento del aprendiz SENA, y convivir en comunidad de acuerdo con ellos. b5) Actuar siempre teniendo como base los principios y valores para la convivencia; obrar con honestidad, respeto, responsabilidad, lealtad, justicia, compañerismo y solidaridad con la totalidad de los integrantes de la comunidad educativa y  expresarse con respeto, cultura y educación, en forma directa o a través de medios impresos o electrónicos (como foros de discusión, chat, correo electrónico, blogs, etc.). Capitulo 4, prohibiciones, artículo 5, b) De carácter disciplinario, b12)  Generar, transmitir, publicar o enviar información confidencial, de circulación restringida, inadecuada, malintencionada, violenta, pornográfica, insultos o agresiones por los medios de comunicación físicos o electrónicos, disponibles para su proceso de formación.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE IF NOT EXISTS `tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `nombre`) VALUES
(1, 'Seleccionar'),
(2, 'Comité Ordinario de Evaluación y Seguimiento Etapa Lectiva'),
(3, 'Comité Ordinario de Evaluación y Seguimiento Etapa Productiva'),
(4, 'Comité Extraordinario de Evaluación y Seguimiento Etapa Lectiva'),
(5, 'Comité Extraordinario de Evaluación y Seguimiento Etapa Productiva'),
(6, 'Comité Ordinario de Evaluación y Finalización Etapa Lectiva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulaciones`
--

CREATE TABLE IF NOT EXISTS `titulaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Volcar la base de datos para la tabla `titulaciones`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trimestres`
--

CREATE TABLE IF NOT EXISTS `trimestres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '1',
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `trimestres`
--

INSERT INTO `trimestres` (`id`, `nombre`, `estado`, `fecha_inicial`, `fecha_final`) VALUES
(1, 'Trimestre 1 Del 2012', 1, '2011-01-15', '2011-04-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `programa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `programa_id` (`programa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `password`, `rol`, `programa_id`) VALUES
(1, 'secretario', 'secretario', 'Secretario', 34),
(6, 'instructor', 'instructor', 'Instructor', 34);

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `actas`
--
ALTER TABLE `actas`
  ADD CONSTRAINT `actas_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`);

--
-- Filtros para la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD CONSTRAINT `asistentes_ibfk_1` FOREIGN KEY (`acta_id`) REFERENCES `actas` (`id`);

--
-- Filtros para la tabla `casos`
--
ALTER TABLE `casos`
  ADD CONSTRAINT `casos_ibfk_15` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `casos_ibfk_16` FOREIGN KEY (`quejoso_id`) REFERENCES `quejosos` (`id`),
  ADD CONSTRAINT `casos_ibfk_17` FOREIGN KEY (`aprendiz_id`) REFERENCES `aprendices` (`id`);

--
-- Filtros para la tabla `compromisos`
--
ALTER TABLE `compromisos`
  ADD CONSTRAINT `compromisos_ibfk_1` FOREIGN KEY (`acta_id`) REFERENCES `actas` (`id`);

--
-- Filtros para la tabla `decisiones`
--
ALTER TABLE `decisiones`
  ADD CONSTRAINT `decisiones_ibfk_1` FOREIGN KEY (`sancion_id`) REFERENCES `sanciones` (`id`);

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_5` FOREIGN KEY (`titulacion_id`) REFERENCES `titulaciones` (`id`),
  ADD CONSTRAINT `grupos_ibfk_6` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`);

--
-- Filtros para la tabla `informes`
--
ALTER TABLE `informes`
  ADD CONSTRAINT `informes_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`);

--
-- Filtros para la tabla `integrantes`
--
ALTER TABLE `integrantes`
  ADD CONSTRAINT `integrantes_ibfk_1` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`);

--
-- Filtros para la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD CONSTRAINT `procesos_ibfk_1` FOREIGN KEY (`programacion_id`) REFERENCES `programaciones` (`id`),
  ADD CONSTRAINT `procesos_ibfk_2` FOREIGN KEY (`acta_id`) REFERENCES `actas` (`id`);

--
-- Filtros para la tabla `programaciones`
--
ALTER TABLE `programaciones`
  ADD CONSTRAINT `programaciones_ibfk_5` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`),
  ADD CONSTRAINT `programaciones_ibfk_6` FOREIGN KEY (`sesion_id`) REFERENCES `sesiones` (`id`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `programas_ibfk_1` FOREIGN KEY (`centro_id`) REFERENCES `centros` (`id`);

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_4` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`),
  ADD CONSTRAINT `sesiones_ibfk_5` FOREIGN KEY (`trimestre_id`) REFERENCES `trimestres` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`);
