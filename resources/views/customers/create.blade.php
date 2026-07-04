<!DOCTYPE html>
<html>
<head>
    <title>Create Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2>Create Customer</h2>

    <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name" required>
        <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name" required>
        <input type="text" name="phone" class="form-control mb-2" placeholder="Phone">
        <input type="email" name="email" class="form-control mb-2" placeholder="Email">
        <input type="text" name="national_id" class="form-control mb-2" placeholder="National ID">
        <textarea name="address" class="form-control mb-2" placeholder="Address"></textarea>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>

</body>
</html>