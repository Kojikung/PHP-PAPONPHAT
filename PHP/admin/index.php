<?php
session_start();
 if(empty($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
 }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Navbar สีน้ำเงินตามธีม */
        .navbar-custom {
            background-color: #0d6efd; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: bold;
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.9);
        }
        .navbar-custom .nav-link:hover, 
        .navbar-custom .nav-link.active {
            color: white;
            font-weight: 500;
        }
        
        /* ส่วนแสดงชื่อผู้ใช้และ Logout ด้านขวา */
        .user-profile {
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-name {
            font-weight: 500;
        }
        .btn-logout {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.3s;
            font-size: 0.9rem;
        }
        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.4);
            color: white;
        }

        /* จัดการส่วน Dropdown menu ให้สวยงาม */
        .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i></i> index
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon navbar-dark"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="user.php">User Manangement</a>
                    </li> 
                </ul>

                <div class="user-profile">
                    <span class="user-name">
                        <i class="bi bi-person-circle me-1"></i> 
                        <?php echo $_SESSION['fullname']; ?>
                    </span>
                    <a href="logout.php" class="btn-logout">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>