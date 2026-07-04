<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2>Edit Customer</h2>

    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')

        <input type="text" name="first_name" class="form-control mb-2"
               value="{{ $customer->first_name }}" required>

        <input type="text" name="last_name" class="form-control mb-2"
               value="{{ $customer->last_name }}" required>

        <input type="text" name="phone" class="form-control mb-2"
               value="{{ $customer->phone }}">

        <input type="email" name="email" class="form-control mb-2"
               value="{{ $customer->email }}">

        <input type="text" name="national_id" class="form-control mb-2"
               value="{{ $customer->national_id }}">

        <textarea name="address" class="form-control mb-2">{{ $customer->address }}</textarea>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>

</body>
</html>