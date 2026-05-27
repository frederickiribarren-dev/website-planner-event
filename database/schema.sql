-- Drop tables if they exist (in reverse order of dependencies)
DROP TABLE IF EXISTS imagenes;
DROP TABLE IF EXISTS imagenables;
DROP TABLE IF EXISTS regalos_reservas;
DROP TABLE IF EXISTS regalos_historial_cambios;
DROP TABLE IF EXISTS auditoria_eventos;
DROP TABLE IF EXISTS regalos;
DROP TABLE IF EXISTS invitados;
DROP TABLE IF EXISTS listas_invitados;
DROP TABLE IF EXISTS configuracion_usuario;
DROP TABLE IF EXISTS eventos;
DROP TABLE IF EXISTS categorias_regalos;
DROP TABLE IF EXISTS usuarios;

-- 1. Tabla de Usuarios (Base)
CREATE TABLE usuarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NULL,
    estado ENUM('Activo', 'Suspendido', 'Eliminado') NULL DEFAULT 'Activo',
    imagen_portada_url VARCHAR(500) NULL,
    ultimo_login DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    KEY `idx_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla de Categorías de Regalos (Base)
CREATE TABLE categorias_regalos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    icono_url VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabla de Eventos (Depende de usuarios)
CREATE TABLE eventos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT UNSIGNED NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    nombre_bebe VARCHAR(100) NULL,
    genero_bebe ENUM('Niño', 'Niña', 'Sorpresa', 'Múltiple') NOT NULL,
    fecha_evento DATETIME NOT NULL,
    ubicacion_nombre VARCHAR(255) NULL,
    mensaje_invitacion LONGTEXT NULL,
    color_tema VARCHAR(7) NULL DEFAULT '#60A5FA',
    estado ENUM('Borrador', 'Publicado', 'Finalizado', 'Cancelado') NULL DEFAULT 'Borrador',
    imagen_portada_url VARCHAR(500) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    KEY `idx_eventos_usuario` (`usuario_id`),
    CONSTRAINT `fk_eventos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabla de Configuración del Usuario (Depende de usuarios)
