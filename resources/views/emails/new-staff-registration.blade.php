<!DOCTYPE html>
<html>
<head>
    <title>New Staff Registration</title>
</head>
<body>
    <h2>New Staff Registration Request</h2>
    <p>A new staff member has registered and is awaiting approval.</p>
    
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>ID Staff:</strong> {{ $user->id_staff }}</p>
    <p><strong>Position:</strong> {{ $user->position }}</p>

    <p>Please log in to approve or reject this request.</p>
</body>
</html>
