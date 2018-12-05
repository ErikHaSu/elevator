<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="public/styles/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="elevator.js"></script>
</head>
<body id="index-background">
    <h1>Bienvenido al hotel.</h1>
    <div class="elevator-form">
        <!-- Form for all values needed in the elevator-->
        <form method="post" action="elevator.php">
            <input class="elevator-form__input" type="text" name="initial_state" placeholder="Piso inicial" required>
            <input class="elevator-form__input" type="text" name="floor_maintenance" placeholder="Piso en mantenimiento" pattern="((?=.*\d){1}" required/>
            <div class="field-wrapper">
                <div class="field-wrapper__input">
                <input type="text" value="<? $_GET['user_1']?>" name="actual_floor_1" placeholder="Piso Actual">
                <input type="text" name="user_1" placeholder="Nombre Usuario">
                <input type="text" value="<? $_GET['actual_floor_1'] ?>" name="floor_target_1" placeholder="Destino">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img src="public/images/add-icon.png"/></a>
                </div>
            </div>
            <input class="form-button"type="submit" value="Click" />
        </form>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        var maxField = 3; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field-wrapper'); //Input field wrapper
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append('<div class="field-wrapper__input"><input type="text" value="<? $_GET['user_'+x+'']?>" name="actual_floor_'+x+'" placeholder="Piso Actual"><input type="text" name="user_'+x+'" placeholder="Nombre Usuario"><input type="text" value="<? $_GET['actual_floor_'+x+''] ?>" name="floor_target_'+x+'" placeholder="Destino"><a href="javascript:void(0);" class="remove_button"><img src="public/images/remove-icon.png"/></a></div>');
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>
</body>
</html>