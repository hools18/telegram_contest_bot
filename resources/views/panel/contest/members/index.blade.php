@extends('panel.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список участников конкурса - {{ $contest->name }}</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Chat ID</th>
                                    <th>Имя</th>
                                    <th>Дата регистрации</th>
                                    <th>Номер участника</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contest->members as $member)
                                    <tr data-member-id="{{ $member->id }}">
                                        <td>{{ $member->id }}</td>
                                        <td>{{ $member->chat_id }}</td>
                                        <td>{{ $member->first_name }}</td>
                                        <td>{{ $member->created_at }}</td>
                                        <td>{{ $member->number_member }}</td>
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
