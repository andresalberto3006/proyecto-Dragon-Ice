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

INSERT INTO productos VALUES
(1,'Café','Helado cremoso con intenso sabor a café',12,7,20,'imagenesproyecto/Helado de cafe.avif'),
(2,'Frutilla','Refrescante y dulce sabor natural',10,6,20,'imagenesproyecto/helado2.jpg'),
(3,'Durazno','Textura suave y sabor tropical',10,6,20,'imagenesproyecto/helado3.jpg'),
(4,'Canela','Un toque cálido y delicioso',11,6,20,'imagenesproyecto/helado4.jpg'),
(5,'Menta','Frescura intensa y cremosa',11,6,20,'imagenesproyecto/helado5.jpg'),
(6,'Banana Split','El clásico favorito de todos',18,10,20,'imagenesproyecto/helado.jpg');