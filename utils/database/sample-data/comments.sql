
CREATE TABLE IF NOT EXISTS `comments` (
  `id` binary(16) NOT NULL,
  `author` binary(16) NOT NULL,
  `post` binary(16) NOT NULL,
  `replied_to` binary(16) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `post` (`post`),
  KEY `replied_to` (`replied_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `comments` (`id`, `author`, `post`, `replied_to`, `date`, `comment`) VALUES
(0x1785308940df48c7a132226edfdf9c9e, 0x77987f2e507e4544b8b5b78c7c648466, 0x608e7ae3776e4545b16c0afdb8517992, NULL, '2024-05-03 17:32:09', 'This build looks like a solid investment for both gaming and productivity. It\'s great to see a setup that can handle heavy workloads as well as it can handle gaming sessions.'),
(0x1c237ffc817440fb8f8a9aaff021415d, 0x77987f2e507e4544b8b5b78c7c648466, 0x191b22968fa7427684277b8dd105a798, NULL, '2024-05-03 17:19:09', 'Wow, that GPU choice is spot on! I\'ve been eyeing it for my build too. How\'s the performance so far?'),
(0x83c13c067e8544249fe522e63a1c8f7a, 0x77987f2e507e4544b8b5b78c7c648466, 0x608e7ae3776e4545b16c0afdb8517992, NULL, '2024-05-03 17:32:24', 'I\'m considering a similar build myself. How did you decide on the specific brands and models for each component?'),
(0x8f289d24f56a49ea96dd7c22c417faed, 0x77987f2e507e4544b8b5b78c7c648466, 0x191b22968fa7427684277b8dd105a798, NULL, '2024-05-03 17:19:21', 'Impressive build! Are you planning any future upgrades or is this your dream rig?'),
(0xb4a05c4dca344d23bcb123229cdc01f4, 0x77987f2e507e4544b8b5b78c7c648466, 0x312cd9e3b5da4eb0bc4ad181cfa2e8fd, NULL, '2024-05-03 17:27:57', 'Great choice on the power supply! It\'s always worth investing in a reliable one for stability.'),
(0xf5cd9f1d56a3470eb04d1fa6c3de090c, 0x77987f2e507e4544b8b5b78c7c648466, 0x67e4738aff204740a28d2412077dcf51, NULL, '2024-05-03 17:19:36', 'Solid choice on the motherboard! Did you find it easy to work with when assembling everything?'),
(0xfb14562d360348fe8be25be908a42775, 0x77987f2e507e4544b8b5b78c7c648466, 0xd51b9d95e6e6476cb5c9f86ff1e02770, NULL, '2024-05-03 17:19:57', 'Nice RAM choice! Have you overclocked it yet, or are you keeping it at stock speeds?');
