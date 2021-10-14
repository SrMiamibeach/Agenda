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
        <input type="hidden" name="array" />
    </form>
    <?php
    function añadirContacto($nombre, $email)
    {
        $agenda = $_POST['array'];
        global $agenda;
        if($agenda== null){
            $agenda = array();
            echo 'a';
        }
        print_r($agenda);
        
            if (!keyExist($nombre, $agenda)) {
                $agenda[$nombre] = $email;
            }
            print_r($agenda);

    }
    function keyExist($nombre, $agenda)
    {

        $keys = array_keys($agenda);
        foreach ($keys as $key) {
            if (strtolower($key) == strtolower($nombre)) {
                return true;
            }
        }
        return false;
    }
    // function getArray(){
    //     $agenda= array();
    //     if(!isset($_POST['array'])){
    //         echo '<input type=hidden name=array value='.json_encode($agenda).'/>';
    //     }else{
    //         $agenda = $_POST['array'];
    //         print_r($agenda);
    //     }
    //     return $agenda;
    // }
    // function getAgenda()
    // {
    //    global $agenda;
    //    if(isset($_POST['array'])){
    //     $agenda = $_POST['array'];
    //     echo 'A';
    //    }


    // }
    // function setAgenda()
    // {
    //     global $agenda;
    //     echo '<input type=hidden name=array value='.json_encode($agenda).'/>';

    // }
    ?>

    <?php
    /*añadirContacto('Aaron', 'aaron@gmail.com');
    añadirContacto('Maida', 'maida@gmail.com');
    añadirContacto('maida', 'maida@gmail.com');
    añadirContacto('AARóN', 'maida@gmail.com');*/
    if (!isset($_POST['nombre']) && empty($_POST['nombre'])) {
        echo '<h4 style=color:red;>El nombre esta vacio</h4>';
    } else {
        $name = $_POST['nombre'];
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $email = $_POST['email'];
            añadirContacto($name, $email);
            echo '<h4>Correo valido</h4>';
        } else {
            echo '<h4>Correo no valido</h4>';
        }
    }
    ?>
</body>

</html>