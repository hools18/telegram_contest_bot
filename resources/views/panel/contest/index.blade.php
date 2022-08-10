@extends('panel.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список конкурсов</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('panel.contest.create') }}" class="btn btn-block btn-primary btn-sm"
                               style="width: 150px">Добавить конкурс</a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Дата начала</th>
                                    <th>Дата завершения</th>
                                    <th>Кол-во участников</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contests as $contest)
                                    <tr data-contest-id="{{ $contest->id }}">
                                        <td>{{ $contest->id }}</td>
                                        <td>
                                            <a href="{{ route('panel.contest.edit', $contest) }}">
                                                {{ $contest->name }}
                                            </a>
                                        </td>
                                        <td>{{ $contest->start_date }}</td>
                                        <td>{{ $contest->end_date }}</td>
                                        <td>{{ $contest->members_count }}</td>
                                        <td>
                                            <button class="btn btn-danger removeContest">X</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script>
        $('.removeContest').click(function (){
            let parent_row = $(this).closest('tr');
            var r = confirm("Вы точно хотите удалить конкурс?");
            if (r === true) {
                $.ajax({
                    data: {
                        contest_id: parent_row.data('contest-id'),
                        _method: 'DELETE'
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                    },
                    type: 'POST',
                    url: '{{ route('panel.contest.delete') }}',
                    success: function (response) {
                        parent_row.remove();
                        toastr.success(response.message);
                    },
                    error: function (response) {

                    }
                });
            }
        });
    </script>
@endsection
