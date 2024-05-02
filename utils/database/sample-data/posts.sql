INSERT INTO
  `atlashardware`.`posts` (
    id,
    author,
    cover,
    title,
    date,
    description,
    rating,
    performance,
    specs
  )
VALUES
  (
    0xd38a9ad84bc14ca5b628759c98c47347,
    0x76b6254b6746435cb5f77fb7216e0d80,
    0x5e51e717193d4d878ceb7a9a3bca500f,
    'R5 3600 RTX 3090',
    '2024-01-02 15:12:54',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel quam convallis, tristique nulla eu, maximus eros. Vestibulum sed vestibulum risus, sit amet bibendum nisi. Morbi consectetur nisi odio, at convallis lectus auctor at. Nulla ultricies placerat massa, sed dapibus elit. Curabitur aliquam nisl nibh, et facilisis metus blandit nec. Vestibulum laoreet, mauris eu condimentum viverra, leo libero placerat elit, cursus rhoncus ante risus a nisl. Nam varius consequat arcu in maximus. Quisque facilisis ut sem non ornare. Vivamus faucibus, ipsum eget eleifend consequat, leo ipsum convallis elit, at scelerisque est urna quis dolor. Vestibulum laoreet dictum turpis sed egestas. Mauris tempus dui ut est pharetra pharetra. Sed vestibulum consectetur dolor, a eleifend est hendrerit eu.',
    9.8,
    981,
    '{"cpu":"Ryzen 5 3600","gpu":"Asus RTX 3090","motherboard":"MSI B450 Tomahawk Max","ram":"Corsair LPX 16 GB DDR4-3200","psu":"Corsair RM750x","storage":["Curcial P1 1TB NVMe SSD","Seagate Barracuda 2TB HDD"],"case":"Fractal Design Meshify C"}'
  );

INSERT INTO
  `atlashardware`.`post_images` (post, image, position)
VALUES
  (
    0xd38a9ad84bc14ca5b628759c98c47347,
    0x5e51e717193d4d878ceb7a9a3bca500f,
    0
  );

INSERT INTO
  `atlashardware`.`posts` (
    id,
    author,
    cover,
    title,
    date,
    description,
    rating,
    performance,
    specs
  )
VALUES
  (
    0xd51b9d95e6e6476cb5c9f86ff1e02770,
    0x76b6254b6746435cb5f77fb7216e0d80,
    0x0518ff737b084358ae4ffa043f0d1688,
    'i5 7600k RTX 4090 SUPER',
    '2024-01-03 16:24:00',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel quam convallis, tristique nulla eu, maximus eros. Vestibulum sed vestibulum risus, sit amet bibendum nisi. Morbi consectetur nisi odio, at convallis lectus auctor at. Nulla ultricies placerat massa, sed dapibus elit. Curabitur aliquam nisl nibh, et facilisis metus blandit nec. Vestibulum laoreet, mauris eu condimentum viverra, leo libero placerat elit, cursus rhoncus ante risus a nisl. Nam varius consequat arcu in maximus. Quisque facilisis ut sem non ornare. Vivamus faucibus, ipsum eget eleifend consequat, leo ipsum convallis elit, at scelerisque est urna quis dolor. Vestibulum laoreet dictum turpis sed egestas. Mauris tempus dui ut est pharetra pharetra. Sed vestibulum consectetur dolor, a eleifend est hendrerit eu.',
    4.5,
    542,
    '{"cpu":"Intel i5 7600k","gpu":"PNY RTX 4090 SUPER","motherboard":"MSI B450 Tomahawk Max","ram":"Corsair LPX 32 GB DDR5-6400","psu":"Corsair RM750x","storage":["Curcial P1 1TB NVMe SSD","Seagate Barracuda 2TB HDD"],"case":"Fractal Design Meshify C"}'
  );

INSERT INTO
  `atlashardware`.`post_images` (post, image, position)
VALUES
  (
    0xd51b9d95e6e6476cb5c9f86ff1e02770,
    0x0518ff737b084358ae4ffa043f0d1688,
    0
  );

INSERT INTO
  `atlashardware`.`users_saved_posts` (user, post)
VALUES
  (
    0x76b6254b6746435cb5f77fb7216e0d80,
    0xd51b9d95e6e6476cb5c9f86ff1e02770
  );

INSERT INTO
  `atlashardware`.`posts` (
    id,
    author,
    cover,
    title,
    date,
    description,
    rating,
    performance,
    specs
  )
VALUES
  (
    0x69fc1a864c2143e180ffe1f8387423aa,
    0x76b6254b6746435cb5f77fb7216e0d80,
    0x5a6e68b8750d45629cb5c57a67049395,
    'R7 5800x RTX 4070 Ti',
    '2023-12-31 01:39:52',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel quam convallis, tristique nulla eu, maximus eros. Vestibulum sed vestibulum risus, sit amet bibendum nisi. Morbi consectetur nisi odio, at convallis lectus auctor at. Nulla ultricies placerat massa, sed dapibus elit. Curabitur aliquam nisl nibh, et facilisis metus blandit nec. Vestibulum laoreet, mauris eu condimentum viverra, leo libero placerat elit, cursus rhoncus ante risus a nisl. Nam varius consequat arcu in maximus. Quisque facilisis ut sem non ornare. Vivamus faucibus, ipsum eget eleifend consequat, leo ipsum convallis elit, at scelerisque est urna quis dolor. Vestibulum laoreet dictum turpis sed egestas. Mauris tempus dui ut est pharetra pharetra. Sed vestibulum consectetur dolor, a eleifend est hendrerit eu.',
    6.9,
    999,
    '{"cpu":"R7 5800x","gpu":"PNY RTX 4070 Ti","motherboard":"MSI B450 Tomahawk Max","ram":"Corsair LPX 32 GB DDR5-6400","psu":"Corsair RM750x","storage":["Curcial P1 1TB NVMe SSD","Seagate Barracuda 2TB HDD"],"case":"Fractal Design Meshify C"}'
  );

