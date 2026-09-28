-- Bare skeleton schema: just what the auth base (UserModel, Auth, AuthMiddleware) needs.

CREATE TABLE users (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email           VARCHAR(255) NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    name            VARCHAR(255) NOT NULL,
    plan            ENUM('FREE','PRO') NOT NULL DEFAULT 'FREE',
    role            ENUM('user','superuser') NOT NULL DEFAULT 'user', -- Easysite\Library\Auth::hasRole()
    created_at      DATETIME NOT NULL,
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

-- Remember-me: selector+hash of the token (not the token itself), survives closing
-- the browser, separate from the session. Rotated on every restore (Auth::restoreFromCookie).
CREATE TABLE user_remember_tokens (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    selector    VARCHAR(24) NOT NULL,
    token_hash  VARCHAR(64) NOT NULL,
    expires_at  DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY uq_remember_selector (selector)
) ENGINE=InnoDB;
