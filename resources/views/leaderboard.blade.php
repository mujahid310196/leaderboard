<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<div class="container mt-5">
    <form method="GET" action="{{ url('/leaderboard') }}" class="mb-4 d-flex align-items-center">
        <input type="text" name="user_id" class="form-control me-2" placeholder="User ID" value="{{ request('user_id') }}">
        <select name="filter" class="form-select me-2">
            <option value="day" {{ request('filter') == 'day' ? 'selected' : '' }}>Day</option>
            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Month</option>
            <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Year</option>
        </select>
        <button class="btn btn-primary">Filter</button>
    </form>

    <form method="POST" action="{{ route('recalculate') }}">
        @csrf
        <button class="btn btn-warning mb-4">Recalculate</button>
    </form>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Points</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr @if(request('user_id') == $user->id) style="background: #222;" @endif>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->total_points }}</td>
                <td>#{{ $user->rank }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