CREATE TABLE configuracion_usuario (
    usuario_id BIGINT UNSIGNED PRIMARY KEY,
    notificaciones_push BOOLEAN NULL DEFAULT 1,
    notificaciones_email BOOLEAN NULL DEFAULT 1,
    idioma CHAR(5) NULL DEFAULT 'es-CL',
    timezone VARCHAR(50) NULL DEFAULT 'America/Santiago',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_conf_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabla de Listas de Invitados (Depende de eventos)
CREATE TABLE listas_invitados (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evento_id BIGINT UNSIGNED NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    categoria TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    KEY `idx_listas_invitados_evento` (`evento_id`),
    CONSTRAINT `fk_listas_invitados_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabla de Invitados (Depende de eventos y listas_invitados)
CREATE TABLE invitados (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evento_id BIGINT UNSIGNED NOT NULL,
    lista_invitado_id BIGINT UNSIGNED NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NULL,
    telefono VARCHAR(20) NULL,
    token_acceso VARCHAR(64) NULL UNIQUE,
    estado_invitacion ENUM('Pendiente', 'Enviado', 'Leído', 'Error') NULL DEFAULT 'Pendiente',
    estado_asistencia ENUM('Sin responder', 'Confirmado', 'Rechazado') NULL DEFAULT 'Sin responder',
    cantidad_adultos INT NULL DEFAULT 1,
    cantidad_ninos INT NULL DEFAULT 0,
    alergias_notas LONGTEXT NULL,
    fecha_confirmacion DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    KEY `idx_invitados_evento` (`evento_id`),
    KEY `idx_invitados_lista` (`lista_invitado_id`),
    CONSTRAINT `fk_invitados_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fk_invitados_lista_invitado` FOREIGN KEY (`lista_invitado_id`) REFERENCES `listas_invitados` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabla de Regalos (Depende de eventos y categorias_regalos)
CREATE TABLE regalos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evento_id BIGINT UNSIGNED NOT NULL,
    categoria_id BIGINT UNSIGNED NULL,
    nombre_regalo VARCHAR(200) NOT NULL,
    descripcion LONGTEXT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta', 'Urgente') NULL DEFAULT 'Media',
    link_referencia VARCHAR(500) NULL,
    precio_estimado DECIMAL(12,2) NULL,
    cantidad_solicitada INT NULL DEFAULT 1,
    cantidad_completada INT NULL DEFAULT 0,
    estado ENUM('Disponible', 'Reservado_Parcial', 'Completado') NULL DEFAULT 'Disponible',
    imagen_portada_url VARCHAR(500) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    KEY `idx_regalos_evento` (`evento_id`),
    KEY `idx_regalos_categoria` (`categoria_id`),
    CONSTRAINT `fk_regalos_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fk_regalos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_regalos` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabla de Auditoría de Eventos (Depende de eventos)
CREATE TABLE auditoria_eventos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evento_id BIGINT UNSIGNED NOT NULL,
    entidad_tipo ENUM('EVENTO', 'INVITADO', 'REGALO', 'RESERVA') NULL,
    entidad_id BIGINT UNSIGNED NULL,
    accion ENUM('CREAR', 'ACTUALIZAR', 'ELIMINAR', 'CONFIRMACION') NULL,
    detalle_cambio JSON NULL,
    usuario_operador BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `idx_auditoria_evento` (`evento_id`),
    KEY `idx_auditoria_entidad` (`entidad_tipo`, `entidad_id`),
    CONSTRAINT `fk_auditoria_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabla de Historial de Cambios de Regalos (Depende de regalos)
CREATE TABLE regalos_historial_cambios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    regalo_id BIGINT UNSIGNED NOT NULL,
    campo_modificado VARCHAR(100) NULL,
    valor_anterior LONGTEXT NULL,
    valor_nuevo LONGTEXT NULL,
    fecha_cambio TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `idx_historial_regalo` (`regalo_id`),
    CONSTRAINT `fk_historial_regalo` FOREIGN KEY (`regalo_id`) REFERENCES `regalos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Tabla de Reservas de Regalos (Depende de regalos e invitados)
CREATE TABLE regalos_reservas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    regalo_id BIGINT UNSIGNED NOT NULL,
    invitado_id BIGINT UNSIGNED NOT NULL,
    cantidad_reservada INT NULL DEFAULT 1,
    comprobante_url VARCHAR(500) NULL,
    fecha_reserva TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `idx_reservas_regalo` (`regalo_id`),
    KEY `idx_reservas_invitado` (`invitado_id`),
    UNIQUE (`regalo_id`, `invitado_id`),
    CONSTRAINT `fk_reserva_regalo` FOREIGN KEY (`regalo_id`) REFERENCES `regalos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fk_reserva_invitado` FOREIGN KEY (`invitado_id`) REFERENCES `invitados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Tabla de Imagenables (Polimórfica) (Depende de usuarios, eventos y regalos)
CREATE TABLE imagenables (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT UNSIGNED NULL,
    evento_id BIGINT UNSIGNED NULL,
    regalo_id BIGINT UNSIGNED NULL,
    descripcion VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `idx_imagenables_usuario` (`usuario_id`),
    KEY `idx_imagenables_evento` (`evento_id`),
    KEY `idx_imagenables_regalo` (`regalo_id`),
    CONSTRAINT `fk_imagenables_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fk_imagenables_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fk_imagenables_regalo` FOREIGN KEY (`regalo_id`) REFERENCES `regalos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Tabla de Imágenes (Depende de imagenables)
CREATE TABLE imagenes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    imagenable_id BIGINT UNSIGNED NOT NULL,
    url VARCHAR(500) NOT NULL,
    nombre_archivo VARCHAR(255) NULL,
    alt_text VARCHAR(255) NULL,
    tipo VARCHAR(50) NULL,
    orden INT NULL DEFAULT 0,
    metadata JSON NULL,
    is_primary BOOLEAN NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY `idx_imagenes_imagenable` (`imagenable_id`),
    KEY `idx_imagenes_primary` (`imagenable_id`, `is_primary`),
    CONSTRAINT `fk_imagenes_imagenable` FOREIGN KEY (`imagenable_id`) REFERENCES `imagenables` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
