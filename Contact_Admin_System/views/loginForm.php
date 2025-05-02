<?php
function init() {
    // Pre-fill with admin credentials
    $adminEmail = 'mblaser@admin.com'; // Replace with your WCC username
    
    return <<<HTML
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1>Login</h1>
                <form action="controllers/loginProc.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{$adminEmail}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
HTML;
} 