<!DOCTYPE html>
<html lang="th" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        /* --- กำหนดตัวแปร --- */
        :root {
            --custom-green: #00e676;
            --custom-green-darker: #00c864;
            --custom-green-focus-ring: rgba(0, 230, 118, 0.5);
            --dark-bg: #0a0a0a;
            
            --grid-bg: #111; 
            --grid-gap: 1px; 

            /* ตัวแปรสำหรับแสงรอบ Card */
            --border-light-color: transparent; 
            --border-light-blur: 10px;
            --border-light-spread: 5px;
        }

        body, html { height: 100%; }
        
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--dark-bg);
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* --- ส่วนของ Grid Background --- */
        #background-grid {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            z-index: 1;
            display: grid;
            gap: var(--grid-gap);
        }
        .grid-square {
            background-color: var(--grid-bg);
            transition: background-color 1.5s ease-out;
        }

        /* --- Container และ Card --- */
        .container {
            position: relative;
            z-index: 2;
            pointer-events: none; /* ให้เมาส์ทะลุไปโดน Grid ได้ในส่วนว่าง */
        }

        .card {
            border: 1px solid rgba(0, 230, 118, 0.2);
            box-shadow: 
                0 0 var(--border-light-blur) var(--border-light-spread) var(--border-light-color),
                0 4px 20px rgba(0, 230, 118, 0.1);
            transition: box-shadow 0.8s ease-out;
            pointer-events: auto; /* ให้คลิกที่ Card ได้ */
            
            background-color: rgba(26, 26, 26, 0.4); /* โปร่งแสง */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .card-header.bg-custom-green {
            background-color: rgba(0, 230, 118, 0.2) !important;
            color: #eee !important;
            border-bottom: 1px solid rgba(0, 230, 118, 0.3);
            padding: 1rem;
        }
        .card-header h3 { font-weight: 600; letter-spacing: 1px; }

        /* --- Form Elements --- */
        .form-label { color: #ccc; font-size: 0.9rem; }
        
        .input-group-text {
            background-color: rgba(42, 42, 42, 0.3);
            border-color: rgba(51, 51, 51, 0.5);
            color: var(--custom-green);
            transition: all 0.2s ease-in-out;
        }
        
        .form-control {
            background-color: rgba(33, 33, 33, 0.3);
            border-color: rgba(51, 51, 51, 0.5);
            color: #eee;
        }
        .form-control:focus {
            background-color: rgba(40, 40, 40, 0.5);
            border-color: var(--custom-green);
            box-shadow: 0 0 0 0.25rem var(--custom-green-focus-ring);
            color: #fff;
        }
        .form-control:focus + .input-group-text {
            color: var(--custom-green);
            background-color: rgba(0, 230, 118, 0.1);
        }

        /* --- ปุ่ม Login (Primary) --- */
        .btn-primary {
            background-color: rgba(0, 230, 118, 0.2);
            border-color: rgba(0, 230, 118, 0.3);
            color: #eee;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
            padding: 0.6rem 1rem;
        }
        .btn-primary:hover {
            background-color: rgba(0, 230, 118, 0.5);
            border-color: rgba(0, 230, 118, 0.6);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 230, 118, 0.4);
        }

        /* --- ปุ่มสมัครสมาชิก (Outline Custom) --- */
        .btn-outline-custom {
            color: var(--custom-green);
            border: 1px solid rgba(0, 230, 118, 0.4);
            background: transparent;
            font-weight: 600;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            background-color: var(--custom-green);
            color: #111;
            box-shadow: 0 0 15px var(--custom-green-focus-ring);
            border-color: var(--custom-green);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div id="background-grid"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                
                <div class="card shadow-lg">
                    <div class="card-header bg-custom-green text-center">
                        <h3 class="mb-0"><i class="fas fa-shield-alt me-2"></i>LOGIN</h3>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        <form action="check_login.php" method="POST">
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <input name="username" type="text" class="form-control" id="username" placeholder="Enter username" required>
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter password" required>
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-3 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Login <i class="fas fa-sign-in-alt ms-2"></i>
                                </button>
                                
                                <a href="register_form.php" class="btn btn-outline-custom text-center">
                                    สมัครสมาชิก <i class="fas fa-user-plus ms-2"></i>
                                </a>
                            </div>

                        </form>
                        </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const gridContainer = document.getElementById('background-grid');
            const squareSize = 20; 
            const gap = 1; 

            const screenWidth = window.innerWidth;
            const screenHeight = window.innerHeight;
            
            const cols = Math.ceil(screenWidth / (squareSize + gap));
            const rows = Math.ceil(screenHeight / (squareSize + gap));
            
            gridContainer.style.gridTemplateColumns = `repeat(${cols}, ${squareSize}px)`;
            gridContainer.style.gridTemplateRows = `repeat(${rows}, ${squareSize}px)`;

            const baseGridColor = getComputedStyle(document.documentElement).getPropertyValue('--grid-bg').trim();
            const totalSquares = cols * rows;

            // สร้าง Grid
            for (let i = 0; i < totalSquares; i++) {
                const square = document.createElement('div');
                square.classList.add('grid-square');
                
                square.addEventListener('mouseover', () => {
                    const randomHue = Math.floor(Math.random() * 360);
                    const randomColor = `hsl(${randomHue}, 100%, 60%)`; 
                    square.style.transition = 'background-color 0s';
                    square.style.backgroundColor = randomColor;
                });
                
                square.addEventListener('mouseout', () => {
                    square.style.transition = 'background-color 1.5s ease-out';
                    square.style.backgroundColor = baseGridColor;
                });
                gridContainer.appendChild(square);
            }

            // ฟังก์ชันเปลี่ยนสีแสงรอบ Card
            function updateBorderLightColor() {
                const randomHue = Math.floor(Math.random() * 360);
                const randomLightColor = `hsla(${randomHue}, 100%, 50%, 0.3)`; 
                document.documentElement.style.setProperty('--border-light-color', randomLightColor);
            }

            setInterval(updateBorderLightColor, 2000);
        });
    </script>
</body>
</html>