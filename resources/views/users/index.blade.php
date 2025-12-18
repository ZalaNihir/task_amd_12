<x-auth>
    <a class="btn btn-sm btn-primary" href="{{route('user.create')}}">Create</a>
    <a class="btn btn-sm btn-primary" href="{{route('user.trash')}}">Recyclebin</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
                <tr>
                    <th scope="row">{{ $item->id }}</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>
                        <a href="{{ route('user.edit',$item->id) }}">Edit</a>
                        <form action="{{ route('user.destroy',$item->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$users->links()}}
</x-auth>
