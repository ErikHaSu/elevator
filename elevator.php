<?php
include "main.elevator.php";

$initial_state = $_POST['initial_state'];
$floor_maintenance = $_POST['floor_maintenance'];
$users = [];
$floor_target = [];
for($x=1; $x <= count($_POST)/2-2; $x++) {
    $floor = $_POST['actual_floor_'.$x];
    $usuario = $_POST['user_'.$x]; 
    $destiny = $_POST['floor_target_'.$x];
    $users[$floor] = $usuario;
    $floor_target[$floor] =$destiny;
}

$elevator = new Elevador();
$elevator -> firstStop($initial_state, $users, $floor_target, $near_state);
$first_position = array_search($elevator -> order_users[0], $users);
$first_destination = $floor_target[$first_position];
$position = $first_position;
$max_floor = max($floor_target);
$min_floor = min($floor_target);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Elevador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="public/styles/style.css"/>
</head>
<body id="body-background">
    <h1>Bienvenido al elevador.</h1>
    <div class="elevator" >
        <div class="grid-container">
            <?php for($x=0; $x < $max_floor; $x++){ 
                echo '<div class="grid-container__items" id="floor-'.($max_floor-$x).'">Piso '.($max_floor-$x).' </div>';
            }?>
        </div>
        <div class="elevator__results">
        <h3>Información adicional.</h3>
        <?php
            //Elevator initial state echo
            echo ('<style>
            #floor-'.$initial_state.' {
                background-color: rgba(0, 0, 0, 0.3);
            }
            </style>');

            //Elevator arrive to the first user
            foreach($elevator->order_users as $key => $user) {
                if($elevator -> actions[$key] == $initial_state) {
                    echo ("El usuario ".$user." ha abordado al elevador. <br>");
                } else if ($elevator -> actions[$key] != $initial_state) {
                    echo ("El elevador ha recogido al usuario ".$user." <br>");
                } else {
                    echo ("El usuario ".$user." ha salido del elevador. <br>");
                }
            }
            print_r("Primer usuario en posición ".$first_position." con destino a piso ".$first_destination."<br>");

            //Elevator functions for the other users (up, down)
            while($first_destination > $position) {
                $initial_state = $position;
                for($i=$position; $i <= $first_destination; $i++) {
                    flush(); 
                    ob_flush(); 
                    sleep(2);
                    echo('<style>
                    #floor-'.$i.' {
                        background-color: #2e2d39;
                    }
                    </style>');
                    //Floors in maintenance
                    if($i == $floor_maintenance) {
                    echo('<style>
                    #floor-'.$i.' {
                        background-color: #525066;
                    }
                    </style>');
                    }
                }
                $elevator -> up($first_destination, $position, $users, $floor_target, $initial_state, $pos, $floor_maintenance);
                $first_destination = $elevator -> destination;
                $position = $elevator -> pos;
            }
            while($first_destination < $position) {
                $initial_state = $position;
                $elevator -> down($first_destination, $position, $users, $floor_target, $initial_state, $floor_maintenance);
                $first_destination = $elevator -> destination;
                $position = $elevator -> pos;
                for($j=$position; $j >= $first_destination; $j--) {
                    flush(); 
                    ob_flush(); 
                    sleep(2);
                    echo('<style>
                    #floor-'.$j.' {
                        background-color: rgba(0, 0, 0, 0.7);
                    }
                    </style>');
                    //Floors in maintenance
                    if($j == $floor_maintenance) {
                        echo('<style>
                        #floor-'.$i.' {
                            background-color: #525066;
                        }
                        </style>');
                    }
                    if($j == $first_destination){
                        ob_end_flush();
                        $position = 0;
                    }
                    ini_set('max_execution_time', 80);
                }
            }?>
            <p class="results__text">Resultados:
            <?php foreach($elevator -> order_users as $route => $user) {
                print_r(" ".$elevator -> order_users[$route]); 
            }?>
            </p>
        </div>
    </div>
</body>
</html>