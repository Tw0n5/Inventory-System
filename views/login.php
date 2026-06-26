<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory App - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/public/style.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <h2>Inventory App</h2>
            <p>Sign in to manage your corporate assets</p>
            <div id="errorMessage" style="color: #ff4d4d; margin-bottom: 15px; font-size: 0.9em; font-weight: 500;"></div>
            
            <form id="loginForm">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="text" id="username" placeholder="Username" required value="">
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" placeholder="Password" required value="">
                </div>
                <button type="submit" class="login-btn">Sign In</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const msgDiv = document.getElementById('errorMessage');
            msgDiv.innerText = "";
            
            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        username: document.getElementById('username').value,
                        password: document.getElementById('password').value
                    })
                });
                const data = await response.json();
                if(data.success) {
                     alert("Login successful! Redirecting to dashboard...");
                   window.location.href = data.redirectUrl;
                   
                } else {
                    alert("Login failed: " + data.message);
                    msgDiv.innerText = data.message;
                }
            } catch (err) {
                msgDiv.innerText = "Server connection lost.";
            }
        });
    </script>
</body>
</html>