DROP TABLE IF EXISTS "User";
CREATE TABLE User (
  id INTEGER PRIMARY KEY,
  akronym TEXT KEY,
  name TEXT,
  email TEXT,
  password TEXT,
  created DATETIME default (datetime('now'))
);
