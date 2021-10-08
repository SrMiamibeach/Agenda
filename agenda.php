<!DOCTYPE html>
<html>

<head>
    <title>Agenda</title>
</head>

<body>
    <?php
    class agenda
    {
        private $agenda = array();

        public function añadirContacto($nombre, $email)
        {
            if (!$this->keyExist($nombre)) {
                $this->agenda[$nombre] = $email;
            } 
        }
        private function keyExist($nombre)
        {
            $keys = array_keys($this->agenda);
            foreach ($keys as $key) {
                if (strtolower($key) == strtolower($nombre)) {
                    return true;
                }
            }
            return false;
        }
        public function a(){
            return $this->agenda;
        }
    }
    ?>
    <?php
    $obj = new agenda();
    $obj->añadirContacto('Aaron', 'aaron@gmail.com');
    $obj->añadirContacto('Maida', 'maida@gmail.com');
    $obj->añadirContacto('maida', 'maida@gmail.com');
    $obj->añadirContacto('AARóN', 'maida@gmail.com');
    print_r($obj->a());
    ?>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" />
        <label>Email</label>
        <input type="email" name="email" />
        <input type="submit" />
    </form>
</body>

</html>