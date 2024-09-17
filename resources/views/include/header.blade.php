<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            margin-bottom: 60px; /* Add margin to the bottom */
        }

        .navbar-brand img {
            width: 40px;
            height: auto;
            margin-right: 0; /* Change fixed to 0 for no margin */
        }

        /* Custom styles for the toggle button */
        .navbar-toggler {
            border: none;
            background-color: transparent;
            color: #333;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .navbar-toggler:focus {
            outline: none;
        }

        .navbar-toggler:hover {
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container-fluid px-0"> 
    <div class="navbar-container" style="background:#F9D725;"> 
        <div class="d-flex align-items-center"> 
            <a class="navbar-brand" href="#">CSWDO RMS</a>
            <img src="img/logo.png" alt="Logo" width="40" class="me-2">
        </div>
        <button id="sidebarToggle" class="navbar-toggler" aria-label="Toggle Navigation">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('#sidebarToggle').on('click', function () {
            $('#sidebarCollapse').toggleClass('show');
        });
    });
</script>
</body>
</html>
