<!DOCTYPE html>
<html>

<head>
    <title>Agenda</title>
</head>

<body>
    <?php
    class agenda2
    {
        private $agenda;

        public function __construct($cookie = null)
        {
            if ($cookie == null) {
                $this->agenda = array();
                setcookie('agenda', json_encode($this->agenda), 0);
            } else {
                $this->agenda = $cookie;
            }
        }
        // Añadir un contacto nuevo a la agenda o editar el contacto
        public function addContact($nombre, $email)
        {
            $keyExit = $this->keyExist($nombre);
            $checkEmail = $this->checkEmail($email);
            if ($keyExit == null && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return '<h4 style=color:green;>Añadido correctamente</h4>';
            } else if ($keyExit != null && $checkEmail) {
                $this->agenda[$keyExit] = $email;
                return '<h4 style=color:green;>Se a actualizado el correo</h4>';
            } else if (!$checkEmail) {
                return '<h4 style=color:red;>El correo no tiene un formato correcto</h4>';
            } else {
                return '<h4 style=color:red;>Todo mal</h4>';
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
        // comprueba el email con funciones de php
        private function checkEmail($email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }
        // Comprueba el email pero con expresiones regulares
        // private function checkEmail($email) {
        //     $regex = '/[a-zA-Z0-9_\-\.\+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
        //     return (bool)preg_match($regex, $email);
        // }

        // Elimina de la agenda el contacto que le introducimos
        public function deleteContact($name)
        {
            if ($this->keyExist($name)) {
                unset($this->agenda[$name]);
                return '<h4 style=color:green;>Contacto eliminado</h4>';
            }
            return '<h4 style=color:red;>No existe ese contacto</h4>';
        }
        // Pasamos el array a string para añadirlo a una cookie
        public function setAgenda()
        {
            setcookie('agenda', json_encode($this->agenda), 0);
        }
        // metodo para ver el array
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
    $result = '';
    if (!isset($_COOKIE['agenda'])) {
        $obj = new agenda2();
    } else {
        $obj = new agenda2(json_decode($_COOKIE['agenda'], true));
        if (empty($_POST['nombre'])) {
            $result = '<h4 style=color:red;>El nombre esta vacio</h4>';
        } else {
            $name = htmlentities($_POST['nombre']);
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $result = $obj->addContact($name, $email);
            } else {
                $result = $obj->deleteContact($name);;
            }
        }
    }
    $obj->setAgenda();
    ?>

    <?php
    // guardamos el nombre que introduce el usuario
    $user = "";
    if (!isset($_COOKIE['username'])) {
        setcookie('username', htmlentities($_POST['username']));
        $user = htmlentities($_POST['username']);
    } else {
        $user = $_COOKIE['username'];
    }
    ?>
    <h1>Esta es la agenda de <?php echo $user; ?></h1>
    <div id="userform">
    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" placeholder=<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>><br>
        <label>Email:</label><br>
        <input type="email" name="email" placeholder=<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>><br>
        <input type="submit" name="submit" />
    </form>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        echo $result;
    }
    $obj->seeArray();

    ?>
</body>

</html>