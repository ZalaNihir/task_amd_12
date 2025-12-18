<x-auth>
    <a class="btn btn-sm btn-primary" href="{{ route('user.index') }}">back</a>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="email" class="form-label">email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="{{ old('email') }}">
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
                        value="{{ old('phone') }}">
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
                            <option value="{{ $role->value }}">
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
                    <div class="row entry">
                        <div class="col-2">
                            <label>Title</label>
                            <input class="form-control form-control-sm" name="qualifications[0][title]" type="text">
                        </div>

                        <div class="col-2">
                            <label>Institute</label>
                            <input class="form-control form-control-sm" name="qualifications[0][institute]"
                                type="text">
                        </div>

                        <div class="col-2">
                            <label>Year</label>
                            <input class="form-control form-control-sm" name="qualifications[0][year]" type="number">
                        </div>

                        <div class="col-2">
                            <label>Grade</label>
                            <input class="form-control form-control-sm" name="qualifications[0][grade]" type="text">
                        </div>

                        <div class="col-2">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-success btn-sm btn-add">+</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <button class="btn btn-sm btn-success" type="submit">Save</button>
    </form>
    @section('script')
        <script>
            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();

                let container = $(this).closest('.fvrduplicate');
                let entry = $(this).closest('.entry');
                let newEntry = entry.clone();

                let index = container.find('.entry').length;

                newEntry.find('input').each(function() {
                    let name = $(this).attr('name');
                    name = name.replace(/\d+/, index);
                    $(this).attr('name', name).val('');
                });

                newEntry.appendTo(container);

                container.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add btn-success')
                    .addClass('btn-remove btn-danger')
                    .text('-');
            });

            $(document).on('click', '.btn-remove', function() {
                $(this).closest('.entry').remove();
            });
        </script>
    @endsection
</x-auth>
