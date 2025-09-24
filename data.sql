-- Đã chuyển đổi để phù hợp với SQLite

-- Bỏ các lệnh không tương thích với SQLite
-- Bỏ ENGINE, COLLATE, AUTO_INCREMENT, UNSIGNED, ALTER TABLE, FOREIGN KEY, SET, START TRANSACTION, COMMIT, v.v.

-- Cấu trúc bảng cho bảng `bank_accounts`
CREATE TABLE bank_accounts (
  id INTEGER PRIMARY KEY,
  bank_name TEXT NOT NULL,
  account_name TEXT NOT NULL,
  account_number TEXT NOT NULL,
  branch TEXT,
  note TEXT,
  is_active INTEGER NOT NULL DEFAULT 0,
  auto_confirm INTEGER NOT NULL DEFAULT 0,
  prefix TEXT NOT NULL DEFAULT 'naptien',
  access_token TEXT,
  created_at TEXT,
  updated_at TEXT
);

-- Cấu trúc bảng cho bảng `configs`
CREATE TABLE configs (
  id INTEGER PRIMARY KEY,
  key TEXT NOT NULL UNIQUE,
  value TEXT,
  created_at TEXT,
  updated_at TEXT
);

-- Đang đổ dữ liệu cho bảng `configs`
INSERT INTO configs (id, key, value, created_at, updated_at) VALUES
(1, 'site_name', 'Neil Dev', '2025-09-24 11:45:24', '2025-09-24 12:02:05'),
(2, 'site_description', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '2025-09-24 11:45:24', '2025-09-24 15:58:45'),
(3, 'site_keywords', 'neil pubg', '2025-09-24 11:45:24', '2025-09-24 12:02:05'),
(4, 'site_logo', '/storage/config/1758698143_d63b0182e8702b85149872c712389a2b.webp', '2025-09-24 11:45:24', '2025-09-24 14:15:43'),
(5, 'site_logo_footer', '/storage/config/1758698143_d63b0182e8702b85149872c712389a2b.webp', '2025-09-24 11:45:24', '2025-09-24 14:15:43'),
(6, 'site_share_image', '/storage/config/1758698143_9e14b884ef35832afd515b2c93a6e977.webp', '2025-09-24 11:45:24', '2025-09-24 14:15:43'),
(7, 'site_banner', '/storage/config/1758698143_9e14b884ef35832afd515b2c93a6e977.webp', '2025-09-24 11:45:24', '2025-09-24 14:15:43'),
(8, 'site_favicon', '/storage/config/1758692117_5871b41907a152ae08cbe990ce82f70c.png', '2025-09-24 11:45:24', '2025-09-24 12:35:17'),
(9, 'address', 'Hồ Chí Minh', '2025-09-24 11:45:24', '2025-09-24 12:02:05'),
(10, 'phone', '0392829827', '2025-09-24 11:45:24', '2025-09-24 12:02:05'),
(11, 'email', 'admin@taphoaneil.com', '2025-09-24 11:45:24', '2025-09-24 12:02:05'),
(12, 'facebook', 'https://fb.com/taphoaneil', '2025-09-24 11:45:24', '2025-09-24 15:58:45'),
(13, 'zalo', '0812665001', '2025-09-24 11:45:24', '2025-09-24 11:45:24'),
(45, 'contact_admin_url', 'https://m.me/taphoaneil', '2025-09-24 12:33:46', '2025-09-24 15:58:45');

-- Cấu trúc bảng cho bảng `game_accounts`
CREATE TABLE game_accounts (
  id INTEGER PRIMARY KEY,
  account_name TEXT NOT NULL,
  password TEXT NOT NULL,
  price REAL NOT NULL,
  status TEXT NOT NULL DEFAULT 'available',
  server INTEGER NOT NULL DEFAULT 1,
  registration_type TEXT NOT NULL DEFAULT 'virtual',
  planet TEXT NOT NULL DEFAULT 'earth',
  earring INTEGER NOT NULL DEFAULT 0,
  note TEXT,
  thumb TEXT,
  images TEXT,
  buyer_id INTEGER,
  created_at TEXT,
  updated_at TEXT
);

-- Đang đổ dữ liệu cho bảng `game_accounts`
INSERT INTO game_accounts (id, account_name, password, price, status, server, registration_type, planet, earring, note, thumb, images, buyer_id, created_at, updated_at) VALUES
(1, 'acc_grUsWJyh', 'SLNFThsF7Z', 1200000.00, 'available', 1, 'virtual', 'earth', 0, 'Gmail', '/storage/accounts/thumbnails/1758691378_f2ffe71337a14db8902250d627f333ac.jpg', NULL, NULL, '2025-09-24 12:22:58', '2025-09-24 12:22:58'),
(2, 'acc_bkOzcQxi', 'E8b9TnQhLj', 10000.00, 'available', 1, 'virtual', 'namek', 0, 'Mail Xanh', '/storage/accounts/thumbnails/1758698329_583a94bf9d35ac302f501228c927d04c.jpg', NULL, NULL, '2025-09-24 14:18:49', '2025-09-24 14:18:49');

-- Cấu trúc bảng cho bảng `game_services`
CREATE TABLE game_services (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL,
  slug TEXT NOT NULL UNIQUE,
  thumbnail TEXT NOT NULL,
  description TEXT,
  type TEXT NOT NULL,
  active INTEGER NOT NULL DEFAULT 1,
  created_at TEXT,
  updated_at TEXT
);

