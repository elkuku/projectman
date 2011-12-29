CREATE TABLE #__projects (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  path TEXT,
  url TEXT,
  excludes TEXT
);

CREATE TABLE #__projects_items (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  project_id INTEGER,
  folder TEXT,
  vcs TEXT,
  branches TEXT,
  status TEXT,
  isjoomla INTEGER
);
