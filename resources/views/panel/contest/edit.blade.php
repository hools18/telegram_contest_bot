@extends('panel.layout')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование конкурса</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <form action="{{ route('panel.contest.update', $contest) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nameInput">Название</label>
                                    <input type="text" class="form-control" name="name" id="nameInput" value="{{ !empty($contest->name) ? $contest->name : old('name') }}">
                                    @if($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="shortNameInput">Короткое название (для меню бота)</label>
                                    <input type="text" class="form-control" name="short_name" id="shortNameInput" value="{{ !empty($contest->short_name) ? $contest->short_name : old('short_name') }}">
                                    @if($errors->has('short_name'))
                                        <div class="error">{{ $errors->first('short_name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="shortDescTextArea">Описание конкурса</label>
                                    <textarea class="form-control" name="description" id="shortDescTextArea">{{ !empty($contest->description) ? $contest->description : old('description') }}</textarea>
                                    @if($errors->has('description'))
                                        <div class="error">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Начало конкурса:</label>
                                    <div class="input-group date" id="startDate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="start_date" data-target="#startDate" value="{{ !empty($contest->start_date) ? $contest->start_date : old('start_date') }}">
                                        <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @if($errors->has('start_date'))
                                        <div class="error">{{ $errors->first('start_date') }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Завершение конкурса:</label>
                                    <div class="input-group date" id="endDate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="end_date" data-target="#endDate" value="{{ !empty($contest->end_date) ? $contest->end_date : old('end_date') }}">
                                        <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @if($errors->has('end_date'))
                                        <div class="error">{{ $errors->first('end_date') }}</div>
                                    @endif
                                </div>
                                @if($contest->getFirstMediaUrl('image'))
                                    <img src="{{ $contest->getFirstMediaUrl('image') }}" alt="" style="width: 200px; height: auto">
                                    <button>Удалить</button>
                                @else
                                    <div class="form-group">
                                        <label for="exampleInputFile">Изображение конкурса</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image"
                                                       id="imageInputFile">
                                                <label class="custom-file-label" for="imageInputFile">Выберите
                                                    файл</label>
                                            </div>
                                        </div>
                                        @if($errors->has('image'))
                                            <div class="error">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    @parent
    <script>
        $('#startDate').datetimepicker({
            locale: moment.locale('ru'),
            format: 'DD.MM.YYYY HH:mm',
            icons: { time: 'far fa-clock' } });
        $('#endDate').datetimepicker({
            locale: moment.locale('ru'),
            format: 'DD.MM.YYYY HH:mm',
            icons: { time: 'far fa-clock' } });
    </script>
@endsection
