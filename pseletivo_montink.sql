SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = '';

-- Dumping structure for table pseletivo_montink.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.cache: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.cache_locks: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.jobs: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.job_batches: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.loja_cupons
CREATE TABLE IF NOT EXISTS `loja_cupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `desconto` decimal(20,2) DEFAULT NULL,
  `valor_minimo` decimal(20,2) DEFAULT NULL,
  `validade` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `deleted_at` (`deleted_at`) USING BTREE,
  KEY `nome` (`codigo`) USING BTREE,
  KEY `validade` (`validade`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pseletivo_montink.loja_cupons: ~2 rows (approximately)
INSERT INTO `loja_cupons` (`id`, `codigo`, `desconto`, `valor_minimo`, `validade`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(3, 'GHY123KK', 30.00, 210.00, '2025-08-31', '2025-07-25 18:31:01', '2025-07-25 18:31:01', NULL),
	(4, '80PJKG22', 15.00, 90.00, '2025-08-08', '2025-07-25 18:31:39', '2025-07-25 18:31:39', NULL);

-- Dumping structure for table pseletivo_montink.loja_estoques
CREATE TABLE IF NOT EXISTS `loja_estoques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loja_produtos_id` int(11) DEFAULT NULL,
  `loja_variacoes_id` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `loja_produtos_id_loja_variacoes_id` (`loja_produtos_id`,`loja_variacoes_id`),
  KEY `deleted_at` (`deleted_at`) USING BTREE,
  KEY `produtos_id` (`loja_produtos_id`) USING BTREE,
  KEY `produtos_variacoes_id` (`loja_variacoes_id`) USING BTREE,
  CONSTRAINT `FK_loja_estoque_loja_produtos` FOREIGN KEY (`loja_produtos_id`) REFERENCES `loja_produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_loja_estoque_loja_variacoes` FOREIGN KEY (`loja_variacoes_id`) REFERENCES `loja_variacoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pseletivo_montink.loja_estoques: ~15 rows (approximately)
