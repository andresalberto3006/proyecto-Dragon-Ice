DROP DATABASE IF EXISTS dragonice;
CREATE DATABASE dragonice CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE dragonice;

CREATE TABLE usuario (
  ci INT NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  direccion VARCHAR(100) NOT NULL,
  celular VARCHAR(20) NOT NULL,
  rol ENUM('Administrador','Vendedor') NOT NULL,
  estado ENUM('Activo','Bloqueado') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (ci)
) ENGINE=InnoDB;

CREATE TABLE productos (
  id INT NOT NULL,
  nombre VARCHAR(80) NOT NULL,
  descripcion VARCHAR(150) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  costo DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  imagen VARCHAR(200) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE pedidos (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL,
  fecha DATE NOT NULL,
  estado ENUM('Pendiente','En proceso','Entregado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  vendedor_ci INT NOT NULL,
  nombrevendedor VARCHAR(80) NOT NULL,
  metodo_pago VARCHAR(45) NOT NULL DEFAULT '',
  ALTER TABLE pedidos
  PRIMARY KEY (id),
  FOREIGN KEY (vendedor_ci) REFERENCES usuario(ci)
) ENGINE=InnoDB;

CREATE TABLE carrito (
  productos_id INT NOT NULL,
  pedidos_id INT NOT NULL,
  cantidad INT NOT NULL,
  costototal DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (productos_id,pedidos_id),
  FOREIGN KEY (productos_id) REFERENCES productos(id),
  FOREIGN KEY (pedidos_id) REFERENCES pedidos(id)
) ENGINE=InnoDB;

CREATE TABLE ventas (
  id INT NOT NULL AUTO_INCREMENT,
  pedidos_id INT NOT NULL,
  fecha DATE NOT NULL,
  cliente VARCHAR(80) NOT NULL,
  vendedor_ci INT NOT NULL,
  nombrevendedor VARCHAR(80) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  metodo_pago VARCHAR(45) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY venta_pedido (pedidos_id),
  FOREIGN KEY (pedidos_id) REFERENCES pedidos(id),
  FOREIGN KEY (vendedor_ci) REFERENCES usuario(ci)
) ENGINE=InnoDB;

INSERT INTO usuario VALUES
(10000000,'Administrador','Dragon Ice','70000000','Administrador','Activo'),
(20000000,'Vendedor','Dragon Ice','71111111','Vendedor','Activo');

INSERT INTO productos (id, nombre, descripcion, precio, costo, stock, imagen) VALUES
(1,  'Banana Split',             'Plátano, helado y toppings clásicos',        18, 10, 20, 'imagenesproyecto/banana.jpg'),
(2,  'Blue Moon',         'Paleta helada de frambuesa azul',             8,  4, 25, 'imagenesproyecto/blue.jpg'),
(3,  'Bolo Frutal',         'Bolo helado con tres leches',                15,  9, 15, 'imagenesproyecto/bolos.jpg'),
(4,  'Boba Helada',              'Helado con perlas de boba',                  14,  8, 20, 'imagenesproyecto/boobas.jpg'),
(5,  'Brownie Supreme',          'Brownie con helado y chocolate caliente',    16,  9, 15, 'imagenesproyecto/brownie.jpg'),
(6,  'Combo Dragon',             'Combo especial de la casa',                  20, 12, 10, 'imagenesproyecto/combo.jpg'),
(7,  'Cono Waffle',              'Helado en cono de waffle artesanal',         10,  5, 25, 'imagenesproyecto/conos.jpg'),
(8,  'Ensalada de Frutas Helada','Frutas frescas con helado',                  12,  6, 20, 'imagenesproyecto/ensalada.jpg'),
(9,  'Kirwi Berry',               'Helado sabor kiwi y berries',                11,  6, 20, 'imagenesproyecto/kiyrbi.jpg'),
(10, 'Mochi Helado',             'Mochi relleno de helado',                    13,  7, 20, 'imagenesproyecto/mochi.jpg'),
(11, 'Paleta Frutal',            'Paleta de frutas naturales',                  7,  3, 25, 'imagenesproyecto/paletas.jpg'),
(12, 'Taiyaki',               'Paleta helada con forma de pez',              9,  4, 20, 'imagenesproyecto/pez.jpg'),
(13, 'Helado Picante',           'Helado con un toque picante',                12,  6, 15, 'imagenesproyecto/picante.jpg'),
(14, 'Raspado de Frutas',        'Raspado de hielo con jarabe de frutas',       9,  4, 20, 'imagenesproyecto/raspados.jpg'),
(15, 'Paleta Rellena',             'Taco de helado relleno',                     14,  8, 15, 'imagenesproyecto/relleno.jpg'),
(16, 'Rollo de Helado',          'Helado enrollado estilo tailandés',          15,  9, 15, 'imagenesproyecto/rollo.jpg'),
(17, 'Rollo de Canela',          'Rollo de helado sabor canela',               15,  9, 15, 'imagenesproyecto/rollocanela.jpg'),
(18, 'Helado Snoopy',            'Helado decorado estilo Snoopy',              16,  9, 10, 'imagenesproyecto/snoopye.jpg'),
(19, 'Taco Helado Clásico',      'Taco de helado tradicional',                 12,  6, 20, 'imagenesproyecto/tacos.jpg');