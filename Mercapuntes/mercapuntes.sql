/*
    Creación de base de datos y usuario
*/
CREATE DATABASE mercapuntes;
USE mercapuntes;

CREATE USER mercapuntes IDENTIFIED BY "mercapuntes";
GRANT ALL ON mercapuntes.* TO mercapuntes;


/*
    Tabla de usuarios
*/
CREATE TABLE usuarios (
	id_usuario INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
	clave VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_usuario)
);

INSERT INTO usuarios (email, clave) VALUES ("user1@email.com", "$2y$10$A0VWhkAy1sV04lPjvO3cBeXQAsHDF7soe8oZIB8k6xvtsnzeWKUMu");
INSERT INTO usuarios (email, clave) VALUES ("user2@email.com", "$2y$10$S30gKroy2A8GkBnEwWpB.uqcNUYIK0ysCYzGq4aEdE.Tiy43enLwu");
INSERT INTO usuarios (email, clave) VALUES ("user3@email.com", "$2y$10$vtYAERwdyjXPkf3OLKfZj.TWmcnT/UiUbPR6VB5v2Ex/MNtXPr53u");
INSERT INTO usuarios (email, clave) VALUES ("user4@email.com", "$2y$10$bDEzAQgVQ/Ibe4.JtQBck./wHWQjjgRxTWwukfKc1fbXRnBm/j0qu");


/*
    Tabla de anuncios
*/
CREATE TABLE anuncios (
    id_anuncio INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    curso VARCHAR(255) NOT NULL,
    tematica VARCHAR(255) NOT NULL,
    precio DECIMAL(6,2) NOT NULL,
    zona VARCHAR(255) NOT NULL,
    telefono VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_anuncio),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (1, "Vendo apuntes de matemáticas", "Hola vendo apuntes de mates en buen estado.", "Secundaria", "Ciencias", "20", "Navarra", "666112233", "2019-02-11 10:06:21", "5cd9e7ef3946f2.07892631.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (1, "Vendo apuntes de plástica", "Hola vendo apuntes de dibujo en buen estado.", "Secundaria", "Artes", "11.50", "Navarra", "666112233", "2019-02-26 11:05:42", "5cd9e94e632634.33648082.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (1, "Vendo apuntes de lengua", "Hola vendo apuntes de lengua en buen estado.", "Secundaria", "Letras", "16", "Navarra", "666112233", "2019-04-28 09:10:22", "5cd9e9b1937352.47619169.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (2, "Libros de programación", "Vendo regalados estos libros de programación.", "Formación Profesional", "Ciencias", "5", "Cataluña", "999225588", "2018-11-10 22:26:01", "5cd9eacc42efd9.43725524.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (2, "Apuntes de PHP", "Vendo apuntes de PHP, valen su peso en oro.", "Formación Profesional", "Ciencias", "860", "Cataluña", "999225588", "2018-12-10 23:01:03", "5cd9ec06c25e35.52146543.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (2, "Recetas de cocina", "Recetas de postres sobretodo.", "Varios", "Otros", "10.20", "Cataluña", "999225588", "2019-01-12 12:11:31", "5cd9ec7baefe04.58236074.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (3, "Apuntes de anatomía", "Hechos a mano, de la carrera de medicina.", "Universidad", "Ciencias", "56", "Asturias", "633448899", "2019-03-10 21:21:01", "5cd9ecfb477400.74507447.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (3, "Apuntes de química", "Apuntes de 2º de bachillerato de la asignatura de química", "Bachillerato", "Ciencias", "12", "Asturias", "633448899", "2019-03-19 20:22:22", "5cd9ed584d15b1.58528541.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (3, "Apuntes de física", "Apuntes de 2º de bachillerato de la asignatura de física", "Bachillerato", "Ciencias", "56", "Asturias", "633448899", "2019-04-02 01:05:58", "5cd9edc28880a7.36903890.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (4, "Hojas sueltas", "Vendo apuntes sueltos de todo un poco, de derecho sobretodo.", "Universidad", "Letras", "12", "Castilla y León", "", "2019-03-10 20:21:01", "5cd9ee1d29f777.34222522.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (4, "Libros de derecho", "Vendo libros de derecho porque no los voy a usar más.", "Universidad", "Letras", "128", "Castilla y León", "", "2019-03-19 10:41:31", "5cd9ee6b3e3a60.13943003.jpg");
INSERT INTO anuncios (id_usuario, titulo, descripcion, curso, tematica, precio, zona, telefono, fecha, imagen) VALUES (4, "Manual jurídico", "Manual jurídico en buen estado, se aceptan intercambios.", "Universidad", "Letras", "8", "Castilla y León", "", "2019-03-19 11:21:01", "5cd9eec93d9151.01322517.jpg");


/*
    Tabla de comunidades autónomas, para los desplegables
*/
CREATE TABLE zonas (
    id_zona INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_zona)
);

INSERT INTO zonas (nombre) VALUES ("Andalucía");
INSERT INTO zonas (nombre) VALUES ("Aragón");
INSERT INTO zonas (nombre) VALUES ("Asturias");
INSERT INTO zonas (nombre) VALUES ("Cantabria");
INSERT INTO zonas (nombre) VALUES ("Castilla-La Mancha");
INSERT INTO zonas (nombre) VALUES ("Castilla y León");
INSERT INTO zonas (nombre) VALUES ("Cataluña");
INSERT INTO zonas (nombre) VALUES ("Ceuta/Melilla");
INSERT INTO zonas (nombre) VALUES ("Extremadura");
INSERT INTO zonas (nombre) VALUES ("Galicia");
INSERT INTO zonas (nombre) VALUES ("Islas Baleares");
INSERT INTO zonas (nombre) VALUES ("Islas Canarias");
INSERT INTO zonas (nombre) VALUES ("Cádiz");
INSERT INTO zonas (nombre) VALUES ("La Rioja");
INSERT INTO zonas (nombre) VALUES ("Madrid");
INSERT INTO zonas (nombre) VALUES ("Murcia");
INSERT INTO zonas (nombre) VALUES ("Navarra");
INSERT INTO zonas (nombre) VALUES ("País Vasco");
INSERT INTO zonas (nombre) VALUES ("Valencia");


/*
    Tabla de cursos, para los desplegables
*/
CREATE TABLE cursos (
    id_curso INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_curso)
);

INSERT INTO cursos (nombre) VALUES ("Secundaria");
INSERT INTO cursos (nombre) VALUES ("Bachillerato");
INSERT INTO cursos (nombre) VALUES ("Formación Profesional");
INSERT INTO cursos (nombre) VALUES ("Universidad");
INSERT INTO cursos (nombre) VALUES ("Oposiciones");
INSERT INTO cursos (nombre) VALUES ("Varios");


/*
    Tabla de temáticas, para los desplegables
*/
CREATE TABLE tematicas (
    id_tematica INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_tematica)
);

INSERT INTO tematicas (nombre) VALUES ("Artes");
INSERT INTO tematicas (nombre) VALUES ("Ciencias");
INSERT INTO tematicas (nombre) VALUES ("Letras");
INSERT INTO tematicas (nombre) VALUES ("Otros");