INSERT INTO `loja_estoques` (`id`, `loja_produtos_id`, `loja_variacoes_id`, `quantidade`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(9, 15, 24, 9, '2025-07-25 18:03:08', '2025-07-25 18:33:29', NULL),
	(10, 14, 22, 4, '2025-07-25 18:03:32', '2025-07-25 18:34:20', NULL),
	(11, 14, 23, 10, '2025-07-25 18:03:44', '2025-07-25 18:03:44', NULL),
	(12, 6, 10, 4, '2025-07-25 18:04:14', '2025-07-25 18:28:09', NULL),
	(13, 6, 11, 0, '2025-07-25 18:04:22', '2025-07-25 18:36:42', NULL),
	(14, 8, 13, 1, '2025-07-25 18:04:32', '2025-07-25 18:04:32', NULL),
	(15, 11, 18, 0, '2025-07-25 18:04:48', '2025-07-25 18:28:09', NULL),
	(16, 13, 21, 5, '2025-07-25 18:04:57', '2025-07-25 18:04:57', NULL),
	(17, 9, 15, 5, '2025-07-25 18:05:30', '2025-07-25 18:36:42', NULL),
	(18, 7, 12, 5, '2025-07-25 18:05:56', '2025-07-25 18:05:56', NULL),
	(19, 8, 14, 15, '2025-07-25 18:08:15', '2025-07-25 18:08:15', NULL),
	(20, 8, 26, 5, '2025-07-25 18:08:26', '2025-07-25 18:08:26', NULL),
	(21, 6, 27, 5, '2025-07-25 18:09:24', '2025-07-25 18:09:24', NULL),
	(22, 9, 28, 1, '2025-07-25 18:10:11', '2025-07-25 18:36:42', NULL),
	(23, 11, 19, 7, '2025-07-25 18:10:48', '2025-07-25 18:33:29', NULL);

-- Dumping structure for table pseletivo_montink.loja_pedidos
CREATE TABLE IF NOT EXISTS `loja_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loja_cupons_id` int(11) DEFAULT NULL,
  `cliente_nome` varchar(255) DEFAULT NULL,
  `cliente_email` varchar(255) DEFAULT NULL,
  `cliente_cep` varchar(255) DEFAULT NULL,
  `cliente_endereco` varchar(255) DEFAULT NULL,
  `cliente_complemento` varchar(255) DEFAULT NULL,
  `cliente_numero` varchar(255) DEFAULT NULL,
  `cliente_uf` varchar(255) DEFAULT NULL,
  `cliente_cidade` varchar(255) DEFAULT NULL,
  `subtotal` decimal(20,6) DEFAULT NULL,
  `frete` decimal(20,6) DEFAULT NULL,
  `cupom_codigo` varchar(50) DEFAULT NULL,
  `cupom` decimal(20,6) DEFAULT NULL,
  `total` decimal(20,6) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `deleted_at` (`deleted_at`) USING BTREE,
  KEY `loja_cupons_id` (`loja_cupons_id`),
  KEY `status` (`status`),
  CONSTRAINT `FK_loja_pedidos_loja_cupons` FOREIGN KEY (`loja_cupons_id`) REFERENCES `loja_cupons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pseletivo_montink.loja_pedidos: ~4 rows (approximately)
INSERT INTO `loja_pedidos` (`id`, `loja_cupons_id`, `cliente_nome`, `cliente_email`, `cliente_cep`, `cliente_endereco`, `cliente_complemento`, `cliente_numero`, `cliente_uf`, `cliente_cidade`, `subtotal`, `frete`, `cupom_codigo`, `cupom`, `total`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(13, NULL, 'Cliente PSeletivo 001', 'cliente001@pseletivo.com.br', '40285-001', 'Avenida Dom João VI', 'de 2 a 99998 - lado par', '001', 'BA', 'BA', 444.000000, NULL, NULL, NULL, 444.000000, 'ENTREGUE', '2025-07-25 18:28:09', '2025-07-25 18:35:33', NULL),
	(14, 3, 'Cliente PSeletivo 002', 'cliente002@pseletivo.com.br', '94836-100', 'Rua Gonçalves Ledo', NULL, '001', 'RS', 'RS', 334.000000, NULL, 'GHY123KK', 30.000000, 304.000000, 'EM_ANDAMENTO', '2025-07-25 18:33:29', '2025-07-25 18:33:29', NULL),
	(15, NULL, 'Cliente PSeletivo 003', 'cliente003@pseletivo.com.br', '64760-970', 'Praça Honório Santos', '200', '003', 'PI', 'PI', 55.000000, 15.000000, NULL, NULL, 70.000000, 'CANCELADO', '2025-07-25 18:34:20', '2025-07-25 18:34:59', NULL),
	(16, 4, 'Cliente PSeletivo 004', 'cliente004@pseletivo.com.br', '51280-033', '3ª Travessa Rio Grande', NULL, '004', 'PE', 'PE', 139.000000, 15.000000, '80PJKG22', 15.000000, 139.000000, 'EM_ANDAMENTO', '2025-07-25 18:36:42', '2025-07-25 18:36:42', NULL);

-- Dumping structure for table pseletivo_montink.loja_pedidos_produtos
CREATE TABLE IF NOT EXISTS `loja_pedidos_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loja_pedidos_id` int(11) DEFAULT NULL,
  `loja_produtos_id` int(11) DEFAULT NULL,
  `loja_variacoes_id` int(11) DEFAULT NULL,
  `loja_estoques_id` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco_unitario` decimal(20,6) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `deleted_at` (`deleted_at`) USING BTREE,
  KEY `nome` (`nome`) USING BTREE,
  KEY `produtos_id` (`loja_produtos_id`) USING BTREE,
  KEY `loja_pedidos_id` (`loja_pedidos_id`),
  KEY `FK_loja_pedidos_produtos_loja_estoques` (`loja_estoques_id`),
  KEY `loja_variacao_id` (`loja_variacoes_id`) USING BTREE,
  CONSTRAINT `FK_loja_pedidos_produtos_loja_estoques` FOREIGN KEY (`loja_estoques_id`) REFERENCES `loja_estoques` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_loja_pedidos_produtos_loja_pedidos` FOREIGN KEY (`loja_pedidos_id`) REFERENCES `loja_pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_loja_pedidos_produtos_loja_produtos` FOREIGN KEY (`loja_produtos_id`) REFERENCES `loja_produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_loja_pedidos_produtos_loja_variacoes` FOREIGN KEY (`loja_variacoes_id`) REFERENCES `loja_variacoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pseletivo_montink.loja_pedidos_produtos: ~11 rows (approximately)
INSERT INTO `loja_pedidos_produtos` (`id`, `loja_pedidos_id`, `loja_produtos_id`, `loja_variacoes_id`, `loja_estoques_id`, `quantidade`, `preco_unitario`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(6, 13, 6, 10, 12, 1, 49.000000, 'Produto 001', '2025-07-25 18:28:09', '2025-07-25 18:28:09', NULL),
	(7, 13, 6, 11, 13, 2, 49.000000, 'Produto 001', '2025-07-25 18:28:09', '2025-07-25 18:28:09', NULL),
	(8, 13, 11, 18, 15, 3, 99.000000, 'Produto 006', '2025-07-25 18:28:09', '2025-07-25 18:28:09', NULL),
	(9, 14, 9, 15, 17, 2, 45.000000, 'Produto 004', '2025-07-25 18:33:29', '2025-07-25 18:33:29', NULL),
	(10, 14, 9, 28, 22, 1, 45.000000, 'Produto 004', '2025-07-25 18:33:29', '2025-07-25 18:33:29', NULL),
	(11, 14, 11, 19, 23, 1, 99.000000, 'Produto 006', '2025-07-25 18:33:29', '2025-07-25 18:33:29', NULL),
	(12, 14, 15, 24, 9, 1, 100.000000, 'Produto 010', '2025-07-25 18:33:29', '2025-07-25 18:33:29', NULL),
	(13, 15, 14, 22, 10, 1, 55.000000, 'Produto 009', '2025-07-25 18:34:20', '2025-07-25 18:34:20', NULL),
	(14, 16, 9, 28, 22, 1, 45.000000, 'Produto 004', '2025-07-25 18:36:42', '2025-07-25 18:36:42', NULL),
	(15, 16, 9, 15, 17, 1, 45.000000, 'Produto 004', '2025-07-25 18:36:42', '2025-07-25 18:36:42', NULL),
	(16, 16, 6, 11, 13, 1, 49.000000, 'Produto 001', '2025-07-25 18:36:42', '2025-07-25 18:36:42', NULL);

-- Dumping structure for table pseletivo_montink.loja_produtos
CREATE TABLE IF NOT EXISTS `loja_produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagem` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `preco` decimal(20,6) DEFAULT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deleted_at` (`deleted_at`),
  KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pseletivo_montink.loja_produtos: ~10 rows (approximately)
INSERT INTO `loja_produtos` (`id`, `imagem`, `nome`, `preco`, `descricao`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(6, 'produtos/fgJGwrzqN6dsziE9.jpg', 'Produto 001', 49.000000, 'descrição do produto 001', '2025-07-25 17:53:17', '2025-07-25 17:53:37', NULL),
	(7, 'produtos/aRWBi93bWRCKxIyQ.jpg', 'Produto 002', 49.000000, 'descrição do produto 002', '2025-07-25 17:54:21', '2025-07-25 17:54:21', NULL),
	(8, 'produtos/8bnOtg7v5hDdO0Cq.jpg', 'Produto 003', 49.000000, 'descrição do produto 003', '2025-07-25 17:54:44', '2025-07-25 17:54:44', NULL),
	(9, 'produtos/qqyLcu8VQdUeVhgS.jpg', 'Produto 004', 45.000000, 'descrição do produto 004', '2025-07-25 17:55:19', '2025-07-25 17:55:19', NULL),
	(10, 'produtos/KteZgMoXaUHBN1kp.jpg', 'Produto 005', 45.000000, 'descrição produto 005', '2025-07-25 17:55:47', '2025-07-25 17:55:47', NULL),
	(11, 'produtos/aVX6LKTSJLRdAR7C.jpg', 'Produto 006', 99.000000, 'descrição do produto 006', '2025-07-25 17:56:24', '2025-07-25 17:56:24', NULL),
	(12, 'produtos/cBzv7hhUKToMsZ9q.jpg', 'Produto 007', 55.000000, 'descrição produto 007', '2025-07-25 17:56:56', '2025-07-25 17:56:56', NULL),
	(13, 'produtos/uuYYXUhaNhO6WgNe.jpg', 'Produto 008', 55.000000, 'descrição do produto 008', '2025-07-25 17:57:35', '2025-07-25 17:57:35', NULL),
	(14, 'produtos/VCFsrGb8vA1JAEgc.jpg', 'Produto 009', 55.000000, 'descrição do produto 009', '2025-07-25 17:58:15', '2025-07-25 17:58:15', NULL),
	(15, 'produtos/j1JmFzTgGu56hSd1.jpg', 'Produto 010', 100.000000, 'descrição do produto 010', '2025-07-25 17:58:48', '2025-07-25 17:58:48', NULL);

-- Dumping structure for table pseletivo_montink.loja_variacoes
CREATE TABLE IF NOT EXISTS `loja_variacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loja_produtos_id` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `deleted_at` (`deleted_at`) USING BTREE,
  KEY `nome` (`nome`) USING BTREE,
  KEY `produtos_id` (`loja_produtos_id`) USING BTREE,
  CONSTRAINT `FK_loja_variacoes_loja_produtos` FOREIGN KEY (`loja_produtos_id`) REFERENCES `loja_produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pseletivo_montink.loja_variacoes: ~20 rows (approximately)
INSERT INTO `loja_variacoes` (`id`, `loja_produtos_id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(10, 6, 'P', '2025-07-25 17:59:33', '2025-07-25 17:59:33', NULL),
	(11, 6, 'M', '2025-07-25 17:59:46', '2025-07-25 18:00:00', NULL),
	(12, 7, 'G', '2025-07-25 18:00:08', '2025-07-25 18:00:08', NULL),
	(13, 8, 'P', '2025-07-25 18:00:19', '2025-07-25 18:00:19', NULL),
	(14, 8, 'M', '2025-07-25 18:00:28', '2025-07-25 18:00:28', NULL),
	(15, 9, 'G', '2025-07-25 18:00:37', '2025-07-25 18:00:37', NULL),
	(16, 10, 'M', '2025-07-25 18:00:47', '2025-07-25 18:00:47', NULL),
	(17, 10, 'G', '2025-07-25 18:00:57', '2025-07-25 18:00:57', NULL),
	(18, 11, 'P', '2025-07-25 18:01:06', '2025-07-25 18:01:06', NULL),
	(19, 11, 'M', '2025-07-25 18:01:13', '2025-07-25 18:01:13', NULL),
	(20, 11, 'G', '2025-07-25 18:01:21', '2025-07-25 18:01:21', NULL),
	(21, 13, 'P', '2025-07-25 18:01:52', '2025-07-25 18:01:52', NULL),
	(22, 14, 'M', '2025-07-25 18:02:18', '2025-07-25 18:02:18', NULL),
	(23, 14, 'G', '2025-07-25 18:02:27', '2025-07-25 18:02:27', NULL),
	(24, 15, 'P', '2025-07-25 18:02:38', '2025-07-25 18:02:38', NULL),
	(25, 7, 'G', '2025-07-25 18:06:21', '2025-07-25 18:06:32', '2025-07-25 18:06:32'),
	(26, 8, 'G', '2025-07-25 18:06:42', '2025-07-25 18:06:42', NULL),
	(27, 6, 'G', '2025-07-25 18:09:07', '2025-07-25 18:09:07', NULL),
	(28, 9, 'M', '2025-07-25 18:10:02', '2025-07-25 18:10:02', NULL),
	(29, 11, 'M', '2025-07-25 18:10:34', '2025-07-25 18:10:57', '2025-07-25 18:10:57');

-- Dumping structure for table pseletivo_montink.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.migrations: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.model_has_roles: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.oauth_access_tokens
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.oauth_access_tokens: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.oauth_auth_codes
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.oauth_auth_codes: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.oauth_clients
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` char(36) NOT NULL,
  `owner_type` varchar(255) DEFAULT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect_uris` text NOT NULL,
  `grant_types` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.oauth_clients: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.oauth_device_codes
CREATE TABLE IF NOT EXISTS `oauth_device_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `user_code` char(8) NOT NULL,
  `scopes` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  KEY `oauth_device_codes_user_id_index` (`user_id`),
  KEY `oauth_device_codes_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.oauth_device_codes: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.oauth_refresh_tokens
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` char(80) NOT NULL,
  `access_token_id` char(80) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.oauth_refresh_tokens: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.permissions: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) DEFAULT NULL COMMENT '// # MXTera -',
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL COMMENT '// # MXTera -',
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '// # MXTera -',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  UNIQUE KEY `hash` (`hash`),
  KEY `deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.roles: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.role_has_permissions: ~0 rows (approximately)

-- Dumping structure for table pseletivo_montink.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pseletivo_montink.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('SGkQMvqiCVN5w0dm86FPcI6pKn8tg3X8xXYm0GB0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV3Z4UTlnU1ZxVVJoQjZZbGd6RUVXSkNpU2I3V2pHb2lFcUE1SHN0ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHBzOi8vbGgucHJvamV0b3MvUHJvamV0b3MvdG9jYXdzL3BzZWxldGl2by1tb250aW5rL19naXQvcHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo4OiJjYXJyaW5obyI7YTo0OntzOjM5OiJsb2phX3Byb2R1dG9zX2lkXzZfbG9qYV92YXJpYWNvZXNfaWRfMTAiO2E6NDp7czoxNjoibG9qYV9lc3RvcXVlc19pZCI7czoyOiIxMiI7czoxNjoibG9qYV9wcm9kdXRvc19pZCI7czoxOiI2IjtzOjE3OiJsb2phX3ZhcmlhY29lc19pZCI7czoyOiIxMCI7czoxMDoicXVhbnRpZGFkZSI7aToyO31zOjM5OiJsb2phX3Byb2R1dG9zX2lkXzdfbG9qYV92YXJpYWNvZXNfaWRfMTIiO2E6NDp7czoxNjoibG9qYV9lc3RvcXVlc19pZCI7czoyOiIxOCI7czoxNjoibG9qYV9wcm9kdXRvc19pZCI7czoxOiI3IjtzOjE3OiJsb2phX3ZhcmlhY29lc19pZCI7czoyOiIxMiI7czoxMDoicXVhbnRpZGFkZSI7aToxO31zOjM5OiJsb2phX3Byb2R1dG9zX2lkXzhfbG9qYV92YXJpYWNvZXNfaWRfMTQiO2E6NDp7czoxNjoibG9qYV9lc3RvcXVlc19pZCI7czoyOiIxOSI7czoxNjoibG9qYV9wcm9kdXRvc19pZCI7czoxOiI4IjtzOjE3OiJsb2phX3ZhcmlhY29lc19pZCI7czoyOiIxNCI7czoxMDoicXVhbnRpZGFkZSI7aToxO31zOjQwOiJsb2phX3Byb2R1dG9zX2lkXzE0X2xvamFfdmFyaWFjb2VzX2lkXzIzIjthOjQ6e3M6MTY6ImxvamFfZXN0b3F1ZXNfaWQiO3M6MjoiMTEiO3M6MTY6ImxvamFfcHJvZHV0b3NfaWQiO3M6MjoiMTQiO3M6MTc6ImxvamFfdmFyaWFjb2VzX2lkIjtzOjI6IjIzIjtzOjEwOiJxdWFudGlkYWRlIjtpOjM7fX1zOjU6ImN1cG9tIjthOjQ6e3M6NjoiY29kaWdvIjtzOjg6IkdIWTEyM0tLIjtzOjEyOiJ2YWxvcl9taW5pbW8iO3M6NjoiMjEwLjAwIjtzOjg6ImRlc2NvbnRvIjtzOjU6IjMwLjAwIjtzOjg6InZhbGlkYWRlIjtzOjEwOiIyMDI1LTA4LTMxIjt9fQ==', 1753475397);

-- Dumping structure for table pseletivo_montink.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) DEFAULT NULL,
  `hash_files` varchar(255) DEFAULT NULL,
  `administradores_id` bigint(20) unsigned DEFAULT NULL,
  `contabilidades_id` bigint(20) unsigned DEFAULT NULL,
  `colaboradores_id` bigint(20) unsigned DEFAULT NULL,
  `clientes_id` bigint(20) unsigned DEFAULT NULL,
  `roles_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `apelido` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `login_deleted` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `users_id_created` bigint(20) unsigned DEFAULT NULL,
  `users_id_updated` bigint(20) unsigned DEFAULT NULL,
  `users_id_deleted` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`),
  UNIQUE KEY `hash_files` (`hash_files`),
  UNIQUE KEY `login` (`login`),
  KEY `deleted_at` (`deleted_at`),
  KEY `email` (`email`),
  KEY `email_verified_at` (`email_verified_at`),
  KEY `remember_token` (`remember_token`),
  KEY `name` (`name`),
  KEY `surname` (`surname`),
  KEY `login_password` (`login`,`password`),
  KEY `password` (`password`),
  KEY `roles_id` (`roles_id`),
  KEY `colaboradores_id` (`colaboradores_id`),
  KEY `clientes_id` (`clientes_id`),
  KEY `contabilidades_id` (`contabilidades_id`) USING BTREE,
  KEY `administradores_id` (`administradores_id`),
  KEY `users_id_created` (`users_id_created`),
  KEY `users_id_deleted` (`users_id_deleted`),
  KEY `users_id_updated` (`users_id_updated`),
  KEY `apelido` (`apelido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

