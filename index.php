<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>

<style>
  body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
  }
  
  /* Hide the default header/nav if it's included in header.php for the login page */
  .header, .sidebar { display: none; } 

  .login-container {
    background: #ffffff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 400px;
    transition: all 0.3s ease;
  }

  .login-header h1 {
    font-weight: 800;
    color: #2d3748;
    margin-bottom: 5px;
    letter-spacing: -1px;
  }

  .login-header p {
    color: #718096;
    margin-bottom: 30px;
  }

  .form-group {
    margin-bottom: 20px;
    position: relative;
  }

  .form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 8px;
    display: block;
  }

  .form-control {
    height: 48px;
    border-radius: 10px;
    border: 2px solid #edf2f7;
    padding: 10px 15px;
    transition: all 0.2s;
    font-size: 15px;
  }

  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
  }

  .btn-login {
    width: 100%;
    height: 48px;
    background: #667eea;
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 700;
    font-size: 16px;
    margin-top: 10px;
    transition: all 0.3s;
    cursor: pointer;
  }

  .btn-login:hover {
    background: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(90, 103, 216, 0.3);
  }

  /* Custom Alert Styling */
  .alert {
    border-radius: 10px;
    border: none;
    font-size: 14px;
    margin-bottom: 20px;
  }
</style>

<div class="login-container">
    <div class="login-header text-center">
        <h1>Welcome Back</h1>
        <p>Please enter your details to sign in</p>
    </div>

    <?php echo display_msg($msg); ?>

    <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-login">Sign In</button>
        </div>
    </form>
    
    <div class="text-center" style="margin-top: 20px;">
        <small class="text-muted">SmartShelf</small>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>