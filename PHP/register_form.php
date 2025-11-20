<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* CSS ทั้งหมดเหมือนเดิม... */
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1a1a1a;
            background-image: 
                repeating-linear-gradient(0deg, #333, #333 1px, transparent 1px, transparent 25px),
                repeating-linear-gradient(90deg, #333, #333 1px, transparent 1px, transparent 25px);
            background-size: 25px 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; 
        }
        #matrix-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; 
        }
        .form-wrapper {
            background-color: #1f2a28; 
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            width: 380px;
            border: 1px solid #00ff7f; 
            position: relative; 
            z-index: 10; 
        }
        /* ... (CSS ส่วนที่เหลือ) ... */
        .form-wrapper h2 {
            color: #00ff7f; 
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .input-group { margin-bottom: 20px; }
        .input-group label {
            display: block;
            color: #00ff7f; 
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        .input-with-icon { position: relative; }
        .input-with-icon .fas {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #00ff7f; 
            font-size: 16px;
        }
        .input-with-icon input[type="text"],
        .input-with-icon input[type="tel"],
        .input-with-icon input[type="password"] {
            width: 100%;
            padding: 12px 15px 12px 45px; 
            background-color: #2a2d3b; 
            border: 1px solid #444;
            border-radius: 5px;
            color: #ffffff; 
            font-size: 16px;
            box-sizing: border-box; 
        }
        .input-with-icon input::placeholder { color: #777; }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #00ff7f; 
            border: none;
            border-radius: 5px;
            color: #1a1a1a; 
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #00e673; 
            box-shadow: 0 0 10px #00ff7f;
        }
    </style>
</head>
<body>

    <canvas id="matrix-canvas"></canvas>

    <div class="form-wrapper">
        <form action="register_save.php" method="POST"> 
            <h2>Create Account</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <div class="input-with-icon"><i class="fas fa-user"></i><input type="text" id="username" name="username" placeholder="Enter username" required></div>
            </div>
            <div class="input-group">
                <label for="phone">Phone</label>
                <div class="input-with-icon"><i class="fas fa-phone"></i><input type="tel" id="phone" name="phone" placeholder="Enter phone number" required></div>
            </div>
            <div class="input-group">
                <label for="full-name">Full Name</label>
                <div class="input-with-icon"><i class="fas fa-id-card"></i><input type="text" id="full-name" name="full-name" placeholder="Enter full name" required></div>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <div class="input-with-icon"><i class="fas fa-lock"></i><input type="password" id="password" name="password" placeholder="Enter password" required></div>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-with-icon"><i class="fas fa-lock"></i><input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required></div>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>

    <script>
        const canvas = document.getElementById('matrix-canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        // ขนาดช่องกริด (สำหรับการคำนวณตำแหน่ง)
        const gridSize = 25; 
        
        // ** 1. ลดขนาด **
        // ขนาดของบล็อกที่จะวาด (เล็กกว่า gridSize)
        const drawSize = 10; 
        // คำนวณ offset เพื่อให้บล็อกอยู่ตรงกลางช่อง
        const offset = (gridSize - drawSize) / 2; 

        const columns = Math.floor(canvas.width / gridSize); 
        const rows = Math.floor(canvas.height / gridSize); 

        const drops = [];
        for (let i = 0; i < columns; i++) {
            drops[i] = Math.floor(Math.random() * rows); 
        }

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function draw() {
            // ** 2. หายไปเร็วขึ้น (Fade) **
            // เปลี่ยนจาก 0.05 เป็น 0.15 (ค่าสูงขึ้น = จางเร็วขึ้น)
            ctx.fillStyle = 'rgba(26, 26, 26, 0.15)'; 
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < drops.length; i++) {
                const randomBlockColor = getRandomColor();
                ctx.fillStyle = randomBlockColor;

                // ** 1. ลดขนาด (วาด) **
                // วาดสี่เหลี่ยมโดยใช้ drawSize และ offset
                ctx.fillRect(
                    (i * gridSize) + offset,    // ตำแหน่ง X + offset
                    (drops[i] * gridSize) + offset, // ตำแหน่ง Y + offset
                    drawSize,                   // ความกว้าง (ใหม่)
                    drawSize                    // ความสูง (ใหม่)
                );

                if (drops[i] * gridSize > canvas.height && Math.random() > 0.975) {
                    drops[i] = 0;
                }
                drops[i]++;
            }
        }

        // ** 3. เร็วขึ้น (Speed) **
        // เปลี่ยนจาก 50ms เป็น 33ms (ค่าต่ำลง = เร็วขึ้น)
        setInterval(draw, 33); 

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            // (ควรคำนวณ columns/rows ใหม่ แต่ reload ก็ใช้ได้ครับ)
        });

    </script>

</body>
</html>