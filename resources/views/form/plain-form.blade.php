<div class="box box-info">
    <!-- /.box-header -->
    <!-- form start -->

    {!! $form->open(['class' => "form-horizontal"]) !!}

    <div class="box-body">

       {{-- @if(!$tabObj->isEmpty())
            @include('admin::form.tab', compact('tabObj'))
        @else--}}

            <div class="fields-group">

                @foreach($form->fields() as $field)
                    {!! $field->render() !!}
                @endforeach

            </div>

{{--        @endif--}}

    </div>
    <!-- /.box-body -->
    <div class="box-footer">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="col-md-{{$width['label']}}">

        </div>
        <div class="col-md-{{$width['field']}}">

            {!! $form->submitButton() !!}

            {!! $form->resetButton() !!}

        </div>

    </div>

    @foreach($form->getHiddenFields() as $hiddenField)
        {!! $hiddenField->render() !!}
    @endforeach

<!-- /.box-footer -->
    {!! $form->close() !!}
</div>

