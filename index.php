<!DOCTYPE html>
<html>

<head>
    <title>ToDoBoX</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Baloo|Montserrat" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <a href="#" class="btn-flat btn-large waves-effect waves-light sidenav-trigger transparent" data-target="slide-out" id="menuButton">
        <i class="material-icons">menu</i>
    </a>
    <div class="container">
        <div class="row">
            <div class="col s12 m3">
                <div class="box z-depth-1">
                    <p class="boxContent">
                        Look at this amazing note, it's so beautiful and long and I hope it doesn't take too much space.
                    </p>
                    <div class="boxBottom">
                        <p class="date">Due: 23/1/19</p>
                        <a class="btn-floating btn-small waves-effect waves-light blue check">
                            <i class="material-icons">check</i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="box z-depth-1">
                    <p class="boxContent">
                        Look at this amazing note, it's so beautiful and long and I hope it doesn't take too much space.
                    </p>
                    <div class="boxBottom">
                        <p class="date">Due: 23/1/19</p>
                        <a class="btn-floating btn-small waves-effect waves-light blue check">
                            <i class="material-icons">check</i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="box z-depth-1">
                    <p class="boxContent">
                        Look at this amazing note, it's so beautiful and long and I hope it doesn't take too much space.
                    </p>
                    <div class="boxBottom">
                        <p class="date">Due: 23/1/19</p>
                        <a class="btn-floating btn-small waves-effect waves-light blue check">
                            <i class="material-icons">check</i>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col s12 m3">
                <div class="box z-depth-1">
                    <p class="boxContent">
                        Look at this amazing note, it's so beautiful and long and I hope it doesn't take too much space.
                    </p>
                    <div class="boxBottom">
                        <p class="date">Due: 23/1/19</p>
                        <a class="btn-floating btn-small waves-effect waves-light blue check">
                            <i class="material-icons">check</i>
                        </a>
                    </div>
                </div>
            </div>


            <div class="col s12 m3">
                <div class="box z-depth-1">
                    <p class="boxContent">
                        Look at this amazing note, it's so beautiful and long and I hope it doesn't take too much space.
                    </p>
                    <div class="boxBottom">
                        <p class="date">Due: 23/1/19</p>
                        <a class="btn-floating btn-small waves-effect waves-light blue check">
                            <i class="material-icons">check</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="https://png.pngtree.com/thumb_back/fw800/back_pic/04/56/39/595865c6a86e7a6.jpg">
                </div>
                <a href="#user"><img class="circle" src="img/profilepic.jpg"></a>
                <span class="white-text name">Manueru Torinidad</span>
            </div>
        </li>
        <li><a href="#!"><i class="material-icons">archive</i>Archive</a></li>
        <li><a href="#settingsModal" class="waves-effect modal-trigger">Settings</a></li>
        <li><a href="#!" class="waves-effect">Log Out</a></li>
        <li>
            <div class="divider"></div>
        </li>
        <li><a class="subheader">ToDoBoX</a></li>
        <li><a class="waves-effect modal-trigger" href="#aboutUsModal">About Us</a></li>
        <li><a class="waves-effect modal-trigger" href="#contactModal">Contact</a></li>
    </ul>

    <!-- Modal New Box -->
    <div id="newBox" class="modal">
        <div class="modal-content newBoxContent">
            <h5>New Note</h5>
            <div class="row blue-text text-darken-2">
                <div class="input-field col s12">
                    <i class="material-icons prefix">mode_edit</i>
                    <textarea id="noteInput" class="materialize-textarea" data-length="120"></textarea>
                    <label for="noteInput">What to do?</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix">date_range</i>
                    <input type="date">
                    <label for="date">Due by</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close btn-large waves-effect waves-red btn-flat transparent">
                <i class="material-icons">clear</i>
            </a>
            <a href="#!" class="modal-close btn-large waves-effect waves-green btn-flat transparent">
                <i class="material-icons">check</i>
            </a>
        </div>
    </div>

    <!-- Modal Settings -->
    <div id="settingsModal" class="modal">
        <div class="modal-content">
            <h5>Settings</h5>
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">account_box</i>
                        Change username
                    </div>
                    <div class="collapsible-body">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="new_name" type="text" class="validate" value="Manueru Torinidad">
                                <label for="new_name">Name</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Change
                            <i class="material-icons right">edit</i>
                        </button>
                    </div>
                </li>

                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">email</i>
                        Change email address
                    </div>
                    <div class="collapsible-body">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="email" type="email" class="validate" value="sample@example.com">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Change
                            <i class="material-icons right">edit</i>
                        </button>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header">
                        <i class="material-icons">enhanced_encryption</i>
                        Change password
                    </div>
                    <div class="collapsible-body">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="password" type="password" class="validate" required>
                                <label for="password">New Password</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="password" type="password" class="validate" required>
                                <label for="password">Confirm Password</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Change
                            <i class="material-icons right">edit</i>
                        </button>

                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal Contact -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <h5>Contact</h5>
            <div class="row">
                <div class="input-field col s6">
                    <input id="new_name" type="text" class="validate" value="Manueru Torinidad" required>
                    <label for="new_name">Name</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="email" type="email" class="validate" value="sample@example.com" required>
                    <label for="email">Contact Email</label>
                </div>
            </div>

            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="textarea" class="materialize-textarea"></textarea>
                            <label for="textarea">Message</label>
                        </div>
                    </div>
                </form>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Send
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>

    <!-- Modal About Us -->
    <div id="aboutUsModal" class="modal">
        <div class="modal-content">
            <h5>About Us</h5>
            <p>We are students of TTÜ with a passion for web technologies.<br>
                This to-do box is proudly presented by Mexi-Hon.<br>
                Arigracias!<br>
            </p>
            <img class="responsive-img" src="img/mexjap.jpg">
        </div>
    </div>


    <a class="btn-floating btn-large waves-effect waves-light light-blue darken-4 addButton modal-trigger" href="#newBox">
        <i class="material-icons">add</i>
    </a>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html> 