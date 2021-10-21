<!DOCTYPE html>
<html>

<head>
    <title>Agenda</title>
</head>

<body>

    <?php
    class agenda1
    {
        private $agenda;
        public function __construct($array = null)
        {
            if ($array == null) {
                $this->agenda = array();
            } else {
                $this->agenda = json_decode($_POST['array'], true);
            }
        }
        // Añadir un contacto nuevo a la agenda
        public function addContact($nombre, $email)
        {
            $keyExit = $this->keyExist($nombre);
            $checkEmail = $this->checkEmail($email);
            if (!$keyExit && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return 'Añadido correctamente';
            } else if ($keyExit && $checkEmail) {
                $this->agenda[$nombre] = $email;
                return 'Se a actualizado el correo';
            } else if (!$checkEmail) {
                return 'El correo no tiene un formato correcto';
            } else {
                return 'Todo mal';
            }
        }
        // comprobar si un nombre existe
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
        // Comprovar el email con funciones de php
        private function checkEmail($email)
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }
        // Comprobar el email pero con expresiones regulares
        // private function checkEmail($email) {
        //     $regex = '/[a-zA-Z0-9_\-\.\+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
        //     return (bool)preg_match($regex, $email);
        // }

        // Elimina de la agenda contacto que le introducimos
        public function deleteContact($name)
        {
            if ($this->keyExist($name)) {
                unset($this->agenda[$name]);
            }
        }
        // Pasamos el array a string para despues poder postearlo en el input 
        public function setAgenda()
        {
            $string = json_encode($this->agenda);
            return $string;
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
    $result = '';
    if (!isset($_POST['array'])) {
        $obj = new agenda1();
    } else {
        $obj = new agenda1($_POST['array']);
        if (empty($_POST['nombre'])) {
            $result = '<h4 style=color:red;>El nombre esta vacio</h4>';
        } else {
            $name = htmlentities($_POST['nombre']);
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $result = $obj->addContact($name, $email);
                $result =  '<h4>' . $result . '</h4>';
            } else {
                $obj->deleteContact($name);
                $result = '<h4>Contacto eliminado</h4>';
            }
        }
    }
    ?>
    <?php
        $user = "";
        if(isset($_POST['username'])){
            $user = htmlentities($_POST['username']);
        }else{
            $user = $_POST['user'];
        }
    ?>
    <h1>Esta es la agenda de <?php echo $user ;?></h1>
    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value=<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?> ><br>
        <label>Email:</label><br>
        <input type="email" name="email" value=<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?> ><br>
        <input type="submit" />
        <input type="hidden" name="array" value=<?php echo $obj->setAgenda(); ?> />
        <input type="hidden" name="user" value=<?php echo $user ;?> />
    </form>
    <?php
    echo $result;
    $obj->seeArray();

    ?>
</body>

</html>