<!DOCTYPE html>
<html>

<head>
    <title>Agenda</title>
</head>

<body>
    <?php
    class agenda2
    {
        private $agenda = array();

        public function __construct()
        {
            if(!isset($_COOKIE['agenda'])){
                $this->agenda = array();
                setcookie('agenda', json_encode($this->agenda), 0);
            }else
            {
                $this->agenda = json_decode($_COOKIE['cumples'], true);
            }
        }

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
    $obj = new agenda2();
    $obj->añadirContacto('Aaron', 'aaron@gmail.com');
    $obj->añadirContacto('Maida', 'maida@gmail.com');
    $obj->añadirContacto('maida', 'maida@gmail.com');
    $obj->añadirContacto('AARóN', 'maida@gmail.com');
    if (!isset($_POST['nombre']) && empty($_POST['nombre'])) {
        echo '<h4 style=color:red;>El nombre esta vacio</h4>';
    } else {
        $name = $_POST['nombre'];
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $email = $_POST['email'];
            $obj->añadirContacto($name, $email);
            echo '<h4>Correo valido</h4>';
        } else {
            echo '<h4>Correo no valido</h4>';
        }
    }
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