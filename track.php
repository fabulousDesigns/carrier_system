<?php
include_once('./config/config.php');
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

<?php
include_once('./config/header.php');
?>


<body>
    <style>
    #t-search {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    input[type=text] {

        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: white;
        background-position: 10px 10px;
        background-repeat: no-repeat;
        padding: 12px 20px 12px 40px;
        font-weight: 600;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;
    }

    .btn-search {
        padding: 6px 1rem;
        background: var(--color-success);
        font-weight: 600;
        border-radius: 6px;
        letter-spacing: 1px;
    }

    .btn-logout {
        padding: 0.8rem 1rem;
        background: var(--color-danger);
        border-radius: 6px;
    }

    /* input[type=text]:focus {
        width: 100%;
    } */
    </style>

    <!-- ==================================Navigation====================================== -->
    <nav>
        <div class="container nav__container">
            <a href="index.php">
                <!-- logo -->
                <h4>Welcome <b><?php echo htmlspecialchars($_SESSION["first_name"]); ?></b></h4>
            </a>
            <ul class="nav__menu"></ul>
            <li>
                <a href="logout.php" name="logout" class="btn-logout">logout</a>
            </li>
            </ul>
        </div>
    </nav>
    <!-- ===============================Close-Navigation=============================== -->
    <!-- ==================================Header====================================== -->

    <header>
        <div class="container header__container">
            <div class="header__left">
                <h3>
                    CHOOSE YOUR QUALITY DELIVERY OF YOUR CARGO
                </h3>
                <p>
                    To track your cargo enter your reference number in the search box
                </p>
            </div>
            <div class="header__right">
                <div class="header__right-image">
                    <form id="t-search">
                        <input type="text" name="search" id="ref_no" placeholder="Tracking Number...">
                        <button type="button" id="track-btn" class="btn btn-sm btn-primary btn-gradient-primary">
                            Track Now
                        </button>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="timeline" id="parcel_history">

                        </div>
                    </div>
                </div>
            </div>
            <div id="clone_timeline-item" class="d-none">
                <div class="iitem">
                    <i class="fas fa-box bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> <span class="dtime">12:05</span></span>
                        <div class="timeline-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>
    <!-- ==================================close Header================================ -->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
function track_now() {
    // start_load()
    var tracking_num = $('#ref_no').val()
    if (tracking_num == '') {
        $('#parcel_history').html('')

    } else {
        $.ajax({
            url: 'ajax.php?action=get_parcel_heistory',
            method: 'POST',
            data: {
                ref_no: tracking_num
            },
            error: err => {
                console.log(err)
                alert("An error occured", 'error')

            },
            success: function(resp) {
                if (typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) ===
                    'object') {
                    resp = JSON.parse(resp)
                    if (Object.keys(resp).length > 0) {
                        $('#parcel_history').html('')
                        Object.keys(resp).map(function(k) {
                            var tl = $('#clone_timeline-item .iitem').clone()
                            tl.find('.dtime').text(resp[k].date_created)
                            tl.find('.timeline-body').text(resp[k].status)
                            $('#parcel_history').append(tl)
                        })
                    }
                } else if (resp == 2) {
                    alert('Unkown Tracking Number.', "error")
                }
            },
            complete: function() {

            }
        })
    }
}
$('#track-btn').click(function() {
    track_now()
})
$('#ref_no').on('search', function() {
    track_now()
})
</script>

</html>