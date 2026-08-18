USE dragonice;
ALTER TABLE pedidos ADD COLUMN telefono VARCHAR(20) NULL AFTER nombre;
ALTER TABLE pedidos ADD COLUMN direccion VARCHAR(100) NULL AFTER telefono;
ALTER TABLE pedidos MODIFY COLUMN estado ENUM('Abierto','Pendiente','En proceso','Entregado','Rechazado') NOT NULL DEFAULT 'Abierto';
ALTER TABLE pedidos MODIFY COLUMN vendedor_ci INT NULL;
ALTER TABLE pedidos MODIFY COLUMN nombrevendedor VARCHAR(80) NULL;
