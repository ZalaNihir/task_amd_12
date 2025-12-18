<x-auth>
    <h3>Deleted Users</h3>
    <a class="btn btn-sm btn-primary mb-3" href="{{ route('user.index') }}">Back</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                {{-- <th>Qualifications</th> --}}
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($deletedUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->role }}</td>
                    {{-- <td>
                        @foreach ($user->qualifications as $q)
                            <div>
                                {{ $q->title }} - {{ $q->institute }} - {{ $q->year }} - {{ $q->grade }}
                            </div>
                        @endforeach
                    </td> --}}
                    <td>
                        <form action="{{ route('user.restore', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success">Restore</button>
                        </form>

                        <form action="{{ route('user.forceDelete', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure? This is permanent!')">Delete Permanently</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No deleted users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-auth>
