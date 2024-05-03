
CREATE TABLE IF NOT EXISTS `post_images` (
  `post` binary(16) NOT NULL,
  `image` binary(16) NOT NULL,
  `position` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`post`,`image`,`position`),
  KEY `image` (`image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `post_images` (`post`, `image`, `position`) VALUES
(0xd51b9d95e6e6476cb5c9f86ff1e02770, 0x0518ff737b084358ae4ffa043f0d1688, 0),
(0x69fc1a864c2143e180ffe1f8387423aa, 0x5a6e68b8750d45629cb5c57a67049395, 0),
(0xd38a9ad84bc14ca5b628759c98c47347, 0x5e51e717193d4d878ceb7a9a3bca500f, 0),
(0x191b22968fa7427684277b8dd105a798, 0x8f8472a7a9504a8daaf4487a34f3a8a2, 0),
(0x312cd9e3b5da4eb0bc4ad181cfa2e8fd, 0x9d3eda6045834dfdb56471df7c7819f6, 0),
(0x608e7ae3776e4545b16c0afdb8517992, 0xe8d0c7ba89064e6bab6a290d9bed098a, 0),
(0x67e4738aff204740a28d2412077dcf51, 0xec82c9be01b8423681a9a3c25d59403b, 0);