INSERT INTO
  `atlashardware`.`post_images` (post, image, position)
VALUES
  (
    0x69fc1a864c2143e180ffe1f8387423aa,
    0x5a6e68b8750d45629cb5c57a67049395,
    0
  );

INSERT INTO
  `atlashardware`.`posts` (
    id,
    author,
    cover,
    title,
    date,
    description,
    rating,
    performance,
    specs
  )
VALUES
  (
    0x67e4738aff204740a28d2412077dcf51,
    0x76b6254b6746435cb5f77fb7216e0d80,
    0xec82c9be01b8423681a9a3c25d59403b,
    'R5 3600 GTX 1660 SUPER',
    '2024-02-01 14:37:19',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel quam convallis, tristique nulla eu, maximus eros. Vestibulum sed vestibulum risus, sit amet bibendum nisi. Morbi consectetur nisi odio, at convallis lectus auctor at. Nulla ultricies placerat massa, sed dapibus elit. Curabitur aliquam nisl nibh, et facilisis metus blandit nec. Vestibulum laoreet, mauris eu condimentum viverra, leo libero placerat elit, cursus rhoncus ante risus a nisl. Nam varius consequat arcu in maximus. Quisque facilisis ut sem non ornare. Vivamus faucibus, ipsum eget eleifend consequat, leo ipsum convallis elit, at scelerisque est urna quis dolor. Vestibulum laoreet dictum turpis sed egestas. Mauris tempus dui ut est pharetra pharetra. Sed vestibulum consectetur dolor, a eleifend est hendrerit eu.',
    1.2,
    687,
    '{"cpu":"Ryzen 5 3600","gpu":"Gigabyte GTX 1660 SUPER","motherboard":"MSI B450 Mortar Max","ram":"Corsair LPX Vengeance 16 GB DDR4-3200","psu":"Seasonic S12III 500W 80+ Bronze","storage":["Curcial 256GB 2.5 SSD","Seagate Barracuda 2TB HDD"],"case":"Cooler Master MasterBox Q300L"}'
  );

INSERT INTO
  `atlashardware`.`post_images` (post, image, position)
VALUES
  (
    0x67e4738aff204740a28d2412077dcf51,
    0xec82c9be01b8423681a9a3c25d59403b,
    0
  );

INSERT INTO
  `atlashardware`.`users_saved_posts` (user, post)
VALUES
  (
    0x76b6254b6746435cb5f77fb7216e0d80,
    0x67e4738aff204740a28d2412077dcf51
  );

INSERT INTO
  `atlashardware`.`posts` (
    id,
    author,
    cover,
    title,
    date,
    description,
    rating,
    performance,
    specs
  )
VALUES
  (
    0x191b22968fa7427684277b8dd105a798,
    0x76b6254b6746435cb5f77fb7216e0d80,
    0x8f8472a7a9504a8daaf4487a34f3a8a2,
    'i7 11700k RTX 3060 Ti',
    '2024-04-10 18:08:53',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel quam convallis, tristique nulla eu, maximus eros. Vestibulum sed vestibulum risus, sit amet bibendum nisi. Morbi consectetur nisi odio, at convallis lectus auctor at. Nulla ultricies placerat massa, sed dapibus elit. Curabitur aliquam nisl nibh, et facilisis metus blandit nec. Vestibulum laoreet, mauris eu condimentum viverra, leo libero placerat elit, cursus rhoncus ante risus a nisl. Nam varius consequat arcu in maximus. Quisque facilisis ut sem non ornare. Vivamus faucibus, ipsum eget eleifend consequat, leo ipsum convallis elit, at scelerisque est urna quis dolor. Vestibulum laoreet dictum turpis sed egestas. Mauris tempus dui ut est pharetra pharetra. Sed vestibulum consectetur dolor, a eleifend est hendrerit eu.',
    8.4,
    752,
    '{"cpu":"i7 11700k","gpu":"RTX 3060 Ti","motherboard":"MSI Z590-A PRO ATX LGA1200","ram":"Corsair Vengeance LPX 16GB (2 x 8GB) DDR4-3200 CL16 Memory","psu":"Corsair RMx (2018) 650 W 80+ Gold Certified Fully Modular ATX Power Supply","storage":["Samsung 970 Evo 1 TB M.2-2280 NVME Solid State Drive","Seagate Barracuda Compute 2 TB 3.5 7200RPM Internal Hard Drive"],"case":"NZXT H510 ATX Mid Tower Case"}'
  );

INSERT INTO
  `atlashardware`.`post_images` (post, image, position)
VALUES
  (
    0x191b22968fa7427684277b8dd105a798,
    0x8f8472a7a9504a8daaf4487a34f3a8a2,
    0
  );