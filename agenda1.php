<!DOCTYPE html>
<html>

<head>
    <title>Agenda</title>
</head>

<body>
    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" /><br>
        <label>Email:</label><br>
        <input type="email" name="email" /><br>
        <input type="submit" />
        <!--<input type="hidden" name="array" value=<?php $array ?> />-->
    </form>
    <?php
    class agenda1
    {
        private $agenda;
        public function __construct($array = null)
        {
            if ($array == null) {
                $this->agenda = array();
            } else {
                $this->agenda = json_decode($_POST['array']);
            }
        }

        public function añadirContacto($nombre, $email)
        {
            if (!$this->keyExist($nombre, $this->agenda)) {
                $agenda[$nombre] = $email;
            }
            print_r($agenda);
        }
        private function keyExist($nombre, $agenda)
        {

            $keys = array_keys($agenda);
            foreach ($keys as $key) {
                if (strtolower($key) == strtolower($nombre)) {
                    return true;
                }
            }
            return false;
        }
        public function setAgenda()
        {
            $string = json_encode($this->agenda);
            echo '<input type="hidden" name="array" value='. $string.' />';
        }
    }
    ?>

    <?php
    /*añadirContacto('Aaron', 'aaron@gmail.com');
    añadirContacto('Maida', 'maida@gmail.com');
    añadirContacto('maida', 'maida@gmail.com');
    añadirContacto('AARóN', 'maida@gmail.com');*/
    if(!isset($_POST['array'])){
        $obj = new agenda1();
    }else{
        $obj = new agenda1($_POST['array']);
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
    }
    $obj->setAgenda();
    
    
    ?>
</body>

</html>