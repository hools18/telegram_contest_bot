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
                            <a href="{{ route('panel.contest.create') }}" class="btn btn-block btn-primary btn-sm" style="width: 150px">Добавить конкурс</a>
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
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contests as $contest)
                                    <tr>
                                        <td>{{ $contest->id }}</td>
                                        <td>{{ $contest->name }}</td>
                                        <td>{{ $contest->start_date }}</td>
                                        <td>{{ $contest->end_date }}</td>
                                        <td>{{ $contest->count_members }}</td>
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
