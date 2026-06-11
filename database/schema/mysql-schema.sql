/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `auditoria_eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria_eventos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `evento_id` bigint unsigned NOT NULL,
  `entidad_tipo` enum('EVENTO','INVITADO','REGALO','RESERVA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entidad_id` bigint unsigned DEFAULT NULL,
  `accion` enum('CREAR','ACTUALIZAR','ELIMINAR','CONFIRMACION') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle_cambio` json DEFAULT NULL,
  `usuario_operador` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_auditoria_entidad` (`entidad_tipo`,`entidad_id`),
  KEY `idx_auditoria_evento` (`evento_id`),
  CONSTRAINT `auditoria_eventos_evento_id_foreign` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categorias_regalos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_regalos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` enum('Ropa','Utensilios','Accesorios','Grupal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `icono_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `configuracion_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion_usuario` (
  `usuario_id` bigint unsigned NOT NULL,
  `notificaciones_push` tinyint(1) DEFAULT '1',
  `notificaciones_email` tinyint(1) DEFAULT '1',
  `idioma` char(5) COLLATE utf8mb4_unicode_ci DEFAULT 'es-CL',
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'America/Santiago',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`),
  CONSTRAINT `configuracion_usuario_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_bebe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genero_bebe` enum('Niño','Niña','Sorpresa','Múltiple') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_evento` datetime NOT NULL,
  `ubicacion_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje_invitacion` longtext COLLATE utf8mb4_unicode_ci,
  `color_tema` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#60A5FA',
  `estado` enum('Borrador','Publicado','Finalizado','Cancelado') COLLATE utf8mb4_unicode_ci DEFAULT 'Borrador',
  `imagen_portada_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lista_invitado_id` bigint unsigned DEFAULT NULL,
  `lista_regalos_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_eventos_usuario` (`usuario_id`),
  KEY `idx_eventos_lista_invitado` (`lista_invitado_id`),
  KEY `idx_eventos_lista_regalos` (`lista_regalos_id`),
  CONSTRAINT `eventos_lista_invitado_id_foreign` FOREIGN KEY (`lista_invitado_id`) REFERENCES `listas_invitados` (`id`) ON DELETE SET NULL,
  CONSTRAINT `eventos_lista_regalos_id_foreign` FOREIGN KEY (`lista_regalos_id`) REFERENCES `listas_regalos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `eventos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `imagenables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned DEFAULT NULL,
  `evento_id` bigint unsigned DEFAULT NULL,
  `regalo_id` bigint unsigned DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_imagenables_usuario` (`usuario_id`),
  KEY `idx_imagenables_evento` (`evento_id`),
  KEY `idx_imagenables_regalo` (`regalo_id`),
  CONSTRAINT `imagenables_evento_id_foreign` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `imagenables_regalo_id_foreign` FOREIGN KEY (`regalo_id`) REFERENCES `regalos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `imagenables_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `imagenable_id` bigint unsigned NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int DEFAULT '0',
  `metadata` json DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_imagenes_primary` (`imagenable_id`,`is_primary`),
  KEY `idx_imagenes_imagenable` (`imagenable_id`),
  CONSTRAINT `imagenes_imagenable_id_foreign` FOREIGN KEY (`imagenable_id`) REFERENCES `imagenables` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `invitados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invitados` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` bigint unsigned DEFAULT NULL,
  `lista_invitado_id` bigint unsigned DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_acceso` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_invitacion` enum('Pendiente','Enviado','Leído','Error') COLLATE utf8mb4_unicode_ci DEFAULT 'Pendiente',
  `estado_asistencia` enum('Sin responder','Confirmado','Rechazado') COLLATE utf8mb4_unicode_ci DEFAULT 'Sin responder',
  `cantidad_adultos` int DEFAULT '1',
  `cantidad_ninos` int DEFAULT '0',
  `alergias_notas` longtext COLLATE utf8mb4_unicode_ci,
  `fecha_confirmacion` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_acceso` (`token_acceso`),
  KEY `idx_invitados_evento` (`evento_id`),
  KEY `idx_invitados_lista` (`lista_invitado_id`),
  CONSTRAINT `fk_invitados_lista_invitado` FOREIGN KEY (`lista_invitado_id`) REFERENCES `listas_invitados` (`id`) ON DELETE SET NULL,
  CONSTRAINT `invitados_evento_id_foreign` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `listas_invitados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listas_invitados` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` bigint unsigned DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_listas_invitados_evento` (`evento_id`),
  CONSTRAINT `fk_listas_invitados_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `listas_regalos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listas_regalos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `evento_id` bigint unsigned DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('Borrador','Activa','Completada') COLLATE utf8mb4_unicode_ci DEFAULT 'Borrador',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_listas_regalos_user` (`user_id`),
  KEY `idx_listas_regalos_evento` (`evento_id`),
  CONSTRAINT `fk_listas_regalos_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_listas_regalos_user` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `regalos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regalos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `evento_id` bigint unsigned DEFAULT NULL,
  `categoria_id` bigint unsigned DEFAULT NULL,
  `lista_regalos_id` bigint unsigned DEFAULT NULL,
  `nombre_regalo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `prioridad` enum('Baja','Media','Alta','Urgente') COLLATE utf8mb4_unicode_ci DEFAULT 'Media',
  `link_referencia` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_referencia_2` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_referencia_3` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_estimado` decimal(12,2) DEFAULT NULL,
  `cantidad_solicitada` int DEFAULT '1',
  `cantidad_completada` int DEFAULT '0',
  `estado` enum('Disponible','Reservado_Parcial','Completado') COLLATE utf8mb4_unicode_ci DEFAULT 'Disponible',
  `imagen_portada_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_regalos_evento` (`evento_id`),
  KEY `idx_regalos_categoria` (`categoria_id`),
  KEY `idx_regalos_lista` (`lista_regalos_id`),
  CONSTRAINT `regalos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_regalos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `regalos_evento_id_foreign` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `regalos_lista_regalos_id_foreign` FOREIGN KEY (`lista_regalos_id`) REFERENCES `listas_regalos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `regalos_historial_cambios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regalos_historial_cambios` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `regalo_id` bigint unsigned NOT NULL,
  `campo_modificado` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_anterior` longtext COLLATE utf8mb4_unicode_ci,
  `valor_nuevo` longtext COLLATE utf8mb4_unicode_ci,
  `fecha_cambio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_historial_regalo` (`regalo_id`),
  CONSTRAINT `regalos_historial_cambios_regalo_id_foreign` FOREIGN KEY (`regalo_id`) REFERENCES `regalos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `regalos_reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regalos_reservas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `regalo_id` bigint unsigned NOT NULL,
  `invitado_id` bigint unsigned NOT NULL,
  `cantidad_reservada` int DEFAULT '1',
  `comprobante_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_reserva` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `regalo_id` (`regalo_id`,`invitado_id`),
  KEY `idx_reservas_regalo` (`regalo_id`),
  KEY `idx_reservas_invitado` (`invitado_id`),
  CONSTRAINT `regalos_reservas_invitado_id_foreign` FOREIGN KEY (`invitado_id`) REFERENCES `invitados` (`id`) ON DELETE CASCADE,
  CONSTRAINT `regalos_reservas_regalo_id_foreign` FOREIGN KEY (`regalo_id`) REFERENCES `regalos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('Activo','Suspendido','Eliminado') COLLATE utf8mb4_unicode_ci DEFAULT 'Activo',
  `imagen_portada_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2026_04_29_225530_create_auditoria_eventos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2026_04_29_225530_create_categorias_regalos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2026_04_29_225530_create_configuracion_usuario_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2026_04_29_225530_create_eventos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2026_04_29_225530_create_imagenables_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2026_04_29_225530_create_imagenes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2026_04_29_225530_create_invitados_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2026_04_29_225530_create_regalos_historial_cambios_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2026_04_29_225530_create_regalos_reservas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2026_04_29_225530_create_regalos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2026_04_29_225530_create_usuarios_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2026_05_16_000000_create_listas_invitados_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2026_06_08_000002_create_listas_regalos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2026_06_11_024019_add_missing_foreign_keys_to_tables',1);
