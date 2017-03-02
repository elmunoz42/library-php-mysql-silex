##copies
| Field     | Type                | Null | Key | Default | Extra          |
|-----------|---------------------|------|-----|---------|----------------|
| id        | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| book_id   | int(11)             | YES  |     | NULL    |                |
| available | tinyint(1)          | YES  |     | NULL    |                |


##patrons_copies
| Field         | Type                | Null | Key | Default | Extra          |
|-----------|---------------------|------|-----|---------|----------------|
| id            | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| patron_id     | int(11)             | YES  |     | NULL    |                |
| copy_id       | int(11)             | YES  |     | NULL    |                |
| checkout_date | datetime            | YES  |     | NULL    |                |
| checkin_date  | datetime            | YES  |     | NULL    |                |

##books
| Field | Type                | Null | Key | Default | Extra          |
|-----------|---------------------|------|-----|---------|----------------|
| id    | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| title | varchar(255)        | YES  |     | NULL    |                |
