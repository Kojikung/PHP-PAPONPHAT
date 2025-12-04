<?php
session_start();
require_once '../connect.php';

// ตรวจสอบ Action (list, add, edit)
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Sarabun', sans-serif; }
        /* Navbar สีน้ำเงินตามรูป */
        .navbar-custom { background-color: #0d6efd; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: white !important; }
        .user-profile { color: white; }
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
    <div class="container">
        
        <?php if(isset($_SESSION['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>


        <?php 
        // =========================================================
        // VIEW 1: ฟอร์มเพิ่มข้อมูล (ADD) - แก้ไข Field ให้ตรง DB
        // =========================================================
        if ($action == 'add') { ?>
            <div class="card shadow w-50 mx-auto">
                <div class="card-header bg-success text-white"><h4>เพิ่มสมาชิกใหม่</h4></div>
                <div class="card-body">
                    <form action="user_crud.php" method="post">
                        <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                        <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                        <div class="mb-3"><label>Fullname</label><input type="text" name="fullname" class="form-control" required></div>
                        
                        <div class="mb-3"><label>Phone</label><input type="text" name="phone" class="form-control" required></div>
                        
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="user">user</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                        <button type="submit" name="save_add" class="btn btn-success w-100">บันทึก</button>
                        <a href="user.php" class="btn btn-secondary w-100 mt-2">ยกเลิก</a>
                    </form>
                </div>
            </div>

        <?php 
        // =========================================================
        // VIEW 2: ฟอร์มแก้ไข (EDIT) - แก้ไข Field ให้ตรง DB
        // =========================================================
        } elseif ($action == 'edit' && isset($_GET['id'])) { 
            $id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE id = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        ?>
            <div class="card shadow w-50 mx-auto">
                <div class="card-header bg-primary text-white"><h4>แก้ไขข้อมูลสมาชิก</h4></div>
                <div class="card-body">
                    <form action="user_crud.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required></div>
                        <div class="mb-3"><label>Fullname</label><input type="text" name="fullname" class="form-control" value="<?php echo $row['fullname']; ?>" required></div>
                        
                        <div class="mb-3"><label>Phone</label><input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required></div>
                        
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="user" <?php if($row['status']=='user') echo 'selected'; ?>>user</option>
                                <option value="admin" <?php if($row['status']=='admin') echo 'selected'; ?>>admin</option>
                            </select>
                        </div>
                        <button type="submit" name="save_edit" class="btn btn-primary w-100">อัปเดตข้อมูล</button>
                        <a href="user.php" class="btn btn-secondary w-100 mt-2">ยกเลิก</a>
                    </form>
                </div>
            </div>

        <?php 
        // =========================================================
        // VIEW 3: ตารางแสดงผล (TABLE)
        // =========================================================
        } else { ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>สมาชิก</h2>
                <a href="user.php?action=add" class="btn btn-success">เพิ่มสมาชิก</a>
            </div>

            <div class="table-responsive bg-white shadow-sm rounded p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mem id</th>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Phone</th> <th>Status</th> <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM users ORDER BY id ASC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['phone']; ?></td> <td>
                                    <?php if($row['status'] == 'admin'): ?>
                                        <span class="text-danger fw-bold">admin</span>
                                    <?php else: ?>
                                        <span class="text-secondary">user</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="user.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">แก้ไข</a>
                                    <a href="user_crud.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูลนี้หรือไม่?');">ลบ</a>
                                </td>
                            </tr>
                        <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4'>ไม่พบข้อมูล</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
