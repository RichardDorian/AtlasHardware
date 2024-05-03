
CREATE TABLE IF NOT EXISTS `users` (
  `id` binary(16) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `avatar` binary(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `avatar` (`avatar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `username`, `password`, `avatar`) VALUES
(0x76b6254b6746435cb5f77fb7216e0d80, 'RichardDorian', '$2y$10$9DKuaMY8HYkSVWi8mYCOXeJKZn663myibHykBXEVIGnLG8/mP3L5y', NULL),
(0x77987f2e507e4544b8b5b78c7c648466, 'BR-Théo', '$2y$10$PjDiADfSG/IeTyqWqgddEe8SWtgQ.hLmCbn5FJj6HekIvW4dHdjGa', NULL),
(0x9a8d8a56afbb4072bb9a925ed3b62770, 'VerrierePaulin', '$2y$10$9DKuaMY8HYkSVWi8mYCOXeJKZn663myibHykBXEVIGnLG8/mP3L5y', NULL);
