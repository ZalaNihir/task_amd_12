<x-auth>
    <a class="btn btn-sm btn-primary" href="{{ route('user.index') }}">back</a>
    <form action="{{ route('user.updateprofile') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', auth()->user()->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="{{ old('email', auth()->user()->email) }}" readonly>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" name="password" id="password" class="form-control" placeholder="Leave blank to keep current">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        value="{{ old('phone', auth()->user()->phone) }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row targetDiv" id="div0">
            <div class="col-md-12">
                <div id="group1" class="fvrduplicate">
                    @foreach (auth()->user()->qualifications as $index => $qualification)
                        <div class="row entry">
                            <input type="hidden" name="qualifications[{{ $index }}][id]" value="{{ $qualification->id }}">

                            <div class="col-2">
                                <label>Title</label>
                                <input class="form-control form-control-sm" name="qualifications[{{ $index }}][title]" type="text" value="{{ $qualification->title }}">
                            </div>

                            <div class="col-2">
                                <label>Institute</label>
                                <input class="form-control form-control-sm" name="qualifications[{{ $index }}][institute]" type="text" value="{{ $qualification->institute }}">
                            </div>

                            <div class="col-2">
                                <label>Year</label>
                                <input class="form-control form-control-sm" name="qualifications[{{ $index }}][year]" type="number" value="{{ $qualification->year }}">
                            </div>

                            <div class="col-2">
                                <label>Grade</label>
                                <input class="form-control form-control-sm" name="qualifications[{{ $index }}][grade]" type="text" value="{{ $qualification->grade }}">
                            </div>

                            <div class="col-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-success btn-sm btn-add">+</button>
                                <button type="button" class="btn btn-danger btn-sm btn-remove">-</button>
                            </div>
                        </div>
                    @endforeach

                    @if(auth()->user()->qualifications->isEmpty())
                        <div class="row entry">
                            <div class="col-2">
                                <label>Title</label>
                                <input class="form-control form-control-sm" name="qualifications[0][title]" type="text" placeholder="Title">
                            </div>
                            <div class="col-2">
                                <label>Institute</label>
                                <input class="form-control form-control-sm" name="qualifications[0][institute]" type="text">
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
                                <button type="button" class="btn btn-danger btn-sm btn-remove">-</button>
                            </div>
                        </div>
                    @endif
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
            let entry = container.find('.entry:last');
            let newEntry = entry.clone();

            let index = container.find('.entry').length;

            newEntry.find('input').each(function() {
                let name = $(this).attr('name');
                if(name) {
                    name = name.replace(/\d+/, index);
                    $(this).attr('name', name).val('');
                }
            });

            newEntry.find('input[type=hidden]').remove(); // Remove old ID
            newEntry.appendTo(container);
        });

        $(document).on('click', '.btn-remove', function() {
            $(this).closest('.entry').remove();
        });
    </script>
    @endsection
</x-auth>
