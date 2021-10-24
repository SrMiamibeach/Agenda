<!DOCTYPE html>
<html>

<head>
    <title>Agenda</title>
</head>

<body>
    <?php
    class agenda3
    {
        private $agenda = array();
        public function __construct($session = null)
        {
            if ($session == null) {
                $this->agenda = array();
                $_SESSION['agenda'] = json_encode($this->agenda);
            } else {
                $this->agenda = $session;
            }
        }
        // Añadir un contacto nuevo a la agenda
        public function addContact($nombre, $email)
        {
            $keyExit = $this->keyExist($nombre);
            $checkEmail = $this->checkEmail($email);
            if ($keyExit == null && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return '<h4>Añadido correctamente</h4>';
            } else if ($keyExit != null && $checkEmail) {
                $this->agenda[$keyExit] = $email;
                return '<h4>Se a actualizado el correo</h4>';
            } else if (!$checkEmail) {
                return '<h4>El correo no tiene un formato correcto</h4>';
            } else {
                return '<h4>Todo mal</h4>';
            }
        }
        // comprobar si un nombre existe
        private function keyExist($nombre)
        {
            $keys = array_keys($this->agenda);
            foreach ($keys as $key) {
                if (strtolower($key) == strtolower($nombre)) {
                    return $key;
                }
            }
            return null;
        }
        // Compruebar el email con funciones de php
        private function checkEmail($email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }
        // Compruebar el email pero con expresiones regulares
        // private function checkEmail($email) {
        //     $regex = '/[a-zA-Z0-9_\-\.\+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
        //     return (bool)preg_match($regex, $email);
        // }

        // Elimina de la agenda el contacto que le introducimos
        public function deleteContact($name)
        {
            if ($this->keyExist($name)) {
                unset($this->agenda[$name]);
                return '<h4>Contacto eliminado</h4>';
            }
            return '<h4>No existe ese contacto</h4>';
        }
        public function setAgenda()
        {
            $_SESSION['agenda'] = json_encode($this->agenda);
        }
        public function seeArray()
        {
            $string = '<table><tr><td style=font-weight:bold;>Nombre</td><td style=font-weight:bold;>Correo</td></tr>';
            foreach ($this->agenda as $key => $value) {
                $string .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
            $string .= '</table>';
            echo $string;
        }
    }
    ?>
    <?php
    session_start();
    $result = '';
    if(!isset($_SESSION['agenda'])){
        $obj = new agenda3();
    }else{
        $obj = new agenda3(json_decode($_SESSION['agenda'], true));
        if (empty($_POST['nombre'])) {
            $result = '<h4 style=color:red;>El nombre esta vacio</h4>';
        } else {
            $name = htmlentities($_POST['nombre']);
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $result = $obj->addContact($name, $email);
                $result =  '<h4>' . $result . '</h4>';
            } else {
                $result = $obj->deleteContact($name);;
            }
        }
    }
    $obj->setAgenda();
    ?>

    <?php
    $user = "";
    if (!isset($_SESSION['username'])) {
        $_SESSION['username'] = htmlentities($_POST['username']);
        $user = htmlentities($_POST['username']);
    } else {
        $user = $_SESSION['username'];
    }
    ?>
    <h1>Esta es la agenda de <?php echo $user; ?></h1>
    <form method="POST">
    <label>Nombre:</label><br>
        <input type="text" name="nombre" placeholder=<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?> ><br>
        <label>Email:</label><br>
        <input type="email" name="email" placeholder=<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?> ><br>
        <input type="submit" name="submit" />
    </form>
    <?php
    if(isset($_POST['submit'])){
        echo $result;
    }
    $obj->seeArray();

    ?>
</body>

</html>