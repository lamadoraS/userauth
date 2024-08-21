
    <h1>Welcome to Our Centralized User Authentication System, {{ $user->first_name }}!</h1>
    <p>Your account has been created successfully. Here are your credentials:</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please keep this information safe and do not share it with anyone.</p>
    <p>Best regards,<br>The Team</p>
