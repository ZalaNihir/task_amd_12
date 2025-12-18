<x-auth>
    <a class="btn btn-sm btn-primary" href="{{ route('user.index') }}">back</a>
    <form action="{{ route('user.update', $user) }}" method="POST">
        @method('PUT')
        @csrf
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
                            <option value="{{ $role->value }}" >
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
                    @foreach ($user->qualifications as $qualification)
                    <div class="row entry">
                        <div class="col-2">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control form-control-sm" name="qualifications[title]" type="text"
                                    placeholder="Length" value="{{ $qualification->title }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Institute</label>
                                <input class="form-control form-control-sm" name="qualifications[institute]"
                                    type="text"  value="{{ $qualification->institute }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Year</label>
                                <input class="form-control form-control-sm" name="qualifications[year]" type="number"
                                     value="{{ $qualification->year }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Grade</label>
                                <input class="form-control form-control-sm" name="qualifications[grade]" type="text"
                                     value="{{ $qualification->grade }}">
                            </div>
                        </div>
                        {{-- <div class="col-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-success btn-sm btn-add">
                                    <i class="fa fa-plus" aria-hidden="true">+</i>
                                </button>
                            </div>
                        </div> --}}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button class="btn btn-sm btn-success" type="submit">Save</button>
    </form>
    @section('script')
        <script>
            $(function() {
                $(document).on('click', '.btn-add', function(e) {
                    e.preventDefault();
                    var controlForm = $(this).closest('.fvrduplicate'),
                        currentEntry = $(this).parents('.entry:first'),
                        newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.find('input').val('');
                    controlForm.find('.entry:not(:last) .btn-add')
                        .removeClass('btn-add').addClass('btn-remove')
                        .removeClass('btn-success').addClass('btn-danger')
                        .html('<i class="fa fa-minus" aria-hidden="true">-</i>');
                }).on('click', '.btn-remove', function(e) {
                    $(this).closest('.entry').remove();
                    return false;
                });
            });
        </script>
    @endsection
</x-auth>
