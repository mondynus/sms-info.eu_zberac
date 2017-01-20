$conn = new PDO(
    'mysql:host=host',
    'meno',
    'heslo', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
