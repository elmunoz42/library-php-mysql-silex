| Field     | Type                | Null | Key | Default | Extra          |
|-----------|---------------------|------|-----|---------|----------------|
| id        | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| book_id   | int(11)             | YES  |     | NULL    |                |
| available | tinyint(1)          | YES  |     | NULL    |                |



OrderDate datetime NOT NULL DEFAULT NOW(),

| Field         | Type                | Null | Key | Default | Extra          |
|-----------|---------------------|------|-----|---------|----------------|
| id            | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| patron_id     | int(11)             | YES  |     | NULL    |                |
| copy_id       | int(11)             | YES  |     | NULL    |                |
| checkout_date | datetime            | YES  |     | NULL    |                |
| checkin_date  | datetime            | YES  |     | NULL    |                |