-- Đang đổ dữ liệu cho bảng `game_services`
INSERT INTO game_services (id, name, slug, thumbnail, description, type, active, created_at, updated_at) VALUES
(5, 'Cày Thuê', 'cay-thue', '', '', 'leveling', 1, '2025-09-24 11:50:58', '2025-09-24 11:50:58'),
(6, 'Cho Thuê', 'cho-thue', '', '', 'leveling', 1, '2025-09-24 11:54:46', '2025-09-24 11:54:46'),
(7, 'Nạp Identity', 'nap-identity', '', '', 'leveling', 1, '2025-09-24 11:54:47', '2025-09-24 11:54:47');

-- Cấu trúc bảng cho bảng `migrations`
CREATE TABLE migrations (
  id INTEGER PRIMARY KEY,
  migration TEXT NOT NULL,
  batch INTEGER NOT NULL
);

-- Đang đổ dữ liệu cho bảng `migrations`
INSERT INTO migrations (id, migration, batch) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_03_28_181908_create_users_table', 1),
(3, '2025_03_28_181914_create_game_categories_table', 1),
(4, '2025_03_28_181917_create_game_accounts_table', 1),
(5, '2025_03_28_181929_create_purchase_history_table', 1),
(6, '2025_03_28_181932_create_money_transactions_table', 1),
(7, '2025_03_29_015110_create_card_deposits_table', 1),
(8, '2025_03_29_154334_create_game_services_table', 1),
(9, '2025_03_29_154343_create_service_packages_table', 1),
(10, '2025_03_29_154350_create_service_histories_table', 1),
(11, '2025_03_30_231218_create_configs_table', 1),
(12, '2025_03_31_050014_create_bank_deposits_table', 1),
(13, '2025_03_31_065843_create_bank_accounts_table', 1),
(14, '2025_04_01_031303_create_random_categories_table', 1),
(15, '2025_04_01_031307_create_random_category_accounts_table', 1),
(16, '2025_04_01_035918_create_discount_codes_table', 1),
(17, '2025_04_01_040223_create_discount_code_usages_table', 1),
(18, '2025_04_02_060346_create_lucky_wheels_table', 1),
(19, '2025_04_02_060438_create_lucky_wheel_histories_table', 1),
(20, '2025_04_02_060504_create_withdrawal_histories_table', 1),
(21, '2025_04_04_043941_create_money_withdrawal_histories_table', 1),
(22, '2025_04_05_101214_create_notifications_table', 1),
(23, '2025_04_07_022109_create_password_reset_tokens_table', 1),
(24, '2025_09_24_120512_create_bank_accounts_table', 2),
(25, '2025_09_24_122132_recreate_game_accounts_table_without_category', 3),
(26, '2025_09_24_122242_drop_game_categories_table', 4),
(27, '2025_09_24_122741_drop_service_packages_table', 5),
(28, '2025_09_24_122810_recreate_service_histories_table_without_package', 6);

-- Cấu trúc bảng cho bảng `notifications`
CREATE TABLE notifications (
  id INTEGER PRIMARY KEY,
  class_favicon TEXT NOT NULL,
  content TEXT NOT NULL,
  created_at TEXT,
  updated_at TEXT
);

-- Cấu trúc bảng cho bảng `password_reset_tokens`
CREATE TABLE password_reset_tokens (
  email TEXT PRIMARY KEY,
  token TEXT NOT NULL,
  created_at TEXT
);

-- Cấu trúc bảng cho bảng `personal_access_tokens`
CREATE TABLE personal_access_tokens (
  id INTEGER PRIMARY KEY,
  tokenable_type TEXT NOT NULL,
  tokenable_id INTEGER NOT NULL,
  name TEXT NOT NULL,
  token TEXT NOT NULL UNIQUE,
  abilities TEXT,
  last_used_at TEXT,
  expires_at TEXT,
  created_at TEXT,
  updated_at TEXT
);

-- Cấu trúc bảng cho bảng `service_histories`
CREATE TABLE service_histories (
  id INTEGER PRIMARY KEY,
  user_id INTEGER NOT NULL,
  game_service_id INTEGER NOT NULL,
  game_account TEXT NOT NULL,
  game_password TEXT NOT NULL,
  server INTEGER NOT NULL,
  amount INTEGER,
  price REAL NOT NULL,
  discount_code TEXT,
  discount_amount REAL,
  status TEXT NOT NULL DEFAULT 'pending',
  admin_note TEXT,
  note TEXT,
  completed_at TEXT,
  created_at TEXT,
  updated_at TEXT
);

-- Cấu trúc bảng cho bảng `users`
CREATE TABLE users (
  id INTEGER PRIMARY KEY,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  google_id TEXT,
  facebook_id TEXT,
  role TEXT NOT NULL DEFAULT 'member',
  balance INTEGER NOT NULL DEFAULT 0,
  total_deposited INTEGER NOT NULL DEFAULT 0,
  gold INTEGER NOT NULL DEFAULT 0,
  gem INTEGER NOT NULL DEFAULT 0,
  banned INTEGER NOT NULL DEFAULT 0,
  ip_address TEXT,
  remember_token TEXT,
  email_verified_at TEXT,
  created_at TEXT,
  updated_at TEXT
);

-- Đang đổ dữ liệu cho bảng `users`
INSERT INTO users (id, username, password, email, google_id, facebook_id, role, balance, total_deposited, gold, gem, banned, ip_address, remember_token, email_verified_at, created_at, updated_at) VALUES
(4, 'admin', '$2y$12$iwR9XHnhswuaEOB13LC0Yukk5R.ZFREvmtXRKFmLWIA.0xNrtwq7W', 'admin@admin.com', NULL, NULL, 'admin', 0, 0, 0, 0, 0, NULL, 'TJBUmhG8HZlzjl10nUXaFzHdOG9GN6fEWfXZtEnJRScBzy6s3mTMWGN9rjRS', '2025-09-24 11:50:34', '2025-09-24 11:50:34', '2025-09-24 11:50:34');
