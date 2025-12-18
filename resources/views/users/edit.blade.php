<x-auth>
    <a class="btn btn-sm btn-primary" href="{{ route('user.index') }}">back</a>
    <form action="{{ route('user.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $user->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="email" class="form-label">email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="password" class="form-label">password</label>
                    <input type="text" name="password" id="password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="phone" class="form-label">phone</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="role" class="form-label">role</label>
                    <select name="role" id="role" class="form-select">
                        @foreach (App\Enum\RoleEnum::cases() as $role)
                            <option value="{{ $role->value }}"
                                {{ $user->role->value == $role->value ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row targetDiv" id="div0">
            <div class="col-md-12">
                <div id="group1" class="fvrduplicate">

                    @forelse ($user->qualifications as $index => $qualification)
                        <div class="row entry">
                            <input type="hidden"
                                name="qualifications[{{ $index }}][id]"
                                value="{{ $qualification->id }}">

                            <div class="col-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control form-control-sm"
                                        name="qualifications[{{ $index }}][title]"
                                        type="text"
                                        value="{{ $qualification->title }}">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label>Institute</label>
                                    <input class="form-control form-control-sm"
                                        name="qualifications[{{ $index }}][institute]"
                                        type="text"
                                        value="{{ $qualification->institute }}">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label>Year</label>
                                    <input class="form-control form-control-sm"
                                        name="qualifications[{{ $index }}][year]"
                                        type="number"
                                        value="{{ $qualification->year }}">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label>Grade</label>
                                    <input class="form-control form-control-sm"
                                        name="qualifications[{{ $index }}][grade]"
                                        type="text"
                                        value="{{ $qualification->grade }}">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    @if ($loop->last)
                                        <button type="button"
                                            class="btn btn-success btn-sm btn-add">+</button>
                                    @else
                                        <button type="button"
                                            class="btn btn-danger btn-sm btn-remove">-</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row entry">
                            <div class="col-2">
                                <input class="form-control form-control-sm"
                                    name="qualifications[0][title]" type="text">
                            </div>
                            <div class="col-2">
                                <input class="form-control form-control-sm"
                                    name="qualifications[0][institute]" type="text">
                            </div>
                            <div class="col-2">
                                <input class="form-control form-control-sm"
                                    name="qualifications[0][year]" type="number">
                            </div>
                            <div class="col-2">
                                <input class="form-control form-control-sm"
                                    name="qualifications[0][grade]" type="text">
                            </div>
                            <div class="col-2">
                                <button type="button"
                                    class="btn btn-success btn-sm btn-add">+</button>
                            </div>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        <button class="btn btn-sm btn-success" type="submit">Save</button>
    </form>

    @section('script')
        <script>
            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();

                let container = $('#group1');
                let lastEntry = container.find('.entry:last');
                let newEntry = lastEntry.clone();

                let index = container.find('.entry').length;

                newEntry.find('input').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', name).val('');
                    }
                });

                newEntry.find('input[type="hidden"]').remove();

                newEntry.appendTo(container);
            });

            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.entry').remove();
            });
        </script>
    @endsection
</x-auth>
